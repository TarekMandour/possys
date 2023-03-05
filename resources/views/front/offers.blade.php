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
                    <h1>العروض الخاصة</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> العروض الخاصة</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>



    <section class="combo-section bg-black pt-100 pb-70">
        <div class="container">
            <div class="section-title">
                <small>{{$Settings->title}}</small>
                <h2 class="color-white">العروض الخاصه</h2>
            </div>
            <div class="row">
                @foreach($offers as $offer)
                    <div class="col-sm-12 col-md-6 col-lg-6 pb-30 wow animate__slideInUp" data-wow-duration="1s"
                         data-wow-delay="0.1s">
                        <div class="combo-box">
                            <div class="combo-box-image">
                                <img src="{{$offer->photo}}" alt="combo">
                            </div>
                            <div class="combo-box-content">
                                <h3>{{$offer->title}}</h3>
                                <h4>{!! $offer->content !!}</h4>
                                <a href="{{url('menu-item/'.$offer->id)}}" class="btn">
                                    اطلب الان
                                    <i class="flaticon-shopping-cart-black-shape"></i>
                                </a>
                            </div>
                            <div class="combo-offer-shape">
                                <div class="combo-shape-inner">
                                    <small>فقط بـ</small>
                                    <p>{{$offer->new_price_sell}}</p>
                                    <small>ريال</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>


@endsection
