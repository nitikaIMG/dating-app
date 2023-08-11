<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInfo;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('phone', '!=','0000000000')->latest()->get();
            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route("users.edit",$row->id).'" class="edit btn btn-success btn-sm"><i class="feather icon-eye"></i></a>  <!--<a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="feather icon-trash-2"></i></a>-->';
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) {
                    $status = $row->status == '1' ? 'checked' : '';
                    $toggleClass = $row->status == '1' ? 'active' : 'inactive';
                    
                    return '<label class="switch">
                                <input type="checkbox"  class="js-switch-primary-small" onclick="updatestatus('. $row->id .')" data-id="' . $row->id . '" ' . $status . ' />
                                <span class="slider round ' . $toggleClass . '"></span>
                            </label>';
                })
                ->addColumn('gender', function ($row) {
                        if($row->gender == '1'){
                            return 'Female';
                        }
                        if($row->gender == '0'){
                            return 'Male';
                        }
                        if($row->gender == '2'){
                            return 'Other';
                        }
                        if(empty($row->gender))
                        {
                            return 'not select yet!';
                        }
                })
                ->rawColumns(['action','status','gender'])
                ->make(true);
        }
        return view('users.user_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        dd($request->id);
        return view('users.user_profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       dd( $request->all());

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
        $user = User::where('id', $id)->with('UserInfo')->first();
        return view('users.user_profile', compact('user'));
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
       if(!empty($request->first_name)){
        $request->validate([  
            'first_name' => ['required', 'string', 'max:255', 'regex:/^\S*$/u'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^\S*$/u'],
        ],[
            'first_name' => 'First Name is Required!',
            'last_name' => 'Last Name is Required!'
        ]);  
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
       }
       if(!empty($request->usermobile)){
        $request->validate([  
            'usermobile' => 'required|digits:10',
        ],[
            'usermobile' => 'Enter A Valid 10 Digits Phone Number!',
        ]);
        $data['phone'] = $request->usermobile;
       }
    //    if(empty($request->usergender)){
        $request->validate([  
            'usergender' => 'required',
        ],[
            'usergender' => 'Choose Gender !',
        ]);
        $data['gender'] = $request->usergender;
        // dd($data);
    //    }
       if(!empty($request->relationship_goals)){
        $userinfo['relationship_goals'] = $request->relationship_goals;
       }
       if(!empty($request->life_style)){
        $userinfo['life_style'] = $request->life_style;
       }
       if(!empty($request->company)){
        $userinfo['company'] = $request->company;
       }
       if(!empty($request->school)){
        $userinfo['school'] = $request->school;
       }
       if(!empty($request->userinterest)){
        $userinfo['interests'] = $request->userinterest;
       }
       if(!empty($request->userbirthdate)){
            $request->validate([  
                'userbirthdate' =>  'required|date|before:'.now()->subYears(18)->toDateString(),
            ],[
                'userbirthdate' => 'Enter Your Valid Date Of Birth ( +18 )!',
            ]);
            $data['dob'] = $request->userbirthdate;
       }

       #update queries
       $user_update = User::where('id', $id)->update($data);
       if(!empty($userinfo)){

        $save = UserInfo::updateOrCreate([
            'user_id' => $id,
        ],
        $userinfo);
       }
      
       return redirect()->route('users.index')->with('success', 'Record Update Successfully');
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
    public function UserActivedeactive(Request $request)
    {
        $data['status'] = $request->value;
        $update = User::where('id', $request->user_id)->update($data);
        return response()->json([
            'status' => 'success'
        ]);
    }
    public function updateuserstatus(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        // dd(user);
        if($user->status == '1'){
            $data['status'] = 0;
        }else{
            $data['status'] = 1;
        }
        $user->update($data);
        return response()->json([
            'status' => 'success'
        ]);

    }
}
