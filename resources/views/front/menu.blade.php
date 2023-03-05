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
                    <h1>قائمة المأكولات</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">قائمة المأكولات</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>



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
