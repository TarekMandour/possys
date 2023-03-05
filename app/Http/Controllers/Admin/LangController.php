<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Language;

class LangController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Language::orderBy('id','desc')->get();
        // $query['data'] = Partner::orderBy('id','desc')->paginate(10);

        return view('admin.language.index',$query);
    }

    public function store(Request $request)
    { 

        $this->validate(request(),[
            'ar_name' => 'required|string'
        ]);

        $data = new Language;
        $data->ar_name = $request->ar_name;
        $data->en_name = $request->en_name;
        $data->page_name = $request->page_name;
        $data->slug = $request->slug;

        try {
            $data->save();
        } catch (Exception $e) {
            return redirect('admin/language')->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function edit(Request $request)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Language::find($request->id);
        $query['query'] = Language::orderBy('id','desc')->get();

        return view('admin.language.model', $query);
    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            'ar_name' => 'required|string'
        ]);

        $row = Language::find($request->id);

        $data = Language::where('id', $request->id)->update([
            'ar_name' => $request->ar_name,
            'en_name' => $request->en_name,
            'page_name' => $request->page_name,
            'slug' => $request->slug
        ]);        

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {   

        try{
            Language::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
