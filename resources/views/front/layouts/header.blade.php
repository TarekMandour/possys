<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Fafo">
    <meta name="keywords" content="HTML,CSS,JavaScript">
    <meta name="author" content="HiBootstrap">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title>{{$Settings->title}}</title>
    <link rel="icon" href="{{ URL::asset('public/uploads/posts') }}/{{$Settings->fav}}" type="image/png" sizes="16x16">

    <link rel="stylesheet" href="{{url('public/front')}}\css\bootstrap-reboot.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="{{url('public/front')}}\css\bootstrap.rtl.min.css" type="text/css" media="all">

    <link rel="stylesheet" href="{{url('public/front')}}\css\animate.min.css" type="text/css" media="all">

    <link rel="stylesheet" href="{{url('public/front')}}\css\owl.carousel.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="{{url('public/front')}}\css\owl.theme.default.min.css" type="text/css" media="all">

    <link rel="stylesheet" href="{{url('public/front')}}\css\slick.css" type="text/css" media="all">
    <link rel="stylesheet" href="{{url('public/front')}}\css\slick-theme.css" type="text/css" media="all">

    <link rel="stylesheet" href="{{url('public/front')}}\css\jquery-ui.css" type="text/css" media="all">

    <link rel="stylesheet" href="{{url('public/front')}}\css\jquery.timepicker.min.css" type="text/css" media="all">

    <link rel="stylesheet" href="{{url('public/front')}}\css\meanmenu.min.css" type="text/css" media="all">

    <link rel="stylesheet" href="{{url('public/front')}}\css\magnific-popup.min.css" type="text/css" media="all">

    <link rel='stylesheet' href='{{url('public/front')}}\css\icofont.min.css' type="text/css" media="all">

    <link rel='stylesheet' href='{{url('public/front')}}\css\flaticon.css' type="text/css" media="all">

    <link rel='stylesheet' href='{{url('public/front')}}\css\settings.css' type="text/css" media="all">
    <link rel='stylesheet' href='{{url('public/front')}}\css\layers.css' type="text/css" media="all">
    <link rel='stylesheet' href='{{url('public/front')}}\css\navigation.css' type="text/css" media="all">

    <link rel='stylesheet' href='{{url('public/front')}}\css\jquery-jvectormap-2.0.5.css' type="text/css" media="all">

    <link rel="stylesheet" href="{{url('public/front')}}\css\style.css" type="text/css" media="all">

    <link rel="stylesheet" href="{{url('public/front')}}\css\responsive.css" type="text/css" media="all">

    <link rel="stylesheet" href="{{url('public/front')}}\css\rtl.css" type="text/css" media="all">

    <style>
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 99999; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #222;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .close {
            color: #fff;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #e7272d;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    @yield('style')
</head>

<body>

<div class="preloader bg-main">
    <div class="preloader-wrapper">
        <div class="preloader-grid">
            <div class="preloader-grid-item preloader-grid-item-1"></div>
            <div class="preloader-grid-item preloader-grid-item-2"></div>
            <div class="preloader-grid-item preloader-grid-item-3"></div>
            <div class="preloader-grid-item preloader-grid-item-4"></div>
            <div class="preloader-grid-item preloader-grid-item-5"></div>
            <div class="preloader-grid-item preloader-grid-item-6"></div>
            <div class="preloader-grid-item preloader-grid-item-7"></div>
            <div class="preloader-grid-item preloader-grid-item-8"></div>
            <div class="preloader-grid-item preloader-grid-item-9"></div>
        </div>
    </div>
