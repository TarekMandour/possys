@extends('front.layouts.master')
@section('content')






    <div class="header-bg header-bg-page">
        <div class="header-padding position-relative">
            <div class="header-page-shape">
                <div class="header-page-shape-item">
                    <img src="{{url('public/front')}}/images\header-shape-1.png" alt="shape">
                </div>
                <div class="header-page-shape-item">
                    <img src="{{url('public/front')}}/images\header-shape-2.png" alt="shape">
                </div>
                <div class="header-page-shape-item">
                    <img src="{{url('public/front')}}/images\header-shape-3.png" alt="shape">
                </div>
                <div class="header-page-shape-item">
                    <img src="{{url('public/front')}}/images\header-shape-1.png" alt="shape">
                </div>
                <div class="header-page-shape-item">
                    <img src="{{url('public/front')}}/images\header-shape-4.png" alt="shape">
                </div>
                <div class="header-page-shape-item">
                    <img src="{{url('public/front')}}/images\header-shape-1.png" alt="shape">
                </div>
                <div class="header-page-shape-item">
                    <img src="{{url('public/front')}}/images\header-shape-3.png" alt="shape">
                </div>

            </div>
            <div class="container">
                <div class="header-page-content">
                    <h1>طلباتى</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">طلباتى</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="account-page-section pt-100 pb-70 bg-black">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pb-30">
                    <div class="account-info">
                        <div class="my-order">
                            <div class="sub-section-title">
                                <h3 class="color-white">طلباتى</h3>
                            </div>
                            <div class="cart-table cart-table-dark mt-20">
                                <table>
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>المنتج</th>
                                        <th>رقم الطلب</th>
                                        <th>الكمية</th>
                                        <th>اجمالى</th>
                                        <th>حالة الطلب</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order_product as $product)
                                        <tr>
                                            <td>
                                                <div class="product-table-info">
                                                    <div class="product-table-thumb">
                                                        <img src="{{$product->product->photo}}" alt="product">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="td-product-name">{{$product->product->title}}</td>
                                            <td>{{$product->order_id}}</td>
                                            <td>
                                                {{$product->qty}}
                                            </td>
                                            <td>{{$product->price}} ريال</td>

                                            <td class="td-total-price">
                                                @if ($product->order->status == 'pending')
                                                    قيد الانتظار
                                                @elseif ($product->order->status == 'confirmed')
                                                    تم قبول الطلب
                                                @elseif ($product->order->status == 'processing')
                                                    جاري التجهيز
                                                @elseif ($product->order->status == 'out_for_delivery')
                                                    خرج مع المندوب
                                                @elseif ($product->order->status == 'delivered')
                                                    تم التوصيل
                                                @elseif ($product->order->status == 'returned')
                                                    ارجاع الطلب
                                                @elseif ($product->order->status == 'failed')
                                                    الغاء من العميل
                                                @elseif ($product->order->status == 'canceled')
                                                    الغاء من الادارة
                                                @else
                                                    -----
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
