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
                    <h1>{{$contact->title}}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$contact->title}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="contact-us-section pt-100 pb-70 bg-black">
        <div class="container">
            <div class="row">


                <div class="col-sm-12 col-md-12 col-lg-8 order-5 order-lg-0 pb-30">
                    <div class="comment-area">
                        <div class="sub-section-title">
                            <h3 class="color-white">اترك رسالتك</h3>
                            <p>بريدك الاليكترونى لن يتم استخدامه . برجاء ملئ الحقول</p>
                        </div>
                        <div class="comment-form mt-30">
                            <form action="{{url('sendMsg')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-20">
                                            <div class="input-group">
                                                <input type="text" name="name" id="name" class="form-control"
                                                       required="" data-error="ادخل الاسم" placeholder="الاسم*">
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-20">
                                            <div class="input-group">
                                                <input type="email" name="email" id="email" class="form-control"
                                                       required="" data-error="ادخل البريد الاليكترونى"
                                                       placeholder="البريد الاليكترونى*">
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-20">
                                            <div class="input-group">
                                                <input type="text" name="phone" id="phone_number" required=""
                                                       data-error="ادخل رقم جوالك" class="form-control"
                                                       placeholder="رقم الجوال*">
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group mb-20">
                                            <div class="input-group">
                                                <input type="text" name="subject" id="msg_subject" class="form-control"
                                                       required="" data-error="ادخل الموضوع" placeholder="الموضوع*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group mb-20">
                                            <div class="input-group">
                                                <textarea name="msg" class="form-control" id="message" rows="8"
                                                          placeholder="رسالتك*" data-error="ادخل الرسالة"
                                                          required=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="custom-control custom-checkbox mb-20">
                                            <input type="checkbox" class="custom-control-input" id="contact1" required>
                                            <label class="custom-control-label" for="contact1">اوافق على <a
                                                    href="terms-conditions.html">الشروط والاحكام</a> و <a
                                                    href="privacy-policy">سياسة الخصوصية</a></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <button class="btn full-width" type="submit">
                                            ارسال
                                        </button>
                                        <div id="msgSubmit"></div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 pb-30">
                    <div class="contact-item">
                        <div class="contact-item-title text-center">
                            <h3 class="color-white">{{$contact->title}}</h3>
                        </div>
                        <div class="contact-item-info">
                            <div class="contact-info-list">
                                <h3>العنوان</h3>
                                <p>{{$Settings->address}}</p>
                            </div>
                            <div class="contact-info-list">
                                <h3>البريد الاليكترونى</h3>
                                <p> {{$Settings->email1}} / {{$Settings->email2}}  </p>
                            </div>
                            <div class="contact-info-list">
                                <h3>ارقام الجوال</h3>
                                <p><a href="tel:{{$Settings->phone1}}">{{$Settings->phone1}}</a>
                                    / <a href="tel:{{$Settings->phone2}}">{{$Settings->phone2}}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="map-section p-tb-100 bg-black">
        <div class="container">
            <div class="google-map-content">
                <iframe src="https://maps.google.com/maps?q={{$contact->lat}}, {{$contact->lng}}&z=15&output=embed" width="360" height="270" frameborder="0" style="border:0"></iframe>

            </div>
        </div>
    </div>

@endsection
