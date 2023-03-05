@extends('admin.layouts.master')

@section('css')
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet"/>
    <style>
        .product-list-box {
            padding: 0px !important;
            margin-bottom: 10px !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <h1 class="page-title">تفاصيل الجرد {{$data->name}}</h1>
@endsection

@section('content')


    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">

            @if (session()->has('msg'))
                <div class="alert alert-success">
                    {{session()->get('msg')}}
                </div>
            @endif


            <div class="card m-b-20">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <input class="form-control" name="itm_code" type="text" value="" id="itm_code"
                                   placeholder="كود الصنف">
                        </div>
                    </div>
                    <br>

                </div>
            </div>

            <div class="row">

                <div class="col-lg-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="form-group m-b-0">
                                <div id="cart">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>

                                            <th>كود الصنف</th>
                                            <th>الاسم</th>
                                            <th>الكمية</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data->InventoryDetails as $key =>$item)
                                            <tr>
                                                <td class="td-product-name"> <strong>{{$item->itm_code}}</strong>
                                                </td>
                                                <td class="td-product-name">{{\App\Models\Post::where('itm_code',$item->itm_code)->first()->title_en}}</td>
                                                <td class="td-product-name"><input
                                                        onchange="editQty({{$item->id}} , this.value)"
                                                        class="form-control col-md-3" type="number"
                                                        value="{{$item->qty}}" name="qty" id="qty"></td>


                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>


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

        <div class="modal fade clientmodel" id="clientmodel" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel"
             aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content card card-outline-info">
                    <div class="modal-header card-header" dir="rtl">
                        <h3 class="modal-title" id="myLargeModalLabel" style="color: grey">بيانات المورد</h3>
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
                            url: "{{url('/')}}/admin/client_data/",
                            data: {phone: phone},
                            success: function (data) {
                                $(".clientmodel .modal-body").html(data)
                                $(".clientmodel").modal('show')
                            }
                        });
                    }
                });

                $('#itm_code').change(function (e) {
                    var itm_code = $("#itm_code").val();
                    var inventory_id = {{$data->id}};
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "GET",
                        url: "{{url('admin/add_inventory')}}",
                        data: {"itm_code": itm_code, "inventory_id": inventory_id},
                        success: function (data) {
                            document.getElementById('itm_code').value = '';
                            document.getElementById("itm_code").focus();
                            $("#cart").html(data);
                        }
                    })
                });

                function edit_itm_code(id) {
                    var branch_id = $("#branch_id").val();
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "GET",
                        url: "{{url('admin/get_order_product')}}",
                        data: {"id": id, "branch_id": branch_id},
                        success: function (data) {
                            $(".cartmodal .modal-body").html(data);
                            $(".cartmodal").modal('show');
                        }
                    })
                }

                function editQty(id, qty) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    var inventory_id = {{$data->id}};

                    console.log(qty);
                    $.ajax({
                        type: "GET",
                        url: "{{url('admin/editQty')}}",
                        data: {"id": id, "qty": qty ,"inventory_id":inventory_id},
                        success: function (data) {
                            $("#cart").html(data);
                        }
                    })
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
