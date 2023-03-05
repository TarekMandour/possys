<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deligate;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class kitchenController extends Controller
{
    public function kitchen($id = null)
    {
        if (Auth::user()->type == 0) {
            $branch_id = $id;
        } else {
            $branch_id = Auth::user()->branch_id;
        }
        return view('admin.order.kitchen', compact('branch_id'));
    }


    public function kitchen_data($id)
    {
        $order = Order::where('status', "processing")->orderBy('id', 'desc');
        if (Auth::user()->type == 0) {
            $branch_id = $id;
        } else {
            $branch_id = Auth::user()->branch_id;
        }

        $order = $order->where('branch_id', $branch_id);

        $query['data'] = $order->with('OrderProduct')->get();
        $query['id'] = $id;
        return view('admin.order.kitchen_data', $query);
    }

    public function orderConfirmed($id)
    {
        $order = Order::where('id', $id)->first();
        $order->status = "confirmed";
        try {
            $order->save();
            return response(["data" => "success"]);
        } catch (\Exception $e) {
            return response(["data" => "failed"]);
        }
    }
}
