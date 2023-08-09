<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PreferList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Api\ApiResponse;
use App\Models\User;
use Auth;
use App\Models\{UserInfo, ExploreUser};
use App\Http\Resources\UserProfileResource;

class PreferListController extends Controller
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
        //
        try {
            DB::beginTransaction();
            $id = Auth::user()->id;
            if(!empty($request->age_status)){
                $data['age_status'] = $request->age_status;
            }
            if(!empty($request->distance_status)){
                $data['distance_status'] = $request->distance_status;
            }
            if(!empty($request->first_age)){
                $data['first_age'] = $request->first_age;
                $data['second_age'] = $request->second_age;   
            }
            if(!empty($request->first_distance)){
                $data['first_distance'] = $request->first_distance; 
                $data['second_distance'] = $request->second_distance; 
            }
            if(!empty($request->show_me_to)){
                $data['show_me_to'] = $request->show_me_to;
            }
            $data['user_id'] = $id;
            $save = PreferList::updateOrCreate([
                'user_id' => $id,
            ],
            $data);
            DB::commit();
            if($save){
                return ApiResponse::ok(
                    'Added  Successfully'
                );
            }else{
                return ApiResponse::error(
                    'Something Went Wrong With Prefer Store Query!'
                );
            }
        }catch(\Exception $e){
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
}
