<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function Home()
    {

        $sliders = Slider::orderBy('sort', 'asc')->get();
        $about = Page::findOrFail(1)->first();
        $categories = Category::orderBy('id', 'asc')->get();
        $products = Post::where('is_fav', 1)->where('branch_id', Session::get('branch_id'))->orderBy('cat_id', 'asc')->get();
        $offers = Post::where('is_fav', 0)->where('branch_id', Session::get('branch_id'))->orderBy('cat_id', 'asc')->get();

        return view('front.home', compact('sliders', 'categories', 'products', 'offers', 'about'));
    }

    public function AboutUs()
    {

        $about = Page::findOrFail(1);
        return view('front.aboutus', compact('about'));

    }


    public function Menu()
    {

        $categories = Category::orderBy('id', 'asc')->get();
        $products = Post::where('is_fav', 1)->where('branch_id', Session::get('branch_id'))->orderBy('cat_id', 'asc')->get();

        return view('front.menu', compact('categories', 'products'));
    }

    public function Offer()
    {


        $offers = Post::where('is_fav', 0)->where('branch_id', Session::get('branch_id'))->orderBy('cat_id', 'asc')->get();

        return view('front.offers', compact('offers'));
    }
}
