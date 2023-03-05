<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Slider::orderBy('id','desc')->get();
        // $query['data'] = Admin::orderBy('id','desc')->paginate(10);

        return view('admin.slider.index',$query);
    }

    public function show($id)
    {
        $query['data'] = Slider::find($id);
        return view('admin.slider.show',$query);
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {

        $this->validate($request,[
            'title1' => 'required|string',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ( $img = $request->file('photo') ) {
            $name = 'img1_' .time() . '.' .$img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $photo = url('/').'/public/uploads/'.$name;
        } else {
            $photo = NULL;
        }

        if ( $img2 = $request->file('logo') ) {
            $name = 'img2_' .time() . '.' .$img2->getClientOriginalExtension();
            $img2->move(public_path('uploads'), $name);
            $logo = url('/').'/public/uploads/'.$name;
        } else {
            $logo = NULL;
        }

        $data = new Slider;
        $data->title1 = $request->title1;
        $data->title2 = $request->title2;
        $data->content = $request->content;
        $data->sort = $request->sort;
        $data->photo = $photo;
        $data->logo = $logo;
        $data->product_id = $request->product_id;
        $data->save();

        return redirect('admin/sliders')->with('msg', 'تم بنجاح');
    }

    public function edit($id)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Slider::find($id);
        return view('admin.slider.edit', $query);
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'title1' => 'required|string',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $row = Slider::find($request->id);

        if ( $img = $request->file('photo') ) {
            $name = 'img1_' .time() . '.' .$img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $photo = url('/').'/public/uploads/'.$name;
        } else {
            $photo = $row->photo;
        }

        if ( $img2 = $request->file('logo') ) {
            $name = 'img2_' .time() . '.' .$img2->getClientOriginalExtension();
            $img2->move(public_path('uploads'), $name);
            $logo = url('/').'/public/uploads/'.$name;
        } else {
            $logo = $row->logo;
        }

        $data = Slider::where('id', $request->id)->update([
            'title1' => $request->title1,
            'title2' => $request->title2,
            'content' => $request->content,
            'sort' => $request->sort,
            'photo' => $photo,
            'logo' => $logo,
            'product_id' => $request->product_id,

        ]);

        return redirect('admin/sliders')->with('msg', 'تم بنجاح');
    }

    public function delete(Request $request)
    {

        try{
            Slider::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
