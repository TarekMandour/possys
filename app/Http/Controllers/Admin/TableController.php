<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Table;

class TableController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Table::orderBy('id','desc')->get();
        // $query['data'] = Table::orderBy('id','desc')->paginate(10);

        return view('admin.table.index',$query);
    }

    public function store(Request $request)
    {

        $this->validate(request(),[
            'title' => 'required|string',
            'cat_id' => 'required',
            'status' => 'required',
        ]);

        $data = new Table;
        $data->title = $request->title;
        $data->cat_id = $request->cat_id;
        $data->status = $request->status;

        try {
            $data->save();
        } catch (Exception $e) {
            return redirect('admin/table')->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function edit(Request $request)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Table::find($request->id);
        $query['query'] = Table::orderBy('id','desc')->get();

        return view('admin.table.model', $query);
    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            'title' => 'required|string',
            'cat_id' => 'required',
            'status' => 'required',
        ]);

        $row = Table::find($request->id);

        $data = Table::where('id', $request->id)->update([
            'title' => $request->title,
            'cat_id' => $request->cat_id,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {

        try{
            Table::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
