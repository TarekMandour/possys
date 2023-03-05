@extends('admin.layouts.master')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet"
          type="text/css">
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/alertify/css/alertify.css') }}" rel="stylesheet"
          type="text/css">
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/magnific-popup/magnific-popup.css') }}" rel="stylesheet"
          type="text/css">
@endsection

@section('breadcrumb')
    <h3 class="page-title">المخزون</h1>
        @endsection

        @section('content')
            <div class="page-content-wrapper">
                <div class="container-fluid" dir="rtl">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <div class="">
                                
                                <form action="{{ route('admin.filter_stock.submit') }}" id="fillter-branches"
                                      method="get">
                                    @csrf
                                    <div class="row">
                                        
                                        <div class="col-sm-1">
                                            <a href="#" id="btn_delete" data-token="{{ csrf_token() }}" class="btn btn-danger waves-effect waves-light" role="button">حذف</a>
                                        </div>

                                        <div class="col-sm-1">
                                            
                                            <button type="submit" class="btn btn-purple waves-effect waves-light"
                                                    role="button">فلتر
                                            </button>
                                        </div>

                                        @if(\Illuminate\Support\Facades\Auth::user()->type == 0)
                                            <div class="col-sm-2">
                                                <select class="form-control" name="branch_id">
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

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="" id="itm_code"
                                                           placeholder="كود الصنف" name="itm_code" autocomplete="false">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="number" value="" id="qty"
                                                           placeholder="الكمية" name="qty" autocomplete="false">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="" id="itm_name"
                                                           placeholder="اسم الصنف" name="itm_name" autocomplete="false">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4 row">
                                            <label for="sdate" class="col-sm-4">من تاريخ</label>
                                            <input class="form-control col-sm-8" type="date" value="{{Request::get('sdate')}}"
                                                   name="sdate" id="sdate">
                                        </div>
        
                                        <div class="col-sm-4 row">
                                            <label for="to_date" class="col-sm-4">الى تاريخ</label>
                                            <input class="form-control col-sm-8" type="date" value="{{Request::get('to_date')}}"
                                                   name="to_date" id="to_date">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br><br>

                            @if (session()->has('msg'))
                                <div class="alert alert-success">
                                    {{session()->get('msg')}}
                                </div>
                            @endif

                            <div class="table-rep-plugin">
                                <div class="table-responsive b-0" data-pattern="priority-columns">

                                    <table id="tech-companies-1" class="table  table-striped" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th style="width: 25px;"><input type="checkbox" id="checker"></th>
                                            <th>الفرع</th>
                                            <th>كود الصنف</th>
                                            <th>الاسـم</th>
                                            <th>الكمية</th>
                                            <th>تاريخ الانتهاء</th>
                                            <th>سعر الشراء</th>
                                            <th>سعر البيع</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($data as $item=>$row)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox" value="{{$row->id}}" name="check_delete{}" id="customControlInline{{$item+1}}">
                                                        <label class="custom-control-label" for="customControlInline{{$item+1}}"></label>
                                                    </div>
                                                </td>
                                                <td>{{$row->Branch->name}}</td>
                                                <td>{{$row->itm_code}}</td>
                                                <td>@if($row->Product){{$row->Product->title_en}}@endif</td>
                                                <td>{{$row->qty}}</td>
                                                <td>
                                                    @if ($row->expiry_date != null) 
                                                    {{Carbon\Carbon::parse($row->expiry_date)->format("Y-m-d")}}
                                                    @else
                                                    ----
                                                    @endif
                                                </td>
                                                <td>{{$row->price_purchasing}}</td>
                                                <td>{{$row->price_selling}}</td>
                                                <td>
                                                    <button type="button" id="edit_stock"
                                                            onclick="edit_stock({{$row->itm_code}},{{$row->id}})"
                                                            class="btn btn-info btn-sm waves-effect waves-light"><i
                                                            class="ti-pencil-alt"></i></button>
                                                            <a href="{{ url('/admin/item-report/'.$row->itm_code) }}" target="_blank" title="تقرير الصنف " class="btn btn-dark btn-sm waves-effect waves-light"><i class="mdi mdi-chart-bar"></i></a>
                                                     <a href="{{ url('/admin/barcode_stock/'.$row->id) }}" target="_blank" title="طباعة الباركود" class="btn btn-dark btn-sm waves-effect waves-light"><i class="fa fa-barcode"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            {{ $data->onEachSide(5)->links() }}

                        </div>
                    </div>
                </div><!-- container -->
            </div> <!-- Page content Wrapper -->

            <div class="modal fade cartmodal" id="myModal" tabindex="-1" role="dialog"
                 aria-labelledby="myLargeModalLabel"
                 aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content card card-outline-info">
                        <div class="modal-header card-header" dir="rtl">
                            <h4 class="modal-title" id="myLargeModalLabel" style="color: grey">تعديل صنف</h4>
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
        <!-- Required datatable js -->
            <script
                src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/jquery.dataTables.min.js') }}"></script>
            <script
                src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
            <script src="{{ URL::asset('public/adminAssets/ar/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
            <script src="{{ URL::asset('public/adminAssets/ar/plugins/alertify/js/alertify.js') }}"></script>
            <script
                src="{{ URL::asset('public/adminAssets/ar/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
            <script src="{{ URL::asset('public/adminAssets/ar/pages/lightbox.js') }}"></script>

        @endsection

        @section('script-bottom')
            <script>
                $(document).ready(function () {
                    $('#datatable').DataTable({
                        ordering: false
                    });
                    $('#datatable2').DataTable({
                        paging: false,
                        searching: true,
                        ordering: false,
                        info: false
                    });
                });


                function edit_stock(itm_code, id) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "GET",
                        url: "{{url('admin/edit_stock')}}",
                        data: {"itm_code": itm_code, "id": id},
                        success: function (data) {
                            $(".cartmodal .modal-body").html(data);
                            $(".cartmodal").modal('show');
                        }
                    })
                }

                $("#checker").click(function () {
                    var items = document.getElementsByTagName("input");

                    for (var i = 0; i < items.length; i++) {
                        if (items[i].type == 'checkbox') {
                            if (items[i].checked == true) {
                                items[i].checked = false;
                            } else {
                                items[i].checked = true;
                            }
                        }
                    }

                });

                $("#btn_delete").click(function (event) {
                    event.preventDefault();
                    var checkIDs = $("#tech-companies-1 input:checkbox:checked").map(function () {
                        return $(this).val();
                    }).get(); // <----

                    if (checkIDs.length > 0) {
                        var token = $(this).data("token");

                        Swal.fire({
                            title: 'هل انت متأكد ؟',
                            text: "لا يمكن استرجاع البيانات المحذوفه",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger m-l-10',
                            confirmButtonText: 'موافق',
                            cancelButtonText: 'لا'
                        }).then(function (isConfirm) {
                            if (isConfirm.value) {
                                $.ajax(
                                    {
                                        url: "{{route('admin.delete_stock')}}",
                                        type: 'post',
                                        dataType: "JSON",
                                        data: {
                                            "id": checkIDs,
                                            "_method": 'post',
                                            "_token": token,
                                        },
                                        success: function (data) {
                                            if (data.msg == "Success") {
                                                location.reload();
                                                alertify.success("تم بنجاح");
                                            } else {
                                                alertify.error("عفوا ! لا يجوز حذف المنتج من المخزون  ");
                                            }
                                        },
                                        fail: function (xhrerrorThrown) {

                                        }
                                    });
                            } else {
                                console.log(isConfirm);
                            }
                        });
                    }

                });
            </script>
@endsection
