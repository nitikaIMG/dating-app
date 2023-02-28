<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use DB;
use App\Api\ApiResponse;



class ProfileControlController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [];
        $validator = Validator::make($request->all(), [
            'age_status'      => ['nullable', 'in:1,0'],
            'distance_status' => ['nullable', 'in:1,0'],
        ], $messages);

        if ($validator->fails()) {
            return $this->validation_error_response($validator);
        }

        try {
            DB::beginTransaction();
            $validated = $validator->validated();

            $id = auth()->user()->id;



            $user = User::where('id', $id)->first();
            $get_age = $user->age_status;
            $distance_status = $user->distance_status;
            if (!empty($user)) {

                # For age
                if ($get_age == 0) {
                    $data['age_status'] = 1;
                    User::where('id', $id)->update($data);
                    DB::commit();
                    return ApiResponse::ok(
                        'Age hide successfully',
                    );
                } else {
                    $data['age_status'] = 0;
                    User::where('id', $id)->update($data);
                    DB::commit();
                    return ApiResponse::ok(
                        'Age show successfully',
                    );
                }

                # For distance
                if ($distance_status == 0) {
                    $data['distance_status'] = 1;
                    User::where('id', $id)->update($data);
                    DB::commit();
                    return ApiResponse::ok(
                        'Distance hide successfully',
                    );
                } else {
                    $data['distance_status'] = 0;
                    User::where('id', $id)->update($data);
                    DB::commit();
                    return ApiResponse::ok(
                        'Distance show successfully',
                    );
                }
            } else {
                return ApiResponse::error('User Not Authenticated!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
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
}
