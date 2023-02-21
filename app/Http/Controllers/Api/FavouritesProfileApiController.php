<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Api\ApiResponse;
use App\Models\Favourite;

class FavouritesProfileApiController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator =  Validator::make($request->all(), [
                'sender_id' => ['required'],
                'fav_user_id'    => ['required'],
                'fav_status'    => ['required'],
            ]);

            if ($validator->fails()) {
                return $this->validation_error_response($validator);
            }

            $favdata['sender_id'] = $request['sender_id']; 
            $favdata['receiver_id'] = $request['fav_user_id']; 
            $favdata['status'] = $request['fav_status'];

            $validated = $validator->validated();
            $findfavourites = Favourite::where('sender_id', $request->sender_id)
            ->where('fav_user_id', $request->fav_user_id)->first();
            if ($findfavourites != null) {
                $sender_id = $request->sender_id;
                $favuserid = $request->fav_user_id;
                $fav_status = $request->fav_status;
                $affectedRows = Favourite::where("sender_id", $sender_id)
                ->where("fav_user_id", $favuserid)->update(["fav_status" => $fav_status]);
                DB::commit();
                if ($fav_status == 1) {
                    return ApiResponse::ok(
                        'You UnFavourite This User!!',$this->getfavdata($favdata)
                    );
                } else {
                    return ApiResponse::ok(
                        'You Favourite This User!!',$this->getfavdata($favdata)
                    );
                }
            } else {
                $fav = Favourite::create([
                    'sender_id' => $request->sender_id,
                    'fav_user_id' => $request->fav_user_id,
                    'fav_status' => 0
                ]);
                DB::commit();

                $fav->save();
                return ApiResponse::ok(
                    'You Favourite This User!!',$this->getfavdata($favdata)
                );
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }
    public function getfavdata($favdata){
        return $favdata;
    }
}
