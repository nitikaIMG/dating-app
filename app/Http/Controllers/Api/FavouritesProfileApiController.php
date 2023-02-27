<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Api\ApiResponse;
use App\Models\Favourite;
use App\Models\User;

class FavouritesProfileApiController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;
            $validator =  Validator::make($request->all(), [
                'sender_id'   => ['required', 'numeric'],
                'fav_user_id' => ['required', 'numeric'],
            ]);

            if ($validator->fails()) {
                return $this->validation_error_response($validator);
            }
            $validated = $validator->validated();

            $favdata['sender_id'] = $request['sender_id'];
            $favdata['fav_user_id'] = $request['fav_user_id'];

            $chk_sender_id = User::where('id', $request->sender_id)
                ->where('phone_verified_at', '!=', null)->first();
            $chk_fav_user_id = User::where('id', $request->fav_user_id)
                ->where('phone_verified_at', '!=', null)->first();

            if (!empty($chk_sender_id) && !empty($chk_fav_user_id)) {

                if ($request->sender_id == $id) {
                    $findfavourites = Favourite::where('sender_id', $request->sender_id)
                        ->where('fav_user_id', $request->fav_user_id)->first();

                    if (!empty($findfavourites)) {
                        if ($findfavourites->fav_status == 1) {
                            $verified['fav_status'] = 0;
                            Favourite::where('sender_id', $request->sender_id)
                                ->where('fav_user_id', $request->fav_user_id)->update($verified);
                            DB::commit();
                            return ApiResponse::ok('User Remove from your favourites!!');
                        } else {
                            $verified['fav_status'] = 1;
                            Favourite::where('sender_id', $request->sender_id)
                                ->where('fav_user_id', $request->fav_user_id)->update($verified);
                            DB::commit();
                            return ApiResponse::ok('User Added in your favourites!!');
                        }
                    } else {
                        $fav = Favourite::create([
                            'sender_id' => $request->sender_id,
                            'fav_user_id' => $request->fav_user_id,
                            'fav_status' => 1
                        ]);
                        DB::commit();
                        return ApiResponse::ok(
                            'User Added in your favourites!!'
                        );
                    }
                } else {
                    return ApiResponse::error('Login First');
                }
            } else {
                if ($chk_fav_user_id == null && $chk_sender_id == null) {
                    return ApiResponse::error('Users Not Exist!!');
                } else {
                    if ($chk_fav_user_id == null) {
                        return ApiResponse::error('Favourite profile id not exist!');
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
    public function getfavdata($favdata)
    {
        return $favdata;
    }
}
