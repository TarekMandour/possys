<div class="page-content-wrapper" dir="rtl">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @foreach($data as $order)
                                <div class="col-md-6 col-lg-4" style="background-color: #F5F5F5">

                                    <div class="product-list-box">
                                        <p> رقم الطلب :{{$order->id}}</p>
                                        <p>ملاحظات الطلب :{{$order->more_notes}}</p>
                                        <div class="detail">
                                            <h4 class="font-16">
                                                <a href="#" class="text-dark">موعد الطلب :   {{ Carbon\Carbon::parse($order->scheduled)->diffForHumans()}}
                                                </a>
                                            </h4>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <td><strong>#</strong></td>
                                                        <td class="text-center"><strong>اسم المنتج</strong></td>
                                                        <td class="text-center"><strong>الكمية</strong></td>
                                                        <td class="text-center"><strong>الخصائص</strong></td>
                                                        <td class="text-center"><strong>الاضافات</strong></td>
                                                        <td class="text-center"><strong>صورة المنتج</strong></td>

                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach ($order->OrderProduct as $key => $pro)
                                                        <tr>
                                                            <td>{{$key + 1}}</td>
                                                            <td class="text-center">{{$pro->name}}</td>
                                                            <td class="text-center">{{$pro->qty}}</td>
                                                            <td class="text-center">
                                                                @if($pro->attributes)
                                                                    @foreach($pro->attributes as $attribute )
                                                                        <b> {{$attribute->name}}</b>
                                                                        :  {{$attribute->option}}
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if($pro->additions)
                                                                    @foreach($pro->additions as $attribute )
                                                                        <b> {{$attribute->name}}</b>

                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td class="text-center"><img src="{{$pro->product->photo}}" height="50px" width="50px" alt=""></td>

                                                        </tr>

                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>


                                        </div>
                                        <div style="text-align: center">
                                            <button onclick="myFunction({{$order->id}}); this.disabled=true; this.value='Sending…'; "
                                                    class="btn btn-success btn-block">تم
                                                التجهيز
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- container -->
</div> <!-- Page content Wrapper -->

