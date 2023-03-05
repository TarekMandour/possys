<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deligate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Category;

class DeligateController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index($id = null)
    {
        if ($id == null) {
            $query['data'] = Deligate::where('branch_id', Auth::user()->branch_id)->orderBy('id', 'desc')->get();
        } else {
            $query['data'] = Deligate::where('branch_id', $id)->orderBy('id', 'desc')->get();

        }
        $query['id'] = $id;
        return view('admin.deligate.index', $query);
    }

    public function store(Request $request)
    {

        $this->validate(request(), [
            'name' => 'required|string',
            'phone' => 'required'
        ]);


        $data = new Deligate();
        $data->name = $request->name;
        $data->phone = $request->phone;

        if (Auth::user()->type == 0) {
            $data->branch_id = $request->branch_id;
        } else {
            $data->branch_id = Auth::user()->branch_id;
        }

        try {
            $data->save();
        } catch (Exception $e) {
            return redirect('admin/deligate')->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function edit(Request $request)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Deligate::find($request->id);


        return view('admin.deligate.model', $query);
    }

    public function update(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|string',
            'phone' => 'required'
        ]);

        $row = Deligate::find($request->id);


        $data = Deligate::where('id', $request->id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {
        try {
            Deligate::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg' => 'Failed']);
        }
        return response()->json(['msg' => 'Success']);
    }

}
