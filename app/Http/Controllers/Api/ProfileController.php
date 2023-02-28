<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Api\ApiResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\UserInfo;
use App\Traits\ManageUserTrait;
use DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as JWTAuth;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserInfoResource;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        # profile Api with per and more fields
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;
            $showprofile = User::where('id', $id)->first();
            if (!empty($showprofile)) {

                $data['profile_image']   =  $showprofile->profile_image;
                $data['first_name'] =  $showprofile->first_name;
                $data['last_name'] =  $showprofile->last_name;
                $data['age']   =  $showprofile->age;


                return ApiResponse::ok(
                    'User profile',
                    $this->getdata($data)
                );
            } else {
                return ApiResponse::error('No user login right now');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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

    public function profilepicture(Request $request)
    {
        # profile Api with add and fetch fields

        try {
            DB::beginTransaction();
            $id = auth()->user()->id;

            $showprofile = User::where('id', $id)->with('media')->with('UserInfo')->first();


            $messages = [];
            $validator = Validator::make($request->all(), [
                'about_me'           => ['required', 'string'],
                'life_interests'     => ['required', 'string'],
                'relationship_goals' => ['required', 'string'],
                'life_style'         => ['required', 'string'],
                'job_title'          => ['required', 'string'],
                'company'            => ['required', 'string'],
                'school'             => ['required', 'string'],
            ], $messages);

            if ($validator->fails()) {
                return $this->validation_error_response($validator);
            }

            # submit data in userInfo table
            $about_me           = $request->about_me;
            $life_interests     = $request->life_interests;
            $relationship_goals = $request->relationship_goals;
            $life_style         = $request->life_style;
            $job_title          = $request->job_title;
            $company            = $request->company;
            $school             = $request->school;

            # get data from users table
            $userdata['profile_image'] =  $showprofile->profile_image;
            $userdata['first_name']    =  $showprofile->first_name;
            $userdata['last_name']     =  $showprofile->last_name;
            $userdata['age']           =  $showprofile->age;



            $data['about_me']           =  $about_me;
            $data['life_interests']     =  $life_interests;
            $data['relationship_goals'] =  $relationship_goals;
            $data['life_style']         =  $life_style;
            $data['job_title']          =  $job_title;
            $data['company']            =  $company;
            $data['school']             =  $school;







            if (!empty($showprofile)) {
                $update_data = UserInfo::where('user_id', $id)->update($data);
                DB::commit();

                $showprofiledata = User::with('media')->with('UserInfo')->where('id', $id)->first();
                // dd($showprofiledata);
                $media = $showprofile->media->toArray();
                $user_media = explode('|', $media[0]['media_image']);
                dump($user_media);

                $user_info = $showprofile->UserInfo->toArray();
                dump($user_info);

                $user_age = $showprofile->age;
                dd($user_age);

                

                $udata = new UserInfoResource($update_data);
                return ApiResponse::ok(
                    'Added more information successfully',
                    $this->getprofiledata($udata)
                );
            } else {
                return ApiResponse::error('No user login right now');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    public function getdata($data)
    {
        return $data;
    }

    public function getprofiledata($udata)
    {
        // dd($udata);
        return $udata;
    }
}
