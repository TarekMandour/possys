@extends('admin.layouts.master') 

@section('css')
@endsection

@section('breadcrumb')
<h3 class="page-title">الرئيسية</h1>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div style="text-align: center;margin-top: 50px;">
                <img src="{{ url('public/uploads/posts')}}/{{ $Settings->logo2 }}" height="100" alt="{{ $Settings->title }}">
                <h2></h2>
            </div>
        </div><!-- container -->
    </div> <!-- Page content Wrapper -->
@endsection

@section('script')

@endsection

