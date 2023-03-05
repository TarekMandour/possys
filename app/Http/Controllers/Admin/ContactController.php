<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Contact::orderBy('id','desc')->get();
        // $query['data'] = Admin::orderBy('id','desc')->paginate(10);

        return view('admin.contact.index',$query);
    }

    public function show($id)
    {
        $query['data'] = Contact::find($id);
        return view('admin.contact.show',$query);
    }

    public function create()
    {
        return view('admin.contact.create');
    }

    public function store(Request $request)
    { 
        $this->validate($request,[
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'msg' => 'required|string',
        ]);

        $data = new Contact;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->msg = $request->msg;
        $data->save();

        return redirect('admin/contacts')->with('msg', 'تم بنجاح');
    }

    public function edit($id)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Contact::find($id);
        return view('admin.contact.edit', $query);
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'msg' => 'required|string',
        ]);

        $data = Contact::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'msg' => $request->msg
        ]);        
        
        return redirect('admin/contacts')->with('msg', 'تم بنجاح');
    }

    public function delete(Request $request)
    {   

        try{
            Contact::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
