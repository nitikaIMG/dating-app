<?php

// namespace App\Http\Controllers\Api;
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Console\View\Components\Info;
use App\Http\Resources\UserInfoResource;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as JWTAuth;
use App\Api\ApiResponse;
use App\Http\Resources\UserResource;
use Auth;
use DB;
use Str;



class UserController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();
            $users = User::where('phone_verified_at', '!=', null)->with('UserInfo')->get();
            // dd($users);
            if (!empty($users)) {
                return UserResource::collection($users);
            } else {
                return ApiResponse::error('No Data');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a details of users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $auth_user_id = auth()->user()->id;
            $users = User::where('id', $auth_user_id)->where('active_device_id', 1)->first();

            if ($users) {
                $validator =  Validator::make($request->all(), [
                    'last_name'     => 'required|alpha|min:2|max:30',
                    'last_name'     => 'required|alpha|min:2|max:30',
                    'gender'        => 'required|in:m,f,o',
                    'interests'     => 'required|integer|max:2',
                    'profile_image' => 'required|mimes:jpg,jpeg,png,PNG,JPG,JPEG',
                ]);

                if ($validator->fails()) {
                    return $this->validation_error_response($validator);
                }

                // image insertion
                $imageName = time() . '.' . $request->profile_image->extension();
                $request->profile_image->move(public_path('images'), $imageName);

                // add data into users table
                $verified['last_name']     = $request->last_name;
                $verified['gender']        = $request->gender;
                $verified['profile_image'] = $request->profile_image;
                User::where('id', $auth_user_id)->update($verified);

                // add data into usersinfo table
                $verifieds['interests'] = $request->interests;
                UserInfo::where('user_id', $auth_user_id)->update($verifieds);
                DB::commit();

                return ApiResponse::ok(
                    'User Details Added Successfully',
                    $this->getUser($users)
                );
            } elseif ($users->phone_enable == 1) {  //logged in by social authentication
                $validator =  Validator::make($request->all(), [
                    'phone' => 'required|digits:10',
                ]);

                if ($validator->fails()) {
                    return $this->validation_error_response($validator);
                }

                $verifieddata['phone']        = $request->phone;
                $verifieddata['phone_enable'] = 0;
                User::where('id', $auth_user_id)->update($verifieddata);
            } else {
                return ApiResponse::error('User Details Already Exist !');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            dd($id);
        } catch (\Exception $e) {
            return response()->json(array(['success' => false, 'message' => $e->getMessage()]));
        }
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function getUser($users)
    {
        return $users->format();
    }
    // public function getUserWithotpverify($user)
    // {
    //     return $user->format();
    // }
}
