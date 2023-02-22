<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Api\ApiResponse;
use App\Http\Resources\RequestResource;

class RequestApiController extends Controller
{

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator =  Validator::make($request->all(), [
                'sender_id'    => ['required'],
                'receiver_id'    => ['required'],
                'status'     => ['required'],
            ]);

            if ($validator->fails()) {
                return $this->validation_error_response($validator);
            }
            $reqdata['sender_id'] = $request['sender_id']; 
            $reqdata['receiver_id'] = $request['receiver_id']; 
            $reqdata['status'] = $request['status']; 

            $validated = $validator->validated();
            $findrequests = Requests::where('receiver_id', $request->receiver_id)->where('sender_id', $request->sender_id)->first();
            if ($findrequests != null) {
                $req = Requests::where('receiver_id', $request->receiver_id)->where('sender_id', $request->sender_id)
                ->update(['status' => $request->status]);
                DB::commit();
                if ($req) {
                    if ($request->status == 1) {
                        return ApiResponse::ok('You Accepted This request!!',
                        $this->getRequestData($reqdata)
                        );
                    } else {
                        return ApiResponse::ok('You Rejected Request!!!!',$this->getRequestData($reqdata));
                    }
                    
                } else {
                    return ApiResponse::error('Something Went Wrong!!',$this->getRequestData($reqdata));
                    
                }
            } else {
                Requests::create([
                    'sender_id' => $validated['sender_id'],
                    'receiver_id' => $validated['receiver_id'],
                ]);
                DB::commit();
                return ApiResponse::ok('Request Has Been Sent!!',$this->getRequestData($reqdata));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    public function getRequestdata($reqdata)
    {
        return $reqdata;
    }
}
