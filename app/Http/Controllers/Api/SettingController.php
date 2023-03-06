<?php

namespace App\Http\Controllers\API;

use App\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\BlockUser;
use App\Traits\ManageUserTrait;
use DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as JWTAuth;
use Twilio\Rest\Client;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\ProfileResource;
use App\Models\SubscriptionPlan;

class SettingController extends ApiController
{
    use ManageUserTrait;
    public function __construct()
    {
        //
    }

    # Account setting api to show and update phone no
    public function accountsetting(Request $request)
    {
        $messages = [];
        $validator = Validator::make($request->all(), [
            'phone'   => ['digits:10'],
        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }
        try {
            DB::beginTransaction();
            $validated = $validator->validated();
            $id = auth()->user()->id;

            $getuserphone = User::where('id', $id)->select('phone')->first();
            if (!empty($getuserphone)) {

                $data['phone'] = $validated['phone'];
                // $data['otp'] = $this->generateOTP();

                $updatePhone = User::where('id', $id)->update($data);
                DB::commit();

                $getuserphone = User::where('id', $id)->select('phone')->first();

                return ApiResponse::ok(
                    'Account setting updated successfully',
                    $this->getaccountsetting($getuserphone)
                );
            } else {
                return ApiResponse::error('User not login right now');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    # global user list on the basis of global status
    public function globaluser(Request $request)
    {
        $messages = [];
        $validator = Validator::make($request->all(), [
            'global_user_status' => ['required', 'numeric', 'in:0,1'],
        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }

        try {
            DB::beginTransaction();
            $validated = $validator->validated();
            $id = auth()->user()->id;

            $user = User::where('id', $id)->with('UserInfo')->first();


            if (!empty($user)) {
                if ($request->global_user_status == 1 && $user->global_user_status != null) {
                    $data['global_user_status'] = 1;
                    $userupdate = User::where('id', $id)->update($data);
                    DB::commit();

                    $alluser = User::where('phone_verified_at', '!=', null)->with('UserInfo')->get();
                    $userdetail = UserResource::collection($alluser);
                    return ApiResponse::ok(
                        'Globally exist user list',
                        $this->getaccountsetting($userdetail)
                    );
                } else {
                    $data['global_user_status'] = 0;
                    $userupdate = User::where('id', $id)->update($data);
                    DB::commit();
                    $validator = Validator::make($request->all(), [
                        'latitude'        => ['required', 'between:-90,90'],
                        'longitude'        => ['required', 'between:-180,180'],
                    ]);

                    if ($validator->fails()) {
                        return $this->validation_error_response($validator);
                    }
                    $validated = $validator->validated();
                    $latitude  = $validated['latitude'];
                    $longitude = $validated['longitude'];

                    $users = User::selectRaw("id,first_name,last_name,latitude, longitude,
                        ( 6371 * acos( cos( radians(?) ) *
                            cos( radians( latitude ) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                            sin( radians( latitude ) ) )
                        ) AS distance", [$latitude, $longitude, $latitude])
                        ->where('enable_location', 1)
                        ->orderBy("distance", 'asc')
                        ->offset(0)
                        ->limit(10)
                        ->get();

                    if (!empty($users)) {
                        return ApiResponse::ok(
                            'User list nearby you',
                            $this->getUserWithotpverify($users)
                        );
                    }
                }
            } else {
                return ApiResponse::error('User Not Authenticated!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    # block the user
    public function blockcontact(Request $request)
    {
        $messages = [];
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'digits:10'],
        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }
        try {
            DB::beginTransaction();
            $validated = $validator->validated();
            $id = auth()->user()->id;
            $userget = User::where('phone', $validated['phone'])->where('phone_verified_at', '!=', null)->first();

            if (!empty($userget)) {
                $blockuser = BlockUser::where('blocked_to', $userget->id)->first();
                if (empty($blockuser)) {
                    $data['block_status'] = 1;
                    $data['blocked_by'] = $id;
                    $data['blocked_to'] = $userget->id;

                    $user = BlockUser::create([
                        'block_status' => $data['block_status'],
                        'blocked_by'   => $data['blocked_by'],
                        'blocked_to'   => $data['blocked_to'],
                    ]);
                    DB::commit();
                    return ApiResponse::ok(
                        'User Blocked Successfully',
                    );
                } else {
                    return ApiResponse::error('User already bloked');
                }
            } else {
                return ApiResponse::error('User not exist with this mobile no');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    # showing list of block user
    public function blockcontactlist(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;
            $blockuserlist = BlockUser::where('blocked_by', $id)->with(['user' => function ($query) {
                $query->select('id', 'phone');
            }])->get()->pluck('user')->flatten();

            return ApiResponse::ok(
                'Blocked user list',
                $this->getaccountsetting($blockuserlist)
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    # profile completnes percentage
    public function profilecompletnesper()
    {
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;

            $userdata = User::where('id', $id)->with('UserInfo')->with('media')->first()->toArray();

            $userinfo = $userdata['user_info'];

            $aboutme  =  $userinfo['about_me'];
            $jobtitle =  $userinfo['job_title'];
            $company   =  $userinfo['company'];



            $usermedia = $userdata['media'][0];

            $media = $usermedia['media_image'];
            $explode_media = explode('|', $media);


            $maximumPoints     = 100;
            $Completedaboutus  = 0;
            $Completedjobtitle = 0;
            $Completedcompany  = 0;
            $Completedmedia    = 0;

            if (!empty($id)) {
                if ($aboutme != "" || $aboutme != null) {
                    $Completedaboutus = 35;
                }
                if ($jobtitle != "" || $jobtitle != null) {
                    $Completedjobtitle = 10;
                }
                if ($company != "" || $company != null) {
                    $Completedcompany = 10;
                }
                if ($media != "" || $media != null) {
                    $Completedmedia = round(count($explode_media) * 5.55);
                }
                $data = User::where('id', $id)->select('id', 'first_name', 'last_name')->first();

                $percentage = ($Completedaboutus + $Completedjobtitle + $Completedcompany + $Completedmedia) * $maximumPoints / 100;
                return ApiResponse::ok(
                    $percentage . '% complete',
                    $this->getaccountsetting($data)
                );
            } else {
                return ApiResponse::error('User not authenticated');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    # show subscription plan api
    public function showsubscription(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_name'    => ['required', 'string', 'in:Tinder Plus,Tinder Gold,Tinder Platinum'],
        ]);
        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }
        try {
            DB::beginTransaction();
            $validated = $validator->validated();
            $validated['plan_name'] = $request->plan_name;
            // dd('sdfsn');
            $id = auth()->user()->id;

            if (!empty($id)) {
                $subscription_data = SubscriptionPlan::where('plan_name', $validated['plan_name'])->first();
                // dd($subscription_data);
                if (!empty($subscription_data)) {
                    return ApiResponse::ok(
                        $validated['plan_name'] . ' Active Plans',
                        $this->getaccountsetting($subscription_data)
                    );
                }
            } else {
                return ApiResponse::error('User not authenticated');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }


    public function getUserWithotpverify($user)
    {
        return $user;
    }


    public function getaccountsetting($userd)
    {
        return $userd;
    }
}
