<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Explore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Api\ApiResponse;
use App\Models\User;
use Auth;
use App\Models\{UserInfo, ExploreUser};
use App\Http\Resources\UserProfileResource;


class ExploreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            DB::beginTransaction();
            $GetExplores = Explore::all();
            if(!empty($GetExplores)){
                return ApiResponse::ok(
                    'List Of Explore',
                    $GetExplores
                );
            }
            else{
                return ApiResponse::error('Something Went Wrong!');
            }
        }catch(\Exception $e){
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $validator = Validator::make($request->all(),[
                'name'     => ['required', 'string', 'min:3', 'max:60','unique:explores,name'],
            ]);
            if($validator->fails()){
                return $this->validation_error_response($validator);
            }
            $validated = $validator->validated();

            $data['name'] = $request->name;
            $save = Explore::create($data);
            DB::commit();
            if($save){
                return ApiResponse::ok('Explore Added Successfully');
            }else{
                return ApiResponse::error('Something Went Wrong!');
            }
        }
        catch (\Exception $e){
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

    public function userAddexplore(Request $request)
    {
        try{
            DB::beginTransaction();
            $id = Auth::user()->id;
            

            $explore_id = $request->explore_id;
    
            $update['explore_id'] = $explore_id;

            $save = ExploreUser::updateOrCreate([
                'user_id' => $id,
                'explore_id' => $explore_id
            ]);
            // $updatedata = explore_users::->create($update);
            DB::commit();
            if($save){
                return ApiResponse::ok(
                    'Explore Added'
                );
            }else{
                return ApiResponse::error('Something Went Wrong!');
            }
        }
        catch(\Exception $e){
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
    }

    public function GetSingleExplore(Request $request)
    {
        try{
            $id = $request->explore_id;
            DB::beginTransaction();
            $exploreusers = ExploreUser::where('explore_id',$id)->with('user')->get();
            if (!$exploreusers->isEmpty()) {
                $groupedUsers = $exploreusers->groupBy('user_id');
            }


            $explore = Explore::where(['id'=>$id, 'status'=>1 ])->first();
            if(!empty($groupedUsers)){

                return ApiResponse::ok(
                    ' user list of '.$explore->name,
                    $groupedUsers
                );
            }else{
                return ApiResponse::error(
                    'No Users',
                );
            }
        }
        catch(\Exception $e){
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
        }
    }
}
