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
            'referred_from'   => ['nullable', 'max:1000'],
            'refer_code'   => ['nullable', 'max:8'],
            'otp'   => ['nullable'],
            'platform' => ['required', 'in:android,ios,web'],
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

            // $user->session_id = $token;
            $user->save();

            DB::commit();

            if (isset($validated['refer_code'])) {
                $this->generateCouponCode($user->refer_by);
            }
            return ApiResponse::ok(
                'OTP has been sent on your mobile no ' . $validated['phone'],
                $this->getUserWithotpverify($user)
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    public function verifyOtp(Request $request)
    {
        $messages = [];

        $validator = Validator::make($request->all(), [
            'phone'    => ['required'],
            'otp'      => ['required', 'numeric'],
            'type'     => ['required', 'in:reg,login'],
            'device_id' => ['required', 'bail', 'nullable', 'max:191'],
        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }
        try {
            DB::beginTransaction();

            $validated = $validator->validated();

            $user = User::where('phone', $validated['phone'])->first();
            if (!empty($user)) {
                if (!empty($user->otp)) {
                    if ($user->otp == $validated['otp']) {
                        $verified['otp'] = NULL;
                        $verified['phone_verified_at'] = now();
                        $verified['active_device_id'] = 1;
                        User::where('id', $user->id)->update($verified);
                        if ($device_id = $request->get('device_id')) {
                            $user->devices()->create([
                                'device_id' => $device_id
                            ]);
                        }
                        $token = JWTAuth::fromUser($user);
                        $type = ($request->type == 'reg') ? true : ((!empty($user->dob)) ? false : true);
                        $message = ($request->type == 'reg') ? 'Registration Sucessfully!' : 'Login Successfully';
                        DB::commit();
                        return ApiResponse::ok(
                            $message,
                            $this->getUserWithToken($token, $user, $type)
                        );
                    } else {
                        return ApiResponse::error('Please enter a valid OTP');
                    }
                } else {
                    return ApiResponse::error('OTP get expired!. Please resend');
                }
            } else {
                return ApiResponse::error('Invalid Phone Number');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    public function resendOtp(Request $request)
    {
        $messages = [];

        $validator = Validator::make($request->all(), [
            'phone'         => ['required', 'digits:10'],
        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }
        try {
            DB::beginTransaction();
            $user = User::where('phone', $request->phone)->where('phone_verified_at', '!=', NULL)->first();

            # Get the User
            if (!empty($user)) {
                // $user->sendSms($request->phone);
                $code['otp'] = $this->generateOTP();
                User::where('id', $user->id)->update($code);
                return ApiResponse::ok(
                    'OTP has been resent on your mobile no ' . $request->phone,
                );
            } else {
                return ApiResponse::error('Invalid Mobile Number');
            }
            # Return Resonse with Token
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    // login with mobile
    public function loginviamobile(Request $request)
    {
        $messages = [];

        $validator = Validator::make($request->all(), [
            'phone'         => ['required', 'digits:10'],
        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }
        try {
            DB::beginTransaction();
            $user = User::where('phone', $request->phone)->where('phone_verified_at', '!=', NULL)->first();

            # Get the User
            if (!empty($user)) {
                // $user->sendSms($request->phone);
                $code['otp'] = $this->generateOTP();
                User::where('id', $user->id)->update($code);
                return ApiResponse::ok(
                    'OTP has been sent on your mobile no ' . $request->phone,
                );
            } else {
                return ApiResponse::error('Invalid Mobile Number');
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

    // public function generateotp($phone)
    // {
    //     $users =  User::where('phone', $phone)->first();
    //     // $now = now();
    //     if ($users) {
    //         return $users;
    //     }
    //     return User::create([
    //         'otp' => rand('0000', '9999'),
    //     ]);
    // }


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
        if ($user) {
            // User::where('id', $user)->update(['session_id' => null]);
            // $this->auth->logout();
            auth()->logout();
            return ApiResponse::ok('Logged Out Successfully ');
        } else {
            return ApiResponse::error('First login user');
        }
        // $auth = auth()->logout();
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
            'name'              => ['required', 'string', 'min:3', 'max:60'],
            'email'             => ['required', 'email'],
            'profile_image'     => ['required', 'mimes:jpg,jpeg,png,PNG,JPG,JPEG'],
            'social_login_with' => ['required', 'in:google,facebook'],
            'platform'          => ['required', 'in:android,ios,web'],
            'social_id'         => ['required'],
            'device_id'         => ['required', 'nullable'],
        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }

        $imageName = time() . '.' . $request->profile_image->extension();
        $request->profile_image->move(public_path(''), $imageName);
        $device_platform = $request->platform;

        $email = $request->email;
        $socialDatas = User::where('email', $email)->first();

        if (!empty($socialDatas)){
            $token = JWTAuth::fromUser($socialDatas);
            if (empty($socialDatas->refer_code)) {
                $socialDatas->refer_code = $this->getReferralCode($socialDatas->first_name);
                $socialDatas->update();
            }
            $type = (!empty($socialDatas->dob)?false:true);
            return ApiResponse::ok(
                'Login Successfully',
                $this->getUserWithToken($token, $socialDatas,$type)
            );
        } else {
        
            $users = new User();
            $users->first_name = $request->input('name');
            $users->last_name = $request->input('name');
            $users->email = $request->input('email');
            $users->email_verified_at = now();
            $users->remember_token = Str::random(10);
            $users->social_login_with = $request->input('social_login_with');
            $users->platform = $request->input('platform');
            $users->social_id = $request->input('social_id');
            $users->profile_image = $imageName;
            $users->active_device_id = $request->input('active_device_id');
            $users->platform = $device_platform;
            $users->phone_enable = 1;
            $users->refer_code = $this->getReferralCode($request->input('name'));
            $users->referred_from = $request->input('referred_from');
            $users->save();
        
            $token = JWTAuth::fromUser($users);

            $datas = array('user' => $users, 'token' => $token);
            $users->social_login = true;

            if (empty($users->refer_code)) {
                $users->refer_code = $this->getReferralCode($users->first_name);
                $users->update();
            }
            $type = (!empty($socialDatas->dob)?false:true);
                return ApiResponse::ok(
                    'Login Successfully',
                    $this->getUserWithToken($token, $socialDatas,$type)
                );
        }
    }

    public function getUserWithToken($token, $user, $type)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            // 'push_enabled' => $user->setting
            //     ? boolval($user->setting->push_notification)
            //     : false,
            'user' => $user->format(),
            'profile_enable' => $type ?? false,
        ];
    }

    public function getUserWithotpverify($user)
    {
        return $user->format();
    }

    # function usedfor sendmail using userverify mail
    public function sendverifyMail($user, $user_id)
    {
        // Mail::to($user)->send(new UserVerify($user));
        return true;
    }
}
