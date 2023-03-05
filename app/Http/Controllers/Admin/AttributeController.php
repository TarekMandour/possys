<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Attribute;

class AttributeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Attribute::orderBy('id','desc')->get();
        // $query['data'] = Attribute::orderBy('id','desc')->paginate(10);

        return view('admin.attribute.index',$query);
    }

    public function store(Request $request)
    {

        $this->validate(request(),[
            'title' => 'required|string',
        ]);

        $data = new Attribute;
        $data->title = $request->title;

        try {
            $data->save();
        } catch (Exception $e) {
            return redirect('admin/attribute')->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function edit(Request $request)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Attribute::find($request->id);
        $query['query'] = Attribute::orderBy('id','desc')->get();

        return view('admin.attribute.model', $query);
    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            'title' => 'required|string',
        ]);

        $row = Attribute::find($request->id);

        $data = Attribute::where('id', $request->id)->update([
            'title' => $request->title,
        ]);

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {

        try{
            Attribute::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
