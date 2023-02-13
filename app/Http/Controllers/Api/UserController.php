<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Console\View\Components\Info;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          try {

            $users=User::all();

            return response()->json([
                'data' => $users,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(array(['success' => false, 'message' => $e->getMessage()]));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            // $token="";
            // $user_id=User::where('token',$token)->select('id')->first();
            // dd($user_id);
            $user_id=1;

            $users=UserInfo::where('user_id',$user_id)->where('deleted_at',0)->select('id')->first();
            if(!$users){

            $validator =  Validator::make($request->all(), [
                'name' => 'required|alpha',
                'dob' => 'required|date',
                'gender' => 'required|integer|max:2',
                'interests' => 'required|integer|max:2',
                'photos' => 'required|mimes:jpg,jpeg,png,PNG,JPG,JPEG',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation Fails',
                    'error' => $validator->errors(),
                ], 422);
            }

            $imageName = time().'.'.$request->photos->extension();
            $request->photos->move(public_path('images'), $imageName);

            $users = UserDetail::create([
                'user_id'=>$user_id,
                'name' => $request->name,
                'dob' => date('Y-m-d', strtotime($request->dob)),
                'gender' => $request->gender,
                'interests' => $request->interests,
                'photos' => $imageName,
            ]);

            return response()->json([
                'data' => 'User Details Added Successfully',
            ], 200);
        }else{
            return response()->json([
                'data' => 'User Details Already Exist !',
            ], 200);
        }
        } catch (\Exception $e) {
            return response()->json(array(['success' => false, 'message' => $e->getMessage()]));
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
        try {
            dd($id);
        } catch (\Exception $e) {
            return response()->json(array(['success' => false, 'message' => $e->getMessage()]));
        }
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
    }
}
