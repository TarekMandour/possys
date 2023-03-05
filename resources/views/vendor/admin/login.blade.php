@extends('admin.layouts.master-without-nav')

@section('content')
 <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
            <div class="card">
                <div class="card-body" dir="rtl">
                    <h3 class="text-center m-0">
                    <a href="/admin/login" class="logo logo-admin"><img src="{{ url('public/uploads/posts')}}/{{ $Settings->logo1 }}" height="100" alt="{{ $Settings->title }}"></a> 
                        
                    </h3>

                    <div class="p-3">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                            </div>
                        @endif
                        @if (session()->has('msg'))
                            <div class="alert alert-danger">
                                    {{session()->get('msg')}}
                            </div>
                        @endif
                        <form class="form-horizontal m-t-30" method="POST" action="{{ route('admin.login.submit') }}">

                            @csrf

                            <div class="form-group">
                                <label for="username">اسم المستخدم</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required id="username" placeholder="اسم المستخدم">
                            </div>

                            <div class="form-group">
                                <label for="userpassword">كلمة المرور</label>
                                <input type="password" class="form-control" name="password" required id="userpassword" placeholder="كلمة المرور">
                            </div>

                            <div class="form-group row m-t-20">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">تسجيل الدخول</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center">
                <p class="text-white">© {{date('Y')}} {{ $Settings->title }},<br> Crafted with <i class="mdi mdi-heart text-danger"></i> by Arabiacode.com</p>
            </div>

        </div>
@endsection

@section('script')

@endsection


