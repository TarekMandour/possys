<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Category;
use App\Models\Subject;
use App\Models\Level;

class MenuController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Menu::where('parent', 0)->orderBy('sort','asc')->get();
        $query['pages'] = Page::orderBy('id','desc')->get();
        $query['categories'] = Category::orderBy('id','desc')->get();
        $query['subjects'] = Subject::orderBy('id','desc')->get();
        $query['levels'] = Level::orderBy('id','desc')->get();
        return view('admin.menu.index',$query);
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

        if ($request->type == 1) {
            $url = $request->link;
        } else if ($request->type == 2) {
            $url = url('/').'/'.'page/'.$request->page;
        } else if ($request->type == 3) {
            $url = url('/').'/'.'category/'.$request->category;
        } else if ($request->type == 4) {
            $url = url('/').'/'.'subject_books/'.$request->subject;
        } else if ($request->type == 5) {
            $url = url('/').'/'.'level_books/'.$request->level;
        }

        $data = new Menu;
        $data->title = $request->title;
        $data->parent = $request->parent;
        $data->url = $url;
        $data->sort = $request->sort;
        $data->photo = $photo;

        try {
            $data->save();
        } catch (Exception $e) {
            return redirect('admin/Menu')->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function edit(Request $request)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Menu::find($request->id);
        $query['query'] = Menu::orderBy('id','desc')->get();

        return view('admin.menu.model', $query);
    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            'title' => 'required|string',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $row = Menu::find($request->id);

        if ( $img = $request->file('photo') ) {
            $name = 'img_' .time() . '.' .$img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $photo = $name;
        } else {
            $photo = $row->photo;
        }

        $data = Menu::where('id', $request->id)->update([
            'title' => $request->title,
            'parent' => $request->parent,
            'url' => $request->url,
            'sort' => $request->sort,
            'photo' => $photo
        ]);

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {

        try{
            Menu::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
