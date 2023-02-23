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
            ])->orderBy('accepted_request_count', 'DESC')->get();

            // $userdetail = UserResource::collection($get);
            return ApiResponse::ok(
                'Most Popular User Profile',
                $this->getUser($get)
            );

            // $dat = User::withCount('requests', function ($categoryTable) {
            //     $categoryTable->where('receiver_id', 2)->select('receiver_id')->get()->count();
            // })->get();
            // return $dat;
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
                'sender_id'    => ['required', 'numeric'],
                'receiver_id'    => ['required', 'numeric'],
            ]);

            if ($validator->fails()) {
                return $this->validation_error_response($validator);
            }
            $reqdata['sender_id'] = $request['sender_id'];
            $reqdata['receiver_id'] = $request['receiver_id'];

            $validated = $validator->validated();

            $chk_id = User::where('id', $request->receiver_id)->orWhere('id', $request->sender_id)->where('phone_verified_at', '!=', null)->get();

            if (!empty($chk_id)) {
                $sender = Requests::where('sender_id', $id)->first();
                $receiver = Requests::where('receiver_id', $id)->first();

                // if (!empty($sender) && $request->sender_id == $id) { # leave it as a comment


                if ($request->sender_id == $id) {
                    if ($sender->status == 0) {
                        return ApiResponse::ok('Sorry!! Request has been already sent before!!');
                    } elseif ($sender->status == 1) {
                        return ApiResponse::ok('Your request already accepted!!');
                    } else {
                        $verified['status'] = 0;
                        Requests::where('sender_id', $request->sender_id)->where('receiver_id', $request->receiver_id)->update($verified);
                        DB::commit();
                        return ApiResponse::ok('Your request has been sent again!!');
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
                        return ApiResponse::ok('Request accepted by you');
                    } elseif ($request->status == 2) {
                        $verified['status'] = 2;
                        Requests::where('sender_id', $request->sender_id)->where('receiver_id', $request->receiver_id)->update($verified);
                        DB::commit();
                        return ApiResponse::ok('Request Rejected by you');
                    } else {
                        return ApiResponse::error('Your request is pending');
                    }
                } else {
                    Requests::create([
                        'sender_id' => $validated['sender_id'],
                        'receiver_id' => $validated['receiver_id'],
                    ]);
                    DB::commit();
                    $receiver_data = User::where('id', $request->receiver_id)->first();
                    return ApiResponse::ok(
                        'Request Has Been Sent Successfully!!',
                        // $this->getRequestData($receiver_data)
                    );
                }
            } else {
                return ApiResponse::error('Users Not Found!');
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
}
