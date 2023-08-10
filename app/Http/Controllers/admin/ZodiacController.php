<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zodiac;
use DataTables;

class ZodiacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Zodiac::all();
            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route("zodiac.edit",$row->id).'" class="edit btn btn-success btn-sm"><i class="feather icon-eye"></i></a>  <button onclick="deleterecord('. $row->id .')" class="delete btn btn-danger btn-sm"><i class="feather icon-trash-2"></i></button>';
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
        return view('basics.zodiac.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $create = 'zodiac';
        return view('basics.zodiac.create',compact('create'));
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
            'name' => 'required|unique:explores|alpha|min:2|max:30',
        ],[
            'name' => 'enter zodiac name!'
        ]);
   
        $data = [
            'name' => $request->name,
            'status' => $request->status,
        ];
        $save = Zodiac::create($data);
        return redirect()->route('zodiac.index')->with('success', 'Zodiac Created');
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
        $edit = 'zodiac';
        $editdata = Zodiac::where('id', $id)->first();
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
            'name' => 'required|alpha|min:2|max:30||unique:zodiacs,name,'.$id,
        ],[
            'name' => 'enter zodiac name!'
        ]);
   
        $data = [
            'name' => $request->name,
            'status' => $request->status,
        ];
        $update = Zodiac::where('id',$id)->update($data);
        return redirect()->route('zodiac.index')->with('success', 'Zodiac Update');
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
        $delete = Zodiac::where('id', $id)->delete();
        return response()->json([
            'status'=> 'success'
        ]);
    }
}
