<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Setting::orderBy('id','desc')->get();
        // $query['data'] = Admin::orderBy('id','desc')->paginate(10);

        return view('admin.setting.index',$query);
    }

    public function show($id)
    {
        $query['data'] = Setting::find($id);
        return view('admin.setting.show',$query);
    }

    public function create()
    {
        return view('admin.setting.create');
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

        $data = new Setting;
        $data->title = $request->title;
        $data->content = $request->content;
        $data->meta_keywords = $request->meta_keywords;
        $data->meta_description = $request->meta_description;
        $data->photo = $photo;
        $data->save();

        return redirect('admin/services')->with('msg', 'Success');
    }

    public function edit($id)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Setting::find($id);
        return view('admin.setting.edit', $query);
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|string',
            'phone1' => 'required',
            'email1' => 'required',
            'logo1' => 'image|mimes:png,jpg,jpeg|max:2048',
            'logo2' => 'image|mimes:png,jpg,jpeg|max:2048',
            'fav' => 'image|mimes:png,jpg,jpeg|max:2048',
            'breadcrumb' => 'image|mimes:png,jpg,jpeg|max:2048',
            'background' => 'image|mimes:png,jpg,jpeg|max:2048',
            'tax'=>'required'
        ]);

        $row = Setting::find($request->id);

        if ( $logo1 = $request->file('logo1') ) {
            $name1 = 'logo1'. '.' .$logo1->getClientOriginalExtension();
            $logo1->move(public_path('uploads/posts/'), $name1);
            $logo1 = $name1;
        } else {
            $logo1 = $row->logo1;
        }

        if ( $logo2 = $request->file('logo2') ) {
            $name2 = 'logo2'. '.' .$logo2->getClientOriginalExtension();
            $logo2->move(public_path('uploads/posts/'), $name2);
            $logo2 = $name2;
        } else {
            $logo2 = $row->logo2;
        }

        if ( $img3 = $request->file('fav') ) {
            $name3 = 'fav'. '.' .$img3->getClientOriginalExtension();
            $img3->move(public_path('uploads/posts/'), $name3);
            $fav = $name3;
        } else {
            $fav = $row->fav;
        }

        if ( $img4 = $request->file('breadcrumb') ) {
            $name4 = 'breadcrumb'. '.' .$img4->getClientOriginalExtension();
            $img4->move(public_path('uploads/posts/'), $name4);
            $breadcrumb = $name4;
        } else {
            $breadcrumb = $row->breadcrumb;
        }if ( $img5 = $request->file('background') ) {
            $name5 = 'background'. '.' .$img5->getClientOriginalExtension();
            $img5->move(public_path('uploads/posts/'), $name5);
            $background = $name5;
        } else {
            $background = $row->background;
        }

        $data = Setting::where('id', $request->id)->update([
            'title' => $request->title,
            'title_en' => $request->title_en,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'meta_description_en' => $request->meta_description_en,
            'tax_num' => $request->tax_num,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'email1' => $request->email1,
            'email2' => $request->email2,
            'address' => $request->address,
            'address_en' => $request->address_en,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'snapchat' => $request->snapchat,
            'logo1' => $logo1,
            'logo2' => $logo2,
            'fav' => $fav,
            'breadcrumb' => $breadcrumb,
            'background' => $background,
            'delivery_cost' => $request->delivery_cost,
            'tax'=>$request->tax,
            'currency'=>$request->currency,
            'printing'=>$request->printing,
            'website_type'=>$request->website_type,
        ]);

        return redirect('admin/edit_setting/1')->with('msg', 'Success');
    }

    public function delete(Request $request)
    {

        try{
            Setting::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
