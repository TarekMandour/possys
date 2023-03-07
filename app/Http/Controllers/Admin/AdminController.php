<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $query['data'] = Admin::orderBy('id', 'desc')->get();
        // $query['data'] = Admin::orderBy('id','desc')->paginate(10);

        return view('admin.admin.index', $query);
    }

    public function show($id)
    {
        $query['data'] = Admin::find($id);
        return view('admin.admin.show', $query);
    }

    public function create()
    {
        return view('admin.admin.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'type' => 'required',
            'email' => 'string|email|unique:admins',
            'phone' => 'required|string|unique:admins',
            'profile' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($img = $request->file('profile')) {
            $name = 'img_' . time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $profile = $name;
        } else {
            $profile = NULL;
        }

        if ($request->type != 0) {
            if (!$request->branch_id || $request->branch_id == null) {
                return redirect()->back()->withInput()->with('error', 'الفرع مطلوب');
            }
        }

            if (strlen($request->password1) < 6) {
                return redirect()->back()->withInput()->with('error', 'عفوا كلمة المرور اقل من 6 احرف');
            } else {
                $password = Hash::make($request->password1);
            }

            if ($request->password1 != $request->password2) {
                return redirect()->back()->withInput()->with('error', 'عفوا تاكيد كلمة المرور خطأ');
            }


        $data = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'photo' => $profile,
            'is_active' => $request->is_active,
        ]);

        $data->type = $request->type;
        if ($request->type != 0) {
            $data->branch_id = $request->branch_id;
        }
        $data->save();

        return redirect('admin/admins')->with('msg', 'تم بنجاح');
    }

    public function edit($id)
    {
        // $query['data'] = Admin::where('id', $id)->get();
        $query['data'] = Admin::find($id);
        return view('admin.admin.edit', $query);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'phone' => 'required|string',
            'profile' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $row = Admin::find($request->id);

        if ($request->password) {
            if (strlen($request->password) < 6) {
                return redirect()->back()->with('error', 'عفوا كلمة المرور اقل من 6 احرف');
            }
            $password = Hash::make($request->password);
        } else {
            $password = $row->password;
        }

        if ($img = $request->file('profile')) {
            $name = 'img_' . time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads'), $name);
            $profile = $name;
        } else {
            $profile = $row->photo;
        }

        $data = Admin::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'photo' => $profile,
            'is_active' => $request->is_active,
        ]);

        $row->type = $request->type;
        if ($request->type != 0) {
            $row->branch_id = $request->branch_id;
        }
        $row->save();
        return redirect('admin/admins')->with('msg', 'تم بنجاح');
    }

    public function delete(Request $request)
    {

        try {
            Admin::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['msg' => 'Failed']);
        }
        return response()->json(['msg' => 'Success']);
    }

}
