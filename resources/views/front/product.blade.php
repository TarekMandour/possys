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
                    <h1>{{$product->title}}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$product->title}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="product-details-section pt-100 pb-70 bg-black">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-12 col-lg-5 pb-30">
                    <div class="product-details-item">
                        <div class="product-details-slider">
                            <div class="product-details-for popup-gallery">
                                <div class="product-for-item">
                                    <a href="{{$product->photo}}"><img src="{{$product->photo}}" alt="product"></a>
                                </div>
                                @if($product->photo2)
                                    <div class="product-for-item">
                                        <a href="{{$product->photo2}}"><img src="{{$product->photo2}}"
                                                                            alt="product"></a>
                                    </div>
                                @endif
                                @if($product->photo3)
                                    <div class="product-for-item">
                                        <a href="{{$product->photo3}}"><img src="{{$product->photo3}}"
                                                                            alt="product"></a>
                                    </div>
                                @endif
                            </div>
                            <div class="product-details-nav">
                                <div class="product-nav-item">
                                    <div class="product-nav-item-inner">
                                        <img src="{{$product->photo}}" alt="product">
                                    </div>
                                </div>
                                @if($product->photo2)
                                    <div class="product-nav-item">
                                        <div class="product-nav-item-inner">
                                            <img src="{{$product->photo2}}" alt="product">
                                        </div>
                                    </div>
                                @endif
                                @if($product->photo3)
                                    <div class="product-nav-item">
                                        <div class="product-nav-item-inner">
                                            <img src="{{$product->photo3}}" alt="product">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-6 pb-30">
                    <div class="product-details-item">
                        <div class="product-details-caption">
                            @if(\Carbon\Carbon::now()->subDays(7) < $product->created_at)
                                <div class="product-status product-status-danger mb-20">
                                    New
                                </div>
                            @endif
                            <h3 class="mb-20 color-white">{{$product->title}}</h3>

                            <div class="product-details-price mb-20">
                                @if($product->new_price_leasing > 0)
                                    <h4>
                                        {{$product->new_price_leasing}}ريال
                                        <del style="color: grey">{{$product->new_price_sell}}ريال</del>
                                    </h4>
                                @else
                                    <h4>
                                        {{$product->new_price_sell}}ريال
                                    </h4>
                                @endif
                            </div>
                            @if($Settings->website_type == "sell")
                                <form action="{{url('add-cart')}}" method="post">
                                    @csrf

                                    <input type="hidden" name="product_id" value="{{$product->id}}">

                                    <div class="row">
                                        @if($product->attributes)
                                            <div class="col-sm-12 col-md-6 mb-20">
                                                @php
                                                    $attrname = [];
                                                @endphp
                                                @foreach($product->attributes as $key => $att)
                                                    @if(!in_array($att->attribute_name , $attrname))
                                                        <h4 style="color: grey">{{$att->attribute_name}}:</h4>
                                                        @php
                                                            $i =1;
                                                            array_push($attrname ,$att->attribute_name )
                                                        @endphp
                                                    @else
                                                        @php
                                                            $i++
                                                        @endphp

                                                    @endif

                                                    {{--                                    <ul class="product-size-list">--}}

                                                    <div class="cart-check-box mb-10">
                                                        <input type="radio" name="attribute[{{$att->attribute_name}}][option]" value="{{$att->attribute_name}},{{$att->attribute_option}},{{$att->attribute_price}}" @if($i==1) checked @endif id="{{$att->attribute_name}}{{$key}}">
                                                        <label for="{{$att->attribute_name}}{{$key}}">
                                                            {{$att->attribute_option}}
                                                            (+{{$att->attribute_price}}ريال)
                                                        </label>
                                                        <input type="hidden" name="attribute[{{$att->attribute_name}}][name]"
                                                        value="{{$att->attribute_name}}">
                                                        <input type="hidden" name="attribute[{{$att->attribute_name}}][price]"
                                                        value="{{$att->attribute_price}}">
                                                    </div>
                                                    
                                                    {{--                                    </ul>--}}
                                                @endforeach
                                            </div>
                                        @endif

                                        @if($product->additions)
                                            <div class="col-sm-12 col-md-6 mb-20">
                                                <h4 style="color: grey">الاضافات :</h4>
                                                    @foreach($product->additions as $key => $att)

                                                    <div class="col-sm-12">
                                                        <div class="custom-control custom-checkbox mb-20">
                                                            <input type="checkbox" class="custom-control-input" name="additions[{{$att->addittion_name}}][name]" value="{{$att->addittion_name}}" id="{{$att->addittion_name}}{{$key}}">
                                                            <label class="custom-control-label" for="{{$att->addittion_name}}{{$key}}">
                                                                {{$att->addittion_name}}
                                                                (+{{$att->addittion_price}}ريال)
                                                            </label>
                                                        </div>
                                                        <input type="hidden" name="additions[{{$att->addittion_name}}][price]"
                                                        value="{{$att->addittion_price}}">
                                                    </div>

                                                    @endforeach
                                            </div>
                                        @endif

                                    </div>

                                    <div class="product-action-info mb-20">
                                        <div class="d-flex flex-wrap align-items-center
                                    product-quantity">
                                            <button class="btn btn-icon product-quantity-item" type="submit">
                                                اضف الى العربة
                                                <i class="flaticon-shopping-cart-black-shape"></i>
                                            </button>
                                            <div class="cart-quantity product-quantity-item">
                                                <a class="qu-btn dec">-</a>
                                                <input type="text" class="qu-input" value="1">
                                                <input type="hidden" name="quantity" id="qu-input" value="1">
                                                <a class="qu-btn inc">+</a>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <div class="product-details-tab below-border">
                <ul class="product-details-tab-list">
                </ul>
                <div class="product-tab-information">
                    <div class="product-tab-information-item active" data-product-details-tab="1">
                        <div class="product-description mb-30">
                            <p>{!! $product->content !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            @if($product->is_fav == 1)
                <div class="related-product mt-50">
                    <div class="sub-section-title">
                        <h3 class="color-white">منتجات ذات صلة</h3>
                    </div>
                    <div class="receipe-grid receipe-grid-three">
                        @foreach($related_products as $pro)
                            <div class="receipe-item receipe-item-black pb-30">
                                <div class="receipe-item-inner">
                                    <div class="receipe-image">
                                        <img src="{{$pro->photo}}" alt="receipe">
                                    </div>
                                    <div class="receipe-content">
                                        <div class="receipe-info">
                                            <h3><a href="{{url('menu-item/'.$pro->id)}}">{{$pro->title}}</a></h3>
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
                                            <div class="receipe-cart receipe-cart-main">
                                                <a data-id="{{$product->id}}" class="show-modal">
                                                    <i class="flaticon-supermarket-basket"></i>
                                                    <i class="flaticon-supermarket-basket"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

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
