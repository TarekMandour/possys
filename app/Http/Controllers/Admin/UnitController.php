<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Unit::orderBy('id','desc')->get();
        // $query['data'] = Unit::orderBy('id','desc')->paginate(10);

        return view('admin.unit.index',$query);
    }

    public function store(Request $request)
    {

        $this->validate(request(),[
            'title' => 'required|string',
            'num' => 'required'
        ]);

        $data = new Unit;
        $data->title = $request->title;
        $data->num = $request->num;

        try {
            $data->save();
        } catch (Exception $e) {
            return redirect('admin/unit')->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function edit(Request $request)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Unit::find($request->id);
        $query['query'] = Unit::orderBy('id','desc')->get();

        return view('admin.unit.model', $query);
    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            'title' => 'required|string',
            'num' => 'required'
        ]);

        $row = Unit::find($request->id);

        $data = Unit::where('id', $request->id)->update([
            'title' => $request->title,
            'num' => $request->num
        ]);

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {

        try{
            Unit::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
