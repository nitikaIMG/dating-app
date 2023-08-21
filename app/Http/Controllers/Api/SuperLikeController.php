<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuperLike;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Api\ApiResponse;
use App\Models\{User, SubscriptionUser};
use App\Http\Resources\UserProfileResource;
use Carbon\Carbon;

class SuperLikeController extends Controller
{
    #list of people/users who likes your profile
    public function index()
    {
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;
            $getusers = SuperLike::where(['super_like_user_id'=>$id, 'super_like_status'=>1])->with('users')->get();
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
            // dd($request->all());
            DB::beginTransaction();
            $id = auth()->user()->id;
            $validator =  Validator::make($request->all(), [
                // 'sender_id'      => ['required', 'numeric'],
                'super_like_user_id'  => ['required', 'numeric'],
            ]);
            
            if ($validator->fails()) {
                return $this->validation_error_response($validator);
            }
            // $likeddata['sender_id']     = $request['sender_id'];
            $likeddata['super_like_user_id'] = $request['super_like_user_id'];
            $validated = $validator->validated();

            $chk_sender_id = User::where('id', $id)
                ->where('phone_verified_at', '!=', null)->first();

            $chk_liked_user_id = User::where('id', $request->super_like_user_id)
                ->where('phone_verified_at', '!=', null)->first();

            $subscription = SubscriptionUser::where('user_id', $id)->first();
            if($subscription){
                
            // dd($request->all());
            if (!empty($chk_sender_id) && !empty($chk_liked_user_id && $subscription->status == '1')){
                if ($id){
                    $findliked = SuperLike::where('sender_id', $id)
                        ->where('super_like_user_id', $request->super_like_user_id)->first();

                    if (!empty($findliked)) {
                        if ($findliked->like_status == 1) {
                            $verified['super_like_status'] = 0;
                            SuperLike::where('sender_id', $id)
                                ->where('super_like_user_id', $request->super_like_user_id)->update($verified);
                            DB::commit();
                            return ApiResponse::ok('You dislike the user profile!!');
                        } else {
                            $verified['super_like_status'] = 1;
                            SuperLike::where('sender_id', $id)
                                ->where('super_like_user_id', $request->super_like_user_id)->update($verified);
                            DB::commit();
                            return ApiResponse::ok('You liked the user profile!!');
                        }
                    } else {
                        $subscription = SubscriptionUser::where('user_id', $id)->first();
                        $formattedDate = Carbon::now()->format('Y-m-d H:i:s');
                        if($subscription->expire_date < $formattedDate)
                        {
                            $updatestatus['status'] = 0;
                            SubscriptionUser::where('user_id', $id)->update($updatestatus);
                            DB::commit();
                            return ApiResponse::ok(
                                'Dear User Your Subscription Is Expire!'
                            );

                        }
                        if($subscription->free_super_like < 5 )
                        {
                            $updatesuper_like['free_super_like'] = $subscription->free_super_like + 1;
                            SubscriptionUser::where('user_id', $id)->update($updatesuper_like);
                            $fav = SuperLike::create([
                                'sender_id' => $id,
                                'super_like_user_id' => $request->super_like_user_id,
                                'super_like_status' => 1
                            ]);
                            DB::commit();
                            return ApiResponse::ok(
                                'User Added in your Super likes!!'
                            );
                        }
                        else{
                            return ApiResponse::error('Your Super Like Limit Complete');
                        }
                    }
                }else {
                    return ApiResponse::error('Login First');
                }
            } else {
                if ($chk_liked_user_id == null && $chk_sender_id == null) {
                    return ApiResponse::error('Users Not Exist!!');
                } else {
                    if ($chk_liked_user_id == null) {
                        return ApiResponse::error('Like profile id not exist!');
                    } else {
                        return ApiResponse::error('Your Plan was Expire! Renew Plan ?');
                    }
                }
            }
        }else{
            return ApiResponse::error('Buy A Plan!');

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


    public function boostaccount(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;
            $subscription = SubscriptionUser::where('user_id', $id)->first();
            if(!empty($subscription)){
                  #check User Subscription 
                  $subscription = SubscriptionUser::where('user_id', $id)->first();
                  if(!empty($subscription)){
                      $formattedDate = Carbon::now()->format('Y-m-d H:i:s');
                      if($subscription->expire_date < $formattedDate)
                      {
                          $updatestatus['status'] = 0;
                          SubscriptionUser::where('user_id', $id)->update($updatestatus);
                          return ApiResponse::ok(
                            'Your Subscription Expire!'
                        ); 
                      }
                  }
                if($subscription->status == '1')
                {
                    if($subscription->boost_status == '1')
                    {
                        return ApiResponse::ok(
                            'Your Account Already In Boost Mode.'
                        ); 
                    }
                    $data['boost_status'] = 0;
                    $user = User::where('id', $id)->update($data);
                    $newdata = [
                        'free_boost_per_month' => 1,
                        'boost_status' => 1
                    ];
                    $new = SubscriptionUser::where('user_id', $id)->update($newdata);
                    DB::commit();
                    return ApiResponse::ok(
                        'Account Boost!!'
                    );
                    
                }
                else{
                    return ApiResponse::error('Plan was Expire!');
                }
            }else{
                return ApiResponse::error('Buy A Plan For Boost!');
            }
        } 
        catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }
}
