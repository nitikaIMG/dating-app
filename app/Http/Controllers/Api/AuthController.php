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
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as JWTAuth;
use Twilio\Rest\Client;

class AuthController extends ApiController
{
    use ManageUserTrait;
    public function __construct()
    {
    }

    // registration api
    public function registerUser(Request $request)
    {

        ## Validate Request Inputs
        $messages = [];

        $validator = Validator::make($request->all(), [
            'name'    => ['required', 'string', 'min:3', 'max:60'],
            'email'         => ['required', 'email', 'unique:users'],
            'password'      => ['required', 'string', 'min:8', 'max:8'],
            'phone'         => ['required', 'numeric', 'digits:10', 'unique:users'],
            'dob'           => ['nullable', 'date'],
            'gender'        => ['nullable', 'in:m,f,o'],
            'country'       => ['required', 'string'],
            'device_id'     => ['bail', 'nullable', 'max:191'],
            'referred_from'   => ['nullable', 'max:1000'],
            'refer_code'   => ['nullable', 'max:8'],
            'otp'   => ['nullable'],

        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }

        try {
            DB::beginTransaction();
            # Store Validated Inputs
            $validated = $validator->validated();

            $dob = $request->get('dob');
            $otp = 1234;

            if ($dob && ($dob = strtotime($dob))) {
                $dob = date('Y-m-d', $dob);
            }
            # Create User and store its Information
            $user = User::create([
                'first_name' => $validated['name'],
                'email'     => $validated['email'],
                'password'  => Hash::make($validated['password']),
                'phone'     => $validated['phone'],
                'dob'       => $dob ?? null,
                'gender'    => $validated['gender'] ?? null,
                'type'      => 'user',
                'referred_from' => $validated['referred_from'] ?? '',
                'refer_code' => $this->getReferralCode($validated['name']),
                'refer_by' => (isset($validated['refer_code'])) ? $this->getUserByRefercode($validated['refer_code']) : 0,
                'country'  => $validated['country'],
                'otp'  => $otp,
            ]);
            if (isset($validated['refer_code']) && $this->getUserByRefercode($validated['refer_code']) == 0) {
                return ApiResponse::error('Refer code is Not valid');
            }

            # Create User Info
            $user->info()->create([
                'dob'       => now()->parse($request->dob)->format('Y-m-d'),
                'country'   => $validated['country'],
            ]);

            if ($device_id = $request->get('device_id')) {
                $user->devices()->create([
                    'device_id' => $device_id
                ]);

                $user->active_device_id = $device_id;
            }

            // $user->session_id = $token;
            $user->save();

            DB::commit();

            if (isset($validated['refer_code'])) {
                $this->generateCouponCode($user->refer_by);
            }


            return ApiResponse::ok(
                'Otp has been sent on your mobile no ' . $validated['phone'],
                $this->getUserWithotpverify($user)
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    public function verifyotp(Request $request)
    {
        $messages = [];

        $validator = Validator::make($request->all(), [
            'phone'      => ['required'],
            'otp'      => ['required', 'numeric'],
        ], $messages);


        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }
        try {
            DB::beginTransaction();

            $validated = $validator->validated();

            $user = User::where('phone', $validated['phone'])->first();
            if ($user) {
                if ($user->otp == $validated['otp']) {

                    $token = JWTAuth::fromUser($user);

                    return ApiResponse::ok(
                        'Otp Verified',
                        // $this->getUserWithotpverify($user)
                        $this->getUserWithToken($token, $user)
                    );
                } else {
                    return ApiResponse::error('Please enter a valid Otp');
                }
            } else {
                return ApiResponse::error('Phone no  Not Found');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    // login with mobile
    public function loginwithmobile(Request $request)
    {
        $messages = [];

        $validator = Validator::make($request->all(), [
            'phone'         => ['required', 'digits:10']
        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }
        try {
            DB::beginTransaction();
            // $validated = $validator->validated();            
            // $token = JWTAuth::attempt($validated);


            $user = User::where('phone', $request->phone)->first();
            $token = JWTAuth::fromUser($user);
            if (!$token) {
                return ApiResponse::unauthorized('You have entered an invalid mobile no.');
            }

            # Get the User
            $user = $this->user();

            // $otpupdate = rand('0000', '9999');
            // User::where('phone', $request->phone)->update(['otp' => $otpupdate]);

            // if (empty($user->otp) || !empty($user->otp)) {
            //     $user['otp'] = $otpupdate;
            //     $user->update();
            // }


            if ($user) {
                if ($user->phone == $request->phone) {

                    if (empty($user->active_device_id) || $user->active_device_id == null) {
                        $user->active_device_id = 1;
                        $user->update();
                    }


                    // $user->sendSms($request->phone);
                    return ApiResponse::ok(
                        'Login Successful with mobile no' . $user->phone,
                        $this->getUserWithToken($token, $user)
                    );
                } else {
                    return ApiResponse::error('Mobile number not verified');
                }
            } else {
                return ApiResponse::error('User Not Found');
            }



            # Return Resonse with Token
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }






    // login with email password
    public function loginUser(Request $request)
    {
        ## Validate Request Inputs
        $messages = [];

        $validator = Validator::make($request->all(), [
            'email'         => ['required', 'email'],
            'password'      => ['required', 'string'],
            // 'otp'      => ['required', 'numeric'],
        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }
        try {
            DB::beginTransaction();

            $validated = $validator->validated();

            if (!$token = JWTAuth::attempt($validated)) {
                return ApiResponse::unauthorized('You have entered an invalid username or password.');
            }

            # Get the User
            $user = $this->user();

            if ($user) {
                if ($user->email == $validated['email']) {
                    return ApiResponse::ok(
                        'Login Successful',
                        $this->getUserWithToken($token, $user)
                    );
                } else {
                    return ApiResponse::error('Email not verified');
                }
            } else {
                return ApiResponse::error('User Not Found');
            }

            if (empty($user->refer_code)) {
                $user->refer_code = $this->getReferralCode($user->first_name);
                $user->update();
            }

            # Return Resonse with Token
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }



    public function generateotp($phone)
    {
        $users =  User::where('phone', $phone)->first();
        // $now = now();

        if ($users) {
            return $users;
        }

        return User::create([
            'otp' => rand('0000', '9999'),
        ]);
    }


    public function verifymobile(Request $request)
    {
        $messages = [];

        $validator = Validator::make($request->all(), [
            'phone'         => ['required', 'digits:10']
        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }
        try {
            DB::beginTransaction();
            $user = User::where('phone', $request->phone)->first();
            $token = JWTAuth::fromUser($user);
            if (!$token) {
                return ApiResponse::unauthorized('You have entered an invalid mobile no.');
            }

            # Get the User
            // $user = $this->user();

            // $otpupdate = rand('0000', '9999');
            // User::where('phone', $request->phone)->update(['otp' => $otpupdate]);

            // if (empty($user->otp) || !empty($user->otp)) {
            //     $user['otp'] = $otpupdate;
            //     $user->update();
            // }
            // dd($user);


            if ($user) {
                if ($user->phone == $request->phone) {
                    // $user->sendSms($request->phone);
                    return ApiResponse::ok(
                        'Phone number verified and Otp sent successfully on ' . $user->phone,
                        // $this->getUserWithToken($token, $user)
                    );
                } else {
                    return ApiResponse::error('Mobile number not verified');
                }
            } else {
                return ApiResponse::error('User Not Found');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }









    public function logout()
    {
        $user = auth()->user()->id;
        // dd($user);
        if ($user) {
            // User::where('id', $user)->update(['session_id' => null]);
            // $this->auth->logout();
            auth()->logout();
            return ApiResponse::ok('Logged Out Successfully ');
        } else {
            return ApiResponse::error('First login user');
        }
        // $auth = auth()->logout();
        // dd($auth);

    }


    public function sendSmsOnMobile(Request $request)
    {
        try {
            $sid = env('TWILIO_ID');
            $token = env('TWILIO_TOKEN');
            $phn_no = env('TWILIO_PHN_NO');
            $client = new Client($sid, $token);
            $client->messages->create('+91' . $request->phone, [
                'from' => $phn_no,
                'body' => "Otp sent by twilio",
            ]);

            return ApiResponse::ok(
                'Message Sent',
            );
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
        // return $request->phone;
    }

    #social Login
    public function social_login(Request $request)
    {
        $messages = [];

        $validator = Validator::make($request->all(), [
            'device_id'    => ['required'],
            'social_id'         => ['required'],
            // 'device_id'     => ['bail', 'nullable', 'max:191', 'unique:user_devices,device_id']

        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }

        $device_platform = $request->platform;

        // $socialDatas = User::where('social_id', $request->get('social_id'))
        //     ->first();

        // if( $socialDatas ) {
        //     $errors = [];

        //     if( empty($socialDatas->dob) && empty($request->get('dob')) ) {
        //         $errors['dob_required'] = null;
        //         $errors['gender_required'] = $socialDatas->gender ?? $request->get('gender');
        //     }

        //     if( empty($socialDatas->gender) && empty($request->get('gender')) ) {
        //         $errors['dob_required'] = $socialDatas->dob ?? $request->get('dob');
        //         $errors['gender_required'] = null;
        //     }

        //     if( !empty($errors) ) {
        //         return ApiResponse::ok(
        //             'Dob or gender not filled',
        //             [
        //                 'dob_required' => $errors['dob_required'],
        //                 'gender_required' => $errors['gender_required']
        //             ]
        //         );
        //     }
        // }

        if ($device_platform == "android") {
            // $first_name=$request->first_name;
            // $last_name=$request->last_name;
            $email = $request->email;
            $social_id = $request->social_id;
            $socialDatas = User::where('social_id', $social_id)->where('platform', 'android')->where('email', $email)->first();
            if ($socialDatas) {
                // $userDatas = User::find($socialDatas->id);
                // dd($userDatas);
                $updates = [
                    'dob', 'country', 'gender',
                    'phone', 'refer_code', 'referred_from'
                ];
                $updated = [];

                foreach ($updates as $val) {
                    $updated[$val] = !empty($socialDatas->{$val})
                        ? $socialDatas->{$val} : $request->get($val);
                }

                $socialDatas->fill($updated);

                if ($socialDatas->isDirty()) {
                    $socialDatas->save();
                }
                $token = JWTAuth::fromUser($socialDatas);
                $socialDatas->social_login = true;
                if (empty($socialDatas->refer_code)) {
                    $socialDatas->refer_code = $this->getReferralCode($socialDatas->first_name);
                    $socialDatas->update();
                }
                return ApiResponse::ok(
                    'Login Successful',
                    $this->getUserWithSocialToken($token, $socialDatas)
                );
            } else {
                $socialDatas = User::where('email', $email)->first();
                if ($socialDatas) {
                    // return response()->json([
                    //         "STATUS"=>0,
                    //         "MESSAGE" => "Email already exists",
                    //         "DATA"=>(object)[]
                    // ]);
                    $userDatas = User::find($socialDatas->id);
                    // dd($userDatas);
                    $token = JWTAuth::fromUser($userDatas);
                    if (empty($socialDatas->refer_code)) {
                        $socialDatas->refer_code = $this->getReferralCode($socialDatas->first_name);
                        $socialDatas->update();
                    }
                    return ApiResponse::ok(
                        'Login Successful',
                        $this->getUserWithSocialToken($token, $userDatas)
                    );
                }
                $users = new User();
                $users->verified = 1;
                $users->first_name = $request->input('name');
                $users->last_name = $request->input('name');
                $users->email = $request->input('email');
                $users->email_verified_at = now();
                $users->remember_token = Str::random(10);
                $users->social_login_with = "gmail";
                $users->platform = $request->input('platform');
                $users->social_id = $request->input('social_id');
                $users->dob = $request->input('dob');
                $users->country = $request->input('country') ? $request->input('country') : 'GH';
                $users->gender = $request->input('gender');
                $users->refer_code = $this->getReferralCode($request->input('name'));
                $users->phone = $request->input('phone');
                $users->referred_from = $request->input('referred_from');

                $users->save();
                $users->syncRoles([User::CUSTOMER]);

                # Create User Info
                $users->info()->create([
                    'dob'       => now()->parse($request->input('dob'))->format('Y-m-d'),
                    'country'   => $request->input('country'),
                ]);
                $token = JWTAuth::fromUser($users);

                $datas = array('user' => $users, 'token' => $token);
                $users->social_login = true;
                // dd($users);
                if (empty($users->refer_code)) {
                    $users->refer_code = $this->getReferralCode($users->first_name);
                    $users->update();
                }
                return ApiResponse::ok(
                    'Registered Successfully & Logged In',
                    $this->getUserWithSocialToken($token, $users)
                );
            }
        } else if ($device_platform == "ios") {
            // dd();

            // $first_name=$request->first_name;
            // $last_name=$request->last_name;
            $email = $request->email;
            $social_id = $request->social_id;
            // $socialDatas = User::where('social_id',$social_id)->where('platform','ios')->where('email',$email)->first();
            $socialDatas = User::where('social_id', $social_id)->where('platform', 'ios')->first();
            if ($socialDatas) {
                // $userDatas = User::find($socialDatas->id);
                // dd($userDatas);
                $updates = [
                    'dob', 'country', 'gender',
                    'phone', 'refer_code', 'referred_from'
                ];
                $updated = [];

                foreach ($updates as $val) {
                    $updated[$val] = !empty($socialDatas->{$val})
                        ? $socialDatas->{$val} : $request->get($val);
                }

                $socialDatas->fill($updated);

                if ($socialDatas->isDirty()) {
                    $socialDatas->save();
                }
                $token = JWTAuth::fromUser($socialDatas);
                $socialDatas->social_login = true;
                if (empty($socialDatas->refer_code)) {
                    $socialDatas->refer_code = $this->getReferralCode($socialDatas->first_name);
                    $socialDatas->update();
                }
                return ApiResponse::ok(
                    'Login Successful',
                    $this->getUserWithSocialToken($token, $socialDatas)
                );
            } else {
                // dd();
                $socialEmail = User::where('email', $email)->first();
                if ($socialEmail) {
                    // return response()->json([
                    //         "STATUS"=>409,
                    //         "MESSAGE" => "Email Has Already Been Taken",
                    //         "DATA"=>(object)[]
                    // ]);
                    $userDatas = User::find($socialEmail->id);
                    // dd($userDatas);
                    $token = JWTAuth::fromUser($userDatas);
                    $userDatas->social_login = true;
                    if (empty($userDatas->refer_code)) {
                        $userDatas->refer_code = $this->getReferralCode($userDatas->first_name);
                        $userDatas->update();
                    }
                    return ApiResponse::ok(
                        'Login Successful',
                        $this->getUserWithSocialToken($token, $userDatas)
                    );
                }
                // dd($socialDatas);
                $users = new User();
                $users->verified = 1;
                $users->first_name = $request->input('name');
                $users->last_name = $request->input('name');
                $users->email = $request->input('email');
                $users->email_verified_at = now();
                $users->remember_token = Str::random(10);
                $users->social_login_with = "Apple";
                $users->platform = $request->input('platform');
                $users->social_id = $request->input('social_id');
                $users->dob = $request->input('dob');
                $users->country = $request->input('country') ? $request->input('country') : 'GH';
                $users->gender = $request->input('gender');
                $users->refer_code = $this->getReferralCode($request->input('name'));
                $users->phone = $request->input('phone');
                $users->referred_from = $request->input('referred_from');

                $users->save();
                $users->syncRoles([User::CUSTOMER]);

                # Create User Info
                $users->info()->create([
                    'dob'       => now()->parse($request->input('dob'))->format('Y-m-d'),
                    'country'   => $request->input('country'),
                ]);
                $token = JWTAuth::fromUser($users);
                //$token=""
                $datas = array('user' => $users, 'token' => $token);
                $users->social_login = true;
                if (empty($users->refer_code)) {
                    $users->refer_code = $this->getReferralCode($users->first_name);
                    $users->update();
                }
                return ApiResponse::ok(
                    'Registered Successfully & Logged In',
                    $this->getUserWithSocialToken($token, $users)
                );
            }
        }
    }
    public function getUserWithSocialToken($token, $user)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 2,
            // 'push_enabled' => $user->setting
            //     ? boolval($user->setting->push_notification)
            //     : false,
            'user' => $user->format()
        ];
    }

    public function getUserWithToken($token, $user)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => JWTAuth::factory()->getTTL() * 60,
            // 'push_enabled' => $user->setting
            //     ? boolval($user->setting->push_notification)
            //     : false,
            'user' => $user->format()
        ];
    }


    public function getUserWithotpverify($user)
    {
        return [
            'user' => $user->format()
        ];
    }

    # function usedfor sendmail using userverify mail
    public function sendverifyMail($user, $user_id)
    {
        // Mail::to($user)->send(new UserVerify($user));
        return true;
    }
}
