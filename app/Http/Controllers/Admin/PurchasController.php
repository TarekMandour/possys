<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vouchers;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Post;
use App\Models\Branch;
use App\Models\Stock;
use App\Models\Purchas;
use App\Models\Supplier;
use App\Models\Setting;
use App\Models\PurchasCart;
use DB;

class PurchasController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['branches'] = Branch::get();
        return view('admin.purchas.index', $query);
    }

    public function datatable(Request $request)
    {
        $data = Purchas::orderBy('id', 'desc');

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

        return Datatables::of($data)
            ->addColumn('id', function ($row) {
                $id = '';
                $id .= '<a href="'.url('/admin/show_purchas/'.$row->order_id).'">'.$row->order_id.'</a>';
                return $id;
            })
            ->editColumn('branch', function ($row) {
                $branch = '';
                $branch .= ' <span class="text-gray-800 text-hover-primary mb-1">' . json_decode($row->branch)->name . '</span>';
                return $branch;
            })
            ->editColumn('total_sub', function ($row) {                
                $total_sub = '';
                $total_sub .= ' <span class="text-gray-800 text-hover-primary mb-1">' . $row->total_sub . '</span>';
                return $total_sub;
            })
            ->editColumn('total_tax', function ($row) {
                $total_tax = '';
                $total_tax .= ' <span class="text-gray-800 text-hover-primary mb-1">' . $row->total_tax . '</span>';
                return $total_tax;
            })
            ->editColumn('total', function ($row) {
                $total = '';
                $total .= ' <span class="text-gray-800 text-hover-primary mb-1">' . ($row->total_sub + $row->total_tax) . '</span>';
                return $total;
            })
            ->editColumn('created_at', function ($row) {
                $created_at = '';
                $created_at .= ' <span class="text-gray-800 text-hover-primary mb-1">' . date('y-m-d | h:i a', strtotime($row->created_at)) . '</span>';
                return $created_at;
            })
            ->addColumn('actions', function ($row) {
                $actions = '';
                $actions .= '<a href="'.url('/admin/show_purchas/'.$row->order_id).'"
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

        $filter = DB::table('purchas')->select(DB::raw('branch,order_type,total_tax,total_sub,order_id,sdate,branch_id,supplier_id'))->orderBy('id', 'desc');

        if ($request->order_id) {
            $filter->where('order_id', $request->order_id);
        }

        if ($request->order_type) {
            if ($request->order_type == 2) {
                $ordertyp = 0;
            } else if ($request->order_type == 1)  {
                $ordertyp = 1;
            }
            $filter->where('order_type', $ordertyp);
        }

        if ($request->branch_id) {
            $filter->where('branch_id', $request->branch_id);
        }

        if ($request->supplier_phone) {
            $client = Supplier::where('phone', $request->supplier_phone)->first();
            if ($client) {
                $filter->where('supplier_id', $client->id);
            }
        }

        if ($request->sdate) {
            $filter->whereDate('sdate', $request->sdate);
        }

        $query['data'] = $filter->get()->groupBy('order_id');

        return view('admin.purchas.index', $query);

    }

    public function copyprice()
    {
        $stocks = Stock::where('price_selling', '>',1)->where('qty', '>',0)->get();

        foreach ($stocks as $sto) {
            $purchas = Purchas::where('itm_code', $sto->itm_code)->get()->last();
            if ($purchas) {
                Stock::where('itm_code', $sto->itm_code)->where('qty', '>',0)->update([
                    'price_purchasing' => $purchas->price_purchasing,
                    'price_selling' => $purchas->price_selling
                ]);
            }
        }
    }

    public function get_supplier(Request $request)
    {
        $client = Supplier::where('phone', $request->phone)->first();
        if ($client) {
            return view('admin.purchas.checksupplier', compact('client'));
        } else {
            $client = [];
            return view('admin.purchas.checksupplier', compact('client'));
        }

    }

    public function get_p_product(Request $request)
    {
        if (Auth::user()->type == 0) {

            $product = Post::where('itm_code', $request->itm_code)->first();
        } else {
            $product = Post::where('itm_code', $request->itm_code)->where('branch_id', Auth::user()->branch_id)->first();

        }

        $stock = Stock::where('itm_code', $product->itm_code)->latest()->first();

        if ($product) {
            return view('admin.purchas.addProductModal', compact('product','stock'));
        } else {
            $product = [];
            return view('admin.purchas.addProductModal', compact('product','stock'));
        }

    }

    public function addCartPurchas(Request $request)
    {

        $data = new PurchasCart;
            $data->emp_id = Auth::user()->id;
            $data->itm_code = $request->itm_code;
            $data->title_en = $request->title_en;
            $data->price_purchasing = round($request->price_purchasing,2);
            $data->qty = $request->qty;
            $data->is_tax = $request->is_tax;
            $data->price_selling = round($request->price_selling,2);
            $data->price_minimum_sale = round($request->price_minimum_sale,2);
            $data->production_date = $request->production_date;
            $data->expiry_date = $request->expiry_date;

            $data->save();

        return view('admin.purchas.cart_data');
    }

    public function alldeletpurchasecart(Request $request)
    {
        PurchasCart::truncate();

        return view('admin.purchas.cart_data');
    }

    public function deletpurchasecart(Request $request)
    {
        $id = $request->id;

        try{
            PurchasCart::where('id',$id)->delete();
        } catch (\Exception $e) {

        }

        return view('admin.purchas.cart_data');
    }

    public function show($id)
    {
        $query['branches'] = Branch::get();

        $query['data'] = Purchas::where('order_id', $id)->get();

        return view('admin.purchas.show', $query);
    }

    public function create()
    {
        $query['branches'] = Branch::get();
        return view('admin.purchas.create', $query);
    }

    public function store(Request $request)
    {
        $Settings = Setting::find(1);
        $supplier = Supplier::where('phone', $request->client_phone)->get()->first();
        if (!$supplier) {
            return redirect()->back()->with('msg', 'المورد غير موجود');
        }

        $cart = PurchasCart::where('emp_id', Auth::user()->id)->get();

        if ($cart->count()) {
            $branch = Branch::find($request->branch_id);

            if (Purchas::count() == 0) {
                $ord_num = 1;
            } else {
                $last_row = Purchas::select('order_id')->latest()->first();
                $ord_num = $last_row->order_id + 1;
            }

            $total_sub = 0;
            $total_tax = 0;
            $total = 0;

            foreach ($cart as $cart_item) {
                $product = Post::where('itm_code', $cart_item['itm_code'])->get()->first();

                $qty = $cart_item['qty']; $qty_mid = 0; $qty_sm = 0;

                if ($product->itm_unit1 != $product->itm_unit2) {
                    $qty_mid = $cart_item['qty'] * $product->mid;
                }

                if ($product->itm_unit2 != $product->itm_unit3) {
                    $qty_sm = $cart_item['qty'] * $product->mid * $product->sm;
                }

                $total_sub = $total_sub + ($cart_item['price_purchasing'] * $cart_item['qty']);
                if ($cart_item['is_tax'] == 1) {
                    $total_tax = round($total_tax + ($cart_item['price_purchasing'] * $cart_item['qty']) * ($Settings->tax / 100),2 );
                }

                $order_Purchas = new Purchas();
                $order_Purchas->order_id = $ord_num;
                $order_Purchas->order_type = $request->order_type;
                $order_Purchas->branch_id = $request->branch_id;
                $order_Purchas->supplier_id = $supplier->id;
                $order_Purchas->sdate = $request->sdate;
                $order_Purchas->order_return = $request->order_return;

                $order_Purchas->price_purchasing = round($cart_item['price_purchasing'],2);
                $order_Purchas->price_selling = round($cart_item['price_selling'],2);
                $order_Purchas->price_minimum_sale = round($cart_item['price_minimum_sale'],2);
                $order_Purchas->production_date = $cart_item['production_date'];
                $order_Purchas->expiry_date = $cart_item['expiry_date'];
                $order_Purchas->itm_code = $cart_item['itm_code'];
                $order_Purchas->qty = $cart_item['qty'];
                $order_Purchas->is_tax = $cart_item['is_tax'];

                $order_Purchas->total_sub = round($total_sub,2);
                $order_Purchas->total_tax = round($total_tax,2);
                $order_Purchas->cash = round($request->cash,2);
                $order_Purchas->online = round($request->online,2);
                $order_Purchas->installment = round($request->installment,2);

                $order_Purchas->branch = $branch;
                $order_Purchas->product = $product;
                $order_Purchas->supplier = $supplier;

                $order_Purchas->add_by_id = Auth::user()->id;
                $order_Purchas->add_by_name = Auth::user()->name;

                $order_Purchas->save();

//                todo::add vouchers one  receipt with (cash or online) and other one exchange with( (total_sub +total_tax));
//                todo::then add wallet In with (cash or online)and other one Out with( (total_sub +total_tax));


                $receipt = new Vouchers();
                $receipt->user_id = $supplier->id;
                $receipt->user_type = "supplier";
                $receipt->external_name = $supplier->title;
                $receipt->trans_date = Carbon::now();
                if ($request->online > 0) {
                    $receipt->pay_type = "network";
                } else {
                    $receipt->pay_type = "cash";
                }
                $receipt->type = "receipt";
                $receipt->amount = $order_Purchas->total_sub + $order_Purchas->total_tax;
                $receipt->notes = "سند قبض لمدفوعات فاتورة رقم   " . $order_Purchas->id;
                $receipt->save();

                $wallet_in = new Wallet();
                $wallet_in->walletable()->associate($supplier);
                $wallet_in->in = $receipt->amount;
                $wallet_in->trans_date = $receipt->trans_date;
                $wallet_in->type = "supplier";
                $wallet_in->notes = $receipt->notes;
                $wallet_in->save();

                //exchange

                $exchange = new Vouchers();
                $exchange->user_id = $supplier->id;
                $exchange->user_type = "supplier";
                $exchange->external_name = $supplier->title;
                $exchange->trans_date = Carbon::now();
                if ($request->online > 0) {
                    $exchange->pay_type = "network";
                } else {
                    $exchange->pay_type = "cash";
                }
                $exchange->type = "exchange";
                $exchange->amount = $order_Purchas->cash + $order_Purchas->online;
                $exchange->notes = "سند صرف فاتورة رقم " . $order_Purchas->id;
                $exchange->save();

                $wallet_out = new Wallet();
                $wallet_out->walletable()->associate($supplier);
                $wallet_out->out = $exchange->amount;
                $wallet_out->trans_date = $exchange->trans_date;
                $wallet_out->type = "supplier";
                $wallet_out->notes = $exchange->notes;
                $wallet_out->save();





                if (!empty($cart_item['expiry_date'])) {
                    $stock = Stock::where('itm_code', $cart_item['itm_code'])->where('branch_id', $request->branch_id)->whereDate('expiry_date', $cart_item['expiry_date'])->get()->first();
                } else {
                    $stock = Stock::where('itm_code', $cart_item['itm_code'])->where('branch_id', $request->branch_id)->where('expiry_date', null)->get()->first();
                }

                if ($request->order_type == 1) {
                    $updateStock = Stock::where('id', $stock->id)->update([
                        'qty' => $stock->qty - $qty,
                        'qty_mid' => $stock->qty_mid - $qty_mid,
                        'qty_sm' => $stock->qty_sm - $qty_sm,
                        'price_purchasing' => $cart_item['price_purchasing'],
                        'price_selling' => $cart_item['price_selling'],
                        'price_minimum_sale' => $cart_item['price_minimum_sale']
                    ]);
                } else {
                    if ($stock) {
                        $updateStock = Stock::where('id', $stock->id)->update([
                            'qty' => $stock->qty + $qty,
                            'qty_mid' => $stock->qty_mid + $qty_mid,
                            'qty_sm' => $stock->qty_sm + $qty_sm,
                            'price_purchasing' => $cart_item['price_purchasing'],
                            'price_selling' => $cart_item['price_selling'],
                            'price_minimum_sale' => $cart_item['price_minimum_sale']
                        ]);
                    } else {
                        $stock_new = new Stock;
                        $stock_new->qty = $cart_item['qty'];
                        $stock_new->price_purchasing = $cart_item['price_purchasing'];
                        $stock_new->price_selling = $cart_item['price_selling'];
                        $stock_new->price_minimum_sale = $cart_item['price_minimum_sale'];
                        $stock_new->production_date = $cart_item['production_date'];
                        $stock_new->expiry_date = $cart_item['expiry_date'];
                        $stock_new->itm_code = $cart_item['itm_code'];
                        $stock_new->branch_id = $request->branch_id;
                        $stock_new->save();
                    }
                }


                PurchasCart::truncate();
            }

            // return redirect('admin/print_order/' . $order->id);
            return redirect()->back()->with('msg', 'تمت الاضافة بنجاح');
        } else {
            return redirect()->back()->with('msg', 'لا يوجد اصناف مضافة !');
        }

        return redirect()->back()->with('msg', 'لا يوجد اصناف مضافة !');
    }

    public function edit($id)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Purchas::find($id);

        return view('admin.purchas.edit', $query);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'itm_code' => 'required|numeric|unique:purchass',
            'cat_id' => 'required|numeric',
            'itm_unit1' => 'required|numeric',
            'itm_unit2' => 'required|numeric',
            'itm_unit3' => 'required|numeric',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $row = Purchas::find($request->id);

        if ($img = $request->file('photo')) {
            $name = 'img_' . time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads/purchass/'), $name);
            $photo = url('/') . '/public/uploads/purchass/' . $name;
        } else {
            $photo = $row->photo;
        }

        $data = Purchas::where('id', $request->id)->update([
            'title' => $request->title,
            'title_en' => $request->title_en,
            'content' => $request->content,
            'cat_id' => $request->cat_id,
            'is_show' => $request->is_show,
            'itm_code' => $request->itm_code,
            'itm_unit1' => $request->itm_unit1,
            'itm_unit2' => $request->itm_unit2,
            'itm_unit3' => $request->itm_unit3,
            'mid' => $request->mid,
            'sm' => $request->sm,
            'status' => $request->status,
            'photo' => $photo
        ]);

        return redirect('admin/products')->with('msg', 'تم بنجاح');
    }

    public function print_purchas($id)
    {
        $query['setting'] = Setting::find(1);
        $query['branches'] = Branch::get();

        $query['data'] = Purchas::where('order_id', $id)->get();

        return view('admin.purchas.print', $query);
    }

    public function delete(Request $request)
    {

        try {
            Purchas::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg' => 'Failed']);
        }
        return response()->json(['msg' => 'Success']);
    }

    public function return_purchas($id)
    {
        $orders = Purchas::where('order_id', $id)->get();

        $last_row = Purchas::select('order_id')->latest()->first();
        $ord_num = $last_row->order_id + 1;

        foreach ($orders as $order) {
            $purchas = Purchas::find($order->id);
            $newOrder = $purchas->replicate();
            $newOrder->order_id = $ord_num;
            $newOrder->order_type = 1;
            $newOrder->order_return = $order->order_id;
            $newOrder->sdate = Carbon::now();
            $newOrder->created_at = Carbon::now();
            $newOrder->save();

            $stock = Stock::where('itm_code', $order->itm_code)->where('branch_id', $order->branch_id)->where('expiry_date', $order->expiry_date)->get()->first();
            if ($stock) {
                $updateStock = Stock::where('id', $stock->id)->update([
                    'qty' => $stock->qty - $order->qty
                ]);
            }
        }

        $query['branches'] = Branch::get();

        $query['data'] = Purchas::where('order_id', $newOrder->order_id)->get();

        return view('admin.purchas.show', $query);
        // return redirect()->back()->with('msg', 'تم بنجاح');
    }

    public function liveitemSearch(Request $request)
    {

        $search_text = $request->search_text;
        if ($search_text) {
            $results = DB::table('posts')
            ->where('title', 'LIKE', '%' . $search_text . '%')
            ->orWhere('title_en','LIKE','%' . $search_text . '%')
            ->orWhere('content','LIKE','%' . $search_text . '%')
            ->get();
        } else {
            $results = [];
        }

        return response()->json([
                    'results' => $results
                  ]);
    }

}
