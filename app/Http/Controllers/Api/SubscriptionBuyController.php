<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Models\Explore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Api\ApiResponse;
use Session;
use Auth;
use Exception;
use App\Models\{UserInfo, ExploreUser,User};
use App\Http\Resources\UserProfileResource;

class SubscriptionBuyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        dd('ok');
        // try {
        //     DB::beginTransaction();
        //     $rules =  UserRule::all();
        //     if ($rules) {
        //         $ruledata = RuleResource::collection($rules);
        //         return ApiResponse::ok(
        //             'Terms and conditions',
        //             $this->getRule($ruledata)
        //         );
        //     } else {
        //         return ApiResponse::error('No Rules Are Mentioned Here !!');
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
        $input = $request->all();

        $curl = curl_init(); 
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://localhost/dating-app/api/subcriptionbuy',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('amount' => $request->amount,'currency' => $request->currency, 'description' => 'Rozerpay',),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
  
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
  
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $order_id = $input['id'];
                $data = [ 'status' => '1'];
                $save = UserInfo::where('subcription_id',$order_id)->update($data);
                
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$request->amount));

            } catch (Exception $e) {
                return  $e->getMessage();
                Session::put('error',$e->getMessage());
                return redirect()->route('addtocart.index')->with('error','payment failed');
            }
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