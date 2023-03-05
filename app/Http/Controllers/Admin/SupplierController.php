<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Supplier::orderBy('id', 'desc')->get();
        // $query['data'] = Supplier::orderBy('id','desc')->paginate(10);

        return view('admin.supplier.index', $query);
    }

    public function store(Request $request)
    {

        $this->validate(request(), [
            'title' => 'required|string',
            'phone' => 'required'
        ]);

        $data = new Supplier;
        $data->title = $request->title;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->sales_name = $request->sales_name;
        $data->phone2 = $request->phone2;
        $data->email = $request->email;
        $data->num = $request->num;
        $data->tax_number = $request->tax_number;
        $data->is_active = $request->is_active;

        try {
            $data->save();
        } catch (Exception $e) {
            return redirect('admin/supplier')->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function edit(Request $request)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Supplier::find($request->id);
        $query['query'] = Supplier::orderBy('id', 'desc')->get();

        return view('admin.supplier.model', $query);
    }

    public function sales($id)
    {
        $query['client'] = Supplier::find($id);
        $wallet = Wallet::where('type', 'supplier')->where('walletable_id', $id);
        $query['in'] = $wallet->sum('in');
        $query['out'] = $wallet->sum('out');
        $query['total'] = $query['in'] - $query['out'];
        $query['data'] = $wallet->get();
        return view('admin.supplier.sales', $query);
    }

    public function update(Request $request)
    {
        $this->validate(request(), [
            'title' => 'required|string',
            'phone' => 'required'
        ]);

        $row = Supplier::find($request->id);

        $data = Supplier::where('id', $request->id)->update([
            'title' => $request->title,
            'address' => $request->address,
            'phone' => $request->phone,
            'sales_name' => $request->sales_name,
            'phone2' => $request->phone2,
            'email' => $request->email,
            'num' => $request->num,
            'tax_number' => $request->tax_number,
            'is_active' => $request->is_active
        ]);

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {

        try {
            Supplier::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg' => 'Failed']);
        }
        return response()->json(['msg' => 'Success']);
    }

}
