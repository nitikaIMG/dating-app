<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\{UserInfo, PreferList};
use App\Api\ApiResponse;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserProfileResource;
use DB;
use Auth;

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
        // dd($request->all());
        try {
            DB::beginTransaction();
            $auth_user_id = auth()->user()->id;
            if (!empty($auth_user_id)) {
                $validator =  Validator::make($request->all(), [
                    'first_name'     => ['required', 'string', 'min:3', 'max:60'],
                    'last_name'      => ['required', 'string', 'min:3', 'max:60'],
                    'gender'         => ['required', 'in:0,1,2'],
                    'age'            => ['required', 'numeric'],
                    'enable_location' => ['required', 'in:1,0'],
                    'dob'            => ['required', 'date'],
                    'email'            => 'required|email||unique:users,email,'.$auth_user_id,
                    'country'        => ['required', 'string'],
                    'interests'      => ['required', 'integer', 'max:2'],
                    // 'zodiac'      => ['required', 'integer', 'max:2'],
                    // 'communication_style'      => ['required', 'integer', 'max:2'],
                    // 'personality_type'      => ['required', 'integer', 'max:2'],
                    // 'education'      => ['required', 'integer', 'max:2'],
                    // 'vaccine'      => ['required', 'integer', 'max:2'],
                    // 'relationship_types'      => ['required', 'integer', 'max:2'],
                    // 'receive_love'      => ['required', 'integer', 'max:2'],
                    // 'children'      => ['required', 'integer', 'max:2'],
                    // 'dietary'      => ['required', 'integer', 'max:2'],
                    // 'drink'      => ['required', 'integer', 'max:2'],
                    // 'smoke'      => ['required', 'integer', 'max:2'],
                    // 'pet'      => ['required', 'integer', 'max:2'],
                    // 'workout'      => ['required', 'integer', 'max:2'],
                    // 'sexualorientation'          => ['numeric', 'digits:10'],
                    // 'passion'          => ['numeric', 'digits:10'],
                    // 'language'          => ['numeric', 'digits:10'],
                    // 'sleeping_habit'          => ['numeric', 'digits:10'],
                    'profile_image'  => ['required', 'mimes:jpg,jpeg,png,PNG,JPG,JPEG'],
                ]);

                if ($validator->fails()) {
                    return $this->validation_error_response($validator);
                }


                $imageName = time() . '.' . $request->profile_image->extension();
                 $full_path = $request->profile_image->move(public_path('images'), $imageName);
                $path = 'public/images/'.$imageName;
                // dd($path);

                $users = User::find($auth_user_id)->first();
                
                # Update data into users table
                $verified['first_name']      = $request->first_name;
                $verified['last_name']       = $request->last_name;
                $verified['gender']          = $request->gender;
                $verified['age']             = $request->age;
                $verified['enable_location'] = $request->enable_location;
                $verified['email']   =    $request->email;
                $verified['profile_image']   =    $path;
                $verified['latitude']      = $request->latitude;
                $verified['longitude']     = $request->longitude;
                User::where('id', $auth_user_id)->update($verified);


                # Update data into usersinfo table
                $verifieds['dob'] = $request->dob;
                $verifieds['country'] = $request->country;
                $verifieds['interests'] = $request->interests;

                if(!empty($request->zodiac)){
                    $verifieds['zodiac'] = $request->zodiac;
                }

                if(!empty($request->education)){
                    $verifieds['education'] = $request->education;
                }

                if(!empty($request->personality_type)){
                    $verifieds['personality_type'] = $request->personality_type;
                }
                if(!empty($request->communication_style)){
                    $verifieds['communication_style'] = $request->communication_style;
                }
                if(!empty($request->receive_love)){
                    $verifieds['receive_love'] = $request->receive_love;
                }
                if(!empty($request->relationship_types)){
                    $verifieds['relationship_types'] = $request->relationship_types;
                }

                if(!empty($request->relationship_goal)){
                    $verifieds['relationship_goal'] = $request->relationship_goal;
                }

                if(!empty($request->vaccine)){
                    $verifieds['vaccine'] = $request->vaccine;
                }
                if(!empty($request->children)){
                    $verifieds['children'] = $request->children;
                }
                if(!empty($request->drink)){
                    $verifieds['drink'] = $request->drink;
                }
                if(!empty($request->dietary)){
                    $verifieds['dietary'] = $request->dietary;
                }
                if(!empty($request->workout)){
                    $verifieds['workout'] = $request->workout;
                }
                if(!empty($request->pet)){
                    $verifieds['pet'] = $request->pet;
                }
                if(!empty($request->smoke)){
                    $verifieds['smoke'] = $request->smoke;
                }
                if(!empty($request->sleeping_habit)){
                    $verifieds['sleeping_habit'] = $request->sleeping_habit;
                }
                if(!empty($request->sexualorientation)){
                    $verifieds['sexualorientation'] = $request->sexualorientation;
                }
                if(!empty($request->language)){
                    $verifieds['language'] = $request->language;
                }
                if(!empty($request->passion)){
                    $verifieds['passion'] = $request->passion;
                }

                $preferdata['show_me_to'] = $request->interests;
                if(!empty($request->about_me)){
                    $verifieds['about_me'] = $request->about_me;
                }
                if(!empty($request->life_interests)){
                    $verifieds['life_interests'] = $request->life_interests;
                }
                if(!empty($request->relationship_goals)){
                    $verifieds['relationship_goals'] = $request->relationship_goals;
                }
                if(!empty($request->life_style)){
                    $verifieds['life_style'] = $request->life_style;
                }
                if(!empty($request->job_title)){
                    $verifieds['job_title'] = $request->job_title;
                }
                if(!empty($request->company)){
                    $verifieds['company'] = $request->company;
                }
                if(!empty($request->school)){
                    $verifieds['school'] = $request->school;
                }
         
                UserInfo::where('user_id', $auth_user_id)->update($verifieds);

                
                $users['first_name']      = $verified['first_name'];
                $users['last_name']       = $verified['last_name'];
                $users['gender']          = $verified['gender'];
                $users['dob']             = $verifieds['dob'];
                $users['age']             = $verified['age'];
                $users['enable_location'] = $verified['enable_location'];
                $users['country']         = $verifieds['country'];
                $users['interests']       = $verifieds['interests'];
                $users['email']           = $users->email;
                DB::commit();
                  
                    
                $userd = new UserProfileResource($users);
               
                PreferList::updateOrCreate([
                    'user_id' => $auth_user_id,
                ],
                $preferdata);
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

    public function myprofile(Request $request)
    {
        try{
            DB::beginTransaction();
            $id =Auth::user()->id;
            $user = User::where(['id'=>$id])->first();
            if(!empty($user)){
                if($user->age_status == 1){$age = $user->age;}else{$age = '';}
                $data = [
                    'profile_image' =>  $user->profile_image,
                    'name' => $user->name,
                    'age' => $age,
                ];
                return ApiResponse::ok(
                    'User Profile',
                    $data
                );
            }
        }
        catch (\Exception $e){
            DB::rollback();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());

        }
    }

    public function ProfileGlobal(Request $request)
    {
        try{
            DB::beginTransaction();
            $id = Auth::user()->id;
            $status = $request->global_user_status;
            $validator = Validator::make($request->all(),[
                'global_user_status' => ['required','in:0,1'],
            ]);
            if($validator->fails()){
                return $this->validation_error_response($validator);
            }
            $validated = $validator->validated();
            $data['global_user_status'] = $status;

            $update = User::where('id', $id)->update($data);
            DB::commit();
            if($update){
              
                return ApiResponse::ok(
                   ( $status==1?'profile set globaly':'profile un set from global'),
                );
            }else{
                return ApiResponse::error('Something went Wrong With Update Query');
            }

        }catch(\Exception $e){
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }
}
