<?php

namespace App\Http\Controllers\Api;

use App\ClientCart;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\AllOrderResource;
use App\Models\PostAttribute;
use App\Models\PostAdditional;
use Carbon\Carbon;
use App\Models\Vouchers;
use App\Models\Wallet;
use App\Models\Client;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Unit;
use App\Models\OrderCart;
use App\Models\Discounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DB;
use Validator;

class CartController extends Controller
{
    public function AddCart(Request $request)
    {
        $api_token = $request->header('token');
        $user = $this->check_api_token($api_token);
        if (!$user) {
            return $this->msgdata($request, 401, "برجاء تسجيل الدخول", (object)[]);
        }

        $rules = [
            'branch_id' => 'required|exists:branches,id',
            'itm_code' => 'required',
            'qty' => 'required',
            'order_type' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->msgdata($request, 401, $validator->messages()->first(), (object)[]);
        }


        $product = Post::select('title_en', 'itm_unit1', 'is_tax')->orderBy('id', 'desc')->with('Unit1')->where('itm_code', $request->itm_code)->first();
        if ($request->order_type == 1) {
            $stock = Stock::orderBy('id', 'desc')->where('itm_code', $request->itm_code)->where('branch_id', $request->branch_id)->first();
        } else {
            $stock = Stock::orderBy('id', 'desc')->where('itm_code', $request->itm_code)->where('branch_id', $request->branch_id)->where('qty', '>', 0)->first();
            if(!$stock) {
                return $this->msgdata($request, 401, "عفوا لا يوجد كميه", NULL); 
            }
        }

        if ($product && $stock) {
            
            $stock = Stock::orderBy('id', 'desc')->where('itm_code', $request->itm_code)->where('branch_id', $request->branch_id)->first();
            if ($stock->qty == 1) {
                $cart = OrderCart::where('emp_id', $user->id)->where('itm_code', $request->itm_code)->get();
                if ($cart->count() > 0) {
                    return $this->msgdata($request, 401, "عفوا المنتج غير متور", NULL);
                }
            }

            $data = new OrderCart;
            $data->emp_id = $user->id;
            $data->itm_code = $request->itm_code;
            $data->title_en = $product->title_en;
            $data->expiry_date = $stock->expiry_date;
            $data->qty = $request->qty;
            $data->unit_id = $product->itm_unit1;
            $data->unit_title = $product->Unit1->title;
            $data->is_tax = $product->is_tax;
            $data->price_selling = round($stock->price_selling, 2);
            $data->attributes = $request->attribute;
            $data->additionals = json_encode($request->additionals);

            $data->save();
        } else {
            return $this->msgdata($request, 401, "عفوا المنتج غير متور", $data);
        }

        return $this->ShowCart($request);
    }

