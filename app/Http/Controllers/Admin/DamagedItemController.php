<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DamagedItem;
use App\Models\Branch;
use App\Models\Post;
use Auth;

class DamagedItemController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['branches'] = Branch::get();
        $query['data'] = DamagedItem::orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('admin.damageditem.index', $query);
    }

    public function filter(Request $request)
    {

        $query['branches'] = Branch::get();

        $filter = DamagedItem::orderBy('id', 'desc');

        if ($request->sdate && $request->to_date) {
            $filter->whereBetween(\DB::raw('DATE(date)'), array($request->sdate, $request->to_date));
        }

        if (Auth::user()->type != 0) {
            $filter->where('branch_id', Auth::user()->branch_id);
        } else {
            if ($request->branch_id) {
                $filter->where('branch_id', $request->branch_id);
            }
        }
        $query['data'] = $filter->paginate(15)->withQueryString();
        return view('admin.damageditem.index', $query);

    }

    public function store(Request $request)
    {

        $this->validate(request(), [
            'itm_code' => 'required',
            'qty' => 'required',
            'date' => 'required'
        ]);

        $product = Post::where('itm_code', $request->itm_code)->first();
        $branch = Branch::find($request->branch_id);

        $data = new DamagedItem;
        $data->product = $product;
        $data->qty = $request->qty;
        $data->date = $request->date;
        $data->admin = Auth::user();
        $data->branch_id = $branch->id;
        $data->branch_name = $branch->name;

        try {
            $data->save();
        } catch (Exception $e) {
            return redirect('admin/damageditem')->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {

        try {
            DamagedItem::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg' => 'Failed']);
        }
        return response()->json(['msg' => 'Success']);
    }

}
