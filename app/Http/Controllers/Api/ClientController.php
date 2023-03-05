<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\PageResource;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Client;
use App\Models\Page;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;


class ClientController extends Controller
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
            return $this->msgdata($request, 401, $validator->messages()->first(), (object)[]);
        }

        $token = Auth::guard('client')->attempt(['phone' => $request->username, 'password' => $request->password]);

        //return token
        if (!$token) {
            return $this->msgdata($request, 401, "رقم الهاتف او كلمة المرور خطأ", (object)[]);
        }
        $user = Auth::guard('client')->user();
        $user_data = Client::where('id', $user->id)->first();

        if ($user_data->is_active != 1) {
            return $this->msgdata($request, 401, "عفوآ هذا الحساب موقوف.", (object)[]);
        }
        $user_data->api_token = Str::random(60);
        $user_data->save();
        $data = new ClientResource($user_data);
        return $this->msgdata($request, 200, "تم الدخول بنجاح", $data);
    }

    public function profile(Request $request)
    {
        $api_token = $request->header('token');
        $user = $this->check_api_token_client($api_token);
        if (!$user) {
            return $this->msgdata($request, 403, "برجاء تسجيل الدخول", (object)[]);
        }
        $data = new ClientResource($user);
        return $this->msgdata($request, 200, "نجاح", $data);


    }


    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'city' => 'required|string',
            'password' => 'required',
            'address' => 'nullable',
            'location' => 'nullable',
            'email' => 'nullable|email|unique:clients',
            'phone' => 'required|string|unique:clients',
            'profile' => 'image|mimes:png,jpg,jpeg|max:2048'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->msgdata($request, 401, $validator->messages()->first(), (object)[]);
        }

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
            'password' => Hash::make($request->password),
            'photo' => $profile,
            'api_token' => Str::random(60),
            'is_active' => 1,
        ]);
        $data = new ClientResource($data);
        return $this->msgdata($request, 200, "تم التسجيل بنجاح", $data);

    }


    public function AllClients(Request $request)
    {
        $api_token = $request->header('token');
        $user = $this->check_api_token($api_token);
        if (!$user) {
            return $this->msgdata($request, 403, "برجاء تسجيل الدخول", (object)[]);
        }
        $data = ClientResource::collection(Client::all());
        return $this->msgdata($request, 200, "نجاح", $data);


    }


    public function Page(Request $request ,$id)
    {

        $data = new PageResource(Page::where('id',$id)->first());
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
}
