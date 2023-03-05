<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\TableCat;

class TableCatController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = TableCat::orderBy('id','desc')->get();
        // $query['data'] = TableCat::orderBy('id','desc')->paginate(10);

        return view('admin.tablecat.index',$query);
    }

    public function store(Request $request)
    {

        $this->validate(request(),[
            'title' => 'required|string',
        ]);

        $data = new TableCat;
        $data->title = $request->title;

        try {
            $data->save();
        } catch (Exception $e) {
            return redirect('admin/tablecat')->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function edit(Request $request)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = TableCat::find($request->id);
        $query['query'] = TableCat::orderBy('id','desc')->get();

        return view('admin.tablecat.model', $query);
    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            'title' => 'required|string',
        ]);

        $row = TableCat::find($request->id);

        $data = TableCat::where('id', $request->id)->update([
            'title' => $request->title,
        ]);

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {

        try{
            TableCat::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
