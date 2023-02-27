<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserInfo;
use App\Api\ApiResponse;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserProfileResource;
use DB;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $auth_user_id = auth()->user()->id;
            if (!empty($auth_user_id)) {
                $validator =  Validator::make($request->all(), [
                    'first_name'     => ['required', 'string', 'min:3', 'max:60'],
                    'last_name'      => ['required', 'string', 'min:3', 'max:60'],
                    'gender'         => ['required', 'in:m,f,o'],
                    'age'            => ['required', 'numeric'],
                    'enable_location' => ['required', 'in:1,0'],
                    'dob'            => ['required', 'date'],
                    'country'        => ['required', 'string'],
                    'interests'      => ['required', 'integer', 'max:2'],
                    'phone'          => ['numeric', 'digits:10'],
                    'profile_image'  => ['required', 'mimes:jpg,jpeg,png,PNG,JPG,JPEG'],
                ]);

                if ($validator->fails()) {
                    return $this->validation_error_response($validator);
                }


                $imageName = time() . '.' . $request->profile_image->extension();
                $request->profile_image->move(public_path('images'), $imageName);

                $users = User::find($auth_user_id)->first();
                
                # Update data into users table
                $verified['first_name']      = $request->first_name;
                $verified['last_name']       = $request->last_name;
                $verified['gender']          = $request->gender;
                $verified['age']             = $request->age;
                $verified['enable_location'] = $request->enable_location;
                $verified['profile_image']   = $request->profile_image;
                
                // $phoneexist = User::where('phone', $request->phone)->select('phone')->first();
                // if ($phoneexist) {
                //     return ApiResponse::error('Mobile Number Already Exist');
                // } else {
                //     $veri['phone']        = $request->phone;
                // }

                // $verified['phone']        = $veri['phone'] ?? $users->phone;

                User::where('id', $auth_user_id)->update($verified);



                # Update data into usersinfo table
                $verifieds['dob'] = $request->dob;
                $verifieds['country'] = $request->country;
                $verifieds['interests'] = $request->interests;
                UserInfo::where('user_id', $auth_user_id)->update($verifieds);


                $users['first_name']      = $verified['first_name'];
                $users['last_name']       = $verified['last_name'];
                // $users['phone']           = $verified['phone'];
                $users['gender']          = $verified['gender'];
                $users['dob']             = $verifieds['dob'];
                $users['age']             = $verified['age'];
                $users['enable_location'] = $verified['enable_location'];
                $users['country']         = $verifieds['country'];
                $users['interests']       = $verifieds['interests'];
                $users['email']           = $users->email;
                // $users['phone']           = $users->phone;
                DB::commit();
                // $userd = new UserResource($users);
                $userd = new UserProfileResource($users);
                return ApiResponse::ok(
                    'User Profile Updated Successfully',
                    $this->getUser($userd)
                );
            } else {
                return ApiResponse::error('User Not Authanticated');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            DB::beginTransaction();
            $users = User::where('id', $id)->where('phone_verified_at', '!=', null)->with('UserInfo')->first();
            if (!empty($users)) {
                $udata = new UserProfileResource($users);
                return ApiResponse::ok(
                    'User Details',
                    $this->getUser($udata)
                );
            } else {
                return ApiResponse::error('User not exist');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getUser($userd)
    {
        return $userd;
    }
}
