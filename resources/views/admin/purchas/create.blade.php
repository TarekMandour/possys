@extends('admin.layouts.master')

@section('css')
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/alertify/css/alertify.css') }}" rel="stylesheet" type="text/css">
    <style>
        .product-list-box {
            padding: 0px !important;
            margin-bottom: 10px !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <h1 class="page-title">فاتورة مشتريات</h1>
@endsection

@section('content')


    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">

            @if (session()->has('msg'))
                <div class="alert alert-success">
                    {{session()->get('msg')}}
                </div>
            @endif


            <div id="alert">

            </div>


            <form action="{{ route('admin.purchase.submit') }}" method="post" enctype="multipart/form-data">

                @csrf
                <div class="card m-b-20">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <input class="form-control" name="itm_code" type="text" value="" id="itm_code"
                                       placeholder="كود الصنف">
                            </div>
                            <div class="col-sm-3">
                                <input class="form-control" name="name" type="text"
                                       value="" onkeydown="itmnameFinder()"
                                       placeholder="اسم الصنف" id="itm_name">
                                       <div id="bgsearch" style="height: 300px;overflow: hidden;overflow-y: auto;position: absolute;z-index: 99999999999;padding: 0px 0px;display:none;">
                                            <ul class="list-unstyled" id="inputitmname" style="padding-right: 0px;">
                                            </ul>
                                       </div>
                                       

                            </div>
                            <div class="col-sm-2">
                                <input class="form-control" name="client_phone" type="text"
                                       value=""
                                       placeholder="جوال المورد" id="client_phone" required>
                            </div>
                            @if(\Illuminate\Support\Facades\Auth::user()->type == 0)
                                <div class="col-sm-2">
                                    <select class="form-control" name="branch_id" required>
                                        <option value="">الفروع</option>
                                        @foreach ($branches as $branche)
                                            <option value="{{$branche->id}}"> {{$branche->name}} </option>
                                        @endforeach

                                    </select>
                                </div>
                            @else
                                <input type="hidden" id="branch_id" name="branch_id" required
                                       value="{{\Illuminate\Support\Facades\Auth::user()->branch_id}}">
                            @endif
                            <div class="col-sm-3">
                                <input class="form-control" type="date" value="{{date('Y-m-d')}}"
                                       name="sdate" required>
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-12">
                            <button type="submit"
                                    class="btn btn-primary btn-block waves-effect waves-light m-r-5">
                                حفظ
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-lg-12">
                        <div class="card m-b-20">
                            <div class="card-body">
                                <div class="row m-b-10">
                                    <div class="col-sm-2">
                                        <small class="form-text text-muted">نوع الفاتورة</small>
                                        <select class="form-control" name="order_type" id="order_type" required>
                                            <option order_type="0" value="0">فاتورة شراء</option>
                                            <option order_type="1" value="1">فاتورة مرتجع</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-2" id="order_return" style="display: none;">
                                        <small class="form-text text-muted">ادخل رقم الفاتورة</small>
                                        <input class="form-control" type="text" value="" id="order_return_value"
                                               placeholder="ادخل رقم الفاتورة " name="order_return">
                                    </div>

                                    <div class="col-sm-2">
                                        <small class="form-text text-muted">كاش</small>
                                        <input class="form-control" type="number" value="" step="0.01"
                                               placeholder="كاش " name="cash" id="cash">
                                    </div>
                                    <div class="col-sm-2">
                                        <small class="form-text text-muted">شبكه</small>
                                        <input class="form-control" type="number" value="" step="0.01"
                                               placeholder="شبكه" name="online" id="online">
                                    </div>
                                </div>

                                <div class="form-group m-b-0">

                                    <div>


                                        <div id="cart">
                                            @include('admin.purchas.cart_data')

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>

            </form>

        </div><!-- container -->
    </div> <!-- Page content Wrapper -->

    <div class="modal fade cartmodal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card card-outline-info">
                <div class="modal-header card-header" dir="rtl">
                    <h4 class="modal-title" id="myLargeModalLabel" style="color: grey">اضف صنف</h4>
                </div>
                <div class="modal-body">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade clientmodel" id="clientmodel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card card-outline-info">
                <div class="modal-header card-header" dir="rtl">
                    <h3 class="modal-title" id="myLargeModalLabel" style="color: grey">بيانات العميل</h3>
                </div>
                <div class="modal-body">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection

@section('script')
    <script
        src="{{ URL::asset('public/adminAssets/ar/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/alertify/js/alertify.js') }}"></script>
@endsection

@section('script-bottom')

    <script>
        window.onload = function () {
            document.getElementById("itm_code").focus();
        }

        $('#client_phone').keydown(function (e) {
            if ((e.keyCode || e.which) == 39) {
                var phone = $("#client_phone").val();
                $.ajax({
                    type: "get",
                    url: "{{url('/')}}/admin/get_supplier/",
                    data: {phone: phone},
                    success: function (data) {
                        $(".clientmodel .modal-body").html(data)
                        $(".clientmodel").modal('show')
                    }
                });
            }
        });

        var delayTimer;

        $("#itm_code").on("input", function() {
            var itm_code = $("#itm_code").val();
            var order_type = $("#order_type").val();
            var order_return_value = $("#order_return_value").val();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {

                $.ajax({
                    type: "GET",
                    url: "{{url('admin/get_p_product')}}",
                    data: {"itm_code": itm_code,"order_type": order_type, "order_return": order_return_value},
                    success: function (data) {
                        if(data.msg) {
                            if(data.msg == "faild") {
                                alertify.error("عفوا ، المنتج غير متوفر");
                            }
                            document.getElementById('itm_code').value = '';
                            document.getElementById("itm_code").focus();
                        } else {
                            $(".cartmodal .modal-body").html(data);
                            $(".cartmodal").modal('show');
                        }
                        
                    }
                })

            }, 300);
        });

        $('#itm_name').keyup(function (e) {
            if ((e.keyCode || e.which) == 39) {
                $("#itm_name").val("");
                var selectElement = document.getElementById('inputitmname');
                selectElement.innerHTML = '';
                document.getElementById('bgsearch').style.display = 'none';
            }
        });

        function set_itm_code(itm) { 
            $("#itm_name").val("");
            var selectElement = document.getElementById('inputitmname');
            selectElement.innerHTML = '';

            document.getElementById('bgsearch').style.display = 'none';

            var itm_code = itm;
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "GET",
                url: "{{url('admin/get_p_product')}}",
                data: {"itm_code": itm_code},
                success: function (data) {
                    $(".cartmodal .modal-body").html(data);
                    $(".cartmodal").modal('show');
                }
            })
        }

        function itmnameFinder() {
            var search_text=document.getElementById("itm_name").value;
            if (search_text && search_text.length > 2){
                $.ajax({
                method: 'post',
                url: "{!!route('liveitemSearch')!!}",
                data: {
                "_token": "{{ csrf_token() }}",
                    "search_text":search_text
                },
                complete: function (result) {

                var new_list=result.responseJSON.results;
                var selectElement = document.getElementById('inputitmname');
                selectElement.innerHTML = '';

                document.getElementById('bgsearch').style.display = 'block';

                var temp;
                for(i = 0; i < new_list.length; i++)
                {
                if(i==0){
                $('#inputitmname').append('<li onclick="set_itm_code('+new_list[i].itm_code+')" style="font-size: 12px;font-weight: bold;padding: 7px 10px;border-top: 1px solid #e3e3e3;border-bottom: 1px solid #e3e3e3;background: #ffffff;">- '+new_list[i].title+'</li>');
                }
                else
                $('#inputitmname').append('<li onclick="set_itm_code('+new_list[i].itm_code+')" style="font-size: 12px;font-weight: bold;padding: 7px 10px;border-top: 1px solid #e3e3e3;border-bottom: 1px solid #e3e3e3;background: #ffffff;">- '+new_list[i].title+'</li>');             
                }
                    
                }
            })
            } else {
                document.getElementById('bgsearch').style.display = 'none';
            }
            
        }

        $('#order_type').change(function () {
            var $select = $('#order_type');
            var order_type = $('option:selected', $select).attr('order_type');

            if (order_type == 1) {
                document.getElementById('order_return').style.display = 'block';
            } else {
                document.getElementById('order_return').style.display = 'none';
            }
        });
    </script>




@endsection