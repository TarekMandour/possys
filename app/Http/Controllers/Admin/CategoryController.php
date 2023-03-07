<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Category::orderBy('id','desc')->get();
        // $query['data'] = Category::orderBy('id','desc')->paginate(10);

        return view('admin.category.index',$query);
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
            $photo = url('/').'/public/uploads/'.$name;
        } else {
            $photo = NULL;
        }

        $data = new Category;
        $data->title = $request->title;
        $data->title_en = $request->title_en;
        $data->parent = $request->parent;
        $data->meta_keywords = $request->meta_keywords;
        $data->meta_description = $request->meta_description;
        $data->photo = $photo;

        try {
            $data->save();
        } catch (Exception $e) {
            return redirect('admin/category')->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function edit(Request $request)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Category::find($request->id);
        $query['query'] = Category::orderBy('id','desc')->get();

        return view('admin.category.model', $query);
    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            'title' => 'required|string',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $row = Category::find($request->id);

        if ( $img = $request->file('photo') ) {
            $name = 'img_' .time() . '.' .$img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $photo = url('/').'/public/uploads/'.$name;
        } else {
            $photo = $row->photo;
        }

        $data = Category::where('id', $request->id)->update([
            'title' => $request->title,
            'title_en' => $request->title_en,
            'parent' => $request->parent,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'photo' => $photo
        ]);

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {

        try{
            // Category::whereIn('id',$request->id)->delete();
            Category::where('id', $request->id)->orWhere('parent', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        // session()->flash('msg', 'Success');

        return back()->with('msg', 'Success');
    }

}
