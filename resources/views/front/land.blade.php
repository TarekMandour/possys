@extends('front.layouts.master')
@section('content')
    <section class="coming-soon-section" style="background-image: url('{{ URL::asset('public/uploads/posts') }}/{{$Settings->background}}')">
        <div class="container">
            <div class="coming-soon-content">

                <div class="coming-soon-logo">
                    <a href="/"><img src="{{ URL::asset('public/uploads/posts') }}/{{$Settings->logo1}}" alt="logo"></a>
                </div>
                <h1>نتمنى لكم مذاقا شهيا</h1>
                <div class="subscribe-form">
                    <form class=" newsletter-form-white" action="{{url('select-branch')}}" method="post"
                          data-bs-toggle="validator">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <select class="form-control"   name="branch_id" style="width: 175px" required>
                                    <option value="">اختر الفرع من هنا</option>
                                    @foreach($branchs as $branch)
                                        <option value="{{$branch->id}}">{{$branch->name}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-yellow" type="submit">اختر
                                <i class="flaticon-right-arrow-sketch-1"></i></button>
                        </div>
{{--                        <div id="validator-newsletter" class="form-result color-white"></div>--}}
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
