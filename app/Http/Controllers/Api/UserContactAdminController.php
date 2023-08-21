<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as JWTAuth;
use App\Api\ApiResponse;
use Auth;
use DB;

class UserContactAdminController extends Controller
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
            $id = Auth::user()->id;
            $contact = ContactUs::where('user_id', $id)->get();
            if (!empty($getusers)) {
                return ApiResponse::ok(
                    'Messagesn To Admin',
                    $contact
                );
            }
        } catch (\Exception $e){
            DB::rollBack();
            return ApiResponse::error(
                'No One Found',
            );
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
        //
        try{
            DB::beginTransaction();
            $id = Auth::user()->id;
            $validator =  Validator::make($request->all(), [
                'msg_for_admin'      => 'required', 
                'email' => 'required'
            ]);
            
            if ($validator->fails()) {
                return $this->validation_error_response($validator);
            }
            $data['msg_for_admin'] = $request->msg_for_admin;
            $data['user_id'] = $id;
            // $save  = ContactUs::create($data);

            $save = ContactUs::updateOrCreate([
                'user_id'   => $id,
                'msg_for_admin' => $request->msg_for_admin,
                'email' => $request->email
                ],
                $data);

            DB::commit();
            if(!empty($save)){
                return ApiResponse::ok(
                    'Message Sent to Admin',
                );
            }
            else{
                return ApiResponse::error(
                    'something Went Wrong',
                );
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
