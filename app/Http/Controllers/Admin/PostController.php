<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Models\Post;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Branch;
use App\Models\Stock;
use App\Models\Attribute;
use App\Models\PostAttribute;
use App\Models\PostAdditional;
use App\Jobs\ImportProduct;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Post::orderBy('id', 'desc')->with('Category')->paginate(15);
        return view('admin.post.index', $query);
    }

    public function filter(Request $request)
    {

        if (!$request->title && !$request->itm_code) {
            
            return redirect()->back()->with('error', 'يجب اختيار احد الحقول');
        }

        $post = Post::orderBy('id', 'desc')->with('Category');

        if ($request->itm_code) {
            $post = $post->where('itm_code', $request->itm_code);
        }

        if ($request->title) {
            $post = $post->where('title','like' ,'%'.$request->title.'%');
        }

        if ($request->title || $request->itm_code) {
            $query['data'] = $post->get();
        } else {
            $query['data'] = '';
        }

        return view('admin.post.fillter', $query);

    }

    public function show($id)
    {
        $query['data'] = Post::with('Category')->find($id);
        return view('admin.post.show', $query);
    }

    public function export() 
    {
        return Excel::download(new ProductsExport, 'Products.xlsx');
    }

    public function create()
    {
        $query['categories'] = Category::orderBy('id', 'desc')->get();
        $query['units'] = Unit::orderBy('id', 'desc')->get();
        return view('admin.post.create', $query);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|string',
            'itm_code' => 'required|numeric|unique:posts',
            'cat_id' => 'required|numeric',
            'itm_unit1' => 'required|numeric',
            'itm_unit2' => 'required|numeric',
            'itm_unit3' => 'required|numeric',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ], [
            'itm_code.unique' => 'كود المنتج مُستخدم من قبل',
        ]);

        if ($img = $request->file('photo')) {
            $name = 'img_' . time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads/posts'), $name);
            $photo = url('/') . '/public/uploads/posts/' . $name;
        } else {
            $photo = url('/') . '/public/adminAssets/ar/images/gallery/dummy.jpg';
        }

        $data = new Post;
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
        $data->is_tax = $request->is_tax;
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


            if(!empty($request->attribute)) {
                foreach ($request->attribute as $key=>$att){
                    if(!empty($att)){
                        PostAttribute::create([
                            'attribute_id'=>$att,
                            'attribute_name'=>Attribute::find($att)->title,
                            'attname'=>$request['attname'][$key],
                            'attprice'=>$request['attprice'][$key],
                            'itm_code'=>$data->itm_code
                        ]);
                    }
                }

            }

            if(!empty($request->addname)) {
                foreach ($request->addname as $key=>$add){
                    if(!empty($add)){
                        PostAdditional::create([
                            'addname'=>$add,
                            'addprice'=>$request['addprice'][$key],
                            'itm_code'=>$data->itm_code
                        ]);
                    }
                }
            }


        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return response()->json(['msg' => 'Failed']);
        }

        return redirect('admin/products')->with('msg', 'تم بنجاح');
    }

    public function import_products()
    {
        return view('admin.post.import_products');
    }

    public function import_products_store(Request $request)
    {
        $file = $request->file('import_file')->store('import');

        $import = new ProductsImport;
        $import->import($file);

        // importProduct::dispatch();

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return back()->withStatus('Import in queue, we will send notification after import finished.');

    }

    public function edit($id)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Post::with('attribute')->with('additional')->find($id);
        $query['categories'] = Category::orderBy('id', 'desc')->get();
        $query['units'] = Unit::orderBy('id', 'desc')->get();

        return view('admin.post.edit', $query);
    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|string',
            'itm_code' => 'required|numeric|unique:posts,itm_code,'.$request->id,
            'cat_id' => 'required|numeric',
            'itm_unit1' => 'required|numeric',
            'itm_unit2' => 'required|numeric',
            'itm_unit3' => 'required|numeric',
            'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
        ], [
            'itm_code.unique' => 'كود المنتج مُستخدم من قبل',
        ]);

        $row = Post::find($request->id);

        if ($img = $request->file('photo')) {
            $name = 'img_' . time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads/posts/'), $name);
            $photo = url('/') . '/public/uploads/posts/' . $name;
        } else {
            $photo = url('/') . '/public/adminAssets/ar/images/gallery/dummy.jpg';
        }

        $data = Post::where('id', $request->id)->update([
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
            'is_tax' => $request->is_tax,
            'photo' => $photo
        ]);

        if ($row->itm_code != $request->itm_code) {
            Stock::where('itm_code', $row->itm_code)->update([
            'itm_code' => $request->itm_code
            ]);
        }

        PostAttribute::where('itm_code',$request->itm_code)->delete();
        PostAdditional::where('itm_code',$request->itm_code)->delete();


        if(!empty($request->attribute)) {

            foreach ($request->attribute as $key=>$att){
                if(!empty($att)){
                    PostAttribute::create([
                        'attribute_id'=>$att,
                        'attribute_name'=>Attribute::find($att)->title,
                        'attname'=>$request['attname'][$key],
                        'attprice'=>$request['attprice'][$key],
                        'itm_code'=>$request->itm_code
                    ]);
                }
            }
    
        }

       if(!empty($request->addname)) {
        foreach ($request->addname as $key=>$add){
            if(!empty($add)){
                PostAdditional::create([
                    'addname'=>$add,
                    'addprice'=>$request['addprice'][$key],
                    'itm_code'=>$request->itm_code
                ]);
            }
        }
       }


        return redirect('admin/products')->with('msg', 'تم بنجاح');
    }

    public function delete(Request $request)
    {

        $row = Post::where('id', $request->id)->get()->first();

        try {
            Stock::where('itm_code', $row->itm_code)->delete();
            Post::whereIn('id', $request->id)->delete();

        } catch (\Exception $e) {
            return response()->json(['msg' => 'Failed']);
        }
        return response()->json(['msg' => 'Success']);
    }

    public function reviews($id)
    {
        $query['data'] = Post::with('Reviews')->findOrFail($id);
        return view('admin.post.reviews', $query);
    }

}
