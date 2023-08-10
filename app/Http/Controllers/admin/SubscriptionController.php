<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use DataTables;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SubscriptionPlan::latest()->get();
            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route("subscription.edit",$row->id).'" class="edit btn btn-success btn-sm"><i class="feather icon-eye"></i></a>  <!--<a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="feather icon-trash-2"></i></a>-->';
                    return $actionBtn;
                })
                ->addColumn('free_boost_per_month_1', function ($row) {
                    $status = $row->free_boost_per_month_1 == '1' ? 'checked' : '';
                    $toggleClass = $row->free_boost_per_month_1 == '1' ? 'active' : 'inactive';
                    
                    return '<label class="switch">
                                <input type="checkbox"  class="js-switch-primary-small"  data-id="' . $row->id . '" ' . $status . ' />
                                <span class="slider round ' . $toggleClass . '"></span>
                            </label>';
                })

                ->addColumn('unlimited_likes', function ($row) {
                    $status = $row->unlimited_likes == '1' ? 'checked' : '';
                    $toggleClass = $row->unlimited_likes == '1' ? 'active' : 'inactive';
                    
                    return '<label class="switch">
                                <input type="checkbox"  class="js-switch-primary-small"  data-id="' . $row->id . '" ' . $status . ' />
                                <span class="slider round ' . $toggleClass . '"></span>
                            </label>';
                })

                ->addColumn('priority_likes', function ($row) {
                    $status = $row->priority_likes == '1' ? 'checked' : '';
                    $toggleClass = $row->priority_likes == '1' ? 'active' : 'inactive';
                    
                    return '<label class="switch">
                                <input type="checkbox"  class="js-switch-primary-small"  data-id="' . $row->id . '" ' . $status . ' />
                                <span class="slider round ' . $toggleClass . '"></span>
                            </label>';
                })

                ->addColumn('status', function ($row) {
                    $status = $row->status == '1' ? 'checked' : '';
                    $toggleClass = $row->status == '1' ? 'active' : 'inactive';
                    
                    return '<label class="switch">
                                <input type="checkbox"  class="js-switch-primary-small" onclick="updatestatus('. $row->id .')" data-id="' . $row->id . '" ' . $status . ' />
                                <span class="slider round ' . $toggleClass . '"></span>
                            </label>';
                })
                ->rawColumns(['action', 'status','free_boost_per_month_1', 'priority_likes', 'unlimited_likes'])
                ->make(true);
        }
        return view('subscription.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subscription.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'plan_name' => 'required|unique:subscription_plans',
            'price' => 'required|numeric',
        ],[
            'plan_name' => 'Please Enter Plan Name!',
            'price' => 'Please Enter Plan Price!'
        ]);
        $data = [
            'plan_name' => $request->plan_name,
            'price' => $request->price,
            'unlimited_likes' => $request->unlimited_likes,
            'see_who_likes_you' => $request->see_who_likes_you,
            'priority_likes' => $request->priority_likes,
            'unlimited_rewinds' => $request->unlimited_rewinds,
            'free_boost_per_month_1' => $request->free_super_likes_per_week,
            'free_super_likes_per_week_5' => $request->free_boost_per_month,
            'top_pics' =>$request->top_pics,
            'passport' =>$request->passport,
            'message_before_matching'=>$request->message_before_matching,
            'control_who_you_see'=>$request->control_who_you_see,
            'control_who_sees_you'=>$request->control_who_sees_you,
            'control_your_profile'=>$request->control_your_profile,
            'top_pics'=>$request->top_pics,
            'hide_ads'=>$request->hide_ads,
            'status' => $request->status
        ];  
        SubscriptionPlan::create($data);
        return redirect()->route('subscription.index')->with('success', 'Plane Created SuccessFully');
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
        $subcription = SubscriptionPlan::Where('id', $id)->first();
        return view('subscription.edit',compact('subcription'));
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
        $request->validate([
            'plan_name' => 'required',
            'price' => 'required|numeric',
        ],[
            'plan_name' => 'Please Enter Plan Name!',
            'price' => 'Please Enter Plan Price!'
        ]);
        $data = [
            'plan_name' => $request->plan_name,
            'price' => $request->price,
            'unlimited_likes' => $request->unlimited_likes,
            'see_who_likes_you' => $request->see_who_likes_you,
            'priority_likes' => $request->priority_likes,
            'unlimited_rewinds' => $request->unlimited_rewinds,
            'free_boost_per_month_1' => $request->free_super_likes_per_week,
            'free_super_likes_per_week_5' => $request->free_boost_per_month,
            'top_pics' =>$request->top_pics,
            'passport' =>$request->passport,
            'message_before_matching'=>$request->message_before_matching,
            'control_who_you_see'=>$request->control_who_you_see,
            'control_who_sees_you'=>$request->control_who_sees_you,
            'control_your_profile'=>$request->control_your_profile,
            'top_pics'=>$request->top_pics,
            'hide_ads'=>$request->hide_ads,
            'status' => $request->status
        ];  
        SubscriptionPlan::where('id', $id)->update($data);
        return redirect()->route('subscription.index')->with('success', 'Plane Update SuccessFully');
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
    public function subscripptionstatus(Request $request)
    {   
        $subscription = SubscriptionPlan::where('id', $request->id)->first();
        // dd($explore);
        if($subscription->status == 1){
            $data['status'] = 0;
        }else{
            $data['status'] = 1;
        }
        SubscriptionPlan::where('id', $request->id)->update($data);
        return response()->json([
            'status' => 'success'
        ]);
    }
}
