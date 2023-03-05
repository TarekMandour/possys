<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:client');
    }

    public function index()
    {
        $query['data'] = Client::orderBy('id', 'desc')->get();
        return view('admin.client.index', $query);
    }

    public function show($id)
    {
        $query['data'] = Client::find($id);
        return view('admin.client.show', $query);
    }

    public function sales($id)
    {
        $query['client'] = Client::find($id);
        $wallet = Wallet::where('type', 'client')->where('walletable_id', $id);
        $query['in'] = $wallet->sum('in');
        $query['out'] = $wallet->sum('out');
        $query['total'] = $query['in'] - $query['out'];
        $query['data'] = $wallet->get();
        return view('admin.client.sales', $query);
    }

    public function create()
    {
        return view('admin.client.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'address' => 'nullable',
            'location' => 'nullable',
            'email' => 'nullable',
            'phone' => 'required|string|unique:clients',
            'profile' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($img = $request->file('profile')) {
            $name = 'img_' . time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $profile = $name;
        } else {
            $profile = NULL;
        }

        $data = Client::create([
            'name' => $request->name,
            'city' => $request->city,
            'address' => $request->address,
            'email' => $request->email,
            'location' => $request->location,
            'phone' => $request->phone,
            'password' => Hash::make($request->password1),
            'photo' => $profile,
            'is_active' => 1,
        ]);

        return redirect('admin/clients')->with('msg', 'تم بنجاح');
    }

    public function edit($id)
    {
        // $query['data'] = Client::where('id', $id)->get();
        $query['data'] = Client::find($id);
        return view('admin.client.edit', $query);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'address' => 'nullable',
            'location' => 'nullable',
            'email' => 'nullable',
            'phone' => 'required|string',
            'profile' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $row = Client::find($request->id);


        if ($img = $request->file('profile')) {
            $name = 'img_' . time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $profile = $name;
        } else {
            $profile = $row->photo;
        }

        $data = Client::where('id', $request->id)->update([
            'name' => $request->name,
            'city' => $request->city,
            'address' => $request->address,
            'email' => $request->email,
            'location' => $request->location,
            'phone' => $request->phone,
            'photo' => $profile,
            'is_active' => 1,
        ]);
        if ($request->password) {
            $password = Hash::make($request->password);
            $row->password = $password;
            $row->save();
        }

        return redirect('admin/clients')->with('msg', 'تم بنجاح');
    }

    public function delete(Request $request)
    {

        try {
            Client::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg' => 'Failed']);
        }
        return response()->json(['msg' => 'Success']);
    }
}
