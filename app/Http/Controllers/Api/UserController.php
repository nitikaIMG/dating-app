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
use App\Models\{UserRule, LikeProfile, PreferList};
use App\Http\Resources\UserProfileResource;




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
            $id = Auth::user()->id;
           
            $getuserchoice = PreferList::where('user_id', $id)->first();
            // dd($getuserchoice);
                if($getuserchoice->show_me_to !== ''){

                    if(!empty($getuserchoice->age_status == '1')){ 
                        $users = User::where('gender', $getuserchoice->show_me_to)->whereBetween('age', [$getuserchoice->first_age, $getuserchoice->second_age])->with('userInfo')->get();
                    }

                    if($getuserchoice->distance_status == '1' && $getuserchoice->first_distance !== '' ) {
            
                        // Fetch users based on distance and gender preference
                        $latitude = Auth::user()->latitude;
                        $longitude = Auth::user()->longitude;
                        // Convert distance preferences to kilometers
                        $minDistance = $getuserchoice->first_distance;
                        $maxDistance = $getuserchoice->second_distance;
                        
                        // Calculate the bounding box coordinates
                        $earthRadius = 6371; // Earth's radius in kilometers
                        $latRadians = deg2rad($latitude);
                        $lngRadians = deg2rad($longitude);
                        
                        $deltaLat = rad2deg($minDistance / $earthRadius);
                        $deltaLng = rad2deg($minDistance / ($earthRadius * cos($latRadians)));
                        
                        $minLat = $latitude - $deltaLat;
                        $maxLat = $latitude + $deltaLat;
                        $minLng = $longitude - $deltaLng;
                        $maxLng = $longitude + $deltaLng;

                        
                        // $latitude  = $validated['latitude'];
                        // $longitude = $validated['longitude'];


                        // $users = User::selectRaw("id,first_name,last_name,latitude, longitude,
                        // ( 6371 * acos( cos( radians(?) ) *
                        //     cos( radians( latitude ) )
                        //    * cos( radians( longitude ) - radians(?)
                        //    ) + sin( radians(?) ) *
                        //     sin( radians( latitude ) ) )
                        // ) AS distance", [$latitude, $longitude, $latitude])
                        //     ->where('enable_location', 1)
                        //     ->orderBy("distance", 'asc')
                        //     ->offset(0)
                        //     ->limit(20)->get();
                    
                        // Fetch users based on distance and gender preference within the bounding box
                        $users = User:: 
                        selectRaw("id,first_name,last_name,latitude, longitude,
                            ( 6371 * acos( cos( radians(?) ) *
                                cos( radians( latitude ) )
                            * cos( radians( longitude ) - radians(?)
                            ) + sin( radians(?) ) *
                                sin( radians( latitude ) ) )
                            ) AS distance", [$latitude, $longitude, $latitude])->where('gender', $getuserchoice->show_me_to)
                        ->whereBetween('latitude', [$minLat, $maxLat])
                        ->whereBetween('longitude', [$minLng, $maxLng])
                        ->with('userInfo')
                        ->get();
    
                    }

                    if( $getuserchoice->age_status == 1 && $getuserchoice->distance_status == 1){
                        $latitude = Auth::user()->latitude;
                        $longitude = Auth::user()->longitude;
                        // Convert distance preferences to kilometers
                        $minDistance = $getuserchoice->first_distance;
                        $maxDistance = $getuserchoice->second_distance;
                        
                        // Calculate the bounding box coordinates
                        $earthRadius = 6371; // Earth's radius in kilometers
                        $latRadians = deg2rad($latitude);
                        $lngRadians = deg2rad($longitude);
                        
                        $deltaLat = rad2deg($minDistance / $earthRadius);
                        $deltaLng = rad2deg($minDistance / ($earthRadius * cos($latRadians)));
                        
                        $minLat = $latitude - $deltaLat;
                        $maxLat = $latitude + $deltaLat;
                        $minLng = $longitude - $deltaLng;
                        $maxLng = $longitude + $deltaLng;
                        
                        // Fetch users based on distance and gender preference within the bounding box
                        $users = User::where('gender', $getuserchoice->show_me_to)
                        ->whereBetween('latitude', [$minLat, $maxLat])
                        ->whereBetween('longitude', [$minLng, $maxLng])
                        ->with('userInfo')->whereBetween('age', [$getuserchoice->first_age, $getuserchoice->second_age])
                        ->get();
                    
                    }  
                // else{
                    
                //     $users = User::Where('gender', $getuserchoice->show_me_to)->with('UserInfo')->get();
                // }
            }
            else{
                $getuserinterest = UserInfo::where('user_id', $id)->first();
                // dd( $getuserinterest->interests);
                $users = User::Where('gender', $getuserinterest->interests)->where('id','!=',$id)->with('UserInfo')->get();
            }
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
        // dd('dd')
        ## Users Profile Api 
        ## After agreed the rules user will come here and fill details
        try {
            DB::beginTransaction();
            $auth_user_id = auth()->user()->id;
            $users = User::where('id', $auth_user_id)->where('agree_rules_status', 1)->with('UserInfo')->first();
            if (!empty($users)) {
                if (empty($users->profile_image) && empty($users->gender)) {
                    $validator =  Validator::make($request->all(), [
                        'first_name'    => 'required|alpha|min:2|max:30',
                        'last_name'     => 'required|alpha|min:2|max:30',
                        'email'         => 'email|unique:users',
                        'dob'           => 'required',
                        'gender'        => 'required|in:m,f,o',
                        'interests'     => 'required|integer|max:2',
                        'profile_image' => 'required|mimes:jpg,jpeg,png,PNG,JPG,JPEG',
                        'country'       => 'required',
                    ]);

                    if ($validator->fails()) {
                        return $this->validation_error_response($validator);
                    }

                    // image insertion
                    $imageName = time() . '.' . $request->profile_image->extension();
                    $full_path  = $request->profile_image->move(public_path('images'), $imageName);
                    $path = 'public/images/'.$imageName;

                    // add data into users table
                    $verified['first_name']    = $request->first_name;
                    $verified['last_name']     = $request->last_name;
                    $verified['email']         = $request->email;
                    $verified['gender']        = $request->gender;
                    $verified['latitude']      = $request->latitude;
                    $verified['longitude']     = $request->longitude;
                    User::where('id', $auth_user_id)->update($verified);

                    // add data into usersinfo table
                    $verifieds['interests'] = $request->interests;
                    $verifieds['dob']       = $request->dob;
                    $verifieds['country']   = $request->country;
                    UserInfo::where('user_id', $auth_user_id)->update($verifieds);
                    PreferList::updateOrCreate([
                        'user_id' => $auth_user_id,
                    ],
                    $verifieds['show_me_to']);
                    

                    $data['id']           = $auth_user_id;
                    $data['first_name']   = $verified['first_name'];
                    $data['last_name']    = $verified['last_name'];
                    $data['email']        = $verified['email'];
                    $data['gender']       = $verified['gender'];
                    // $data['profile_image'] = $verified['profile_image'];
                    $data['profile_image'] = $path;
                    $data['interests']    = $verifieds['interests'];
                    $data['dob']          = $verifieds['dob'];
                    $data['country']      = $verifieds['country'];

                    DB::commit();

                    return ApiResponse::ok(
                        'User Details Filled Successfully',
                        $this->getUser($data)
                    );
                } else {
                    return ApiResponse::ok(
                        'User Details Already Filled !',
                    );
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
    public function getActiveUser(Request $request)
    {
        try {
            DB::beginTransaction();
            $getusers = User::where(['active_device_id'=>1])->get();
            if (!empty($getusers)) {
                return ApiResponse::ok(
                    'List Of Active Users',
                    $getusers
                );
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No User',
            );
        }
    }
    public function topRatedprofile(Request $request)
    {
        try {
            DB::beginTransaction();
            $mainArray = [];
            $new = [];
            $getusers = LikeProfile::where('like_status','1')->get();
            
            if (!$getusers->isEmpty()) {
                $groupedUsers = $getusers->groupBy('liked_user_id');
                foreach ($groupedUsers as $likedUserId => $users) {
                    $new[] = User::find($likedUserId);
                }
                return ApiResponse::ok(
                    'List Of Top Rated Profiles',
                    $new
                );
            }     
        }
        catch (\Exception $e){
            DB::rollback();
            return ApiResponse::error(
                'No User',
            );
        }
    }
}
