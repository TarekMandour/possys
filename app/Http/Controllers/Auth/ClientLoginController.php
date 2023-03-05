<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;

class ClientLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:client')->except('logout');
    }

    public function showLoginForm()
    {
        return view(' front.user.login');
    }

    public function login(Request $request)
    {
        $messages = [
            'email' => 'Email required!',
            'password' => 'Password required!'
        ];
        
        // Validate form data
        $validates = $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ],[], $messages);

        $query = Client::where('email', $request->email)->get();

        if (count($query) > 0) {
            if ($query[0]['is_active'] != 1) {
                session()->flash('msg', 'عفوا .. الحساب غير مفعل');
                return redirect()->back()->withInput($request->only('email','remember'));
            }

            // Attempt to log the user in
            if( Auth::guard('client')->attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1], $request->remember))
            {
                return redirect()->intended(route('client.blank'));
            }
        } else {
            session()->flash('msg', 'لا يوجد حساب لهذا المستخدم');
            return redirect()->back()->withInput($request->only('email','remember'));
        }

        // if unsuccessful
        return redirect()->back()->withInput($request->only('email','remember'));
    }

    public function logout(Request $request) {
        Auth::guard('client')->logout();
        return redirect('admin/login');
    }
}
