<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Models\Post;
use App\Models\TransferPermission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Company;
use App\Models\Client;
use App\Models\OrderStatus;
use App\Models\Setting;
use App\Models\Deligate;
use App\Models\Branch;
use App\Models\Stock;
use App\Models\Unit;
use DB;
use Illuminate\Support\Facades\Session;

class TransferPermissionController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index(Request $request, $id = null)
    {
        $query['branches'] = Branch::get();
        if (Auth::user()->type != 0) {
            $query['data'] = TransferPermission::all();
        } else {
            $query['data'] = TransferPermission::where('branch_from_id', Auth::user()->branch_id);
        }

        return view('admin.transfer.index', $query);
    }

    public function filter(Request $request)
    {
        $query['branches'] = Branch::get();
        $filter = TransferPermission::orderBy('id', 'desc');

        if (Auth::user()->type != 0) {
            $filter->where('branch_from_id', Auth::user()->branch_id);
        } else {
            if ($request->branch_from_id) {
                $filter->where('branch_from_id', $request->branch_from_id);
            }
        }

        if ($request->branch_to_id) {
            $filter->where('branch_to_id', $request->branch_to_id);
        }

        $query['data'] = $filter->paginate(15);
        return view('admin.transfer.index', $query);

    }

    public function show($id)
    {
        $query['setting'] = Setting::find(1);
        $query['data'] = Order::where('order_id', $id)->get();

        return view('admin.transfer.show', $query);
    }


    public function create($id = null)
    {
        $query['branches'] = Branch::orderBy('id', 'asc')->get();
        return view('admin.transfer.cashier', $query);
    }

    public function client_data(Request $request)
    {
        $client = Client::where('phone', $request->phone)->first();

        if ($client) {
            return view('admin.order.checkclient', compact('client'));
        } else {
            $client = [];
            $client_phone = $request->phone;
            return view('admin.transfer.checkclient', compact('client'), compact('client_phone'));
        }

    }

    public function addClientOrder(Request $request)
    {

        $data = Client::create([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->phone),
            'is_active' => 1,
        ]);

        return $data->id;
    }

    public function addCartOrder(Request $request)
    {

        $cart = Session::get('transfer');
        $product = Post::select('title_en', 'itm_unit1')->orderBy('id', 'desc')->with('Unit1')->where('itm_code', $request->itm_code)->first();
        $stock = Stock::orderBy('id', 'desc')->where('itm_code', $request->itm_code)->where('branch_id', $request->branch_from_id)->first();

        if ($product && $stock) {
            $c_r = [
                'itm_code' => $request->itm_code,
                'expiry_date' => $stock->expiry_date,
                'title_en' => $product->title_en,
                'qty' => 1,
            ];

            $cart[] = $c_r;
            Session::put('transfer', $cart);

            return view('admin.transfer.cart_data');
        } else {

        }
    }

    public function get_order_product(Request $request)
    {
        $id = $request->id;
        $branch_from_id = $request->branch_from_id;
        $branch_to_id = $request->branch_to_id;
        $cart = Session::get('transfer');

        $itm_code = $cart[$id]['itm_code'];
        $product = Post::where('itm_code', $itm_code)->with('Unit1')->with('Unit2')->with('Unit3')->first();
        $stock = Stock::where('itm_code', $itm_code)->where('branch_id', $request->branch_from_id)->get();

        // unset($cart[$id]);//remove second element, do not re-index array
        // Session::forget('cart');
        // Session::put('cart', $cart);


        return view('admin.transfer.addProductModal', compact('product'), compact('stock', 'branch_from_id', 'branch_to_id'))->with('qty', $cart[$id]['qty'])->with('sessin_id', $id);

    }

    public function editcartorder(Request $request)
    {

        $cart = Session::get('transfer');

        unset($cart[$request->sessin_id]);
        Session::forget('transfer');

        $product = Post::where('itm_code', $request->itm_code)->get()->first();
        $stock = Stock::where('itm_code', $request->itm_code)->where('branch_id', $request->branch_from_id)->where('expiry_date', $request->expiry_date)->get()->first();


        $c_r = [
            'itm_code' => $request->itm_code,
            'expiry_date' => $request->expiry_date,
            'title_en' => $product->title_en,
            'qty' => $request->qty,

        ];

        $cart[] = $c_r;

        Session::put('transfer', $cart);

        return view('admin.transfer.cart_data');
    }

    public function print_order($id)
    {
        $query['setting'] = Setting::find(1);
        $query['data'] = Order::where('order_id', $id)->get();

        return view('admin.transfer.print', $query);
    }

    public function invoice($id)
    {
        $query['setting'] = Setting::find(1);
        $query['data'] = Order::where('order_id', base64_decode($id))->get();

        return view('admin.transfer.invoice', $query);
    }

    public function category_data($id, $branch_id)
    {
        $products = Post::where('cat_id', $id)->where('branch_id', $branch_id)->get();
        return view('admin.transfer.productPos_data', compact('products'));
    }

    public function Product(Request $request)
    {
        $product = Post::findOrFail($request->id);
        return view('admin.transfer.addProductModal', compact('product'));
    }

