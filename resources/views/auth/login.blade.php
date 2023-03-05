{{--@extends('front.layouts.master')--}}

{{--@section('keywords')--}}
{{--@if(empty($data->meta_keywords) || $data->meta_keywords == NULL )--}}
{{--<meta name="keywords" content="{{$Settings->meta_keywords}}" />--}}
{{--<meta name="description" content="{{$Settings->meta_description}}" />--}}
{{--@else--}}
{{--<meta name="keywords" content="{{$data->meta_keywords}}" />--}}
{{--<meta name="description" content="{{$data->meta_description}}" />--}}
{{--@endif--}}
{{--@endsection--}}

{{--@section('css')--}}
{{--@endsection--}}

{{--@section('breadcrumb')--}}
{{--<!-- breadcrumbs-area-start -->--}}
{{--<div class="breadcrumbs-area mb-70">--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-12">--}}
{{--                <div class="breadcrumbs-menu">--}}
{{--                    <ul>--}}
{{--                        <li><a href="{{ url('/') }}">Home</a></li>--}}
{{--                        <li><a href="javascript:void()" class="active">Login</a></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<!-- breadcrumbs-area-end -->--}}
{{--@endsection--}}

{{--@section('content')--}}

{{--<!-- user-login-area-start -->--}}
{{--<div class="user-login-area mb-70">--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-12">--}}
{{--                <div class="login-title text-center mb-30">--}}
{{--                    <h2>Login</h2>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="offset-lg-3 col-lg-6 col-md-12 col-12">--}}
{{--                @if ($errors->any())--}}
{{--                    <div class="alert alert-danger">--}}
{{--                            @foreach ($errors->all() as $error)--}}
{{--                                <p>{{ $error }}</p>--}}
{{--                            @endforeach--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                @if (session()->has('msg'))--}}
{{--                    <div class="alert alert-danger">--}}
{{--                            {{session()->get('msg')}}--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--                <form class="form-horizontal m-t-30" method="POST" action="">--}}
{{--                    @csrf--}}
{{--                    <div class="login-form">--}}
{{--                        <div class="single-login">--}}
{{--                            <label>Email<span>*</span></label>--}}
{{--                            <input type="text" name="email" value="{{ old('email') }}" required id="username" />--}}
{{--                        </div>--}}
{{--                        <div class="single-login">--}}
{{--                            <label>Passwords <span>*</span></label>--}}
{{--                            <input type="text" name="password" required id="userpassword"/>--}}
{{--                        </div>--}}
{{--                        <div class="single-login single-login-2">--}}
{{--                            <button class="btn btn-danger" type="submit">login</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<!-- user-login-area-end -->--}}

{{--@endsection--}}

{{--@section('script')--}}

{{--@endsection--}}
