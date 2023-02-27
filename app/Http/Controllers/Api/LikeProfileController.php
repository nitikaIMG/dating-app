<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LikeProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Api\ApiResponse;
use App\Models\User;
use App\Http\Resources\UserProfileResource;


class LikeProfileController extends Controller
{
    #list of people/users who likes your profile
    public function index()
    {
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;
            $getusers = LikeProfile::where('liked_user_id', $id)->where('like_status', 1)->with('users')->get();

            if (!empty($getusers)) {
                return ApiResponse::ok(
                    'List Of Users Who Liked Your Profile',
                    $this->getUserlist($getusers)
                );
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No User',
            );
        }
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;
            $validator =  Validator::make($request->all(), [
                'sender_id'      => ['required', 'numeric'],
                'liked_user_id'  => ['required', 'numeric'],
            ]);

            if ($validator->fails()) {
                return $this->validation_error_response($validator);
            }
            $likeddata['sender_id']     = $request['sender_id'];
            $likeddata['liked_user_id'] = $request['liked_user_id'];

            $validated = $validator->validated();

            $chk_sender_id = User::where('id', $request->sender_id)
                ->where('phone_verified_at', '!=', null)->first();

            $chk_liked_user_id = User::where('id', $request->liked_user_id)
                ->where('phone_verified_at', '!=', null)->first();

            if (!empty($chk_sender_id) && !empty($chk_liked_user_id)) {
                if ($request->sender_id == $id) {
                    $findliked = LikeProfile::where('sender_id', $request->sender_id)
                        ->where('liked_user_id', $request->liked_user_id)->first();

                    if (!empty($findliked)) {
                        if ($findliked->like_status == 1) {
                            $verified['like_status'] = 0;
                            LikeProfile::where('sender_id', $request->sender_id)
                                ->where('liked_user_id', $request->liked_user_id)->update($verified);
                            DB::commit();
                            return ApiResponse::ok('You dislike the user profile!!');
                        } else {
                            $verified['like_status'] = 1;
                            LikeProfile::where('sender_id', $request->sender_id)
                                ->where('liked_user_id', $request->liked_user_id)->update($verified);
                            DB::commit();
                            return ApiResponse::ok('You liked the user profile!!');
                        }
                    } else {
                        $fav = LikeProfile::create([
                            'sender_id' => $request->sender_id,
                            'liked_user_id' => $request->liked_user_id,
                            'like_status' => 1
                        ]);
                        DB::commit();
                        return ApiResponse::ok(
                            'User Added in your likes!!'
                        );
                    }
                } else {
                    return ApiResponse::error('Login First');
                }
            } else {
                if ($chk_liked_user_id == null && $chk_sender_id == null) {
                    return ApiResponse::error('Users Not Exist!!');
                } else {
                    if ($chk_liked_user_id == null) {
                        return ApiResponse::error('Like profile id not exist!');
                    } else {
                        return ApiResponse::error('User Not Exist!!');
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }


    public function getLikeUnlikeResponse($likeddata)
    {
        return $likeddata;
    }

    public function getUserlist($data)
    {
        return $data;
    }
}
