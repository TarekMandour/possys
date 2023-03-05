<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Service::orderBy('id','desc')->get();
        // $query['data'] = Admin::orderBy('id','desc')->paginate(10);

        return view('admin.service.index',$query);
    }

    public function show($id)
    {
        $query['data'] = Service::find($id);
        return view('admin.service.show',$query);
    }

    public function create()
    {
        return view('admin.service.create');
    }

    public function store(Request $request)
    { 
        $this->validate($request,[
            'title' => 'required|string',
            'content' => 'required|string',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ( $img = $request->file('photo') ) {
            $name = 'img_' .time() . '.' .$img->getClientOriginalExtension();
            $img->move(public_path('uploads/posts'), $name);
            $photo = $name;
        } else {
            $photo = NULL;
        }

        $data = new Service;
        $data->title = $request->title;
        $data->content = $request->content;
        $data->title_en = $request->title_en;
        $data->content_en = $request->content_en;
        $data->meta_keywords = $request->meta_keywords;
        $data->meta_description = $request->meta_description;
        $data->photo = $photo;
        $data->save();

        return redirect('admin/services')->with('msg', 'تم بنجاح');
    }

    public function edit($id)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Service::find($id);
        return view('admin.service.edit', $query);
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|string',
            'content' => 'required|string',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $row = Service::find($request->id);

        if ( $img = $request->file('photo') ) {
            $name = 'img_' .time() . '.' .$img->getClientOriginalExtension();
            $img->move(public_path('uploads/posts/'), $name);
            $photo = $name;
        } else {
            $photo = $row->photo;
        }

        $data = Service::where('id', $request->id)->update([
            'title' => $request->title,
            'content' => $request->content,
            'title_en' => $request->title_en,
            'content_en' => $request->content_en,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'photo' => $photo
        ]);        
        
        return redirect('admin/services')->with('msg', 'تم بنجاح');
    }

    public function delete(Request $request)
    {   

        try{
            Service::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
