<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRule;
use DataTables;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = UserRule::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route("rule.edit",$row->id).'" class="edit btn btn-success btn-sm"><i class="feather icon-eye"></i></a> <button type="button" onclick="deleterecord('. $row->id .')" class="delete btn btn-danger btn-sm"><i class="feather icon-trash-2"></i></button>';
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
                ->rawColumns(['action','status'])
                ->make(true);
        }
        return view('rule.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rule.create');
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
            'name' => 'required |unique:user_rules',
            'rule' => 'required'
        ]);
        $data = [
            'name' => $request->name,
            'terms_conditions' => $request->rule,
            'status' => $request->status
        ];
        UserRule::create($data);
        return redirect()->route('rule.index')->with('success','New Page Create Successfully.');
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
        $rule = UserRule::where('id', $id)->first();
        return view('rule.edit',compact('rule'));
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
            'name' => 'required|min:2|max:30|unique:user_rules,name,'.$id,
            'rule' => 'required'
        ]);
        $data = [
            'name' => $request->name,
            'terms_conditions' => $request->rule,
            'status' => $request->status
        ];
        $update = UserRule::where('id', $id)->update($data);
        return redirect()->route('rule.index')->with('success','rule page update successfully');
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

    public function ckeditorUpload(Request $request)
    {
        $validation = $request->file('upload')->store('', '');
        $request->file('upload')->move(public_path('/storage/uploadimages'), $validation);
        return response()->json(['filename'=>$validation, 'uploaded'=>1,'url'=>asset('public/storage/uploadimages/'.$validation)]);
    }

    public function ruleActivedeactive(Request $request)
    {
        $data['status'] = $request->value;
        $update = UserRule::where('id', $request->rule_id)->update($data);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function updateuserstatus(Request $request)
    {
        $user = UserRule::where('id', $request->id)->first();
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
    public function deleterecord(Request $request)
    {
        $id = $request->id;
        $delete = UserRule::where('id', $id)->delete();
        return response()->json([
            'status'=> 'success'
        ]);
    }
}
