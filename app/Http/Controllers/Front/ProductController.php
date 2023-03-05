<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Page;
use App\Models\Post;
use App\Models\Slider;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function Home($id)
    {
        $product = Post::findOrFail($id);
        $related_products = Post::where('cat_id', $product->cat_id)->where('is_fav', 1)->where('branch_id', Session::get('branch_id'))->get();
        $related_offers = Post::where('cat_id', $product->cat_id)->where('is_fav', 0)->where('branch_id', Session::get('branch_id'))->get();
        return view('front.product', compact('product', 'related_products'));
    }

    public function Product(Request $request)
    {
        $product = Post::findOrFail($request->id);
        return view('front.layouts.modal', compact('product'));
    }

    public function AddCart(Request $request)
    {

        $cart = Session::get('cart');
        $product = Post::find($request->product_id);
        if ($product->new_price_leasing > 0) {
            $price = $product->new_price_leasing;
        } else {
            $price = $product->new_price_sell;
        }
        $attributes = [];

        if ($request->attribute) {
            foreach ($request->attribute as $key => $attribute) {
                $attribute_value = explode(',', $attribute['option']);
                $attribute['option'] = $attribute_value[1];
                array_push($attributes, $attribute);
                $price =  $attribute_value[2];

            }
        }
        $additions = [];
        if ($request->additions) {
            foreach ($request->additions as $key => $addition) {

                if (array_key_exists("name", $addition)) {
                    array_push($additions, $addition);
                    $price = $price + $addition['price'];
                }
            }
        }

        $c_r = [
            'attributes' => $attributes,
            'additions' => $additions,
            'price' => $price,
            'product' => $product,
            'quantity' => $request->quantity
        ];

        $cart[] = $c_r;
        Session::put('cart', $cart);
        return redirect()->back();
    }

    public function ShowCart()
    {
//        dd(Session::get('cart'));
        return view('front.cart');
    }

    public function DeleteCart($id)
    {
        $cart = Session::get('cart');
        unset($cart[$id]);//remove second element, do not re-index array
        Session::forget('cart');
        Session::put('cart', $cart);
        return redirect()->back();
    }

    public function placeOrder(Request $request)
    {
        $data = $this->validate($request, [
            'client_name' => 'required',
            'client_phone' => 'required',
            'client_email' => '',
            'client_state' => '',
            'client_city' => 'required',
            'client_address' => 'required',
            'total_price' => 'required',
        ]);


        $cart = Session::get('cart');

        if ($cart) {
            if (Auth::check()) {
                $data['client_id'] = Auth::user()->id;
            }

            $branch = Branch::find(Session::get('branch_id'));
            $data['branch_id'] = $branch->id;
            $data['branch_name'] = $branch->name;
            $data['more_notes'] = $request->more_notes;
            $data['type'] = $request->type;
            $data['scheduled'] = $request->ordertime;
            $data['delivery_cost'] = $request->delivery_cost;
            $data['order_by'] = 0;
            $data['status_pay'] = 'unpaid';

            $order = Order::create($data);
            foreach ($cart as $cart_item) {
                $order_product = new OrderProduct();
                $order_product->order_id = $order->id;
                $order_product->pro_id = $cart_item['product']->id;
                $order_product->name = $cart_item['product']->title;
                $order_product->category = $cart_item['product']->cat_id;
                $order_product->qty = $cart_item['quantity'];
                $order_product->price = $cart_item['price'] * $cart_item['quantity'];
                $order_product->attributes = json_encode($cart_item['attributes']);
                $order_product->additions = json_encode($cart_item['additions']);

                $order_product->save();
                Session::forget('cart');


            }
            return redirect('home');
        } else {
            return redirect()->back();
        }

    }

    public function MyOrders()
    {
        if (Auth::check()) {
            $order_product = OrderProduct::whereHas('order', function ($q) {
                $q->where('client_id', Auth::user()->id);
            })->orderBy('order_id', 'desc')->get();


            return view('front.myorders', compact('order_product'));
        } else {
            return redirect(url('/home'));
        }

    }
}
