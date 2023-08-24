<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Models\User;
use DataTables;
use Mail;
use App\Mail\ContactUsMail;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactUs::with('user')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route("contactus.edit",$row->id).'" class="edit btn btn-success btn-sm"><i class="feather icon-eye"></i></a> <button type="button" onclick="deleterecord('. $row->id .')" class="delete btn btn-danger btn-sm"><i class="feather icon-trash-2"></i></button>';
                    return $actionBtn;
                })
                ->addColumn('name', function($row){
                    $name = $row->user->name;
                    return $name;
                })
                ->addColumn('reply', function($row){
                    if(!empty($row->reply_from_admin)){
                        return $row->reply_from_admin;
                    }
                    else{
                        return '<div style="text-align:center;"><b>--</b></div>';
                    }
                })
                ->addColumn('status', function ($row) {
                    $status = $row->status == '1' ? 'checked' : '';
                    $toggleClass = $row->status == '1' ? 'active' : 'inactive';
                    
                    return '<label class="switch">
                                <input type="checkbox"  class="js-switch-primary-small" onclick="updatestatus('. $row->id .')" data-id="' . $row->id . '" ' . $status . ' />
                                <span class="slider round ' . $toggleClass . '"></span>
                            </label>';
                })
                ->rawColumns(['action','status', 'name','reply'])
                ->make(true);
        }
        return view('contactus.index');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contactus = ContactUs::where('id', $id)->with('user')->first();
        return view('contactus.edit', compact('contactus',));
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
            'reply' => 'required|min:1|max:100'
        ]);
   
        $data = [
            'reply_from_admin' => $request->reply,
        ];

        $email = 'aksharma72299@gmail.com';
        $contactus = ContactUs::where('id', $id)->with('user')->first();
        // $email = User::where('id', $contactus->user_id)->value('email');
        $email = $contactus->email;
        if(!empty($email)){
            Mail::to($email)->send(new ContactUsMail($request->reply, 'email.contact_to_admin', 'Contact Us'));
        }

        $update = ContactUs::where('id',$id)->update($data);
        return redirect()->route('contactus.index')->with('success', 'Update');
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
    public function updateuserstatus(Request $request)
    {
        $user = ContactUs::where('id', $request->id)->first();
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
    public function ContactusActivedeactive(Request $request)
    {
        $data['status'] = $request->value;
        $update = ContactUs::where('id', $request->contact_id)->update($data);
        return response()->json([
            'status' => 'success'
        ]);
    }
    public function deleterecord(Request $request)
    {
        $id = $request->id;
        $delete = ContactUs::where('id', $id)->delete();
        return response()->json([
            'status'=> 'success'
        ]);
    }
}
