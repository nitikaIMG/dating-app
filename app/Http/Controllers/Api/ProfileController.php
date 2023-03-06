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
        // dd('dfsh');
        # profile Api with per and more fields
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;
            $userdata = User::where('id', $id)->with('UserInfo')->with('media')->first()->toArray();
            if (!empty($userdata)) {

                $usermedia  = $userdata['media'][0];
                $expprofile =  explode('|', $usermedia['media_image']);


                $data['profile_image'] = $expprofile[0];
                $data['first_name']    =  $userdata['first_name'];
                $data['last_name']     =  $userdata['last_name'];
                $data['age']           =  $userdata['age'];

                $userinfo =  $userdata['user_info'];

                $aboutme  =  $userinfo['about_me'];
                $jobtitle =  $userinfo['job_title'];
                $company  =  $userinfo['company'];

                $media = $usermedia['media_image'];
                $explode_media = explode('|', $media);

                $maximumPoints     = 100;
                $Completedaboutus  = 0;
                $Completedjobtitle = 0;
                $Completedcompany  = 0;
                $Completedmedia    = 0;

                if (!empty($id)) {
                    if ($aboutme != "" || $aboutme != null) {
                        $Completedaboutus = 35;
                    }
                    if ($jobtitle != "" || $jobtitle != null) {
                        $Completedjobtitle = 10;
                    }
                    if ($company != "" || $company != null) {
                        $Completedcompany = 10;
                    }
                    if ($media != "" || $media != null) {
                        $Completedmedia = round(count($explode_media) * 5.55);
                    }
                    
                    $percentage = ($Completedaboutus + $Completedjobtitle + $Completedcompany + $Completedmedia) * $maximumPoints / 100;

                    $data['profile_completeness_percentage'] = $percentage . '% complete';
                    return ApiResponse::ok(
                        $percentage . '% complete',
                        $this->getdata($data)
                    );
                } else {
                    return ApiResponse::error('User not authenticated');
                }


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
        # profile Api with add and fetch fields # point no. 13

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

                $media = $showprofile->media->toArray();
                $user_media = explode('|', $media[0]['media_image']);
                $user_info = $showprofile->UserInfo->toArray();
                $user_age = $showprofile->age;
                $user_info['age'] = $user_age;
                $user_info['media'] = $user_media;

                return ApiResponse::ok(
                    'Added more information successfully related to profile',
                    $this->getprofiledata($user_info)
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

    // public function profilepicture(Request $request)
    // {
    //     # profile Api with add and fetch fields # point no. 13

    //     try {
    //         DB::beginTransaction();
    //         $id = auth()->user()->id;

    //         $showprofile = User::where('id', $id)->with('media')->with('UserInfo')->first();


    //         $messages = [];
    //         $validator = Validator::make($request->all(), [
    //             'about_me'           => ['required', 'string'],
    //             'life_interests'     => ['required', 'string'],
    //             'relationship_goals' => ['required', 'string'],
    //             'life_style'         => ['required', 'string'],
    //             'job_title'          => ['required', 'string'],
    //             'company'            => ['required', 'string'],
    //             'school'             => ['required', 'string'],
    //         ], $messages);

    //         if ($validator->fails()) {
    //             return $this->validation_error_response($validator);
    //         }

    //         # submit data in userInfo table
    //         $about_me           = $request->about_me;
    //         $life_interests     = $request->life_interests;
    //         $relationship_goals = $request->relationship_goals;
    //         $life_style         = $request->life_style;
    //         $job_title          = $request->job_title;
    //         $company            = $request->company;
    //         $school             = $request->school;


    //         $data['about_me']           =  $about_me;
    //         $data['life_interests']     =  $life_interests;
    //         $data['relationship_goals'] =  $relationship_goals;
    //         $data['life_style']         =  $life_style;
    //         $data['job_title']          =  $job_title;
    //         $data['company']            =  $company;
    //         $data['school']             =  $school;


    //         if (!empty($showprofile)) {
    //             $update_data = UserInfo::where('user_id', $id)->update($data);
    //             DB::commit();

    //             $showprofiledata = User::with('media')->with('UserInfo')->where('id', $id)->first();

    //             $media = $showprofile->media->toArray();
    //             $user_media = explode('|', $media[0]['media_image']);
    //             $user_info = $showprofile->UserInfo->toArray();
    //             $user_age = $showprofile->age;
    //             $user_info['age'] = $user_age;
    //             $user_info['media'] = $user_media;

    //             return ApiResponse::ok(
    //                 'Added more information successfully related to profile',
    //                 $this->getprofiledata($user_info)
    //             );
    //         } else {
    //             return ApiResponse::error('No user login right now');
    //         }
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return ApiResponse::error($e->getMessage());
    //         logger($e->getMessage());
    //     }
    // }

    public function getdata($data)
    {
        return $data;
    }

    public function getprofiledata($udata)
    {
        return $udata;
    }
}
