<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Printer;

class PrinterController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Printer::orderBy('id','desc')->get();
        // $query['data'] = Printer::orderBy('id','desc')->paginate(10);

        return view('admin.printer.index',$query);
    }

    public function store(Request $request)
    {

        $this->validate(request(),[
            'title' => 'required|string',
            'ip' => 'required',
            'port' => 'required',
        ]);

        $data = new Printer;
        $data->title = $request->title;
        $data->ip = $request->ip;
        $data->port = $request->port;

        try {
            $data->save();
        } catch (Exception $e) {
            return redirect('admin/printer')->with('msg', 'Failed');
        }

        return redirect()->back()->with('msg', 'Success');
    }

    public function edit(Request $request)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Printer::find($request->id);
        $query['query'] = Printer::orderBy('id','desc')->get();

        return view('admin.printer.model', $query);
    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            'title' => 'required|string',
            'ip' => 'required',
            'port' => 'required',
        ]);

        $row = Printer::find($request->id);

        $data = Printer::where('id', $request->id)->update([
            'title' => $request->title,
            'ip' => $request->ip,
            'port' => $request->port,
        ]);

        return redirect()->back()->with('msg', 'Success');
    }

    public function delete(Request $request)
    {

        try{
            Printer::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg'=>'Failed']);
        }
        return response()->json(['msg'=>'Success']);
    }

}
