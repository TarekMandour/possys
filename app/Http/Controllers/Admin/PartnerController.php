<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Partner::orderBy('id','desc')->get();
        // $query['data'] = Partner::orderBy('id','desc')->paginate(10);

        return view('admin.partner.index',$query);
    }

    public function store(Request $request)
    { 

        $this->validate(request(),[
            'title' => 'required|string',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ( $img = $request->file('photo') ) {
            $name = 'img_' .time() . '.' .$img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $photo = $name;
        } else {
            $photo = NULL;
        }

        $data = new Partner;
        $data->title = $request->title;
        $data->link = $request->link;
        $data->photo = $photo;

        try {
            $data->save();
        } catch (Exception $e) {
            return redirect('admin/partner')->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function edit(Request $request)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Partner::find($request->id);
        $query['query'] = Partner::orderBy('id','desc')->get();

        return view('admin.partner.model', $query);
    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            'title' => 'required|string',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $row = Partner::find($request->id);

        if ( $img = $request->file('photo') ) {
            $name = 'img_' .time() . '.' .$img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $photo = $name;
        } else {
            $photo = $row->photo;
        }

        $data = Partner::where('id', $request->id)->update([
            'title' => $request->title,
            'link' => $request->link,
            'photo' => $photo
        ]);        

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {   

        try{
            Partner::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