    public function ShowCart(Request $request)
    {
        $api_token = $request->header('token');
        $user = $this->check_api_token($api_token);
        if (!$user) {
            return $this->msgdata($request, 401, "برجاء تسجيل الدخول", []);
        }

        $total_product = 0;
        $total_discount = 0;
        $pre_tax = 0 ;
        $total_sub = 0;
        $total_tax = 0;
        $total = 0;
        $is_discount = 0;
        $discount_price = 0;
        $Settings = Setting::find(1);
        $cart = OrderCart::where('emp_id', $user->id)->get();
        $carts = [];
        $cart_item_discount = 0;
        $discount_title = Null;
        $carts['products'] = [];
            foreach($cart as $key=> $cart_item) {
                $pro = Post::where('itm_code', $cart_item['itm_code'])->get()->first();

                $attributes = (object)[];
                $attPrice = 0;
                foreach (PostAttribute::where('itm_code', $cart_item['itm_code'])->get() as $key => $att) {
                    if ($att->id == $cart_item['attributes']) {
                        $attributes = $att;
                        $attPrice = $att->attprice;
                    }
                }

                $arr_additional = array();
                $addiPrice = 0;
                $additional = json_decode($cart_item['additionals']);
                foreach (PostAdditional::where('itm_code', $cart_item['itm_code'])->get() as $key => $addi) {
                    foreach ((array) $additional as $key => $additi) {
                        if ($addi->id == $additi) {
                            $arr_additional[] = $addi;
                            $addiPrice += $addi->addprice;
                        }
                    }
                }

                $pro_price_before_tax = (($cart_item['price_selling'] + $attPrice) * $cart_item['qty']) + $addiPrice ;
                $pro_tax = 0 ;
                
                $total_product = round($total_product + $pro_price_before_tax, 2);
                if ($cart_item['is_tax'] == 1) {
                    $pro_tax = ((($cart_item['price_selling'] + $attPrice) * $cart_item['qty']) + $addiPrice) * ($Settings->tax / 100);
                    $pre_price = $pro_price_before_tax ;
                    $pre_discount = $pre_price * ( $cart_item['discount'] / 100);
                    $total_tax = round($total_tax + ($pre_price - $pre_discount) * ($Settings->tax / 100), 2);
                }
                
                $is_discount += $cart_item['is_discount'];
                $discount_title = $cart_item['discount_title'];
                $cart_item_discount = $cart_item['discount'];

                $pro_price_after_tax = $pro_price_before_tax + $pro_tax ;

                $carts['products'][] = [
                    'id' => $cart_item['id'],
                    'emp_id' => $user->id,
                    'itm_code' => $cart_item['itm_code'],
                    'title_en' => $cart_item['title_en'],
                    'photo' => $pro->photo,
                    'expiry_date' => $cart_item['expiry_date'],
                    'qty' => $cart_item['qty'],
                    'unit_id' => $cart_item['unit_id'],
                    'unit_title' => $cart_item['unit_title'],
                    'is_tax' => $cart_item['is_tax'],
                    'price_selling' => $cart_item['price_selling'],
                    'discount' => $cart_item['discount'],
                    'discount_title' => $cart_item['discount_title'],
                    'discount_price' => $cart_item['discount_price'],
                    'is_discount' => $cart_item['is_discount'],
                    'attributes' => $attributes,
                    'additionals' => $arr_additional,
                    'price_before_tax' => $pro_price_before_tax,
                    'tax' => $pro_tax,
                    'price_after_tax' => $pro_price_after_tax
                ];
            };

            $total_discount = round(( $cart_item_discount / 100) * $total_product, 2);

            $carts['totals'][] = [
                'total_product_price' => $total_product,
                'discount_title' => $discount_title,
                'total_discount' => $total_discount,
                'total_sub' => $total_product - $total_discount,
                'total_tax' => $total_tax,
                'totals' => ($total_product - $total_discount) + $total_tax,
            ];
            
        // $data = CartResource::collection($cart);

        return $this->msgdata($request, 200, "نجاح", $carts);
    }

    public function DeleteCart(Request $request, $id)
    {
        $api_token = $request->header('token');
        $user = $this->check_api_token($api_token);
        if (!$user) {
            return $this->msgdata($request, 401, "برجاء تسجيل الدخول", (object)[]);
        }
        $data = OrderCart::where('id', $id)->delete();

        return $this->ShowCart($request);
    }

    public function DeleteAllCart(Request $request)
    {
        $api_token = $request->header('token');
        $user = $this->check_api_token($api_token);
        if (!$user) {
            return $this->msgdata($request, 401, "برجاء تسجيل الدخول", (object)[]);
        }
        $data = OrderCart::where('emp_id', $user->id)->delete();

        return $this->ShowCart($request);
    }

