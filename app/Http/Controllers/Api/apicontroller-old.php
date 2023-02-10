<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class apicontroller extends Controller
{
    public function register(Request $request)
    {
        // dd($request->all());
        try {
            $validator =  Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
                'mobile' => 'required|digits:10',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation Fails',
                    'error' => $validator->errors(),
                ], 422);
            }
            // $otp = rand(1000, 9999);
            $otp = 1234;
            $users = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'confirm_password' => $request->confirm_password,
                'mobile' => $request->mobile,
                'otp' => $otp,
            ]);

            $users['otp'] = $otp;

            // $usersotp = sendSMS($request->mobile);
            // $messageotp =  "OTP is" . $users['otp'];

            return response()->json([
                'message' => 'Registerd Successfully',
                'data' => $users,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(array(['success' => false, 'message' => $e->getMessage()]));
        }
    }

    public function login(Request $request)
    {
        try {
            $validator =  Validator::make($request->all(), [
                'email' => 'required|email',
                // 'password' => 'required',
                'otp' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation Fails',
                    'error' => $validator->errors(),
                ], 422);
            }

            $users = User::where('email', $request->email)->where('otp', $request->otp)->first();
            dd($users);
            if ($users) {
                if ($request->otp == $users->otp) {
                    $token = $users->createToken('auth-token')->plainTextToken;

                    
                    return response()->json([
                        'message' => 'Login Susccessfull',
                        'token' => $token,
                        'data' => $users,
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Invalid Credentials',
                        'error' => $validator->errors(),
                    ], 400);
                }
            } else {
                return response()->json([
                    'message' => 'Invalid Details',
                    // 'error' => $validator->errors(),
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json(array(['success' => false, 'message' => $e->getMessage()]));
        }
    }

    public function forgot(Request $request)
    {
        try {
            $validator =  Validator::make($request->all(), [
                'email' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation Fails',
                    'error' => $validator->errors(),
                ], 422);
            }

            $users = User::where('email', $request->email)->first();
            if ($users) {
                $token =  Str::random(40);
                // $domain = URL::to('/');
                // $url = $domain . '/resetpassword?token=' . $token;

                $otp = rand(1000, 9999);
                $usersotp = User::where('email', $request->email)->update(['otp' => $otp]);


                $data['otp'] = $otp;
                $data['email'] = $request->email;
                $data['title'] = "Password Reset Mail";
                $data['body'] = "Otp for reset password";

                Mail::send('forgetpassword', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email']);
                    $message->subject($data['title']);
                });

                $datetime = Carbon::now()->format('y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    [
                        'email' => $request->email
                    ],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $datetime,
                    ]
                );


                $users['otp'] = $otp;

                return response()->json([
                    'message' => 'Please Check Your Mail',
                    'data' => $users,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'User Not Found',
                    // 'error' => $validator->errors(),
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json(array(['success' => false, 'message' => $e->getMessage()]));
        }
    }

    public function resetpassword(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $input = $request->all();
                $password = $request->password;
                $password_confirm = $request->password_confirmation;
                $data['otp'] = $request->otp;
                dd($input);
                if ($password == $password_confirm) {
                    $password = Hash::make($request->password);
                    $users =   User::where('id', $request->id)->update(['password' => $password]);

                    print_r('Password Reset Succesfully');
                    die;
                } else {
                    print_r('Password not same as confirm password');
                    die;
                }
            } else {
                $resetdata =  PasswordReset::where('token', $request->token)->first();
                // dd(count($resetdata));
                if (isset($request->token) && (!empty($resetdata))) {
                    $users =   User::where('email', $resetdata->email)->first();
                    return view('resetpassword', compact('users'));
                } else {
                    return view('errors.404');
                }
            }
        } catch (\Exception $e) {
            return response()->json(array(['success' => false, 'message' => $e->getMessage()]));
        }
    }

    // public function logout(Request $request)
    // {
    //     dd('logout');
    //     try {
    //         print_r('logout');
    //         auth()->user()->tokens()->delete();
    //         return [
    //             'message' => 'user logged out'
    //         ];

    //     } catch (\Exception $e) {
    //         return response()->json(array(['success' => false, 'message' => $e->getMessage()]));
    //     }
    // }







    // public function user(Request $request){
    //     dd('user');
    //     return response()->json([
    //         'message' => 'User Fetched Successfully',
    //         'data' => $request->user(),
    //     ], 200);
    // }
}
