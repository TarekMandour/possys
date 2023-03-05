@extends('front.layouts.master')
@section('content')
    <div class="header-bg">
        <div class="container-fluid">
            <div class="header-container position-relative p-tb-100">
                <div class="header-page-shape">
                    <div class="header-page-shape-item wow animate__rollIn" data-wow-duration="1s"
                         data-wow-delay="0.5s">
                        <img src="{{url('public/front')}}/images/header-shape-1.png" alt="shape">
                    </div>
                    <div class="header-page-shape-item wow animate__slideInDown" data-wow-duration="1s"
                         data-wow-delay="0.5s">
                        <img src="{{url('public/front')}}/images/header-shape-2.png" alt="shape">
                    </div>
                    <div class="header-page-shape-item wow animate__slideInRight" data-wow-duration="1.5s"
                         data-wow-delay="0.5s">
                        <img src="{{url('public/front')}}/images/header-shape-3.png" alt="shape">
                    </div>
                    <div class="header-page-shape-item wow animate__rollIn" data-wow-duration="1s"
                         data-wow-delay="0.5s">
                        <img src="{{url('public/front')}}/images/header-shape-1.png" alt="shape">
                    </div>
                    <div class="header-page-shape-item wow animate__slideInUp" data-wow-duration="1s"
                         data-wow-delay="0.5s">
                        <img src="{{url('public/front')}}/images/header-shape-4.png" alt="shape">
                    </div>
                    <div class="header-page-shape-item wow animate__rollIn" data-wow-duration="1s"
                         data-wow-delay="0.5s">
                        <img src="{{url('public/front')}}/images/header-shape-1.png" alt="shape">
                    </div>
                    <div class="header-page-shape-item wow animate__slideInUp" data-wow-duration="1s"
                         data-wow-delay="0.5s">
                        <img src="{{url('public/front')}}/images/header-shape-3.png" alt="shape">
                    </div>

                </div>

                <div class="header-carousel owl-carousel owl-theme">
                    @foreach($sliders as $slider)
                        <div class="item">
                            <div class="row align-items-center">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="header-carousel-text max-555 mx-auto me-lg-0 text-center text-lg-start">
                                        <h1 class="color-white">{{$slider->title1}}</h1>
                                        <p>{{$slider->title2}}</p>
                                        @if($slider->Product)
                                            <div class="header-carousel-action">
                                                {{--                                                product-details --}}
                                                <a href="{{url('menu-item/'.$slider->Product->id)}}" class="btn">اطلب الآن
                                                    <i class="flaticon-shopping-cart-black-shape"></i>
                                                </a>
                                                @if($slider->Product->new_price_leasing > 0)
                                                    <p class="header-product-price color-white">
                                                        ${{$slider->Product->new_price_leasing}}
                                                        <del>${{$slider->Product->new_price_sell}}</del>
                                                    </p>
                                                @else
                                                    <p class="header-product-price color-white">
                                                        ${{$slider->Product->new_price_sell}}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="header-carousel-image wow animate__zoomIn" data-wow-duration="1s"
                                         data-wow-delay="0.5s">
                                        <img src="{{$slider->photo}}" height="750px" alt="header">
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <section class="welcome-section bg-overlay-1 pt-100 pb-70 bg-black">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-5 col-lg-5 pb-30">
                    <div class="section-title section-title-left text-center text-md-start m-0">
                        <small>{{$about->title}}</small>
                        <h2 class="color-white">{{$Settings->title}}</h2>
                        <p>{!! $about->content !!}</p>
                        <a href="{{url('about')}}" class="btn">
                            شاهد المزيد
                            <i class="flaticon-right-arrow-sketch-1"></i>
                        </a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 col-lg-7">
                    <div class="about-image-grid">
                        <div class="about-image-grid-item">
                            <div class="about-image-grid-inner mb-30">
                                <img src="{{ URL::asset('public/uploads/') }}/{{$about->photo}}" alt="welcome">
                            </div>
                            <div class="about-image-grid-inner mb-30">
                                <img src="{{ URL::asset('public/uploads/') }}/{{$about->photo2}}" alt="welcome">
                            </div>
                        </div>
                        <div class="about-image-grid-item">
                            <div class="about-image-grid-inner fluid-height">
                                <img src="{{ URL::asset('public/uploads/') }}/{{$about->photo3}}" alt="welcome">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="menu-section bg-black p-tb-100">
        <div class="container position-relative">
            <div class="section-title">
                <small>{{$Settings->title}}</small>
                <h2 class="color-white">قائمة المأكولات</h2>
            </div>
            <div class="menu-main-carousel-area">
                <div class="menu-main-thumb-nav">
                    @foreach($categories as $category)
                        <div class="menu-main-thumb-item">
                            <div class="menu-main-thumb-inner">
                                <img src="{{$category->photo}}" alt="{{$category->title}}">
                                <p>{{$category->title}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="menu-main-details-for">
                    @foreach($categories as $category)
                        <div class="menu-main-details-item">
                            <div class="receipe-grid receipe-grid-three">
                                @foreach($products->where('cat_id',$category->id) as $key => $product)

                                    <div class="receipe-item receipe-item-black pb-30 receipe-grid-item">
                                        <div class="receipe-item-inner">
                                            <div class="receipe-image">
                                                <img src="{{$product->photo}}" alt="receipe">
                                            </div>
                                            <div class="receipe-content">
                                                <div class="receipe-info">
                                                    <h3>
                                                        <a href="{{url('menu-item/'.$product->id)}}">{{$product->title}}</a>
                                                    </h3>
                                                    @if($product->new_price_leasing > 0)
                                                        <h4>
                                                            {{$product->new_price_leasing}}ريال
                                                            <del>{{$product->new_price_sell}}ريال</del>
                                                        </h4>
                                                    @else
                                                        <h4>
                                                            {{$product->new_price_sell}}ريال
                                                        </h4>
                                                    @endif

                                                </div>
                                                @if($Settings->website_type == "sell")
                                                    <div class="receipe-cart">
                                                        <a data-id="{{$product->id}}" class="show-modal">
                                                            <i class="flaticon-shopping-cart"></i>
                                                            <i class="flaticon-shopping-cart"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                            @if($products->where('cat_id',$category->id)->count() > 9)
                                <div class="text-center">
                                    <a href="pro" class="btn load-more-btn">
                                        <span class="load-more-text">عرض المزيد</span>
                                        <span class="load-more-icon"><i class="icofont-refresh"></i></span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </section>

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

    <section class="subscribe-section mural-bg pt-100 pb-70 bg-main">
        <div class="container">
            <div class="subscribe-grid">
                <div class="subscribe-item">
                    <div class="section-title text-center text-lg-start m-0">
                        <h2 class="color-white">اشترك في القائمة البريدية</h2>
                        <p>اشترك معنا الان ، في القائمة البريدية ليصل جديد عروضنا</p>
                    </div>
                </div>
                <div class="subscribe-item">
                    <div class="subscribe-form">
                        <form class="newsletter-form newsletter-form-white" data-bs-toggle="validator">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="email" id="emails" class="form-control"
                                           placeholder="ادخل البريد الالكتروني" name="EMAIL" required=""
                                           autocomplete="off">
                                </div>
                                <button class="btn btn-yellow" type="submit">اشترك الان <i
                                        class="flaticon-right-arrow-sketch-1"></i></button>
                            </div>
                            <div id="validator-newsletter" class="form-result color-white"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>




@endsection
@section('script')
    <script>
        $(".show-modal").click(function () {
            var id = $(this).data('id')
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "GET",
                url: "{{url('product-modal')}}",
                data: {"id": id},
                success: function (data) {
                    $(".cartmodal .modal-body").html(data)
                    $(".cartmodal").modal('show')

                }
            })
        })
    </script>
@endsection
