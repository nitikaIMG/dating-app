<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requests;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Api\ApiResponse;
use App\Http\Resources\RequestResource;
use App\Http\Resources\UserResource;

class RequestApiController extends Controller
{
    public function index()
    {
        try {
            DB::beginTransaction();

            $get = User::withCount([
                'requests', 'requests as accepted_request_count' => function ($query) {
                    $query->select(DB::raw('count(receiver_id)'))
                        ->where('status', 1);
                }
            ])->orderBy('accepted_request_count', 'DESC')
                ->get();

            $userdetail = RequestResource::collection($get);
            return ApiResponse::ok(
                'Most Popular User Profile',
                $this->getUser($userdetail)
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;
            $validator =  Validator::make($request->all(), [
                'sender_id'   => ['required', 'numeric'],
                'receiver_id' => ['required', 'numeric'],
                'status'      => ['nullable', 'numeric'],
            ]);

            if ($validator->fails()) {
                return $this->validation_error_response($validator);
            }
            $validated = $validator->validated();

            $reqdata['sender_id'] = $validated['sender_id'];
            $reqdata['receiver_id'] = $validated['receiver_id'];
            // $reqdata['status'] = $validated['status'];


            $chk_sender_id = User::where('id', $request->sender_id)
                ->where('phone_verified_at', '!=', null)->first();

            $chk_receiver_id = User::where('id', $request->receiver_id)
                ->where('phone_verified_at', '!=', null)->first();



            if (!empty($chk_sender_id) && !empty($chk_receiver_id)) { # exist in database user table !!
                if ($request->sender_id == $id) { # sender is equeal to auth user !!
                    $sender_in_request_tbl = Requests::where('sender_id', $request->sender_id)->where('receiver_id', $request->receiver_id)->first();
                    if (!empty($sender_in_request_tbl)) { # checking the record is exist or not in request tbl !!
                        if ($request->sender_id == $id) {
                            if ($sender_in_request_tbl->status == 0) {
                                return ApiResponse::ok('Sorry!! Request has been already sent before!!');
                            } elseif ($sender_in_request_tbl->status == 1) {
                                return ApiResponse::ok('Your request already accepted!!');
                            } else {
                                $verified['status'] = 0;
                                Requests::where('sender_id', $request->sender_id)
                                    ->where('receiver_id', $request->receiver_id)->update($verified);
                                DB::commit();
                                return ApiResponse::ok('Your request has been sent again!!');
                            }
                        }
                    } else {
                        if ($request->sender_id == $id && $request->receiver_id == $id) {
                            return ApiResponse::error('Sender and Receiver cannot same');
                        } elseif ($request->sender_id == $id) {
                            Requests::create([
                                'sender_id' => $validated['sender_id'],
                                'receiver_id' => $validated['receiver_id'],
                            ]);
                            DB::commit();
                            $receiver_data = User::where('id', $request->receiver_id)->first();
                            return ApiResponse::ok(
                                'Request Has Been Sent Successfully!!',
                            );
                        } else {
                            return ApiResponse::error('Sender not authenticate');
                        }
                    }
                } elseif ($request->receiver_id == $id) {
                    $validator =  Validator::make($request->all(), [
                        'sender_id'    => ['required', 'numeric'],
                        'receiver_id'  => ['required', 'numeric'],
                        'status'       => ['required', 'in:0,1,2'],
                    ]);

                    if ($validator->fails()) {
                        return $this->validation_error_response($validator);
                    }
                    $reqdata['sender_id'] = $request['sender_id'];
                    $reqdata['receiver_id'] = $request['receiver_id'];
                    $reqdata['status'] = $request['status'];
                    $validated = $validator->validated();
                    if ($request->status == 1) {
                        $verified['status'] = 1;
                        Requests::where('sender_id', $request->sender_id)->where('receiver_id', $request->receiver_id)->update($verified);
                        DB::commit();
                        return ApiResponse::ok('Request accepted');
                    } elseif ($request->status == 2) {
                        $verified['status'] = 2;
                        Requests::where('sender_id', $request->sender_id)->where('receiver_id', $request->receiver_id)->update($verified);
                        DB::commit();
                        return ApiResponse::ok('Request Rejected');
                    } else {
                        $verified['status'] = 0;
                        Requests::where('sender_id', $request->sender_id)->where('receiver_id', $request->receiver_id)->update($verified);
                        DB::commit();
                        return ApiResponse::error('Your request is pending');
                    }
                } else {
                    return ApiResponse::error('Sender Not Login');
                }
            } else {
                if ($chk_receiver_id == null && $chk_sender_id == null) {
                    return ApiResponse::error('Users Not Exist!!');
                } else {
                    if ($chk_receiver_id == null) {
                        return ApiResponse::error('Receiver Not Exist!!');
                    } else {
                        return ApiResponse::error('Sender Not Exist!!');
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    public function showAllRequest()
    {
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;
            $userallrequest = Requests::where('receiver_id', $id)->where('status', 0)->get();
            if (count($userallrequest) != 0) {
                $listarr = [];
                foreach ($userallrequest as $userallreq) {
                    $getid =  $userallreq->sender_id;
                    $users = User::where('id', $getid)->select('id', 'first_name', 'last_name')->get();
                    array_push($listarr, $users);
                }

                $result = collect($listarr)->flatten();
                return ApiResponse::ok(
                    'Requested user list!!',
                    $this->getRequestedUserList($result)
                );
            } else {
                return ApiResponse::error('No user sent you request');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    public function getRequestdata($receiver_data)
    {
        return $receiver_data;
    }

    public function getUser($get)
    {
        return $get;
    }

    public function getRequestedUserList($result)
    {
        return $result;
    }
}
