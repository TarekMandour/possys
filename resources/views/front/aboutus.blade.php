@extends('front.layouts.master')
@section('content')


    <div class="header-bg header-bg-page">
        <div class="header-padding position-relative">
            <div class="header-page-shape">
                <div class="header-page-shape-item">
                    <img src="{{url('/public')}}/front\images\header-shape-1.png" alt="shape">
                </div>
                <div class="header-page-shape-item">
                    <img src="{{url('/public')}}/front\images\header-shape-2.png" alt="shape">
                </div>
                <div class="header-page-shape-item">
                    <img src="{{url('/public')}}/front\images\header-shape-3.png" alt="shape">
                </div>
                <div class="header-page-shape-item">
                    <img src="{{url('/public')}}/front\images\header-shape-1.png" alt="shape">
                </div>
                <div class="header-page-shape-item">
                    <img src="{{url('/public')}}/front\images\header-shape-4.png" alt="shape">
                </div>
                <div class="header-page-shape-item">
                    <img src="{{url('/public')}}/front\images\header-shape-1.png" alt="shape">
                </div>
                <div class="header-page-shape-item">
                    <img src="{{url('/public')}}/front\images\header-shape-3.png" alt="shape">
                </div>
            </div>
            <div class="container">
                <div class="header-page-content">
                    <h1>{{$about->title}}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$about->title}}</li>
                        </ol>
                    </nav>
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

                        <p>{!! $about->content !!}</p>
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
    <section class="welcome-section bg-overlay-1 pt-100 pb-70 bg-black">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-5 col-lg-4 pb-30">
                    <div class="section-title section-title-left text-center text-md-start m-0">
                        <small>رؤيتنا</small>

                        <p>{!! $about->vision !!}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-4 pb-30">
                    <div class="section-title section-title-left text-center text-md-start m-0">
                        <small>مهمتنا</small>

                        <p>{!! $about->mission !!}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-4 pb-30">
                    <div class="section-title section-title-left text-center text-md-start m-0">
                        <small>لماذا نحن؟</small>

                        <p>{!! $about->whywedo !!}</p>
                    </div>
                </div>

            </div>
        </div>
    </section>




@endsection
