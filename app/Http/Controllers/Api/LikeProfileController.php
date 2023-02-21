<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LikeProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Api\ApiResponse;

class LikeProfileController extends Controller
{
    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            $validator =  Validator::make($request->all(), [
                'sender_id'    => ['required'],
                'liked_user_id'    => ['required'],
                'like_status'     => ['required'],
            ]);

            if ($validator->fails()) {
                return $this->validation_error_response($validator);
            }
            $likeddata['sender_id'] = $request['sender_id']; 
            $likeddata['liked_user_id'] = $request['liked_user_id']; 
            $likeddata['like_status'] = $request['like_status']; 

            $validated = $validator->validated();
            $findlikeduser = LikeProfile::where('sender_id', $request->sender_id)
                ->where("liked_user_id", $request->liked_user_id)->first();
            $sender_id = $request->sender_id;
            $likeuserid = $request->liked_user_id;
            $like_status = $request->like_status;
            if ($findlikeduser != null) {
                $affectedRows = LikeProfile::where("sender_id", $sender_id)->where("liked_user_id", $likeuserid)
                ->update(["like_status" => $like_status]);
                DB::commit();
                if ($like_status == 1) {
                    return ApiResponse::ok(
                        'You UnLiked This User!!',$this->getLikeUnlikeResponse($likeddata)
                    );
                } else {
                    return ApiResponse::ok(
                        'You Liked This User!!',$this->getLikeUnlikeResponse($likeddata)
                    );
                }
            } else {
                $fav = LikeProfile::create([
                    'sender_id' => $sender_id,
                    'liked_user_id' => $likeuserid,
                    'like_status' => 0
                ]);
                $fav->save();
                DB::commit();

                return ApiResponse::ok(
                    'You Liked This User!!',$this->getLikeUnlikeResponse($likeddata)
                );
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }


    public function getLikeUnlikeResponse($likeddata){
        return $likeddata;
    }
}
