<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Stock;
use App\Models\Client;
use App\Models\Order;
use App\Models\Post;
use App\Models\Bonus;
use App\Models\Purchas;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{
    public function TaxReport(Request $request)
    {
        $filter = Order::orderBy('id', 'desc');

        if ($request->order_type) {

            if ($request->order_type == 2) {
                $ordertyp = 0;
            } else if ($request->order_type == 1) {
                $ordertyp = 1;
            }

            $filter = $filter->where('order_type', $ordertyp);
        }

        if ($request->sdate) {
            $filter->whereBetween(\DB::raw('DATE(sdate)'), array($request->sdate, $request->to_date));
            $query['data'] = $filter->get()->groupBy('order_id');
            return view('admin.report.taxreport', $query);
        }
        
        $query['data'] = null;
        return view('admin.report.taxreport', $query);

    }

    public function saleinvReport(Request $request)
    {
        $filter = Order::orderBy('id', 'desc');

        if ($request->order_type) {

            if ($request->order_type == 2) {
                $ordertyp = 0;
            } else if ($request->order_type == 1) {
                $ordertyp = 1;
            }

            $filter = $filter->where('order_type', $ordertyp);
        }

        if ($request->sdate) {
            $filter->whereBetween(\DB::raw('DATE(sdate)'), array($request->sdate, $request->to_date));
            $query['data'] = $filter->get()->groupBy('order_id');
            return view('admin.report.saleinvreport', $query);
        }
        
        $query['data'] = null;
        return view('admin.report.saleinvreport', $query);

    }

    public function PrintTaxReport(Request $request)
    {
        $filter = Order::orderBy('id', 'desc')->where('order_type', 0);
        if ($request->sdate) {
            $filter->whereBetween(\DB::raw('DATE(sdate)'), array($request->sdate, $request->to_date));
            $query['data'] = $filter->get()->groupBy('order_id');
            return view('admin.report.printtaxreport', $query);
        }
        $query['data'] = null;
        return view('admin.report.taxreport', $query);

    }

    public function BonusReport(Request $request)
    {
        $query['admins'] = Admin::orderBy('id', 'desc')->get();

        if ($request->sdate) {
            $bonuses = Bonus::orderBy('id', 'desc')->where('admin_id',$request->admin_id)->get();

            foreach ($bonuses as $bon) {

                $filter = Order::orderBy('id', 'desc')->where('order_type', 0);
                $filter->where('add_by_id',$request->admin_id);
                $filter->whereBetween(\DB::raw('DATE(sdate)'), array($request->sdate, $request->to_date));
                $filter->where('itm_code',$bon->pro_id);
                $results = $filter->get();

                $price = 0;
                $qty = 0;
                foreach ($results as $result) {
                    $price += $result->qty  * $result->price_selling;
                    $qty += $result->qty;
                }

                if (Auth::user()->type == 0) {
                    if ($results->count() > 0) {
                        $query['data'][] = array (
                            "title" => json_decode($bon->product)->title,
                            "qty" => $qty,
                            "price" => $price,
                            "percent_num" => $bon->percent * 100,
                            "percent" => round($bon->percent * $price, 2) ,
                        );
                    }
                } else {
                    $query['data'][] = array (
                        "title" => json_decode($bon->product)->title,
                        "qty" => $qty,
                        "price" => $price,
                        "percent_num" => $bon->percent * 100,
                        "percent" => round($bon->percent * $price, 2) ,
                    );
                }
                
            }

            if (!isset($query['data'])) {
                $query['data'] = null;
            }
           
            return view('admin.report.bonusreport', $query);
        }
        $query['data'] = null;
        return view('admin.report.bonusreport', $query);

    }


    public function SellReport(Request $request)
    {
        if ($request->user_id && !$request->supplier_id) {

            $orders = DB::table('orders')->select(DB::raw('order_type,itm_code,qty,unit_id,total_tax,total_sub,order_id,sdate'))->orderByRaw('id DESC');
            $orders = $orders->where('add_by_id', $request->user_id);
            $orders = $orders->whereBetween(\DB::raw('DATE(sdate)'), array($request->sdate, $request->to_date))
                ->get()->groupBy('order_id');
            $total_tax = 0;
            $total_sub = 0;

            $total_tax_return = 0;
            $total_sub_return = 0;

            $pricepurchasing = 0;

            foreach ($orders as $rowo) {

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

                }

                
            }
            
            $total_sales = $total_tax + $total_sub;
            $total_return = $total_tax_return + $total_sub_return;


            $purcase = Purchas::orderBy('id', 'desc')
                ->whereBetween(\DB::raw('DATE(sdate)'), array($request->sdate, $request->to_date))
                ->where('order_type', 0);
            $purcase_return = Purchas::orderBy('id', 'desc')
                ->whereBetween(\DB::raw('DATE(sdate)'), array($request->sdate, $request->to_date))
                ->where('order_type', 1);

            $purcase = $purcase->where('add_by_id', $request->user_id)->get()->groupBy('order_id');
            $purcase_return = $purcase_return->where('add_by_id', $request->user_id)->get()->groupBy('order_id');
            $total_buy_tax = 0;
            $total_sub_buy = 0;
            foreach ($purcase as $row) {
                $total_buy_tax += $row[0]->total_tax;
                $total_sub_buy += $row[0]->total_sub;
            }

            $total_buy = $total_sub_buy + $total_buy_tax;

            $total_buy_tax_return = 0;
            $total_sub_buy_return = 0;
            foreach ($purcase_return as $row) {
                $total_buy_tax_return += $row[0]->total_tax;
                $total_sub_buy_return += $row[0]->total_sub;
            }
            $total_buy_return = $total_sub_buy_return + $total_buy_tax_return;


        }
        elseif ($request->supplier_id) {

            $purcase = Purchas::orderBy('id', 'desc')
                ->whereBetween(\DB::raw('DATE(sdate)'), array($request->sdate, $request->to_date))
                ->where('supplier_id', $request->supplier_id)->where('order_type', 0);
            $purcase_return = Purchas::orderBy('id', 'desc')
                ->whereBetween(\DB::raw('DATE(sdate)'), array($request->sdate, $request->to_date))
                ->where('supplier_id', $request->supplier_id)->where('order_type', 1);
            if ($request->user_id) {
                $purcase = $purcase->where('add_by_id', $request->user_id);
                $purcase_return = $purcase_return->where('add_by_id', $request->user_id);
            }
            $purcase = $purcase->get()->groupBy('order_id');
            $purcase_return = $purcase_return->get()->groupBy('order_id');

            $pricepurchasing = 0;
            $total_buy_tax = 0;
            $total_sub_buy = 0;
            foreach ($purcase as $row) {
                $total_buy_tax += $row[0]->total_tax;
                $total_sub_buy += $row[0]->total_sub;
            }

            $total_buy = $total_sub_buy + $total_buy_tax;

            $total_buy_tax_return = 0;
            $total_sub_buy_return = 0;
            foreach ($purcase_return as $row) {
                $total_buy_tax_return += $row[0]->total_tax;
                $total_sub_buy_return += $row[0]->total_sub;
            }


            $total_buy_return = $total_buy_tax_return + $total_sub_buy_return;

//            $total_buy = $purcase->sum('total_sub') + $purcase->sum('total_tax');
//            $total_buy_tax = $purcase->sum('total_tax');
//            $total_buy_return = $purcase_return->sum('total_sub') + $purcase_return->sum('total_tax');

            $total_sales = 0;
            $total_tax = 0;
            $total_return = 0;

        }
        else {

            $orders = DB::table('orders')->select(DB::raw('order_type,itm_code,qty,unit_id,total_tax,total_sub,order_id,sdate'))->orderByRaw('id DESC');
            $orders = $orders->whereBetween(\DB::raw('DATE(sdate)'), array($request->sdate, $request->to_date))
                ->get()->groupBy('order_id');
            $total_tax = 0;
            $total_sub = 0;

            $total_tax_return = 0;
            $total_sub_return = 0;

            $pricepurchasing = 0;

            

            foreach ($orders as $rowo) {

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

                }

                
            }
            
            $total_sales = $total_tax + $total_sub;
            $total_return = $total_tax_return + $total_sub_return;

            $purcase = DB::table('purchas')->select(DB::raw('id,order_type,total_tax,total_sub,order_id,sdate'))->orderByRaw('id DESC');
            $purcase = $purcase->whereBetween(\DB::raw('DATE(sdate)'), array($request->sdate, $request->to_date))
                ->get()->groupBy('order_id');
            $total_buy_tax = 0;
            $total_sub_buy = 0;

            $total_buy_tax_return = 0;
            $total_sub_buy_return = 0;

            foreach ($purcase as $key => $rowp) {

                    if ($rowp[0]->order_type == 0) {

                        $total_buy_tax += $rowp[0]->total_tax;
                        $total_sub_buy += $rowp[0]->total_sub;

                    } else if ($rowp[0]->order_type == 1) {

                        $total_buy_tax_return += $rowp[0]->total_tax;
                        $total_sub_buy_return += $rowp[0]->total_sub;

                    }

            }
            $total_buy = $total_sub_buy + $total_buy_tax;

            $total_buy_return = $total_buy_tax_return + $total_sub_buy_return;
        }

        return view('admin.report.sellreport', compact('total_sales', 'total_tax', 'total_return', 'total_buy', 'total_buy_tax', 'total_buy_return', 'pricepurchasing'));
    }

    public function ItemReport(Request $request) {

        $now = Carbon::now();
        $query['results'] = "[[0, 10, 20, 30, 40, 50, 30, 20, 80, 80, 70, 50, 30]]";
        $lastDay = date('m',strtotime('last month'));

        $month[] = $now ->month ;
        $year[] = $now ->year ;
        $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', $now ->month)->whereYear('sdate', $now ->year)->get()->count();
        $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', $now ->month)->whereYear('sdate', $now ->year)->get();
        $total_price = 0 ;
        foreach ($item_price as $itm) {
            $total_price += $itm->price_selling * $itm->qty ;
        }
        $price_selling_order[] = $total_price;

        $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', $now ->month)->whereYear('sdate', $now ->year)->get();
        $total_price_Purchas = 0 ;
        foreach ($item_price_Purchas as $itm) {
            $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
        }
        $price_purchasing_order[] = $total_price_Purchas;

        for ($i=1; $i < 12; $i++) { 
            $last_month = $now ->month - $i ;
            if ($last_month < 1) {
                if ($last_month == 0) {
                    $month[] = 12 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', 12)->whereYear('sdate', ($now ->year - 1))->get()->count();

                    $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', 12)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price = 0 ;
                    foreach ($item_price as $itm) {
                        $total_price += $itm->price_selling * $itm->qty ;
                    }
                    $price_selling_order[] = $total_price;

                    $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', 12)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price_Purchas = 0 ;
                    foreach ($item_price_Purchas as $itm) {
                        $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
                    }
                    $price_purchasing_order[] = $total_price_Purchas;
                } else if ($last_month == -1) {
                    $month[] = 11 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', 11)->whereYear('sdate', ($now ->year - 1))->get()->count();

                    $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', 11)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price = 0 ;
                    foreach ($item_price as $itm) {
                        $total_price += $itm->price_selling * $itm->qty ;
                    }
                    $price_selling_order[] = $total_price;
                    
                    $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', 11)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price_Purchas = 0 ;
                    foreach ($item_price_Purchas as $itm) {
                        $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
                    }
                    $price_purchasing_order[] = $total_price_Purchas;
                } else if ($last_month == -2) {
                    $month[] = 10 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', 10)->whereYear('sdate', ($now ->year - 1))->get()->count();

                    $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', 10)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price = 0 ;
                    foreach ($item_price as $itm) {
                        $total_price += $itm->price_selling * $itm->qty ;
                    }
                    $price_selling_order[] = $total_price;
                    
                    $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', 10)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price_Purchas = 0 ;
                    foreach ($item_price_Purchas as $itm) {
                        $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
                    }
                    $price_purchasing_order[] = $total_price_Purchas;
                } else if ($last_month == -3) {
                    $month[] = 9 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', 9)->whereYear('sdate', ($now ->year - 1))->get()->count();

                    $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', 9)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price = 0 ;
                    foreach ($item_price as $itm) {
                        $total_price += $itm->price_selling * $itm->qty ;
                    }
                    $price_selling_order[] = $total_price;

                    $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', 9)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price_Purchas = 0 ;
                    foreach ($item_price_Purchas as $itm) {
                        $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
                    }
                    $price_purchasing_order[] = $total_price_Purchas;
                } else if ($last_month == -4) {
                    $month[] = 8 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', 8)->whereYear('sdate', ($now ->year - 1))->get()->count();

                    $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', 8)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price = 0 ;
                    foreach ($item_price as $itm) {
                        $total_price += $itm->price_selling * $itm->qty ;
                    }
                    $price_selling_order[] = $total_price;

                    $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', 8)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price_Purchas = 0 ;
                    foreach ($item_price_Purchas as $itm) {
                        $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
                    }
                    $price_purchasing_order[] = $total_price_Purchas;
                } else if ($last_month == -5) {
                    $month[] = 7 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', 7)->whereYear('sdate', ($now ->year - 1))->get()->count();

                    $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', 7)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price = 0 ;
                    foreach ($item_price as $itm) {
                        $total_price += $itm->price_selling * $itm->qty ;
                    }
                    $price_selling_order[] = $total_price;

                    $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', 7)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price_Purchas = 0 ;
                    foreach ($item_price_Purchas as $itm) {
                        $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
                    }
                    $price_purchasing_order[] = $total_price_Purchas;
                } else if ($last_month == -6) {
                    $month[] = 6 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', 6)->whereYear('sdate', ($now ->year - 1))->get()->count();

                    $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', 6)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price = 0 ;
                    foreach ($item_price as $itm) {
                        $total_price += $itm->price_selling * $itm->qty ;
                    }
                    $price_selling_order[] = $total_price;

                    $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', 6)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price_Purchas = 0 ;
                    foreach ($item_price_Purchas as $itm) {
                        $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
                    }
                    $price_purchasing_order[] = $total_price_Purchas;
                } else if ($last_month == -7) {
                    $month[] = 5 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', 5)->whereYear('sdate', ($now ->year - 1))->get()->count();

                    $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', 5)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price = 0 ;
                    foreach ($item_price as $itm) {
                        $total_price += $itm->price_selling * $itm->qty ;
                    }
                    $price_selling_order[] = $total_price;

                    $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', 5)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price_Purchas = 0 ;
                    foreach ($item_price_Purchas as $itm) {
                        $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
                    }
                    $price_purchasing_order[] = $total_price_Purchas;
                } else if ($last_month == -8) {
                    $month[] = 4 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', 4)->whereYear('sdate', ($now ->year - 1))->get()->count();

                    $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', 4)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price = 0 ;
                    foreach ($item_price as $itm) {
                        $total_price += $itm->price_selling * $itm->qty ;
                    }
                    $price_selling_order[] = $total_price;

                    $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', 4)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price_Purchas = 0 ;
                    foreach ($item_price_Purchas as $itm) {
                        $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
                    }
                    $price_purchasing_order[] = $total_price_Purchas;
                } else if ($last_month == -9) {
                    $month[] = 3 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', 3)->whereYear('sdate', ($now ->year - 1))->get()->count();

                    $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', 3)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price = 0 ;
                    foreach ($item_price as $itm) {
                        $total_price += $itm->price_selling * $itm->qty ;
                    }
                    $price_selling_order[] = $total_price;

                    $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', 3)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price_Purchas = 0 ;
                    foreach ($item_price_Purchas as $itm) {
                        $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
                    }
                    $price_purchasing_order[] = $total_price_Purchas;
                } else if ($last_month == -10) {
                    $month[] = 2 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', 2)->whereYear('sdate', ($now ->year - 1))->get()->count();

                    $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', 2)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price = 0 ;
                    foreach ($item_price as $itm) {
                        $total_price += $itm->price_selling * $itm->qty ;
                    }
                    $price_selling_order[] = $total_price;

                    $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', 2)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price_Purchas = 0 ;
                    foreach ($item_price_Purchas as $itm) {
                        $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
                    }
                    $price_purchasing_order[] = $total_price_Purchas;
                } else if ($last_month == -11) {
                    $month[] = 1 ;
                    $year[] = $now ->year - 1 ;
                    $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', 1)->whereYear('sdate', ($now ->year - 1))->get()->count();

                    $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', 1)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price = 0 ;
                    foreach ($item_price as $itm) {
                        $total_price += $itm->price_selling * $itm->qty ;
                    }
                    $price_selling_order[] = $total_price;

                    $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', 1)->whereYear('sdate', ($now ->year - 1))->get();
                    $total_price_Purchas = 0 ;
                    foreach ($item_price_Purchas as $itm) {
                        $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
                    }
                    $price_purchasing_order[] = $total_price_Purchas;
                }
            } else {
                $month[] = $last_month ;
                $year[] = $now ->year ;
                $count_order[] = Order::where('itm_code', $request->id)->whereMonth('sdate', $last_month)->whereYear('sdate', $now ->year)->get()->count();
                
                $item_price = Order::select('price_selling','qty')->where('itm_code', $request->id)->whereMonth('sdate', $last_month)->whereYear('sdate', $now ->year)->get();
                $total_price = 0 ;
                foreach ($item_price as $itm) {
                    $total_price += $itm->price_selling * $itm->qty ;
                }
                $price_selling_order[] = $total_price;

                $item_price_Purchas = Purchas::select('price_purchasing','qty')->where('itm_code', $request->id)->whereMonth('sdate', $last_month)->whereYear('sdate', $now ->year)->get();
                $total_price_Purchas = 0 ;
                foreach ($item_price_Purchas as $itm) {
                    $total_price_Purchas += $itm->price_purchasing * $itm->qty ;
                }
                $price_purchasing_order[] = $total_price_Purchas;
            }
        }

        // dd($count_order);
        $count_order = array_reverse($count_order);
        $price_selling_order = array_reverse($price_selling_order);
        $price_purchasing_order = array_reverse($price_purchasing_order);
        $month_result = array(array_reverse($month)) ;


        $branchs = Branch::get();
        foreach ($branchs as $branch) {
            $stocks = Stock::join('branches', 'stocks.branch_id', '=', 'branches.id')->where('branch_id', $branch->id)->where('itm_code', $request->id)->with('Branch')->
            select( "branches.*", "qty", "qty_mid", "qty_sm" )->get();

            $stc_qty = 0 ; $stc_qty_mid = 0 ; $stc_qty_sm = 0 ;
            foreach ($stocks as $key => $stc) {
                $stc_qty += $stc->qty ;  
                $stc_qty_mid += $stc->qty_mid ;  
                $stc_qty_sm += $stc->qty_sm ;  
            }

            $total_stocks[] = array(
                "branch" => $branch->name,
                "qty" => $stc_qty,
                "qty_mid" => $stc_qty_mid,
                "qty_sm" => $stc_qty_sm
            );
            
        }

        $suppliers = Purchas::orderBy('created_at', 'desc')->where('itm_code', $request->id)->with('Supplier')->take(10)->get();

        // $suppliers = $suppliers->groupBy('supplier_id') ;

        $product = Post::with('Unit1')->with('Unit2')->with('Unit3')->where('itm_code', $request->id)->first();

        return view('admin.report.itemreport', compact('month_result','count_order','price_selling_order','price_purchasing_order','total_stocks','suppliers','product'));
    }
}
