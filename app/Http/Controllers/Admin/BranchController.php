<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Stock;

class BranchController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Branch::orderBy('id','desc')->get();
        // $query['data'] = Category::orderBy('id','desc')->paginate(10);

        return view('admin.branch.index',$query);
    }

    public function store(Request $request)
    {

        $this->validate(request(),[
            'name' => 'required|string',

        ]);

        $data = new Branch();
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->location = $request->location;


        try {
            $data->save();
        } catch (\Exception $e) {
            return redirect('admin/branch')->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function edit(Request $request)
    {
        $query['data'] = Branch::find($request->id);
        return view('admin.branch.model', $query);
    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required|string',
        ]);

        $row = Branch::find($request->id);



        $data = Branch::where('id', $request->id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'location' => $request->location,

        ]);

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {

        try{
            Branch::whereIn('id',$request->id)->delete();
            Stock::whereIn('branch_id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
