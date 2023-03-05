<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminLoginController extends Controller 
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.admin.login');
    }

    public function login(Request $request)
    {
        $messages = [
            'email' => 'Email tarek required!',
            'password' => 'Password mandour required!'
        ];
        
        // Validate form data
        $validates = $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ],[], $messages);

        $query = Admin::where('email', $request->email)->get();

        if (count($query) > 0) {
            if ($query[0]['is_active'] != 1) {
                session()->flash('msg', 'عفوا .. الحساب غير مفعل');
                return redirect()->back()->withInput($request->only('email','remember'));
            }

            // Attempt to log the user in
            if( Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1], $request->remember))
            {
                return redirect()->intended(route('admin.blank'));
            }
        } else {
            session()->flash('msg', 'لا يوجد حساب لهذا المستخدم');
            return redirect()->back()->withInput($request->only('email','remember'));
        }

        // if unsuccessful
        return redirect()->back()->withInput($request->only('email','remember'));
    }

    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
