<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Api\ApiResponse;
use App\Models\UserRule;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RuleResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;



class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();
            $rules =  UserRule::all();
            if ($rules) {
                $ruledata = RuleResource::collection($rules);
                return ApiResponse::ok(
                    'Terms and conditions',
                    $this->getRule($ruledata)
                );
            } else {
                return ApiResponse::error('No Rules Are Mentioned Here !!');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $rules =  UserRule::all();
            $auth_user_id = auth()->user()->id;

            $users = User::where('id', $auth_user_id)->first();
            if (!empty($rules)) {
                if (!empty($users)) {
                    $validator =  Validator::make($request->all(), [
                        'agree_rules_status'  => 'required|in:1',
                    ]);

                    if ($validator->fails()) {
                        return $this->validation_error_response($validator);
                    }


                    $verified['agree_rules_status']     = $request->agree_rules_status;
                    User::where('id', $auth_user_id)->update($verified);

                    DB::commit();
                    $userdata = new UserResource($users);

                    return ApiResponse::ok(
                        'Rules Agreed Successfully By User',
                        $this->getUser($userdata)
                    );
                } else {
                    return ApiResponse::error('No User Found');
                }
            } else {
                return ApiResponse::error('No Rules Are Mentioned Here !!');
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

    public function getRule($ruledata)
    {
        return $ruledata;
    }

    public function getUser($userdata)
    {
        // $users['dob'] = $users['UserInfo']['dob'];
        // $users['country'] = $users['UserInfo']['country'];
        // $users['interests'] = $users['UserInfo']['interests'];
        return $userdata;
    }
}
