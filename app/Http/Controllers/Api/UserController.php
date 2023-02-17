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
use App\Models\UserRule;



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
            if (!empty($users)) {
                $userdetail = UserResource::collection($users);
                return ApiResponse::ok(
                    'All Users Details',
                    $this->getUser($userdetail)
                );
            } else {
                return ApiResponse::error('No User Found');
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
        //
    }

    /**
     * Store a details of users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ## Users Profile Api 
        ## After agreed rules user will come here and fill details
        try {
            DB::beginTransaction();
            $auth_user_id = auth()->user()->id;
            $users = User::where('id', $auth_user_id)->where('agree_rules_status', 1)->with('UserInfo')->first();
            if ($users) {
                if (empty($users->profile_image) && empty($users->gender)) {
                    $validator =  Validator::make($request->all(), [
                        'last_name'     => 'required|alpha|min:2|max:30',
                        'dob'           => 'required',
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
                    $verifieds['dob'] = $request->dob;
                    UserInfo::where('user_id', $auth_user_id)->update($verifieds);
                    DB::commit();

                    return ApiResponse::ok(
                        'User Details Added Successfully',
                        $this->getUser($users)
                    );
                } else {
                    return ApiResponse::ok(
                        'User Details Already Exist !',
                        $this->getUser($users)
                    );
                    // return ApiResponse::error('User Details Already Exist !');
                }
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
                return ApiResponse::error('User Not Found');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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

    public function getUser($userdetail)
    {
        // $userdetail['dob'] = $userdetail['UserInfo']['dob'];
        // $userdetail['country'] = $userdetail['UserInfo']['country'];
        // $userdetail['interests'] = $userdetail['UserInfo']['interests'];
        return $userdetail;
    }

    public function getUserdata($users)
    {
        $users['dob'] = $users['UserInfo']['dob'];
        $users['country'] = $users['UserInfo']['country'];
        $users['interests'] = $users['UserInfo']['interests'];
        return $users->formatdata();
    }

    // public function detailofuser(Request $request, $id)
    // {
    //     try {
    //         DB::beginTransaction();
    //         $users = User::where('id', $id)->where('phone_verified_at', '!=', null)->with('UserInfo')->first();
    //         if (!empty($users)) {
    //             return ApiResponse::ok(
    //                 'User Details',
    //                 $this->getUserdata($users)
    //             );
    //         } else {
    //             return ApiResponse::error('User not exist');
    //         }
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return ApiResponse::error($e->getMessage());
    //         logger($e->getMessage());
    //     }
    // }
}