    public function EditCart(Request $request)
    {
        $api_token = $request->header('token');
        $user = $this->check_api_token($api_token);
        if (!$user) {
            return $this->msgdata($request, 401, "برجاء تسجيل الدخول", (object)[]);
        }

        $rules = [
            'branch_id' => 'required|exists:branches,id',
            'cart_id' => 'required',
            'qty' => 'required',
            'itm_code' => 'required',
            'order_type' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->msgdata($request, 401, $validator->messages()->first(), (object)[]);
        }


        $product = Post::select('title_en', 'itm_unit1','itm_unit2','itm_unit3','mid','sm', 'is_tax')->orderBy('id', 'desc')->with('Unit1')->where('itm_code', $request->itm_code)->first();
        if ($request->order_type == 1) {
            $stock = Stock::orderBy('id', 'desc')->where('itm_code', $request->itm_code)->where('branch_id', $request->branch_id)->first();
        } else {
            $stock = Stock::orderBy('id', 'desc')->where('itm_code', $request->itm_code)->where('branch_id', $request->branch_id)->where('qty', '>', 0)->first();
            if(!$stock) {
                return $this->msgdata($request, 401, "عفوا لا يوجد كميه", NULL); 
            } else if(($request->qty) > $stock->qty) {
                return $this->msgdata($request, 401, "عفوا لا يوجد كميه", NULL); 
            }
        }

        $price = $stock->price_selling;

        if ($request->unit_id) {
            $unit = Unit::find($request->unit_id);

            if ($product->itm_unit1 == $unit->num) {
                $price = $stock->price_selling;
            } elseif ($product->itm_unit2 == $unit->num) {
                $price = $stock->price_selling / $product->mid;
            } elseif ($product->itm_unit3 == $unit->num) {
                $price = $stock->price_selling / ($product->sm * $product->mid);
            }
        }
        

        if ($product && $stock) {

            $data = OrderCart::find($request->cart_id);
            $data->emp_id = $user->id;
            $data->itm_code = $request->itm_code;
            $data->title_en = $product->title_en;
            $data->expiry_date = $stock->expiry_date;
            $data->qty = $request->qty;
            $data->unit_id = $product->itm_unit1;
            $data->unit_title = $product->Unit1->title;
            $data->is_tax = $product->is_tax;
            $data->price_selling = round($price, 2);
            $data->attributes = $request->attribute;
            $data->additionals = json_encode($request->additionals);

            $data->save();
        } else {
            return $this->msgdata($request, 401, "عفوا المنتج غير متور", $data);
        }
        
        return $this->ShowCart($request);
    }

    public function AddDiscount(Request $request)
    {
        $api_token = $request->header('token');
        $user = $this->check_api_token($api_token);
        if (!$user) {
            return $this->msgdata($request, 401, "برجاء تسجيل الدخول", (object)[]);
        }

        $rules = [
            'discount' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->msgdata($request, 401, $validator->messages()->first(), (object)[]);
        }

        $discount = Discounts::find($request->discount);

        $carts = OrderCart::where('emp_id', $user->id)->get();

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
        
        return $this->ShowCart($request);
    }


