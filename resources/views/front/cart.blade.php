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
                    <h1>العربة</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/home')}}">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> العربة</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>



    <section class="cart-section pt-100 pb-70 bg-black">
        <div class="container">
            <div class="cart-table cart-table-dark">
                <table>
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>المنتج</th>
                        <th>الخصائص</th>
                        <th>الاضافات</th>
                        <th>الكمية</th>
                        <th>الاجمالى</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @if(Session::get('cart'))

                        @foreach(Session::get('cart') as $key=> $cart_item)
                            @php
                                $total = $total + $cart_item['price'] * $cart_item['quantity'];
                            @endphp
                            <tr>
                                <td class="cancel"><a href="{{url('delete-cart/'.$key)}}"><i
                                            class='flaticon-cancel'></i></a></td>
                                <td>
                                    <div class="product-table-info">
                                        <div class="product-table-thumb">
                                            <img src="{{$cart_item['product']->photo}}" alt="product">
                                        </div>
                                    </div>
                                </td>
                                <td class="td-product-name">{{$cart_item['product']->title}}</td>
                                <td>
                                    @if($cart_item['attributes'])
                                        @foreach($cart_item['attributes'] as $attribute )
                                            <b> {{$attribute['name']}}</b> :  {{$attribute['option']}}
                                        @endforeach
                                    @endif
                                </td>
                                <td>

                                    @if(count($cart_item['additions']))
                                        @foreach($cart_item['additions'] as $addition )
                                            {{$addition['price']}}
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    {{$cart_item['quantity']}}
                                </td>
                                <td class="td-total-price">{{ $cart_item['quantity'] * $cart_item['price']}} ريال</td>
                            </tr>
                        @endforeach

                    @endif
                    </tbody>
                </table>
            </div>

            <div class="row">


                <div class="checkout-section pt-100 pb-70 bg-black">
                    <div class="container">
                        <form action="{{url('place-order')}}" method="post">
                            <div class="row">
                                <div class="col-sm-12 col-md-7 col-lg-7 pb-30">
                                    <div class="checkout-item">
                                        <div class="">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12">
                                                        <div class="form-group mb-20">
                                                            <div class="input-group">
                                                                <input type="text" name="client_name" class="form-control"
                                                                    required="" placeholder="الاسم*"
                                                                    @if(auth()->check()) value="{{auth()->user()->name}}" readonly @endif>
                                                                <input type="hidden" name="total_price" id="total_price" value="{{$total + $Settings->delivery_cost}}"
                                                                    class="form-control" required="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="form-group mb-20">
                                                            <div class="input-group">
                                                                <input type="text" name="client_phone" class="form-control"
                                                                    required=""
                                                                    placeholder="رقم الجوال*"
                                                                    @if(auth()->check()) value="{{auth()->user()->phone}}" readonly @endif>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="form-group mb-20">
                                                            <div class="input-group">
                                                                <input type="text" name="client_city" class="form-control"
                                                                    required="" placeholder="المدينة*">
                                                                <input type="hidden" name="client_state"
                                                                    class="form-control"
                                                                    required="" value="السعودية" placeholder="الدولة*">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group mb-20">
                                                            <div class="input-group">
                                                                <input type="text" name="client_address"
                                                                    class="form-control"
                                                                    required="" placeholder="العنوان بالتفصيل*">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <button type="submit" class="btn full-width">ارسل الطلب</button>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-5 col-lg-5 pb-30">
                                    <div class="checkout-item">

                                        

                                        <div class="checkout-details cart-details mb-30">
                                            <h3 class="cart-details-title color-white">تفاصيل الطلب</h3>
                                            <div class="cart-total-item">
                                                <h4>نوع الطلب :</h4>
                                                <div class="cart-total-checkarea">
                                                    <div class="cart-checkarea-item">
                                                        <div class="cart-check-box">
                                                            <input type="radio" name="type" id="cart1" value="delivery" checked>
                                                            <label for="cart1">دليفري</label>
                                                        </div>
                                                    </div>
                                                    <div class="cart-checkarea-item">
                                                        <div class="cart-check-box">
                                                            <input type="radio" name="type" value="take_away" id="cart2">
                                                            <label for="cart2">تيك اوي</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cart-total-item">
                                                <h4>وقت الطلبية :</h4>
                                                <div class="cart-total-checkarea">
                                                    <div class="col-sm-12">
                                                        <div class="form-group mb-20">
                                                            <div class="input-group" style="border: none;">
                                                                <input type="datetime-local" id="ordertime" name="ordertime" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cart-total-item">
                                                <h4>تكلفة التوصيل:</h4>
                                                <p id="delivery_cost">{{$Settings->delivery_cost}} ريال</p>
                                            </div>
                                            <input type="hidden" name="delivery_cost" id="delivery_price" value="{{$Settings->delivery_cost}}"
                                                                    class="form-control" required="">
                                            <div class="cart-total-box">
                                                <div class="cart-total-item cart-total-bold">
                                                    <h4 class="color-white"> الاجمالى </h4>
                                                    <p id="total_cost">{{$total + $Settings->delivery_cost}} ريال</p>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group mb-20">
                                                <div class="input-group input-group-textarea">
                                                    <textarea class="form-control" rows="5" name="more_notes" placeholder="ملاحظات اضافية"></textarea>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>




@endsection

@section('script')
    <script>
        var dt = new Date().toLocaleString('en-US', { timeZone: 'Asia/Karachi' });

        $('#ordertime').val(new Date(dt).toJSON().slice(0,16));

        $("#cart1, #cart2").change(function(){ 
            if( $(this).is(":checked") ){ 
                var val = $(this).val();
                if ( val == 'take_away') {
                    document.getElementById("delivery_cost").innerHTML = '0 ريال';
                    document.getElementById("total_cost").innerHTML = '{{$total}} ريال';
                    $('#total_price').val('{{$total}}') ;
                    $('#delivery_price').val(0) ;
                } else {
                    $('#delivery_price').val('{{$Settings->delivery_cost}}') ;
                    $('#total_price').val('{{$Settings->delivery_cost + $total}}') ;
                    document.getElementById("delivery_cost").innerHTML = '{{$Settings->delivery_cost}} ريال';
                    document.getElementById("total_cost").innerHTML = '{{$Settings->delivery_cost + $total}} ريال';
                }
            }
        });

    </script>
@endsection
