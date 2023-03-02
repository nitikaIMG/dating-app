<?php

namespace App\Http\Controllers\API;

use App\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Traits\ManageUserTrait;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as JWTAuth;
use Twilio\Rest\Client;
use App\Http\Resources\UserProfileResource;

class FilterController extends ApiController
{
    use ManageUserTrait;
    public function __construct()
    {
        //
    }

    # Filter out on basis on Profile privacy(Men, Women, Everyone)
    public function filterProfilePrivacybyGender(Request $request)
    {
        $messages = [];
        $validator = Validator::make($request->all(), [
            'gender'        => ['in:m,f,o'],
        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }

        try {
            DB::beginTransaction();
            $validated = $validator->validated();

            $user = User::where('gender', $request->gender)->where('phone_verified_at', '!=', null)->with('UserInfo')->get();


            if (!empty($user)) {
                if ($request->gender == 'f') {
                    return ApiResponse::ok(
                        'Filter out on basis on Profile privacy',
                        $this->getUserWithotpverify($user)
                    );
                } elseif ($request->gender == 'm') {
                    return ApiResponse::ok(
                        'Filter out on basis on Profile privacy',
                        $this->getUserWithotpverify($user)
                    );
                } else {
                    $user = User::where('phone_verified_at', '!=', null)->get();
                    return ApiResponse::ok(
                        'Filter out on basis on Profile privacy',
                        $this->getUserWithotpverify($user)
                    );
                }
            } else {
                return ApiResponse::error('User Not Authenticated!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    # Profile of nearby users
    public function filterProfilenearbyusers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude'        => ['required', 'between:-90,90'],
            'longitude'        => ['required', 'between:-180,180'],
            // 'distance'        => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }

        try {
            DB::beginTransaction();
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
                ->limit(20)
                ->get();


            if (!empty($users)) {
                return ApiResponse::ok(
                    'User list nearby you',
                    $this->getUserWithotpverify($users)
                );
            } else {
                return ApiResponse::error('No user found related to ths address');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }


    # Filter out on basis on Age
    public function filterProfilePrivacybyage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_age'        => ['required', 'numeric'],
            'second_age'        => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }
        try {
            DB::beginTransaction();
            $validated = $validator->validated();

            $agefrom = $request->first_age;
            $ageto = $request->second_age;
            $user = User::where('phone_verified_at', '!=', null)->whereBetween('age', [$agefrom, $ageto])->get();
            $userAge = User::whereBetween('age', [$agefrom, $ageto])->get()->toArray();
            if (!empty($user) && !empty($userAge)) {
                return ApiResponse::ok(
                    'User Detail',
                    $this->getUserWithotpverify($user)
                );
            } else {
                return ApiResponse::error('No Data Found Between Required Age');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    #save address with lat long
    public function addLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude'        => ['required', 'between:-90,90'],
            'longitude'        => ['required', 'between:-180,180'],
        ]);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }

        try {
            DB::beginTransaction();
            $validated = $validator->validated();
            $id = auth()->user()->id;

            if (!empty($id)) {
                $data['latitude']  = $validated['latitude'];
                $data['longitude'] = $validated['longitude'];

                User::where('id', $id)->update($data);
                DB::commit();

                return ApiResponse::ok(
                    'Adress added successfully',
                    $this->getUserWithotpverify($data)
                );
            } else {
                return ApiResponse::error('No user found');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    #Recent active users
    public function activeusers()
    {
        try {
            DB::beginTransaction();
            $activeusers = User::where('active_device_id', 1)->select('id', 'first_name', 'last_name', 'email', 'phone', 'active_device_id', 'gender')->get();
            if (!empty($activeusers)) {
                return ApiResponse::ok(
                    'Currently Active Users',
                    $this->getActiveUser($activeusers)
                );
            } else {
                return ApiResponse::error('No user active right now');
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


    public function getActiveUser($userd)
    {
        return $userd;
    }
}
