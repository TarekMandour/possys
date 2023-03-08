<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Inventory;
use App\InventoryDetails;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type != 0) {
            $query['data'] = Inventory::where('branch_id', Auth::user()->branch_id)->orderBy('id', 'desc')->get();
        } else {
            $query['data'] = Inventory::orderBy('id', 'desc')->get();
        }

        return view('admin.inventory.index', $query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(request(), [
            'name' => 'required|string',
            'branch_id' => 'required'
        ]);


        $data = new Inventory();
        $data->name = $request->name;
        $data->branch_id = $request->branch_id;
        try {
            $data->save();
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {

        try {
            Inventory::where('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg' => 'Failed']);
        }
        return response()->json(['msg' => 'Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query['data'] = Inventory::findOrFail($id);
        return view('admin.inventory.details', $query);
    }

    public function add_inventory(Request $request)
    {


        $inventory = Inventory::whereId($request->inventory_id)->first();
        if ($inventory) {


            $stock = Stock::orderBy('id', 'desc')->where('itm_code', $request->itm_code)->where('branch_id', $inventory->branch_id)->first();
            if ($stock) {
                $data = InventoryDetails::where('inventory_id', $request->inventory_id)->where('itm_code', $request->itm_code)->first();
                if ($data) {
                    $data->qty += 1;
                    $data->save();
                } else {
                    $data = new InventoryDetails();
                    $data->inventory_id = $request->inventory_id;
                    $data->itm_code = $request->itm_code;
                    $data->qty = 1;
                    $data->save();
                }
            }
        }
        $details = InventoryDetails::where('inventory_id', $request->inventory_id)->get();

        return view('admin.inventory.details_table', compact('details'));

    }

    public function editQty(Request $request)
    {

        $data = InventoryDetails::where('id', $request->id)->first();
        $data->qty = $request->qty;
        $data->save();

        $details = InventoryDetails::where('inventory_id', $request->inventory_id)->get();

        return view('admin.inventory.details_table', compact('details'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
