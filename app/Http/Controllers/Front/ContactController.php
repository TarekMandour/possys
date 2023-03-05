<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Post;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    public function index(){
        $contact = Page::findOrFail(2);
        return view('front.contactus',compact('contact'));
    }


    public function SendMessage(Request $request){

       $data =  $this->validate($request,[
            'name' => 'required|string',
            'email' => 'string|email',
            'phone' => 'required',
            'subject' => 'required|string',
            'msg' => 'required|string',
        ]);

        Contact::create($data);


        return redirect(url('contact-us'));
    }

}
