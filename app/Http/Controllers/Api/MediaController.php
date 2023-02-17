<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Api\ApiResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MediaResource;


class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // try {
        //     DB::beginTransaction();
        //     $auth_user_id = auth()->user()->id;
        //     $medias =  Media::where('user_id', $auth_user_id)->get();
        //     if (!empty($medias)) {

        //         $user_media = MediaResource::collection($medias);
        //         return ApiResponse::ok(
        //             'Media Photos Of User',
        //             $this->mediaimages($user_media)
        //         );
        //     } else {
        //         return ApiResponse::error('No Media Here !!');
        //     }
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return ApiResponse::error($e->getMessage());
        //     logger($e->getMessage());
        // }
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
                    'media_image' => ['required'],
                ]);

                if ($validator->fails()) {
                    return $this->validation_error_response($validator);
                }

                $allowedfileExtension = ['pdf', 'jpg', 'png', 'PNG', 'JPG', 'JPEG'];
                $files = $request->media_image;

                foreach ($files as $file) {

                    // $imageName = time() . '.' . $request->media_image->extension();
                    // $request->media_image->move(public_path('media'), $imageName);

                    $extension = $file->getClientOriginalExtension();

                    $check = in_array($extension, $allowedfileExtension);

                    if ($check) {
                        foreach ($request->media_image as $key => $mediaFiles) {

                            $name = $mediaFiles->getClientOriginalName();
                            $path = $mediaFiles->move('public/media/', $name);

                            $user = new Media();
                            $user->media_image = $path;
                            $user->user_id = $auth_user_id;
                            $user->save();
                            DB::commit();
                            $img[$key]=asset("public/media/".$name);
                            $user->media_image = $img;
                        }
                    } else {
                        return ApiResponse::error('invalid file format');
                    }
                    $user_media = new MediaResource($user);
                    return ApiResponse::ok(
                        'Media Added Successfully',
                        $this->mediaimages($user_media)
                    );
                }
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
            $id = auth()->user()->id;
            $medias =  Media::where('user_id', $id)->get();
            if (!empty($medias)) {

                $user_media = MediaResource::collection($medias);
                return ApiResponse::ok(
                    'All Media Of User',
                    $this->mediaimages($user_media)
                );
            } else {
                return ApiResponse::error('No Media Here !!');
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
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;
            if (!empty($id)) {
                $validator =  Validator::make($request->all(), [
                    'media_image' => ['required', 'mimes:jpg,jpeg,png,PNG,JPG,JPEG'],
                ]);

                if ($validator->fails()) {
                    return $this->validation_error_response($validator);
                }


                $imageName = time() . '.' . $request->media_image->extension();
                $request->media_image->move(public_path('media'), $imageName);

                $users = User::find($id)->first();

                # Update data into media table
                $verified['profile_image'] = $request->profile_image;

                $phoneexist = User::where('phone', $request->phone)->select('phone')->first();
                if ($phoneexist) {
                    return ApiResponse::error('Mobile Number Already Exist');
                } else {
                    $veri['phone']        = $request->phone;
                }

                $verified['phone']        = $veri['phone'] ?? $users->phone;

                User::where('id', $auth_user_id)->update($verified);



                # Update data into usersinfo table
                $verifieds['dob'] = $request->dob;
                $verifieds['country'] = $request->country;
                $verifieds['interests'] = $request->interests;
                UserInfo::where('user_id', $auth_user_id)->update($verifieds);


                $users['first_name']  = $verified['first_name'];
                $users['last_name'] = $verified['last_name'];
                $users['phone'] = $verified['phone'];
                $users['gender'] = $verified['gender'];
                $users['dob'] = $verifieds['dob'];
                $users['country'] = $verifieds['country'];
                $users['interests'] = $verifieds['interests'];
                $users['email'] = $users->email;
                $users['phone'] = $users->phone;
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function mediaimages($mediaimages)
    {
        return $mediaimages;
    }
}
