<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Api\ApiResponse;
use DB;
use App\Models\LikeProfile;
use App\Models\User;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        # match found api
        try {
            DB::beginTransaction();
            $id = auth()->user()->id;

            # 1st condition
            $likebysender = LikeProfile::where('sender_id', $id)->where('like_status', 1)->get();
            $likesenderarrs = $likebysender->toArray();

            $arrid1 = [];
            foreach ($likesenderarrs as  $likesenderarr) {
                $id_data1 = $likesenderarr['liked_user_id'];
                array_push($arrid1, $id_data1);
            }

            # 2nd condition
            $likebyreceiver = LikeProfile::where('liked_user_id', $id)->where('like_status', 1)->get();
            $likereceiverarrs = $likebyreceiver->toArray();

            $arrid2 = [];
            foreach ($likereceiverarrs as  $likereceiverarr) {
                $id_data2 = $likereceiverarr['sender_id'];
                array_push($arrid2, $id_data2);
            }

            $commonvalues = array_intersect($arrid1, $arrid2);

            $emparray = [];
            foreach ($commonvalues as $cvalue) {
                $user = User::where('id', $cvalue)->select('id', 'first_name', 'last_name', 'age')->get();
                array_push($emparray, $user);
            }

            $res = collect($emparray)->flatten();
            if (!empty($likebysender)) {
                return ApiResponse::ok(
                    'Your match found with !!',
                    $this->getMatchUserData($res)
                );
            } else {
                return ApiResponse::error('Records not found');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage());
            logger($e->getMessage());
        }
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

    public function getMatchUserData($likebyreceiver)
    {
        return $likebyreceiver;
    }
}
