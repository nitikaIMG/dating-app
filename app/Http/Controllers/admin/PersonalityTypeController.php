<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PersonalityType;
use DataTables;

class PersonalityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PersonalityType::all();
            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route("personality.edit",$row->id).'" class="edit btn btn-success btn-sm"><i class="feather icon-eye"></i></a>  <button onclick="deleterecord('. $row->id .')" class="delete btn btn-danger btn-sm"><i class="feather icon-trash-2"></i></button>';
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
        return view('basics.personality.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $create = 'personality';
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
            'name' => 'required|unique:personality_types|alpha|min:2|max:30',
        ],[
            'name' => 'enter personality type name!'
        ]);
   
        $data = [
            'name' => $request->name,
            'status' => $request->status,
        ];
        $save = PersonalityType::create($data);
        return redirect()->route('personality.index')->with('success', 'Personality Type Created');
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
        $edit = 'personality';
        $editdata = PersonalityType::where('id', $id)->first();
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
            'name' => 'required|alpha|min:2|max:30||unique:personality_types,name,'.$id,
        ],[
            'name' => 'enter personality name!'
        ]);
   
        $data = [
            'name' => $request->name,
            'status' => $request->status,
        ];
        $update = PersonalityType::where('id',$id)->update($data);
        return redirect()->route('personality.index')->with('success', 'Personality Type Update');
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
        $delete = PersonalityType::where('id', $id)->delete();
        return response()->json([
            'status'=> 'success'
        ]);
    }
}
