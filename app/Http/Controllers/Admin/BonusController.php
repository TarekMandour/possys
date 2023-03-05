<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Bonus;
use App\Models\Post;

class BonusController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $query['data'] = Bonus::orderBy('id','desc')->get();
        $query['admin_id'] = $request->id;
        // $query['data'] = Bonus::orderBy('id','desc')->paginate(10);

        return view('admin.admin.bonus',$query);
    }

    public function store(Request $request)
    {
        $product = Post::where('itm_code', $request->itm_code)->get()->first();
        $percent = $request->percent / 100 ;

        $data = new Bonus;
        $data->admin_id = $request->admin_id;
        $data->pro_id = $request->itm_code; 
        $data->percent = $percent; 
        $data->product = $product;

        try {
            $data->save();
        } catch (Exception $e) {
            return response()->json(['msg'=>'faild']);
        }

        return response()->json(['msg'=>'Success']);
    }

    public function edit(Request $request)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Bonus::find($request->id);
        $query['query'] = Bonus::orderBy('id','desc')->get();

        return view('admin.Bonus.model', $query);
    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            'title' => 'required|string',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $row = Bonus::find($request->id);

        if ( $img = $request->file('photo') ) {
            $name = 'img_' .time() . '.' .$img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $photo = url('/').'/public/uploads/'.$name;
        } else {
            $photo = $row->photo;
        }

        $data = Bonus::where('id', $request->id)->update([
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
            Bonus::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