    public function addOrder(Request $request)
    {
        $api_token = $request->header('token');
        $user = $this->check_api_token($api_token);
        if (!$user) {
            return $this->msgdata($request, 401, "برجاء تسجيل الدخول", (object)[]);
        }

        $Settings = Setting::find(1);
        if ($request->client_id) {
            $client = Client::find($request->client_id);
            if (!$client) {
                return $this->msgdata($request, 401, 'العميل غير موجود', (object)[]);
            }
        } else {
            $client = Client::where('phone', $request->client_phone)->get()->first();
            if (!$client) {
                return $this->msgdata($request, 401, 'العميل غير موجود', (object)[]);
            }
        }

        $cart = OrderCart::where('emp_id', $user->id)->orderBy('id','asc')->get();

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
            $pre_tax = 0 ;
            $total_sub = 0;
            $total_tax = 0;
            $total = 0;
            $is_discount = 0;
            $discount_price = 0;

            foreach ($cart as $yy => $cart_item) {
                $product = Post::where('itm_code', $cart_item['itm_code'])->get()->first();

                $attributes = (object)[];
                $attPrice = 0;
                foreach (PostAttribute::where('itm_code', $cart_item['itm_code'])->get() as $key => $att) {
                    if ($att->id == $cart_item['attributes']) {
                        $attributes = $att;
                        $attPrice = $att->attprice;
                    }
                }

                $arr_additional = array();
                $addiPrice = 0;
                $additional = json_decode($cart_item['additionals']);
                foreach (PostAdditional::where('itm_code', $cart_item['itm_code'])->get() as $key => $addi) {
                    foreach ((array) $additional as $key => $additi) {
                        if ($addi->id == $additi) {
                            $arr_additional[] = $addi;
                            $addiPrice += $addi->addprice;
                        }
                    }
                }

                $pro_price_before_tax = (($cart_item['price_selling'] + $attPrice) * $cart_item['qty']) + $addiPrice ;
                $pro_tax = 0 ;
                
                $total_product = round($total_product + $pro_price_before_tax, 2);
                if ($cart_item['is_tax'] == 1) {
                    $pro_tax = ((($cart_item['price_selling'] + $attPrice) * $cart_item['qty']) + $addiPrice) * ($Settings->tax / 100);
                    $pre_price = $pro_price_before_tax ;
                    $pre_discount = $pre_price * ( $cart_item['discount'] / 100);
                    $total_tax = round($total_tax + ($pre_price - $pre_discount) * ($Settings->tax / 100), 2);
                }
                
                $is_discount += $cart_item['is_discount'];
                $discount_title = $cart_item['discount_title'];
                $pro_price_after_tax = $pro_price_before_tax + $pro_tax ;


                $total_discount = ($cart_item['discount'] / 100) * $total_product;

                $is_discount += $cart_item['is_discount'];
                $discount_price += $cart_item['discount_price'];

                $order_orders = new Order();
                $order_orders->order_id = $ord_num;
                $order_orders->order_type = $request->order_type;
                $order_orders->branch_id = $request->branch_id;
                $order_orders->client_id = $client->id;
                $order_orders->sdate = $request->order_date;
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

                $order_orders->total_sub = round(($total_product - $total_discount), 2);
                $order_orders->total_tax = $total_tax;
                $order_orders->cash = round($request->cash, 2);
                $order_orders->online = round($request->online, 2);
                $order_orders->tax_setting = $Settings->tax;

                $order_orders->branch = $branch;
                $order_orders->product = $product;
                $order_orders->attributes = $cart_item['attributes'];
                $order_orders->additionals = $cart_item['additionals'];
                $order_orders->client = $client;

                $order_orders->add_by_id = $user->id;
                $order_orders->add_by_name = $user->name;
                $order_orders->save();

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
                    $stock = Stock::where('itm_code', $cart_item['itm_code'])->where('branch_id', $request->branch_id)->whereDate('expiry_date', $cart_item['expiry_date'])->get()->first();
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

            $order_details = Order::where('order_id', $order_orders->order_id)->get();
            $order = OrderResource::collection($order_details);

            return $this->msgdata($request, 200, 'تمت الاضافة بنجاح', $order[count($order) - 1]);
        } else {
            return $this->msgdata($request, 401, 'لا يوجد اصناف مضافة !', (object)[]);
        }

        return $this->msgdata($request, 401, 'لا يوجد اصناف مضافة !', (object)[]);
        
    }

    public function getOrders(Request $request)
    {
        $api_token = $request->header('token');
        $user = $this->check_api_token($api_token);
        if (!$user) {
            return $this->msgdata($request, 401, "برجاء تسجيل الدخول", (object)[]);
        }

        $query['branches'] = Branch::get();
        $filter = DB::table('orders')->select(DB::raw('order_id'))->distinct('order_id')->orderBy('order_id', 'desc');
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

        if ($request->from_date) {
            $filter->whereBetween(\DB::raw('DATE(sdate)'), array($request->from_date, $request->to_date));

        }

        if ($request->branch_id) {
            $filter->where('branch_id', $request->branch_id);
        }

        if ($request->client_phone) {
            $client = Client::where('phone', $request->client_phone)->first();
            if ($client) {

                $filter->where('client_id', $client->id);
            }
        }

        $order = $filter->paginate(10);
        // dd($order);
        $data = AllOrderResource::collection($order)->response()->getData(true);
        // $data = Order::where('client_id', $user->id)->select('client_id','id','branch','total_sub','total_tax','sdate')->get();
        return $this->msgdata($request, 200, "نجاح",$data);


    }

    public function getOrder(Request $request ,$id)
    {
        $api_token = $request->header('token');
        $user = $this->check_api_token($api_token);
        if (!$user) {
            return $this->msgdata($request, 401, "برجاء تسجيل الدخول", (object)[]);
        }

        $data = Order::where('order_id',$id)->get();
        $order = OrderResource::collection($data); 

        return $this->msgdata($request, 200, "نجاح",$order[count($order) - 1]);


    }
}
