<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Supplier;
use App\Models\Vouchers;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Stock;

class VouchersController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $query['data'] = Vouchers::orderBy('id', 'desc');
        $query['data'] = $query['data']->get();

        return view('admin.voucher.index', $query);
    }

    public function store(Request $request)
    {

        $this->validate(request(), [
            'user_id' => 'nullable|numeric',
            'user_type' => 'required|in:client,supplier,external',
            'external_name' => 'nullable|string',
            'trans_date' => 'required|date',
            'pay_type' => 'required|in:client,cash,network',
            'type' => 'required|in:receipt,exchange',
            'amount' => 'required',
            'notes' => 'required|string',


        ]);

        $data = new Vouchers();
        $data->user_id = $request->user_id;
        $data->user_type = $request->user_type;
        $data->trans_date = $request->trans_date;
        $data->pay_type = $request->pay_type;
        $data->type = $request->type;
        $data->amount = $request->amount;
        $data->notes = $request->notes;
        
        if ($request->user_type == "external") {
            $data->external_name = $request->external_name;
        } else if ($request->user_type == "client") {
            $wallet = new Wallet();
            $client = Client::whereId($request->user_id)->first();
            $data->external_name = $client->name;
            $wallet->type = "client";
        } else {
            $wallet = new Wallet();
            $client = Supplier::whereId($request->user_id)->first();
            $data->external_name = $client->title;
            $wallet->type = "supplier";
        }

        $data->save();

        if($request->user_type != "external") {
            $wallet->walletable()->associate($client);
            $wallet->trans_date = $request->trans_date;
            $wallet->notes = $request->notes;
            if ($request->type == "receipt") {
                $wallet->in = $request->amount;
            } else {
                $wallet->out = $request->amount;
            }
            $wallet->save();
    
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
        $this->validate(request(), [
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

        try {
            Vouchers::whereIn('id', $request->id)->delete();

        } catch (\Exception $e) {
            return response()->json(['msg' => 'Failed']);
        }
        return response()->json(['msg' => 'Success']);
    }

}
