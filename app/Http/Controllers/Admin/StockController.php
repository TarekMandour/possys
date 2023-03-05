<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Branch;
use App\Models\Stock;
use App\Models\Purchas;

class StockController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['branches'] = Branch::get();
        if (Auth::user()->type == 0) {
            $query['data'] = Stock::orderBy('branch_id', 'desc')->paginate(15);
        } else {
            $query['data'] = Stock::where('branch_id', Auth::user()->branch_id)->orderBy('branch_id', 'desc')->paginate(15);
        }
        return view('admin.stock.index', $query);
    }

    public function filter(Request $request)
    {

        $query['branches'] = Branch::get();

        $filter = Stock::orderBy('id', 'desc');
        if ($request->itm_code) {
            $filter->where('itm_code', $request->itm_code);
        }

        if ($request->qty) {
            if ($request->qty == -1) {
                $filter->where('qty', 0);
            } else {
                $filter->where('qty', $request->qty);
            }
        }

        if ($request->sdate && $request->to_date) {
            $filter->whereBetween(\DB::raw('DATE(expiry_date)'), array($request->sdate, $request->to_date));
        }
        if ($request->itm_name) {
            $product = Post::select('itm_code')->where('title_en', 'like' ,'%'.$request->itm_name.'%')->get();
            $filter->whereIn('itm_code', $product);
        }
        if (Auth::user()->type != 0) {
            $filter->where('branch_id', Auth::user()->branch_id);
        } else {
            if ($request->branch_id) {
                $filter->where('branch_id', $request->branch_id);
            }
        }
        $query['data'] = $filter->paginate(15)->withQueryString();
        return view('admin.stock.index', $query);

    }

    public function show($id)
    {
        $query['data'] = Stock::with('Category')->find($id);
        return view('admin.stock.show', $query);
    }

    public function barcode($id)
    {
        $query['data'] = Stock::findOrFail($id);
        return view('admin.stock.barcode', $query);
    }

    public function purchasbarcode($id)
    {
        $query['data'] = Purchas::where('order_id', $id)->get();
        return view('admin.stock.purchasbarcode', $query);
    }

    public function create()
    {
        $query['categories'] = Category::orderBy('id', 'desc')->get();
        $query['units'] = Unit::orderBy('id', 'desc')->get();
        return view('admin.stock.create', $query);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|string',
            'itm_code' => 'required|numeric|unique:stocks',
            'cat_id' => 'required|numeric',
            'itm_unit1' => 'required|numeric',
            'itm_unit2' => 'required|numeric',
            'itm_unit3' => 'required|numeric',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($img = $request->file('photo')) {
            $name = 'img_' . time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads/stocks'), $name);
            $photo = url('/') . '/public/uploads/stocks/' . $name;
        } else {
            $photo = NULL;
        }

        $data = new Stock;
        $data->title = $request->title;
        $data->title_en = $request->title_en;
        $data->content = $request->content;
        $data->cat_id = $request->cat_id;
        $data->is_show = $request->is_show;
        $data->itm_code = $request->itm_code;
        $data->itm_unit1 = $request->itm_unit1;
        $data->itm_unit2 = $request->itm_unit2;
        $data->itm_unit3 = $request->itm_unit3;
        $data->mid = $request->mid;
        $data->sm = $request->sm;
        $data->status = $request->status;
        $data->photo = $photo;

        try {
            $data->save();

            $stock = new Stock;
            $stock->qty = 0;
            $stock->price_purchasing = 0;
            $stock->price_selling = 0;
            $stock->price_minimum_sale = 1;
            $stock->production_date = null;
            $stock->expiry_date = null;
            $stock->itm_code = $data->itm_code;
            $stock->branch_id = 1;
            $stock->save();

        } catch (\Exception $e) {
            return response()->json(['msg' => 'Failed']);
        }

        return redirect('admin/products')->with('msg', 'تم بنجاح');
    }

    public function edit(Request $request)
    {

        $stock = Stock::find($request->id);
        $product = Post::where('itm_code', $request->itm_code)->first();

        return view('admin.stock.model', compact('product'), compact('stock'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'price_purchasing' => 'required',
            'price_selling' => 'required',
            'price_minimum_sale' => 'required'
        ]);

        $product = Post::where('itm_code', $request->itm_code)->first();

        $qty = $request->qty; $qty_mid = 0; $qty_sm = 0;
        
        if ($product->itm_unit1 != $product->itm_unit2) {
            $qty_mid = $request->qty * $product->mid;
        }

        if ($product->itm_unit2 != $product->itm_unit3) {
            $qty_sm = $request->qty * $product->mid * $product->sm;
        }

        $data = Stock::where('id', $request->id)->update([
            'price_purchasing' => $request->price_purchasing,
            'qty' => $qty,
            'qty_mid' => $qty_mid,
            'qty_sm' => $qty_sm,
            'price_selling' => $request->price_selling,
            'price_minimum_sale' => $request->price_minimum_sale,
            'production_date' => $request->production_date,
            'expiry_date' => $request->expiry_date
        ]);

        return redirect()->back()->with('msg', 'تم بنجاح');
    }

    public function delete(Request $request)
    {
        $stock = Stock::whereIn('id', $request->id)->get();
        foreach ($stock as $sto) {
            $products_stock = Stock::where('itm_code', $sto->itm_code)->get();

            if ($products_stock->count() > 1) {
                try {
                    Stock::where('id', $sto->id)->delete();
                } catch (\Exception $e) {
                    return response()->json(['msg' => 'Failed']);
                }
            } else {
                return response()->json(['msg' => 'Failed']);
            }
        }
        
        return response()->json(['msg' => 'Success']);
    }

    public function reviews($id)
    {
        $query['data'] = Stock::with('Reviews')->findOrFail($id);
        return view('admin.stock.reviews', $query);
    }

}
