<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Explore;
use App\Models\User;
use App\Models\UserInfo;
use DataTables;
use Storage;


class ExploreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Explore::latest()->get();
            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route("explore.edit",$row->id).'" class="edit btn btn-success btn-sm"><i class="feather icon-eye"></i></a>  <!--<a href="javascript:void(0)" class="delete btn btn-danger btn-sm"><i class="feather icon-trash-2"></i></a>-->';
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
                // ->addColumn('gender', function ($row) {
                //         if($row->gender == 'f'){
                //             return 'Female';
                //         }
                //         if($row->gender == 'm'){
                //             return 'Male';
                //         }
                //         if($row->gender == 'o'){
                //             return 'Other';
                //         }
                //         if(empty($row->gender))
                //         {
                //             return 'not select yet!';
                //         }
                // })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('explore.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('explore.create');
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
            'file' => 'required|mimes:jpg,jpeg,png,PNG,JPG,JPEG',
        ],[
            'name' => 'Please Enter A Unique Explore\'s Category Name!'
        ]);
        
       if(!empty($request->file)){
           $imageName = time() . '.' . $request->file->extension();;
           $full_path = $request->file->move(public_path('images'), $imageName);
           $path = 'public/images/'.$imageName;
        }
        $data = [
            'name' => $request->name,
            'status' => $request->status,
            'thumbnail' => $path
        ];
        $save = Explore::create($data);
        return redirect()->route('explore.index')->with('success', 'Explore Category Created');
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
        $explore = Explore::where('id', $id)->first();
        return view('explore.edit', compact('explore'));
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
            $old_img = Explore::where('id', $id)->value('thumbnail');
        
            $request->validate([
                // 'name' => 'required|alpha|min:2|max:3|unique:explores,name,'.$id,
            ],[
                // 'name' => 'Please Enter A Unique Explore\'s Category Name!'
            ]);
            $data = [
                'name' => $request->name,
                'status' => $request->status,
            ];

           if(!empty($request->file)){
            $request->validate([
                'file' => 'required|mimes:jpg,jpeg,png,PNG,JPG,JPEG',
            ]);
            $imageName = time() . '.' . $request->file->extension();;
            $full_path = $request->file->move(public_path('images'), $imageName);
            $path = 'public/images/'.$imageName;
            $data['thumbnail'] = $path;
                if($old_img){
                    Storage::delete($old_img);
                }

            }
           
            
            $update = Explore::where('id', $id)->update($data);
            return redirect()->route('explore.index')->with('success', 'Explore Category Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     

    }

    public function updateexplorestatus(Request $request)
    {
        $explore = Explore::where('id', $request->id)->first();
        // dd($explore);
        if($explore->status == 1){
            $data['status'] = 0;
        }else{
            $data['status'] = 1;
        }
        Explore::where('id', $request->id)->update($data);
        return response()->json([
            'status' => 'success'
        ]);
    }
    public function ExploreActivedeactive(Request $request)
    {
        $data['status'] = $request->value;
        $update = Explore::where('id', $request->explore_id)->update($data);
        return response()->json([
            'status' => 'success'
        ]);
    }
}
