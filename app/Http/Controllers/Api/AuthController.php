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

class AuthController extends ApiController
{
    use ManageUserTrait;
    public function __construct()
    {
    }

    public function registerUser(Request $request)
    {

        ## Validate Request Inputs
        $messages = [];

        $validator = Validator::make($request->all(), [
            'name'    => ['required', 'string', 'min:3', 'max:60'],
            'email'         => ['required', 'email', 'unique:users'],
            'password'      => ['required', 'string', 'min:8'],
            'phone'         => ['required', 'numeric', 'min:10', 'unique:users'],
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
            if (!$token = JWTAuth::fromUser($user)) {
                // return ApiResponse::unauthorized('Bad Credentials');
                throw new \Exception('JWT could not generate token: 3309');
            }

            $user->session_id = $token;
            $user->save();

            DB::commit();

            /*send mail function*/
            try {
                $this->sendverifyMail($user, $user->id);
            } catch (\Exception $e) {
                logger('Signup issue: ' . $e->getMessage());
            }
            if (isset($validated['refer_code'])) {
                $this->generateCouponCode($user->refer_by);
            }
            # Return Resonse with Token
            return ApiResponse::ok(
                'Registered Successfully & Logged In',
                $this->getUserWithToken($token, $user)
            );
            // return ApiResponse::Notverify2('Verification Link sent to your Email Id. Check your email to verify & Login');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

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

    public function verifyotp(Request $request)
    {
        ## Validate Request Inputs
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

            # Get the User
            $user = $this->user();


            if ($user) {
                if ($user->otp == $validated['otp']) {
                    return ApiResponse::ok(
                        'Otp Verified Successful',
                        $this->getUserWithotpverify($user)
                    );
                } else {
                    return ApiResponse::error('Otp not verified');
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

    public function logout()
    {
        $user = auth()->user()->id;
        User::where('id', $user)->update(['session_id' => null]);
        $this->auth->logout();

        return ApiResponse::ok('Logged Out Successfully ');
    }

    #social Login
    public function social_login(Request $request)
    {
        $messages = [];

        $validator = Validator::make($request->all(), [
            'name'    => ['required', 'string', 'min:3', 'max:60'],
            'email'         => ['required', 'email'],
            'profile_image' => ['required','mimes:jpg,jpeg,png,PNG,JPG,JPEG'],
            'social_login_with' => ['required','in:google,facebook'],
            'platform'=>['required','in:android,ios'],
            'social_id'         => ['required'],
            'active_device_id'    => ['required', 'nullable', 'unique:users,active_device_id']
            // 'device_id'     => ['bail', 'nullable', 'max:191', 'unique:user_devices,device_id']
        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }

        $imageName = time().'.'.$request->profile_image->extension();
        $request->profile_image->move(public_path(''), $imageName);

        $device_platform = $request->platform;

        $socialDatas = User::where('social_id', $request->get('social_id'))
            ->first();

        if ($device_platform == "android") {
            $email = $request->email;
            $social_id = $request->social_id;
            $socialDatas = User::where('social_id', $social_id)->where('platform', 'android')->where('email', $email)->first();

            if ($socialDatas) {
                // $userDatas = User::find($socialDatas->id);
 
                // $updates = [
                //     'dob', 'country', 'gender',
                //     'phone', 'refer_code', 'referred_from'
                // ];
                // $updated = [];

                // foreach ($updates as $val) {
                //     $updated[$val] = !empty($socialDatas->{$val})
                //         ? $socialDatas->{$val} : $request->get($val);
                // }

                // $socialDatas->fill($updated);

                // if ($socialDatas->isDirty()) {
                //     $socialDatas->save();
                // }

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
                // $users->verified = 1;
                $users->first_name = $request->input('name');
                $users->last_name = $request->input('name');
                $users->email = $request->input('email');
                $users->email_verified_at = now();
                $users->remember_token = Str::random(10);
                $users->social_login_with = $request->input('social_login_with');
                $users->platform = $request->input('platform');
                $users->social_id = $request->input('social_id');
                $users->profile_image= $imageName;
                $users->active_device_id= $request->input('active_device_id');
                $users->platform= $device_platform;
                $users->phone_enable=1;
                // $users->dob = $request->input('dob');
                // $users->country = $request->input('country') ? $request->input('country') : 'GH';
                // $users->gender = $request->input('gender');
                $users->refer_code = $this->getReferralCode($request->input('name'));
                // $users->phone = $request->input('phone');
                $users->referred_from = $request->input('referred_from');

                $users->save();
                // $users->syncRoles([User::CUSTOMER]);

                # Create User Info
                // $users->info()->create([
                //     'dob'       => now()->parse($request->input('dob'))->format('Y-m-d'),
                //     'country'   => $request->input('country'),
                // ]);
                $token = JWTAuth::fromUser($users);

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
        } else if ($device_platform == "ios") {
            $email = $request->email;
            $social_id = $request->social_id;
            $socialDatas = User::where('social_id', $social_id)->where('platform', 'ios')->first();
            
            if ($socialDatas) {
                // $userDatas = User::find($socialDatas->id);
                // dd($userDatas);
                // $updates = [
                //     'dob', 'country', 'gender',
                //     'phone', 'refer_code', 'referred_from'
                // ];
                // $updated = [];

                // foreach ($updates as $val) {
                //     $updated[$val] = !empty($socialDatas->{$val})
                //         ? $socialDatas->{$val} : $request->get($val);
                // }

                // $socialDatas->fill($updated);

                // if ($socialDatas->isDirty()) {
                //     $socialDatas->save();
                // }
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
                $socialEmail = User::where('email', $email)->first();
                if ($socialEmail) {
                    // return response()->json([
                    //         "STATUS"=>409,
                    //         "MESSAGE" => "Email Has Already Been Taken",
                    // ]);
                    $userDatas = User::find($socialEmail->id);
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
         
                $users = new User();
                // $users->verified = 1;
                $users->first_name = $request->input('name');
                $users->last_name = $request->input('name');
                $users->email = $request->input('email');
                $users->email_verified_at = now();
                $users->remember_token = Str::random(10);
                $users->social_login_with = $request->input('social_login_with');
                $users->platform = $request->input('platform');
                $users->social_id = $request->input('social_id');
                $users->profile_image= $imageName;
                $users->active_device_id= $request->input('active_device_id');
                $users->platform= $device_platform;
                $users->phone_enable=1;
                // $users->dob = $request->input('dob');
                // $users->country = $request->input('country') ? $request->input('country') : 'GH';
                // $users->gender = $request->input('gender');
                $users->refer_code = $this->getReferralCode($request->input('name'));
                // $users->phone = $request->input('phone');
                $users->referred_from = $request->input('referred_from');
                $users->save();

                # Create User Info
                // $users->info()->create([
                //     'dob'       => now()->parse($request->input('dob'))->format('Y-m-d'),
                //     'country'   => $request->input('country'),
                // ]);
                $token = JWTAuth::fromUser($users);
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
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
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
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
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
