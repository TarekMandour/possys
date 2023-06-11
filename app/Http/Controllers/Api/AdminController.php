<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\ClientResource;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Unit;
use App\Models\Branch;
use App\Models\Slider;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Printer;
use App\Models\Order;
use App\Models\Table;
use App\Models\TableCat;
use App\Models\Discounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Validator;
use DB;


class AdminController extends Controller
{
    //
    public function login(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->msgdata($request, 401, $validator->messages()->first(), null);
        }

        $token = Auth::guard('admin')->attempt(['phone' => $request->username, 'password' => $request->password]);

        //return token
        if (!$token) {
            return $this->msgdata($request, 401, "رقم الهاتف او كلمة المرور خطأ", null);
        }
        $user = Auth::guard('admin')->user();
        $user_data = Admin::where('id', $user->id)->first();

        if ($user_data->is_active != 1) {
            return $this->msgdata($request, 401, "عفوآ هذا الحساب موقوف.", null);
        }
        $user_data->api_token = Str::random(60);
        $user_data->save();
        $data = new AdminResource($user_data);
        return $this->msgdata($request, 200, "تم الدخول بنجاح", $data);
    }

    public function profile(Request $request)
    {

        $api_token = $request->header('token');
        $user = $this->check_api_token($api_token);

        if (!$user) {
            return $this->msgdata($request, 401, "برجاء تسجيل الدخول", null);
        }
        $data = new AdminResource($user);
        return $this->msgdata($request, 200, "نجاح", $data);


    }

    public function change_pasword(Request $request)
    {

        $rule = [
            'phone' => 'required',
            'password' => 'required|min:6'
        ];

        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {


            $data = Admin::where('phone', $request->phone)->update([
                'password' => Hash::make($request->password)
            ]);

            if ($data) {
                return $this->msgdata($request, 200, "تم التعديل بنجاح", null);

            } else {
                return response(['status' => 401, 'msg' => 'عفوا رقم الهاتف غير صحيح', 'data' => NULL]);

            }

        }

    }

    public function UpdateProfile(Request $request)
    {

        $rule = [       
            'name' => 'required|string',
            'phone' => 'required|unique:admins,api_token,' . $request->header('token'),
            'email' => 'required|email|unique:admins,api_token,' . $request->header('token'),
            'profile' => 'image|mimes:png,jpg,jpeg|max:2048'
        ];

        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {

            $api_token = $request->header('token');
            $user = $this->check_api_token($api_token);

            if (!$user) {
                return $this->msgdata($request, 401, "برجاء تسجيل الدخول", null);
            }

   
            if ($img = $request->file('profile')) {
                $name = 'img_' . time() . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('uploads'), $name);
                $profile = $name;
            } else {
                $profile = $user->photo;
            }
    
            $data = Admin::where('id', $user->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                 'photo' => $profile,
            ]);
            
            if ($data) {
                $user = $this->check_api_token($api_token);
                $data = new AdminResource($user);
                return $this->msgdata($request, 200, "تم التعديل بنجاح", $data);

            } else {
                return response(['status' => 401, 'msg' => 'عفوا هناك خطأ ما !', 'data' => NULL]);

            }

        }

    }

    public function Updatepassword(Request $request)
    {

        $rule = [       
            'oldpassword' => 'required|string',
            'password' => 'required|min:6'
        ];

        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {

            $api_token = $request->header('token');
            $user = $this->check_api_token($api_token);

            if (!$user) {
                return $this->msgdata($request, 401, "برجاء تسجيل الدخول", null);
            }

   
            if ($request->password) {
                $password = Hash::make($request->password);
            } else {
                $password = $user->password;
            }
    
            $data = Admin::where('id', $user->id)->update([
                'password' => $password,
            ]);
            
            if ($data) {
                $user = $this->check_api_token($api_token);
                $data = new AdminResource($user);
                return $this->msgdata($request, 200, "تم التعديل بنجاح", $data);

            } else {
                return response(['status' => 401, 'msg' => 'عفوا هناك خطأ ما !', 'data' => NULL]);

            }

        }

    }

    public function checkCode(Request $request)
    {

        $rule = [
            'phone' => 'required',
            'recode' => 'required|min:4'
        ];

        $validate = Validator::make($request->all(), $rule);

        if ($validate->fails()) {

            return response(['status' => 401, 'msg' => $validate->messages()->first(), 'data' => NULL]);
        } else {

            $user = Admin::where('phone', $request->phone)->get()->first();

            $Settings = Setting::find(1);

            if ($Settings->opt == 'email') {
                mail($user->email,"رمز التحقق",$request->recode);
            } else {

                // $ch = curl_init();
                // $url = "https://www.enjazsms.com/api/sendsms.php";
                // curl_setopt($ch, CURLOPT_URL, $url);
                // curl_setopt($ch, CURLOPT_POST, true);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, "username=fs4host&password=544566&message=كود التحقق : " . $request->recode . "&numbers=" . $request->phone . "&sender=iGold&unicode=E&return=full"); // define what you want to post
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // $output = curl_exec($ch);
                // curl_close($ch);

            }
            

            return response(['status' => 200, 'msg' => 'تم بنجاح', 'data' => NULL]);


        }

    }

    public function settings(Request $request)
    {

        $data = Setting::first();
        $data->logo1 = url('public/uploads/posts/' . $data->logo1);
        $data->logo2 = url('public/uploads/posts/' . $data->logo2);
        $data->fav = url('public/uploads/posts/' . $data->fav);
        $data->breadcrumb = url('public/uploads/posts/' . $data->breadcrumb);
        $data->flag = 'pharma';

        return $this->msgdata($request, 200, "نجاح", $data);

    }

    public function Units(Request $request )
    {
        $data = Unit::select('id','title','num')->get();
        return $this->msgdata($request, 200, "نجاح", $data);
    }

    public function Branches(Request $request)
    {
        $data = Branch::all();
        return $this->msgdata($request, 200, "نجاح", $data);
    }

    public function Categories(Request $request)
    {

        $data = CategoryResource::collection(Category::all());
        return $this->msgdata($request, 200, "نجاح", $data);


    }

    public function ProductsByCatID(Request $request, $branch_id, $cat_id)
    {
        $stock = Stock::where('branch_id', $branch_id)->limit(999)->pluck('itm_code')->toArray();
        $data = Post::whereStatus(1)->where('cat_id', $cat_id)->with('attribute')->with('additional')->with(['stock'=>function($query) use($branch_id){
            $query->where('branch_id',$branch_id);
            $query->Where('qty', '!=' , 0);
            $query->Where('qty', '>' , 0);
            $query->orWhere('qty_mid', '!=' , 0);
            $query->orWhere('qty_sm', '!=' , 0);
        }])->whereHas('stock', function ($query) use($branch_id) {
            $query->where('branch_id',$branch_id);
        })->paginate(10);
        $data = PostResource::collection($data)->response()->getData(true);
        return $this->msgdata($request, 200, "نجاح", $data);
    }

    public function ProductDetail(Request $request, $branch_id, $product_id)
    {
        $product = Post::where('id',$product_id)->with('attribute')->with('additional')->with(['stock'=>function($query) use($branch_id){
            $query->where('branch_id',$branch_id);
            $query->Where('qty', '!=' , 0);
            $query->orWhere('qty_mid', '!=' , 0);
            $query->orWhere('qty_sm', '!=' , 0);
        }])->whereHas('stock', function ($query) use($branch_id) {
            $query->where('branch_id',$branch_id);
        })->get();
        $data = PostResource::collection($product);
        return $this->msgdata($request, 200, "نجاح", $data);
    }

    public function Search(Request $request)
    {
        $rules = [
            'key' => 'required|string',
            'type' => 'required|in:product,category',
            'branch_id' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->msgdata($request, 401, $validator->messages()->first(), null);
        }

        $branch_id = $request->branch_id;
        
        if ($request->type == "product") {
            // $data = Stock::where('branch_id',$branch_id)
            // ->whereHas('Product', function ($query) use($request) {
            //     $query->where('title', 'like', '%' . $request->key . '%')
            //     ->orWhere('title_en', 'like', '%' . $request->key . '%')
            //     ->orWhere('content','like','%' . $request->key . '%');
            //    })->with('Product')->paginate(10);

            $data = Post::where('title', 'like', '%' . $request->key . '%')
                ->orWhere('title_en', 'like', '%' . $request->key . '%')
                ->orWhere('content','like','%' . $request->key . '%')
                ->whereHas('stock', function ($query) use($branch_id) {
                    $query->where('branch_id',$branch_id);
                })
                ->with(['stock'=>function($query) use($branch_id){
                    $query->where('branch_id',$branch_id);
                    $query->Where('qty', '!=' , 0);
                    $query->Where('qty', '>' , 0);
                }])
                ->paginate(10);
        } else {
            $data = Category::where('title', 'like', '%' . $request->key . '%')
                ->orWhere('title_en', 'like', '%' . $request->key . '%')
                ->get();
        }

        $data = PostResource::collection($data)->response()->getData(true);
        return $this->msgdata($request, 200, "نجاح", $data);
    }

    public function SearchItemCode(Request $request, $branch_id, $item_code)
    {
        $product = Post::where('itm_code', $item_code)->with('attribute')->with('additional')
        ->whereHas('stock', function ($query) use($branch_id) {
            $query->where('branch_id',$branch_id);
        })
        ->with(['stock'=>function($query) use($branch_id){
            $query->where('branch_id',$branch_id);
            $query->Where('qty', '!=' , 0);
        }])->get();
        $data = PostResource::collection($product);

        return $this->msgdata($request, 200, "نجاح", $data);
    }

    public function printers(Request $request)
    {
        $data = Printer::orderBy('id','desc')->get();
        return $this->msgdata($request, 200, "نجاح", $data);
    }

    public function printerUpdate(Request $request)
    {
        $rules = [
            'printer_id' => 'required',
            'title' => 'required',
            'ip' => 'required',
            'port' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->msgdata($request, 401, $validator->messages()->first(), null);
        }

        $data = Printer::where('id', $request->printer_id)->update([
            'title' => $request->title,
            'ip' => $request->ip,
            'port' => $request->port,
        ]);

        $printer = Printer::find($request->printer_id);

        return $this->msgdata($request, 200, "نجاح", $printer);
    }

    public function printerDetail(Request $request, $id)
    {
        $printer = Printer::find($id);
        return $this->msgdata($request, 200, "نجاح", $printer);
    }

    public function printerremove(Request $request, $id)
    {
        Printer::where('id',$request->id)->delete();
        return $this->msgdata($request, 200, "نجاح", null);
    }

    public function tablesCategory(Request $request)
    {
        $data = TableCat::orderBy('id','desc')->get();
        return $this->msgdata($request, 200, "نجاح", $data);
    }

    public function tableByCategory(Request $request, $cat_id)
    {
        $data = Table::where('cat_id', $cat_id)->orderBy('id','desc')->get();
        return $this->msgdata($request, 200, "نجاح", $data);
    }

    public function tables(Request $request)
    {
        $data = Table::orderBy('id','desc')->get();
        return $this->msgdata($request, 200, "نجاح", $data);
    }

    public function tableDetail(Request $request, $id)
    {
        $table = Table::find($id);
        return $this->msgdata($request, 200, "نجاح", $table);
    }

    public function tableUpdate(Request $request)
    {
        $rules = [
            'table_id' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->msgdata($request, 401, $validator->messages()->first(), null);
        }

        $client = Client::find($request->client_id);
        if ($client) {
            $client_name = $client->name;
            $client_phone = $client->phone;
        } else {
            $client_name = NULL;
            $client_phone = NULL;
        }

        $data = Table::where('id', $request->table_id)->update([
            'status' => $request->status,
            'client_name' => $client_name,
            'client_phone' => $client_phone,
        ]);

        $table = Table::find($request->table_id);

        return $this->msgdata($request, 200, "نجاح", $table);
    }

    public function clientAdd(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'address' => 'nullable',
            'location' => 'nullable',
            'email' => 'nullable',
            'phone' => 'required|string|unique:clients',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->msgdata($request, 401, $validator->messages()->first(), null);
        }

        $data = Client::create([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'location' => $request->location,
            'phone' => $request->phone,
            'password' => Hash::make($request->phone),
            'is_active' => 1,
        ]);

        $data = new ClientResource($data);
        return $this->msgdata($request, 200, "تم التسجيل بنجاح", $data);
    }

    public function clientProfile(Request $request, $phone)
    {

        $user = Client::where('phone','LIKE', "%$phone%")->get();

        if ($user->count() == 0) {
            return $this->msgdata($request, 401, "لا يوجد حساب مسجل لهذا الرقم", null);
        }

        $data = ClientResource::collection($user);

        return $this->msgdata($request, 200, "نجاح", $data);
    }

    public function Discounts(Request $request)
    {
        $data = Discounts::orderBy('id','desc')->get();
        return $this->msgdata($request, 200, "نجاح", $data);
    }

    public function home(Request $request, $id)
    {
        $orders = DB::table('orders')->select(DB::raw('order_type,itm_code,qty,unit_id,total_tax,total_sub,order_id,sdate,client,created_at,cash,online'))->orderByRaw('id DESC');
            $orders = $orders->whereDate('sdate', date("Y-m-d"))
                ->where('branch_id', $id)
                ->get()->groupBy('order_id');

            $data['products'] = Post::count();
            $total_tax = 0;
            $total_sub = 0;
            $total_cash = 0;
            $total_cash_return = 0;
            $total_online = 0;
            $total_online_return = 0;

            $total_tax_return = 0;
            $total_sub_return = 0;

            $pricepurchasing = 0;
            $data['orders'] = [];
            foreach ($orders as $rowo) {
                $data['orders'][] = [
                    'order_id' => $rowo[0]->order_id,
                    'order_type' => $rowo[0]->order_type,
                    'cash' => $rowo[0]->cash,
                    'online' => $rowo[0]->online,
                    'date' => $rowo[0]->sdate,
                    'client' => json_decode($rowo[0]->client)->name,
                    'phone' => json_decode($rowo[0]->client)->phone
                ];
                if ($rowo[0]->order_type == 0) {

                    foreach ($rowo as $sto) {
                
                        $pri = Stock::select('price_purchasing','itm_code')->with('Product')->where('itm_code', $sto->itm_code)->latest()->first();
    
                        if ($pri) {
                            if ($sto->unit_id == $pri->product->itm_unit1) {
                                $stock_purchasing = $pri->price_purchasing;
                            } else if ($sto->unit_id == $pri->product->itm_unit2) {
                                $stock_purchasing = $pri->price_purchasing / $pri->product->mid;
                            } else if ($sto->unit_id == $pri->product->itm_unit3) {
                                $stock_purchasing = $pri->price_purchasing / $pri->product->sm;
                            }
    
                            $pricepurchasing += $stock_purchasing * $sto->qty ;
                        }
    
                    }

                    $total_tax += $rowo[0]->total_tax;
                    $total_sub += $rowo[0]->total_sub;
                    $total_cash += $rowo[0]->cash;
                    $total_online += $rowo[0]->online;

                } else if ($rowo[0]->order_type == 1) {

                    foreach ($rowo as $sto) {
                
                        $pri = Stock::select('price_purchasing','itm_code')->with('Product')->where('itm_code', $sto->itm_code)->latest()->first();
    
                        if ($pri) {
                            if ($sto->unit_id == $pri->product->itm_unit1) {
                                $stock_purchasing = $pri->price_purchasing;
                            } else if ($sto->unit_id == $pri->product->itm_unit2) {
                                $stock_purchasing = $pri->price_purchasing / $pri->product->mid;
                            } else if ($sto->unit_id == $pri->product->itm_unit3) {
                                $stock_purchasing = $pri->price_purchasing / $pri->product->sm;
                            }
    
                            $pricepurchasing -= $stock_purchasing * $sto->qty ;
                        }
    
                    }

                    $total_tax_return += $rowo[0]->total_tax;
                    $total_sub_return += $rowo[0]->total_sub;
                    $total_cash_return += $rowo[0]->cash;
                    $total_online_return += $rowo[0]->online;


                }
            }
            
            $data['pricepurchasing'] = $pricepurchasing;
            $data['total_tax'] = $total_tax;
            $data['total_sales'] = $total_tax + $total_sub;
            $data['total_return'] = $total_tax_return + $total_sub_return;
            $data['total_cash'] = $total_cash - $total_cash_return;
            $data['total_online'] = $total_online - $total_online_return;

            $now = Carbon::now();
        $query['results'] = "[[0, 10, 20, 30, 40, 50, 30, 20, 80, 80, 70, 50, 30]]";
        $lastDay = date('m',strtotime('last month'));

        $month[] = $now ->month ;
        $year[] = $now ->year ;
        $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', $now ->month)->whereYear('sdate', $now ->year)->get()->count();

        for ($i=1; $i < 12; $i++) { 
            $last_month = $now ->month - $i ;
            if ($last_month < 1) {
                if ($last_month == 0) {
                    $month[] = 12 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', 12)->whereYear('sdate', ($now ->year - 1))->get()->count();

                } else if ($last_month == -1) {
                    $month[] = 11 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', 11)->whereYear('sdate', ($now ->year - 1))->get()->count();

                } else if ($last_month == -2) {
                    $month[] = 10 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', 10)->whereYear('sdate', ($now ->year - 1))->get()->count();
                
                } else if ($last_month == -3) {
                    $month[] = 9 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', 9)->whereYear('sdate', ($now ->year - 1))->get()->count();

                } else if ($last_month == -4) {
                    $month[] = 8 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', 8)->whereYear('sdate', ($now ->year - 1))->get()->count();

                } else if ($last_month == -5) {
                    $month[] = 7 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', 7)->whereYear('sdate', ($now ->year - 1))->get()->count();

                } else if ($last_month == -6) {
                    $month[] = 6 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', 6)->whereYear('sdate', ($now ->year - 1))->get()->count();

                } else if ($last_month == -7) {
                    $month[] = 5 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', 5)->whereYear('sdate', ($now ->year - 1))->get()->count();

                } else if ($last_month == -8) {
                    $month[] = 4 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', 4)->whereYear('sdate', ($now ->year - 1))->get()->count();

                } else if ($last_month == -9) {
                    $month[] = 3 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', 3)->whereYear('sdate', ($now ->year - 1))->get()->count();

                } else if ($last_month == -10) {
                    $month[] = 2 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', 2)->whereYear('sdate', ($now ->year - 1))->get()->count();

                } else if ($last_month == -11) {
                    $month[] = 1 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', 1)->whereYear('sdate', ($now ->year - 1))->get()->count();

                }
            } else {
                $month[] = $last_month ;
                $year[] = $now ->year ;
                $count_order[] = Order::where('branch_id', $id)->whereMonth('sdate', $last_month)->whereYear('sdate', $now ->year)->get()->count();

            }
        }

        $data['chart'] = $count_order;
        $data['month'] = $month;
        $data['year'] = $year;

        return $this->msgdata($request, 200, "نجاح", $data);
    }




    public function sliders(Request $request)
    {

        $data = SliderResource::collection(Slider::orderBy('id', 'desc')->get());
        return $this->msgdata($request, 200, "نجاح", $data);


    }

    public function supplies(Request $request)
    {
        $api_token = $request->header('token');
        $user = $this->check_api_token($api_token);
        if (!$user) {
            return $this->msgdata($request, 401, "برجاء تسجيل الدخول", null);
        }
        $data = SupplierResource::collection(Supplier::orderBy('id', 'desc')->get());
        return $this->msgdata($request, 200, "نجاح", $data);


    }


    public function StoreSupplier(Request $request)
    {
        $api_token = $request->header('token');
        $user = $this->check_api_token($api_token);
        if (!$user) {
            return $this->msgdata($request, 401, "برجاء تسجيل الدخول", null);
        }

        $rules = [
            'title' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'sales_name' => 'required',
            'phone2' => 'required',
            'email' => 'nullable|email',
            'num' => 'required',
            'tax_number' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->msgdata($request, 401, $validator->messages()->first(), null);
        }

        $data = new Supplier;
        $data->title = $request->title;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->sales_name = $request->sales_name;
        $data->phone2 = $request->phone2;
        $data->email = $request->email;
        $data->num = $request->num;
        $data->tax_number = $request->tax_number;
        $data->is_active = 1;
        $data->save();

        $data = new SupplierResource($data);
        return $this->msgdata($request, 200, "نجاح", $data);


    }


    public function ActiveProducts(Request $request, $id)
    {
        $stock = Stock::where('branch_id', $id)->pluck('itm_code')->toArray();
        $data = Post::whereStatus(1)->whereIn('itm_code', $stock)->paginate(10);
        return $this->msgdata($request, 200, "نجاح", $data);

    }

    

    public function FeaturedProducts(Request $request, $id)
    {
        $stock = Stock::where('branch_id', $id)->pluck('itm_code')->toArray();
        $data = Post::where('is_show', 1)->whereIn('itm_code', $stock)->paginate(10);
        return $this->msgdata($request, 200, "نجاح", $data);


    }


}
