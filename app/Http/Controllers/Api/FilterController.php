<?php

namespace App\Http\Controllers\API;

use App\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Traits\ManageUserTrait;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as JWTAuth;
use Twilio\Rest\Client;

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

            $user = User::where('gender', $request->gender)->where('phone_verified_at', '!=', null)->get();

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

    # Filter out Profile nearby users
    public function filterProfilenearbyusers(Request $request)
    {
        dd('nerar by user');
        // if ($request->has('lat') && $request->has('long')) {
        //     $lat = $request->lat;
        //     $long = $request->long;

        //     $data = DB::table("users")
        //         ->select(
        //             "users.id",
        //             DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
        //         * cos(radians(users.lat)) 
        //         * cos(radians(users.long) - radians(" . $long . ")) 
        //         + sin(radians(" . $lat . ")) 
        //         * sin(radians(users.lat))) AS distance")
        //         )
        //         ->groupBy("users.id")
        //         ->get();

        //     dd($data);





        //     //     $parties = DB::select(DB::raw("SELECT *,111.045*DEGREES(ACOS(COS(RADIANS(':lat'))*COS(RADIANS(`latitude`))*COS(RADIANS(`longitude`) - RADIANS(':long'))+SIN(RADIANS(':lat'))*SIN(RADIANS(`latitude`)))) AS distance_in_km FROM parties ORDER BY distance_in_km asc LIMIT 0,5"), array(
        //     //         'lat' => $lat,
        //     //         'long' => $long
        //     //     ));
        //     //     $hidacik = Parties::hydrate($parties);
        //     //     return Fractal::includes('places')->collection($hidacik, new PartyTransformer);
        //     // } else {
        //     //     $parties = Parties::all();
        //     // }
        //     // return Fractal::includes('places')->collection($parties, new PartyTransformer);

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

    public function acceptedRequest(){
        dd('accepted');
    }

    public function getUserWithotpverify($user)
    {
        return $user;
    }
}
