<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RelationshipType;
use DataTables;


class RelationshipTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        if ($request->ajax()) {
            $data = RelationshipType::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route("relationship_type.edit",$row->id).'" class="edit btn btn-success btn-sm"><i class="feather icon-eye"></i></a> <button type="button" onclick="deleterecord('. $row->id .')" class="delete btn btn-danger btn-sm"><i class="feather icon-trash-2"></i></button>';
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
        return view('basics.relationship_types.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $create = 'relationship_type';
        return view('basics.create',compact('create'));
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
            'name' => 'required|unique:relationship_types|min:2|max:30',
        ],[
            'name' => 'this field is required!'
        ]);
   
        $data = [
            'name' => $request->name,
            'status' => $request->status,
        ];
        $save = RelationshipType::create($data);
        return redirect()->route('relationship_type.index')->with('success', 'Created');
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
        $edit = 'relationship_type';
        $editdata = RelationshipType::where('id', $id)->first();
        return view('basics.edit', compact('editdata','edit'));
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
            'name' => 'required|min:2|max:30|unique:relationship_types,name,'.$id,
        ],[
            'name' => 'this field is required!'
        ]);
   
        $data = [
            'name' => $request->name,
            'status' => $request->status,
        ];
        $update = RelationshipType::where('id',$id)->update($data);
        return redirect()->route('relationship_type.index')->with('success', 'Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleterecord(Request $request)
    {
        $id = $request->id;
        $delete = RelationshipType::where('id', $id)->delete();
        return response()->json([
            'status'=> 'success'
        ]);
    }

    public function updateuserstatus(Request $request)
    {
        $user = RelationshipType::where('id', $request->id)->first();
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