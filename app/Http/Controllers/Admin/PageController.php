<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Page::orderBy('id','desc')->get();
        // $query['data'] = Admin::orderBy('id','desc')->paginate(10);

        return view('admin.page.index',$query);
    }

    public function show($id)
    {
        $query['data'] = Page::find($id);
        return view('admin.page.show',$query);
    }

    public function create()
    {
        return view('admin.page.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|string',
            'content' => 'required|string'
        ]);

        $data = new Page;
        $data->title = $request->title;
        $data->content = $request->content;
        $data->title_en = $request->title_en;
        $data->content_en = $request->content_en;
        $data->meta_keywords = $request->meta_keywords;
        $data->meta_description = $request->meta_description;
        $data->save();

        return redirect('admin/pages')->with('msg', 'تم بنجاح');
    }

    public function edit($id)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Page::find($id);
        return view('admin.page.edit', $query);
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|string',
            'content' => 'required|string'
        ]);

        $row = Page::find($request->id);

        if ( $img = $request->file('photo') ) {
            $name = 'img_' .time() . '.' .$img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $photo = $name;
        } else {
            $photo = $row->photo;
        }
        if ( $img = $request->file('photo2') ) {
            $name = 'img2_' .time() . '.' .$img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $photo2 = $name;
        } else {
            $photo2 = $row->photo2;
        }
        if ( $img = $request->file('photo3') ) {
            $name = 'img3_' .time() . '.' .$img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $photo3 = $name;
        } else {
            $photo3 = $row->photo3;
        }
        if ( $img = $request->file('photo4') ) {
            $name = 'img4_' .time() . '.' .$img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $photo4 = $name;
        } else {
            $photo4 = $row->photo4;
        }

        $data = Page::where('id', $request->id)->update([
            'title' => $request->title,
            'content' => $request->content,
            'title_en' => $request->title_en,
            'content_en' => $request->content_en,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'whywedo' => $request->whywedo,
            'mission' => $request->mission,
            'vision' => $request->vision,
            'photo' => $photo,
            'photo2' => $photo2,
            'photo3' => $photo3,
            'photo4' => $photo4,
        ]);

        return redirect('admin/pages')->with('msg', 'تم بنجاح');
    }

    public function delete(Request $request)
    {

        try{
            Page::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
