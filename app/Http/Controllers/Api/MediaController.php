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
use Illuminate\Support\Facades\Storage;


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

                $query = Media::where('user_id', $auth_user_id)->select('media_image')->first();
                // $mediacount = explode('|', $query->media_image);
                // $total_count = count($mediacount);
                // if ($total_count <= 9) {
                    if (empty($query)) {
                        $images = array();
                        if ($files = $request->file('media_image')) {
                            foreach ($files as $file) {
                                $imgname = md5(rand('1000', '10000'));
                                $extension = strtolower($file->getClientOriginalExtension());
                                $img_full_name = $imgname . '.' . $extension;
                                $upload_path = 'public/media/';
                                $img_url = $upload_path . $img_full_name;
                                $file->move($upload_path, $img_full_name);

                                array_push($images, $img_url);
                            }
                        }


                        $imp_image =  implode('|', $images);
                        $media = Media::insert([
                            'media_image' => $imp_image,
                            'user_id' => $auth_user_id,
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now(),
                        ]);
                        $query1 = Media::where('user_id', $auth_user_id)->first();

                        DB::commit();
                        $user_media = new MediaResource($query1);
                        return ApiResponse::ok(
                            'Media Added Successfully',
                            $this->mediaimages($user_media)
                        );
                    } else {
                        $explode = explode('|', $query->media_image);
                        if ($files = $request->file('media_image')) {
                            foreach ($files as $file) {
                                $imgname = md5(rand('1000', '10000'));
                                $extension = strtolower($file->getClientOriginalExtension());
                                $img_full_name = $imgname . '.' . $extension;
                                $upload_path = 'public/media/';
                                $img_url = $upload_path . $img_full_name;
                                $file->move($upload_path, $img_full_name);

                                array_push($explode, $img_url);
                            }
                        }
                        $imp_image =  implode('|', $explode);

                        $verified['media_image'] = $imp_image;
                        $verified['updated_at']  = \Carbon\Carbon::now();
                        $media = Media::where('user_id', $auth_user_id)->update($verified);

                        DB::commit();
                        $user_media = new MediaResource($query);
                        return ApiResponse::ok(
                            'Media Added Successfully',
                            $this->mediaimages($user_media),
                        );
                    }
                // } else {
                //     return ApiResponse::error('You Can Not Insert More Then 9 Media Images');
                // }
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
            $medias =  Media::where('user_id', $id)->first();
            if (!empty($medias)) {
                $exe_img = explode('|', $medias->media_image);
                $medias =  Media::where('user_id', $id)->first();
                $medias['media_image'] = explode('|', $medias->media_image);
                $user_media = new MediaResource($medias);

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
    public function update(Request $request, $update_key)
    {
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;
            $user_media = Media::where('user_id', $id)->first();
            if (!empty($id)) {
                if (!empty($user_media)) {
                    $explode = explode('|', $user_media->media_image);
                    if (isset($explode[$update_key])) {
                        if ($files = $request->file('media_image')) {
                            $imgname = md5(rand('1000', '10000'));
                            $extension = strtolower($files->getClientOriginalExtension());
                            $img_full_name = $imgname . '.' . $extension;
                            $upload_path = 'public/media/';
                            $img_url = $upload_path . $img_full_name;
                            $files->move($upload_path, $img_full_name);

                            if (!empty($explode[$update_key])) {
                                unlink($explode[$update_key]);
                            }

                            $explode[$update_key] = $img_url;
                        }
                        $imp_image =  implode('|', $explode);

                        $verified['media_image'] = $imp_image;
                        $media = Media::where('user_id', $id)->update($verified);
                        $mediadata = Media::where('user_id', $id)->first();
                        DB::commit();
                        $user = new MediaResource($mediadata);
                        return ApiResponse::ok(
                            'Media Image Updated Successfully',
                            $this->mediaimages($user)
                        );
                    }
                } else {
                    return ApiResponse::error('No Media Exist On this Key!!');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $d_id)
    {
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;
            $user_media_delete = Media::where('user_id', $id)->first();
            $images = explode("|", $user_media_delete->media_image);
            if (isset($images[$d_id])) {
                unlink($images[$d_id]);
                unset($images[$d_id]);
                $arr = implode('|', $images);
                $verified['media_image'] = $arr;
                $media = Media::where('user_id', $id)->update($verified);
                $deleted_media = Media::where('user_id', $id)->first();
                DB::commit();
                $user_media = new MediaResource($deleted_media);
                return ApiResponse::ok(
                    'Media Deleted Successfully',
                    $this->mediaimages($user_media)
                );
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    public function mediaimages($mediaimages)
    {
        return $mediaimages;
    }
}
