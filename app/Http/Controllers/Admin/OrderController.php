<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Models\Post;
use App\Models\Vouchers;
use App\Models\Wallet;
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
use App\Models\Discounts;
use App\Models\OrderCart;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index(Request $request, $id = null)
    {
        $query['branches'] = Branch::get();

        return view('admin.order.index', $query);
    }

    public function datatable(Request $request)
    {
        $data = Order::select('id','itm_code','order_type','order_id', 'branch','client_id','total_sub','total_tax','created_at')->orderBy('id', 'desc');

        $time_to = 4105360822;
        $time_from = 949600822;
        
        if(!empty($request->sdate) && !empty($request->to_date)){
            $data = $data->whereBetween('created_at', [date('Y-m-d H:m:s',strtotime( $request->sdate )) , date('Y-m-d H:m:s',strtotime( $request->to_date ))]);
        } else if (!empty($request->sdate)) {
            $data = $data->whereBetween('created_at', [date('Y-m-d H:m:s',strtotime( $request->sdate )) , date('Y-m-d H:m:s', $time_to)]);   
        } else if (!empty($request->to_date)) {
            $data = $data->whereBetween('created_at', [date('Y-m-d H:m:s',949600822) , date('Y-m-d H:m:s', strtotime( $request->to_date ))]);   
        }

        if($request->order_id){
            $data = $data->where('order_id', $request->order_id);
        }

        if($request->itm_code){
            $data = $data->where('itm_code', $request->itm_code);
        }

        if($request->order_type){
            if ($request->order_type == 2) {
                $ordertyp = 0;
            } else if ($request->order_type == 1) {
                $ordertyp = 1;
            }
            $data = $data->where('order_type', $ordertyp);
        }

        if (Auth::user()->type != 0) {
            $data = $data->where('branch_id', Auth::user()->branch_id);
        } else {
            if ($request->branch_id) {
                $data = $data->where('branch_id', $request->branch_id);
            }
        }

        if ($request->client_phone) {
            $client = Client::where('phone', $request->client_phone)->first();
            if ($client) {

                $data = $data->where('client_id', $client->id);
            }
        }

        $data = $data->get()->groupBy('order_id'); 

        return Datatables::of($data)
            ->addColumn('id', function ($row) {
                $id = '';
                $id .= '<a href="'.url('/admin/show_order/'.$row[0]->order_id).'">'.$row[0]->order_id.'</a>';
                return $id;
            })
            ->editColumn('branch', function ($row) {
                $branch = '';
                $branch .= ' <span class="text-gray-800 text-hover-primary mb-1">' . json_decode($row[0]->branch)->name . '</span>';
                return $branch;
            })
            ->editColumn('total_sub', function ($row) {                
                $total_sub = '';
                $total_sub .= ' <span class="text-gray-800 text-hover-primary mb-1">' . $row[0]->total_sub . '</span>';
                return $total_sub;
            })
            ->editColumn('total_tax', function ($row) {
                $total_tax = '';
                $total_tax .= ' <span class="text-gray-800 text-hover-primary mb-1">' . $row[0]->total_tax . '</span>';
                return $total_tax;
            })
            ->editColumn('total', function ($row) {
                $total = '';
                $total .= ' <span class="text-gray-800 text-hover-primary mb-1">' . ($row[0]->total_sub + $row[0]->total_tax) . '</span>';
                return $total;
            })
            ->editColumn('created_at', function ($row) {
                $created_at = '';
                $created_at .= ' <span class="text-gray-800 text-hover-primary mb-1">' . date('y-m-d | h:i a', strtotime($row[0]->created_at)) . '</span>';
                return $created_at;
            })
            ->addColumn('actions', function ($row) {
                $actions = '';
                $actions .= '<a href="'.url('/admin/show_order/'.$row[0]->order_id).'"
                class="btn btn-info btn-sm waves-effect waves-light"><i
                     class="ti-pencil-alt"></i></a>';
                return $actions;

            })

            ->rawColumns(['actions', 'branch', 'id', 'total_sub', 'total_tax', 'total', 'created_at'])
            
            ->make();

            

    }

    public function filter(Request $request)
    {
        $query['branches'] = Branch::get();
        $filter = DB::table('orders')->select(DB::raw('branch,order_type,total_tax,total_sub,order_id,sdate,branch_id,client_id,created_at'))->orderBy('id', 'desc');
        if ($request->order_id) {
            $filter->where('order_id', $request->order_id);
        }

        if ($request->itm_code) {
            $filter->where('itm_code', $request->itm_code);
        }

        if ($request->order_type) {
            if ($request->order_type == 2) {
                $ordertyp = 0;
            } else if ($request->order_type == 1) {
                $ordertyp = 1;
            }
            $filter->where('order_type', $ordertyp);
        }

        if ($request->sdate && $request->to_date) {
            $filter->whereBetween(\DB::raw('DATE(sdate)'), array($request->sdate, $request->to_date));

        }

        if (Auth::user()->type != 0) {
            $filter->where('branch_id', Auth::user()->branch_id);
        } else {
            if ($request->branch_id) {
                $filter->where('branch_id', $request->branch_id);
            }
        }

        if ($request->client_phone) {
            $client = Client::where('phone', $request->client_phone)->first();
            if ($client) {

                $filter->where('client_id', $client->id);
            }
        }

        $query['data'] = $filter->get()->groupBy('order_id');
        return view('admin.order.index', $query);

    }

    public function show($id)
    {
        $query['setting'] = Setting::find(1);
        $query['data'] = Order::where('order_id', $id)->get();
        $inv = Order::where('order_id', $id)->get()->last();
        $inv_total = $inv->total_sub + $inv->total_tax;
        $generatedString = [
            $this->toString($query['setting']->title, '1'),
            $this->toString($query['setting']->tax_num, '2'),
            $this->toString($inv->created_at, '3'),
            $this->toString($inv_total, '4'),
            $this->toString($inv->total_tax, '5'),
        ];
        $query['qrcode'] = QrCode::size(150)->generate($this->toBase64($generatedString));
        return view('admin.order.show', $query);
    }


    public function create($id = null)
    {

        $query['branches'] = Branch::orderBy('id', 'asc')->get();
        return view('admin.order.cashier', $query);
    }

    public function client_data(Request $request)
    {
        $client = Client::where('phone', $request->phone)->first();

        if ($client) {
            return view('admin.order.checkclient', compact('client'));
        } else {
            $client = [];
            $client_phone = $request->phone;
            return view('admin.order.checkclient', compact('client'), compact('client_phone'));
        }

    }

    public function addClientOrder(Request $request)
    {
        $data = Client::create([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'location' => $request->location,
            'password' => Hash::make($request->phone),
            'is_active' => 1,
        ]);

        return $data->id;
    }

    public function addCartOrder(Request $request)
    { 

        $product = Post::select('title_en', 'itm_unit1', 'is_tax')->orderBy('id', 'desc')->with('Unit1')->where('itm_code', $request->itm_code)->first();
        if ($request->order_type == 1) {
            $stock = Stock::orderBy('id', 'desc')->where('itm_code', $request->itm_code)->where('branch_id', $request->branch_id)->first();
            $pro_return = Order::where('order_type', 0)->where('itm_code', $request->itm_code)->where('order_id', $request->order_return)->sum('qty');
            $prcart = OrderCart::where('itm_code', $request->itm_code)->where('emp_id', Auth::user()->id)->sum('qty');

            if ($pro_return == 0) {
                return response()->json(['msg' => 'faild']);
            }
        } else {
            $stock = Stock::orderBy('id', 'desc')->where('itm_code', $request->itm_code)->where('branch_id', $request->branch_id)->where('qty', '>', 0)->first();
            $prcart = OrderCart::where('itm_code', $request->itm_code)->where('emp_id', Auth::user()->id)->sum('qty');
        }

        if ($product && $stock) {
            if ($request->order_type == 1) {
                if (($prcart + 1) > $pro_return) {
                    return response()->json(['msg' => 'faild']);
                }
            } else {
                if (($prcart + 1) > $stock->qty) {
                    return response()->json(['msg' => 'faild']);
                }
            }

            $data = new OrderCart;
            $data->emp_id = Auth::user()->id;
            $data->itm_code = $request->itm_code;
            $data->title_en = $product->title_en;
            $data->expiry_date = $stock->expiry_date;
            $data->qty = 1;
            $data->unit_id = $product->itm_unit1;
            $data->unit_title = $product->Unit1->title;
            $data->is_tax = $product->is_tax;
            $data->price_selling = round($stock->price_selling, 2);

            $data->save();

            return view('admin.order.cart_data');
        } else {
            return response()->json(['msg' => 'faild']);
        }
    }

    public function getname(Request $request)
    { 

        $product = Post::select('title_en', 'itm_unit1', 'is_tax')->orderBy('id', 'desc')->with('Unit1')->where('itm_code', $request->itm_code)->first();

        if ($product) {
            return $product->title_en;
        } 
    }

    public function get_order_product(Request $request)
    {
        $id = $request->id;
        $cart = OrderCart::find($id);

        $itm_code = $cart->itm_code;
        $product = Post::where('itm_code', $itm_code)->with('Unit1')->with('Unit2')->with('Unit3')->first();
        $stock = Stock::where('itm_code', $itm_code)->where('branch_id', $request->branch_id)->get();

        return view('admin.order.addProductModal', compact('product'), compact('stock'))->with('qty', $cart->qty)->with('unit', $cart->unit_id)->with('price', $cart->price_selling)->with('sessin_id', $id);

    }

    public function editcartorder(Request $request)
    {

        $product = Post::where('itm_code', $request->itm_code)->get()->first();
        if (!empty($request->expiry_date)) {
            $stock = Stock::where('itm_code', $request->itm_code)->where('branch_id', $request->branch_id)->where('expiry_date', $request->expiry_date)->get()->first();
        } else {
            $stock = Stock::where('itm_code', $request->itm_code)->where('branch_id', $request->branch_id)->where('expiry_date', null)->get()->last();
        }

        if (($request->qty) > $stock->qty) {
            session()->flash('qty_faild', "عفوا ، المنتج غير متوفر");
            return view('admin.order.cart_data');
        }

        $unit = Unit::find($request->unit_id);

        if ($product->itm_unit1 == $unit->num) {
            $price = $request->price_selling;
        } elseif ($product->itm_unit2 == $unit->num) {
            $price = $request->price_selling / $product->mid;
        } elseif ($product->itm_unit3 == $unit->num) {
            $price = $request->price_selling / ($product->sm * $product->mid);
        } else {
            $price = $request->price_selling;
        }

        if ($request->discount) {
            $discount_percent = $request->discount / 100;
            $discount_price = round($price * $discount_percent, 2);

            $discount = $request->discount;
            $is_discount = 1;
        } else {
            $discount = 0;
            $discount_price = 0;
            $is_discount = 0;
        }

        $data = OrderCart::where('id', $request->sessin_id)->update([
            'itm_code' => $request->itm_code,
            'title_en' => $request->title_en,
            'expiry_date' => $request->expiry_date,
            'qty' => $request->qty,
            'unit_id' => $unit->num,
            'unit_title' => $unit->title,
            'is_tax' => $product->is_tax,
            'discount' => $discount,
            'discount_price' => $discount_price,
            'is_discount' => $is_discount,
            'price_selling' => round($price, 2)
        ]);

        return view('admin.order.cart_data');
    }

    public function add_discount(Request $request)
    {

        $discount = Discounts::find($request->discount);

        $carts = OrderCart::where('emp_id', Auth::user()->id)->get();

        if (!empty($request->discount)) {
            foreach ($carts as $ca) {
                $data = OrderCart::where('id', $ca->id)->update([
                    'discount' => $discount->discount,
                    'discount_title' => $discount->title,
                    'is_discount' => 1
                ]);
            }
        } else {
            foreach ($carts as $ca) {
                $data = OrderCart::where('id', $ca->id)->update([
                    'discount' => 0,
                    'discount_title' => NULL,
                    'is_discount' => 0
                ]);
            }
        }


        return view('admin.order.cart_data');
    }

    public function print_order($id)
    {
        $query['setting'] = Setting::find(1);
        $query['data'] = Order::where('order_id', $id)->get();

        $inv = Order::where('order_id', $id)->get()->last();

        $inv_total = $inv->total_sub + $inv->total_tax;

        $generatedString = [
            $this->toString($query['setting']->title, '1'),
            $this->toString($query['setting']->tax_num, '2'),
            $this->toString($inv->created_at, '3'),
            $this->toString($inv_total, '4'),
            $this->toString($inv->total_tax, '5'),

        ];

        $query['qrcode'] = QrCode::size(150)->generate($this->toBase64($generatedString));

        if ($query['setting']->printing == 'pos') {
            return view('admin.order.print-reset', $query);
        } else {
            return view('admin.order.print', $query);
        }
    }

    public function invoice($id)
    {
        $query['setting'] = Setting::find(1);
        $query['data'] = Order::where('order_id', $id)->get();

        $inv = Order::where('order_id', $id)->get()->last();

        $inv_total = $inv->total_sub + $inv->total_tax;

        $generatedString = [
            $this->toString($query['setting']->title, '1'),
            $this->toString($query['setting']->tax_num, '2'),
            $this->toString($inv->created_at, '3'),
            $this->toString($inv_total, '4'),
            $this->toString($inv->total_tax, '5'),

        ];

        $query['qrcode'] = QrCode::size(150)->generate($this->toBase64($generatedString));

        return view('admin.order.invoice', $query);
    }

    public function category_data($id, $branch_id)
    {
        $products = Post::where('cat_id', $id)->where('branch_id', $branch_id)->get();
        return view('admin.order.productPos_data', compact('products'));
    }

    public function Product(Request $request)
    {
        $product = Post::findOrFail($request->id);
        return view('admin.order.addProductModal', compact('product'));
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
            'price' => round($price, 2),
            'product' => $product,
            'quantity' => $request->quantity
        ];

        $cart[] = $c_r;
        Session::put('cart', $cart);
        return view('admin.order.cart_data');
    }

    public function DeleteCart(Request $request)
    {
        $id = $request->id;

        try {
            OrderCart::where('id', $id)->delete();
        } catch (\Exception $e) {

        }

        return view('admin.order.cart_data');
    }

    public function alldeletordercart(Request $request)
    {
        OrderCart::truncate();
        return view('admin.order.cart_data');
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
        return view('admin.order.todayOrders', $query);
    }

    public function cashier_show($id)
    {
        $query['setting'] = Setting::find(1);
        $query['data'] = Order::with('OrderProduct')->where('id', $id)->get()->first();
        $query['pro_details'] = Client::find($query['data']->pro_id);

        return view('admin.order.cashier_show', $query);
    }

    public function store(Request $request)
    {
        $Settings = Setting::find(1);
        if ($request->client_id) {
            $client = Client::find($request->client_id);
            if (!$client) {
                return redirect()->back()->with('msg', 'العميل غير موجود');
            }
        } else {
            $client = Client::where('phone', $request->client_phone)->get()->first();
            if (!$client) {
                return redirect()->back()->with('msg', 'العميل غير موجود');
            }
        }

        $cart = OrderCart::where('emp_id', Auth::user()->id)->get();

        if ($cart->count()) {
            $branch = Branch::find($request->branch_id);
            if (Order::count() == 0) {
                $ord_num = 1;
            } else {
                $last_row = Order::select('order_id')->latest()->first();
                $ord_num = $last_row->order_id + 1;
            }

            $total_product = 0;
            $total_discount = 0;
            $total_sub = 0;
            $total_tax = 0;
            $total = 0;
            $is_discount = 0;
            $discount_price = 0;

            foreach ($cart as $cart_item) {
                $product = Post::where('itm_code', $cart_item['itm_code'])->get()->first();

                $total_product = round($total_product + ($cart_item['price_selling'] * $cart_item['qty']), 2);
                if ($cart_item['is_tax'] == 1) {
                    $pre_price = $cart_item['price_selling'] * $cart_item['qty'];
                    $pre_discount = ($cart_item['price_selling'] * $cart_item['qty']) * ($cart_item['discount'] / 100);
                    $total_tax = round($total_tax + ($pre_price - $pre_discount) * ($Settings->tax / 100), 2);
                }

                $total_discount = ($cart_item['discount'] / 100) * $total_product;

                $is_discount += $cart_item['is_discount'];
                $discount_price += $cart_item['discount_price'];

                $order_orders = new Order();
                $order_orders->order_id = $ord_num;
                $order_orders->order_type = $request->order_type;
                $order_orders->branch_id = $request->branch_id;
                $order_orders->client_id = $client->id;
                $order_orders->sdate = $request->sdate;
                $order_orders->order_return = $request->order_return;

                $order_orders->price_selling = round($cart_item['price_selling'], 2);
                $order_orders->is_tax = $cart_item['is_tax'];
                $order_orders->unit_id = $cart_item['unit_id'];
                $order_orders->unit_title = $cart_item['unit_title'];
                $order_orders->expiry_date = $cart_item['expiry_date'];
                $order_orders->itm_code = $cart_item['itm_code'];
                $order_orders->qty = $cart_item['qty'];
                $order_orders->discount = $cart_item['discount'];
                $order_orders->discount_title = $cart_item['discount_title'];
                $order_orders->discount_price = $discount_price;
                $order_orders->is_discount = $is_discount;

                $order_orders->total_sub = $total_product - $total_discount;
                $order_orders->total_tax = $total_tax;
                $order_orders->cash = round($request->cash, 2);
                $order_orders->online = round($request->online, 2);
                $order_orders->tax_setting = $Settings->tax;

                $order_orders->branch = $branch;
                $order_orders->product = $product;
                $order_orders->client = $client;

                $order_orders->add_by_id = Auth::user()->id;
                $order_orders->add_by_name = Auth::user()->name;
                $order_orders->save();
//                todo::add vouchers one  receipt with (cash or online) and other one exchange with( (total_sub +total_tax));
//                todo::then add wallet In with (cash or online)and other one Out with( (total_sub +total_tax));
                $receipt = new Vouchers();
                $receipt->user_id = $client->id;
                $receipt->user_type = "client";
                $receipt->external_name = $client->name;
                $receipt->trans_date = Carbon::now();
                if ($request->online > 0) {
                    $receipt->pay_type = "network";
                } else {
                    $receipt->pay_type = "cash";
                }
                $receipt->type = "receipt";
                $receipt->amount = $order_orders->cash + $order_orders->online;
                $receipt->notes = "سند قبض لمدفوعات فاتورة بيع رقم   " . $order_orders->id;
                $receipt->save();

                $wallet_in = new Wallet();
                $wallet_in->walletable()->associate($client);
                $wallet_in->in = $receipt->amount;
                $wallet_in->trans_date = $receipt->trans_date;
                $wallet_in->type = "client";
                $wallet_in->notes = $receipt->notes;
                $wallet_in->save();

                //exchange

                $exchange = new Vouchers();
                $exchange->user_id = $client->id;
                $exchange->user_type = "client";
                $exchange->external_name = $client->name;
                $exchange->trans_date = Carbon::now();
                if ($request->online > 0) {
                    $exchange->pay_type = "network";
                } else {
                    $exchange->pay_type = "cash";
                }
                $exchange->type = "exchange";
                $exchange->amount = $order_orders->total_sub + $order_orders->total_tax;
                $exchange->notes = "سند صرف فاتورة مرتجع رقم " . $order_orders->id;
                $exchange->save();

                $wallet_out = new Wallet();
                $wallet_out->walletable()->associate($client);
                $wallet_out->out = $exchange->amount;
                $wallet_out->trans_date = $exchange->trans_date;
                $wallet_out->type = "client";
                $wallet_out->notes = $exchange->notes;
                $wallet_out->save();

                if (!empty($cart_item['expiry_date'])) {
                    $stock = Stock::where('itm_code', $cart_item['itm_code'])->where('branch_id', $request->branch_id)->whereDate('expiry_date', Carbon::parse($cart_item['expiry_date'])->format('Y-m-d'))->get()->first();
                } else {
                    $stock = Stock::where('itm_code', $cart_item['itm_code'])->where('branch_id', $request->branch_id)->where('expiry_date', NULL)->get()->first();
                }

                $qty = 0;
                $qty_mid = 0;
                $qty_sm = 0;

                if ($cart_item['unit_id'] == $product->itm_unit1) {
                    $qty = $cart_item['qty'];
                    if ($product->itm_unit1 != $product->itm_unit2) {
                        $qty_mid = $cart_item['qty'] * $product->mid;
                    }

                    if ($product->itm_unit2 != $product->itm_unit3) {
                        $qty_sm = $cart_item['qty'] * $product->mid * $product->sm;
                    }

                } else if ($cart_item['unit_id'] == $product->itm_unit2) {
                    $mid = $stock->qty_mid - $cart_item['qty'];
                    $mid_qty = $mid / $product->mid;

                    $qty = (int)($stock->qty - $mid_qty);
                    $qty_mid = $cart_item['qty'];

                    if ($product->itm_unit2 != $product->itm_unit3) {
                        $qty_sm = $cart_item['qty'] * $product->sm;
                    }

                } else if ($cart_item['unit_id'] == $product->itm_unit3) {
                    $sm = $stock->qty_sm - $cart_item['qty'];
                    $sm_qty = $sm / $product->sm;

                    $mid = $sm_qty / $product->mid;

                    $qty = (int)($stock->qty - $mid);
                    $qty_mid = (int)($stock->qty_mid - $sm_qty);
                    $qty_sm = $cart_item['qty'];
                }

                if ($request->order_type == 1) {
                    if ($stock) {
                        $updateStock = Stock::where('id', $stock->id)->update([
                            'qty' => $stock->qty + $qty,
                            'qty_mid' => $stock->qty_mid + $qty_mid,
                            'qty_sm' => $stock->qty_sm + $qty_sm
                        ]);
                    }
                } else {
                    if ($stock) {
                        $updateStock = Stock::where('id', $stock->id)->update([
                            'qty' => $stock->qty - $qty,
                            'qty_mid' => $stock->qty_mid - $qty_mid,
                            'qty_sm' => $stock->qty_sm - $qty_sm
                        ]);
                    }
                }

                OrderCart::truncate();
            }

            return redirect('admin/print_order/' . $order_orders->order_id);
            // return redirect()->back()->with('msg', 'تمت الاضافة بنجاح');
        } else {
            return redirect()->back()->with('msg', 'لا يوجد اصناف مضافة !');
        }

        return redirect()->back()->with('msg', 'لا يوجد اصناف مضافة !');
    }

    public function return_order($id)
    {
        $orders = Order::where('order_id', $id)->get();
        $check_order = Order::where('order_type', 1)->where('order_id', $id)->get();

        if ($check_order->count() > 0) {
            return redirect()->to('admin/show_order/' . $newOrder->order_id)->with('msg', 'عفوا تم ارجاع الفاتوره من قبل');
        } else {
        
            $last_row = Order::select('order_id')->latest()->first();
            $ord_num = $last_row->order_id + 1;
            foreach ($orders as $order) {
                $ord = Order::find($order->id);
                $newOrder = $ord->replicate();
                $newOrder->order_id = $ord_num;
                $newOrder->order_return = $order->order_id;
                $newOrder->order_type = 1;
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

            return redirect()->to('admin/show_order/' . $newOrder->order_id)->with('msg', 'تم بنجاح');
        }
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

    public function toBase64($value): string
    {
        return base64_encode($this->toTLV($value));
    }

    public function toTLV($value): string
    {
        return implode('', $value);
    }

    public function toString($value, $tag)
    {
        $value = (string)$value;

        return $this->toHex($tag) . $this->toHex($this->getLength($value)) . ($value);
    }

    protected function toHex($value)
    {
        return pack("H*", sprintf("%02X", $value));
    }

    public function getLength($value)
    {
        return strlen($value);
    }

}