</div>
@if(Request::segment(1) != "")
    <div class="topbar bg-main">
        <div class="container">
            <div class="topbar-inner">
                <div class="topbar-item topbar-padding d-none d-md-block d-lg-block">
                    <ul class="social-list social-list-white">
                        <li><a target="_blank" href="{{$Settings->facebook}}"><i class="flaticon-facebook"></i></a></li>
                        <li><a target="_blank" href="{{$Settings->twitter}}"><i class="flaticon-twitter"></i></a></li>
                        <li><a target="_blank" href="{{$Settings->linkedin}}"><i class="flaticon-linkedin"></i></a></li>
                        <li><a target="_blank" href="{{$Settings->youtube}}"><i class="flaticon-youtube"></i></a></li>
                        <li><a target="_blank" href="{{$Settings->instagram}}"><i class="flaticon-instagram-1"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="topbar-item d-none d-md-block d-lg-block">
                    <div
                        class="topbar-right d-flex flex-wrap topbar-right justify-content-center justify-content-md-start full-height">
                        <div class="topbar-right-item topbar-padding color-white">
                            <i class="flaticon-placeholder-1"></i>
                            {{$Settings->address}}
                        </div>
                        <div class="topbar-right-item topbar-padding color-white">
                            <i class="flaticon-smartphone-call"></i>
                            <a href="tel:{{$Settings->phone1}}" class="color-white">{{$Settings->phone1}}</a>
                        </div>
                    </div>
                </div>
                <div class="topbar-item d-block d-sm-none">
                    <div
                        class="topbar-right d-flex flex-wrap topbar-right justify-content-center justify-content-md-start full-height">
                        <a href="javascript:(void);" class="mobile-brand">
                            <img src="{{ URL::asset('public/uploads/posts') }}/{{$Settings->logo1}}" alt="logo"
                                 class="blue-logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <header>

        <div class="fixed-top">
            <div class="navbar-area navbar-dark">

                <div class="mobile-nav">
                    <div class="topbar-item d-block d-sm-none">
                        <ul class="social-list social-list-white">
                            <li><a href="{{$Settings->facebook}}"><i class="flaticon-facebook"></i></a></li>
                            <li><a href="{{$Settings->twitter}}"><i class="flaticon-twitter"></i></a></li>
                            <li><a href="{{$Settings->linkedin}}"><i class="flaticon-youtube"></i></a></li>
                            <li><a href="{{$Settings->youtube}}"><i class="flaticon-instagram-1"></i></a></li>
                        </ul>
                    </div>

                    <a href="javascript:(void);" class="mobile-brand d-none d-md-block d-lg-block">
                        <img src="{{ URL::asset('public/uploads/posts') }}/{{$Settings->logo1}}" alt="logo"
                             class="blue-logo">
                    </a>

                    <div class="navbar-option d-flex align-items-center">
                        <div class="navbar-option-item navbar-option-dots mobile-hide">
                            <button class="dropdown-toggle" type="button" id="mobileOptionDropdown"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="flaticon-menu-1"></i>
                            </button>
                            @if($Settings->website_type == "sell")
                                <div class="dropdown-menu" aria-labelledby="mobileOptionDropdown">
                                    <div class="navbar-option-item navbar-option-cart">
                                        <a href="#" class="productCart"><i class="flaticon-shopping-cart"></i></a>
                                        @if(Session::get('cart'))
                                            <span
                                                class="option-badge">{{count(\Illuminate\Support\Facades\Session::get('cart'))}}</span>
                                        @endif
                                    </div>
                                    <div class="navbar-option-item navbar-option-order">
                                        <a href="{{url('show-cart')}}" class="btn">
                                            <i class="flaticon-shopping-cart-black-shape"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if(!auth()->check())
                            <div class="navbar-option-item navbar-option-authentication">
                                <button class="navbar-authentication-button" type="button" id="auth2"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"><i class="flaticon-add-user"></i></button>
                                <div class="authentication-box dropdown-menu" aria-labelledby="auth2">
                                    <div class="authentication-close"><i class="flaticon-cancel"></i></div>
                                    <div class="authentication-body">
                                        <ul class="authentication-tab">
                                            <li class="authentication-tab-item active" data-authentication-tab="1">تسجيل
                                                الدخول
                                            </li>
                                            <li class="authentication-tab-item" data-authentication-tab="2">حساب جديد
                                            </li>
                                        </ul>
                                        <div class="authentication-details">
                                            <div class="authentication-details-item active"
                                                 data-authentication-details="1">
                                                <form action="{{route('client.login')}}" method="post">
                                                    @csrf
                                                    <div class="form-group mb-20">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                   name="phone" placeholder="رقم الجوال">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-20">
                                                        <div class="input-group">
                                                            <input type="password" class="form-control"
                                                                   name="password" placeholder="كلمة المرور">
                                                        </div>
                                                    </div>

                                                    <div class="authentication-btn">
                                                        <button class="btn full-width btn-border mb-20">تسجيل الدخول
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="authentication-details-item" data-authentication-details="2">
                                                <form action="{{route('client.register')}}" method="post">
                                                    @csrf
                                                    <div class="form-group mb-20">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                   name="name" placeholder="الاسم بالكامل">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-20">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                   name="phone" placeholder="رقم الجوال">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-20">
                                                        <div class="input-group">
                                                            <input type="password" class="form-control"
                                                                   name="password" placeholder="كلمة المرور">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-20">
                                                        <div class="input-group">
                                                            <input type="password" class="form-control"
                                                                   name="password_confirmation"
                                                                   placeholder="تأكيد كلمة المرور">
                                                        </div>
                                                    </div>

                                                    <div class="authentication-btn">
                                                        <button type="submit" class="btn full-width btn-border mb-20">
                                                            تسجيل
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif
                        @if($Settings->website_type == "sell")
                            <div class="navbar-option-item navbar-option-cart mobile-block">
                                <a href="#" class="productCart"><i class="flaticon-shopping-cart"></i></a>
                                @if(Session::get('cart'))
                                    <span
                                        class="option-badge">{{count(\Illuminate\Support\Facades\Session::get('cart'))}}</span>
                                @endif
                            </div>
                            <div class="navbar-option-item navbar-option-order mobile-block">
                                <a href="{{url('show-cart')}}" class="btn">
                                    <i class="flaticon-shopping-cart-black-shape"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="main-nav">
                    <div class="container">
                        <nav class="navbar navbar-expand-md navbar-light">
                            <a class="navbar-brand" href="javascript:(void);">
                                <img src="{{ URL::asset('public/uploads/posts') }}/{{$Settings->logo1}}" alt="logo"
                                     class="logo">
                            </a>

                            <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a href="{{url('home')}}"
                                           class="nav-link @if(Request::segment(1) == "home") active @endif ">الرئيسية</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('about')}}"
                                           class="nav-link @if(Request::segment(1) == "about") active @endif">نبذة
                                            عنا</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('menu')}}"
                                           class="nav-link @if(Request::segment(1) == "menu") active @endif ">قائمة
                                            المأكولات</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('offers')}}"
                                           class="nav-link @if(Request::segment(1) == "offers") active @endif ">العروض
                                            الخاصة</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{url('contact-us')}}"
                                           class="nav-link  @if(Request::segment(1) == "contact-us") active @endif">تواصل
                                            معنا</a>
                                    </li>
                                    @if(auth()->check())
                                        <li class="nav-item">
                                            <a href="{{url('my-orders')}}"
                                               class="nav-link  @if(Request::segment(1) == "my-orders") active @endif">طلباتى</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="navbar-option d-flex align-items-center">
                                @if(!auth()->check())
                                    <div class="navbar-option-item navbar-option-authentication">
                                        <button class="navbar-authentication-button" type="button" id="auth1"
                                                data-bs-toggle="dropdown" aria-haspopup="true"><i
                                                class="flaticon-add-user"></i>
                                        </button>
                                        <div class="authentication-box dropdown-menu" aria-labelledby="auth1">
                                            <div class="authentication-close"><i class="flaticon-cancel"></i></div>
                                            <div class="authentication-body">
                                                <ul class="authentication-tab">
                                                    <li class="authentication-tab-item active"
                                                        data-authentication-tab="1">
                                                        تسجيل
                                                        الدخول
                                                    </li>
                                                    <li class="authentication-tab-item" data-authentication-tab="2">حساب
                                                        جديد
                                                    </li>
                                                </ul>
                                                <div class="authentication-details">
                                                    <div class="authentication-details-item active"
                                                         data-authentication-details="1">
                                                        <form action="{{route('client.login')}}" method="post">
                                                            @csrf
                                                            <div class="form-group mb-20">
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control"
                                                                           name="phone" placeholder="رقم الجوال">
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-20">
                                                                <div class="input-group">
                                                                    <input type="password" class="form-control"
                                                                           name="password" placeholder="كلمة المرور">
                                                                </div>
                                                            </div>

                                                            <div class="authentication-btn">
                                                                <button type="submit"
                                                                        class="btn full-width btn-border mb-20">تسجيل
                                                                    الدخول
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="authentication-details-item"
                                                         data-authentication-details="2">
                                                        <form action="{{route('client.register')}}" method="post">
                                                            @csrf
                                                            <div class="form-group mb-20">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                           name="name" placeholder="الاسم بالكامل">
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-20">
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control"
                                                                           name="phone" placeholder="رقم الجوال">
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-20">
                                                                <div class="input-group">
                                                                    <input type="password" class="form-control"
                                                                           name="password" placeholder="كلمة المرور">
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-20">
                                                                <div class="input-group">
                                                                    <input type="password" class="form-control"
                                                                           name="password_confirmation"
                                                                           placeholder="تأكيد كلمة المرور">
                                                                </div>
                                                            </div>

                                                            <div class="authentication-btn">
                                                                <button type="submit"
                                                                        class="btn full-width btn-border mb-20">تسجيل
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($Settings->website_type == "sell")
                                    <div class="navbar-option-item navbar-option-cart">
                                        <a href="#" class="productCart"><i class="flaticon-shopping-cart"></i></a>
                                        @if(Session::get('cart'))
                                            <span
                                                class="option-badge">{{count(\Illuminate\Support\Facades\Session::get('cart'))}}</span>
                                        @endif
                                    </div>
                                    <div class="navbar-option-item navbar-option-order">
                                        <a href="{{url('show-cart')}}" class="btn text-nowrap">
                                            اطلب الان <i class="flaticon-shopping-cart-black-shape"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </header>
@endif