//    add to cart admin
    public function AddCart(Request $request)
    {

        $cart = Session::get('cart');
        $product = Post::find($request->product_id);
        if ($product->new_price_leasing > 0) {
            $price = $product->new_price_leasing;
        } else {
            $price = $product->new_price_sell;
        }
        $attributes = [];

        if ($request->attribute) {
            foreach ($request->attribute as $key => $attribute) {
                $attribute_value = explode(',', $attribute['option']);
                $attribute['option'] = $attribute_value[1];
                array_push($attributes, $attribute);
                $price = $attribute_value[2];

            }
        }
        $additions = [];
        if ($request->additions) {
            foreach ($request->additions as $key => $addition) {

                if (array_key_exists("name", $addition)) {
                    array_push($additions, $addition);
                    $price = $price + $addition['price'];
                }
            }
        }

        $c_r = [
            'attributes' => $attributes,
            'additions' => $additions,
            'price' => $price,
            'product' => $product,
            'quantity' => $request->quantity
        ];

        $cart[] = $c_r;
        Session::put('cart', $cart);
        return view('admin.transfer.cart_data');
    }

    public function DeleteCart(Request $request)
    {
        $id = $request->id;
        $cart = Session::get('transfer');
        unset($cart[$id]);//remove second element, do not re-index array
        Session::forget('transfer');
        Session::put('transfer', $cart);
        return view('admin.transfer.cart_data');
    }

    public function alldeletordercart(Request $request)
    {
        Session::forget('cart');
        return view('admin.transfer.cart_data');
    }

    public function BranchOrderToday(Request $request, $id = null)
    {
        $order = Order::whereDate('scheduled', Carbon::today())->orderBy('id', 'desc');
        if (Auth::user()->type == 0) {
            $branch_id = $id;
        } else {
            $branch_id = Auth::user()->branch_id;
        }

        $order = $order->where('branch_id', $branch_id);
        if ($request->status) {
            $order = $order->where('status', $request->status);
        }
        $query['data'] = $order->get();
        $query['id'] = $id;
        return view('admin.transfer.todayOrders', $query);
    }

    public function cashier_show($id)
    {
        $query['setting'] = Setting::find(1);
        $query['data'] = Order::with('OrderProduct')->where('id', $id)->get()->first();
        $query['pro_details'] = Client::find($query['data']->pro_id);

        return view('admin.transfer.cashier_show', $query);
    }

    public function store(Request $request)
    {

        $Settings = Setting::find(1);

        $cart = Session::get('transfer');

        if ($cart) {
            foreach ($cart as $cart_item) {
                $data = new  TransferPermission();
                $data->branch_from_id = $request->branch_from_id;
                $data->branch_to_id = $request->branch_to_id;
                $data->expiry_date = $cart_item['expiry_date'];
                $data->itm_code = $cart_item['itm_code'];
                $data->qty = $cart_item['qty'];

                $product = Post::where('itm_code', $cart_item['itm_code'])->first();

                $qty_mid = 0; $qty_sm = 0;
        
                if ($product->itm_unit1 != $product->itm_unit2) {
                    $qty_mid = $cart_item['qty'] * $product->mid;
                }

                if ($product->itm_unit2 != $product->itm_unit3) {
                    $qty_sm = $cart_item['qty'] * $product->mid * $product->sm;
                }

                $stock = Stock::where('itm_code', $cart_item['itm_code'])->where('branch_id', $request->branch_from_id)->where('expiry_date', $cart_item['expiry_date'])->get()->first();
                if ($stock) {
                    $updateStock = Stock::where('id', $stock->id)->update([
                        'qty' => $stock->qty - $cart_item['qty'],
                        'qty_mid' => $stock->qty_mid - $qty_mid,
                        'qty_sm' => $stock->qty_sm - $qty_sm,
                    ]);
                }

                $stock2 = Stock::where('itm_code', $cart_item['itm_code'])->where('branch_id', $request->branch_to_id)->where('expiry_date', $cart_item['expiry_date'])->get()->first();
                if ($stock2) {
                    $updateStock = Stock::where('id', $stock2->id)->update([
                        'qty' => $stock2->qty + $cart_item['qty'],
                        'qty_mid' => $stock2->qty_mid + $qty_mid,
                        'qty_sm' => $stock2->qty_sm + $qty_sm,
                    ]);
                } else {
                    $stock2 = new Stock();
                    $stock2->qty = $cart_item['qty'];
                    $stock2->qty_mid = $qty_mid;
                    $stock2->qty_sm = $qty_sm;
                    $stock2->price_purchasing = $stock->price_purchasing;
                    $stock2->price_selling = $stock->price_selling;
                    $stock2->price_minimum_sale = $stock->price_minimum_sale;
                    $stock2->expiry_date = $cart_item['expiry_date'];
                    $stock2->production_date = $stock->production_date;
                    $stock2->itm_code = $stock->itm_code;
                    $stock2->branch_id = $request->branch_to_id;
                    $stock2->save();

                }

                $data->save();
                Session::forget('transfer');
            }

//            return redirect('admin/print_order/' . $order_orders->order_id);
            return redirect()->back()->with('msg', 'تمت الاضافة بنجاح');
        } else {
            return redirect()->back()->with('msg', 'لا يوجد اصناف مضافة !');
        }

        return redirect()->back()->with('msg', 'لا يوجد اصناف مضافة !');
    }

    public function return_order($id)
    {
        $orders = Order::where('order_id', $id)->get();

        $last_row = Order::select('order_id')->latest()->first();
        $ord_num = $last_row->order_id + 1;

        foreach ($orders as $order) {
            $ord = Order::find($order->id);
            $newOrder = $ord->replicate();
            $newOrder->order_id = $ord_num;
            $newOrder->order_return = $order->order_id;
            $newOrder->sdate = Carbon::now();
            $newOrder->created_at = Carbon::now();
            $newOrder->save();

            $stock = Stock::where('itm_code', $order->itm_code)->where('branch_id', $order->branch_id)->where('expiry_date', $order->expiry_date)->get()->first();
            if ($stock) {
                $updateStock = Stock::where('id', $stock->id)->update([
                    'qty' => $stock->qty + $order->qty
                ]);
            }
        }


        return redirect()->back()->with('msg', 'تم بنجاح');
    }

    public function edit($id)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Order::find($id);
        return view('admin.order.edit', $query);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
            'deligate_id' => 'nullable'
        ]);

        $delivery = Deligate::find($request->delivery_id);

        $data = Order::where('id', $request->order_id)->update([
            'status' => $request->status,
            'status_pay' => $request->status_pay,
            'scheduled' => $request->scheduled,
            'type' => $request->type,
            'more_notes' => $request->more_notes,

        ]);

        $order = Order::where('id', $request->order_id)->first();
        if ($delivery) {

            $order->delivery_id = $delivery->id;
            $order->delivery_name = $delivery->name;
        }


        return redirect()->back()->with('msg', 'تم بنجاح');
    }

    public function delete(Request $request)
    {

        try {
            Order::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg' => 'Failed']);
        }
        return response()->json(['msg' => 'Success']);
    }

    public function delete_Status(Request $request)
    {

        try {
            OrderStatus::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg' => 'Failed']);
        }
        return response()->json(['msg' => 'Success']);
    }

}
