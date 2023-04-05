@extends('admin.layouts.master')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/responsive.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/magnific-popup/magnific-popup.css') }}" rel="stylesheet"
          type="text/css">

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ URL::asset('public/adminAssets/ar/plugins/morris/morris.css') }}">
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet"
          type="text/css">
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/alertify/css/alertify.css') }}" rel="stylesheet"
          type="text/css">
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/select2/css/select2.min.css') }}" rel="stylesheet"
          type="text/css"/>
@endsection

@section('breadcrumb')
    <h1 class="page-title">السندات</h1>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="m-b-30">
                        @can('اضافة السندات')

                        <a href="{{ url('/admin/create_admin/') }}"
                           class="btn btn-purple waves-effect waves-light" data-toggle="modal"
                           data-target="#addModel" role="button">اضف جديد</a>
                           @endcan
                           @can('حذف السندات')

                        <a href="#" id="btn_delete" data-token="{{ csrf_token() }}"
                           class="btn btn-danger waves-effect waves-light" role="button">حذف</a>
                           @endcan
                    </div>

                    <table id="datatable" class="table table-striped table-bordered dt-responsive"
                           cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th style="width: 25px;">#</th>
                            <th style="width: 25px;"><input type="checkbox" id="checker"></th>
                            <th>نوع السند</th>
                            <th>نوع الدفع</th>
                            <th>تحرير لنوع</th>
                            <th>تحريرآ لـ</th>
                            <th>التاريخ</th>
                            <th>المبلغ</th>
                            <th>البيان</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item=>$row)
                            <tr @if($row->type == "exchange") style="color: red" @endif >
                                <td>{{$item+1}}</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" value="{{$row->id}}"
                                               name="check_delete{}" id="customControlInline{{$item+1}}">
                                        <label class="custom-control-label"
                                               for="customControlInline{{$item+1}}"></label>
                                    </div>
                                </td>
                                <td>{{$row->type}}</td>
                                <td>{{$row->pay_type}}</td>
                                <td>{{$row->user_type}}</td>
                                <td>{{$row->external_name}}</td>
                                <td>{{$row->trans_date}}</td>
                                <td>{{$row->amount}}</td>
                                <td>{{$row->notes}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div><!-- container -->
    </div> <!-- Page content Wrapper -->

    <!-- sample modal content -->
    <div id="addModel" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">اضافة جديده</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" dir="rtl">

                    <form method="post" action="{{ route('admin.create_voucher.submit') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">نوع السند </label>
                                        <br>
                                        <label class="radio">
                                            <input type="radio" value="receipt" name="type" checked/>
                                            قبض
                                        </label>
                                        <label class="radio">
                                            <input type="radio" value="exchange" name="type"/>
                                            صرف
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">نوع الدفع </label>
                                        <br>
                                        <label class="radio">
                                            <input type="radio" value="cash" name="pay_type" checked/>
                                            نقدآ
                                        </label>
                                        <label class="radio">
                                            <input type="radio" value="network" name="pay_type"/>
                                            شبكة
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">تحريرا لـ</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" id="user_type"
                                                name="user_type" required>

                                            <option value="client">عميل</option>
                                            <option value="supplier">مورد</option>
                                            <option value="external">جهة خارجيه</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">اختر المحرر
                                        له</label>
                                    <div class="col-sm-8" id="select">
                                        <select class="form-control select2" id="client" name="user_id" required>
                                            @foreach(\App\Models\Client::select('id','name')->get() as $row)
                                                <option value="{{$row->id}}">{{$row->name}}</option>
                                            @endforeach
                                        </select>


                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">المبلغ</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" name="amount" step="any" required/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">تاريخ السند</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="trans_date" id="datePickerId" required/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">البيان</label>
                                    <div class="col-sm-8">
                                        <textarea name="notes" class="form-control" required></textarea>

                                    </div>
                                </div>


                            </div>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </form>

                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade bs-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card card-outline-info">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">تعديل</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" dir="rtl">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection

@section('script')
    <!-- Required datatable js -->
    <script
        src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script
        src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/alertify/js/alertify.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/select2/js/select2.min.js') }}"></script>
    <script
        src="{{ URL::asset('public/adminAssets/ar/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
    <script
        src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script
        src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
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

        datePickerId.max = new Date().toISOString().split("T")[0];

        $(".edit-Advert").click(function () {
            var id = $(this).data('id')
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "GET",
                url: "{{url('admin/edit_branch')}}",
                data: {"id": id},
                success: function (data) {
                    $(".bs-edit-modal-lg .modal-body").html(data)
                    $(".bs-edit-modal-lg").modal('show')
                    $(".bs-edit-modal-lg").on('hidden.bs.modal', function (e) {
                        //   $('.bs-edit-modal-lg').empty();
                        $('.bs-edit-modal-lg').hide();
                    })
                }
            })
        })

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
            var checkIDs = $("#datatable input:checkbox:checked").map(function () {
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
                                url: "{{route('admin.delete_voucher')}}",
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
                                    } else {
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

    <script>
        $(function () {
            $("#user_type").on('change', function () {
                var user_type = document.getElementById("user_type").value;
                console.log(user_type);

                $('#select').empty();
                $('#external_name').empty();
                if (user_type === "client") {
                    $("#select").append('<select class="form-control select2" id="client" name="user_id" required></select>');
                    @foreach(\App\Models\Client::select('id','name')->get() as $row)
                    $('#client').append($("<option/>", {
                        value: {{$row->id}},
                        text: "{{$row->name}}"
                    }));
                    @endforeach
                } else if (user_type === "supplier") {
                    $("#select").append('<select class="form-control select2" id="client" name="user_id" required></select>');
                    @foreach(\App\Models\Supplier::select('id','title')->get() as $row)
                    $('#client').append($("<option/>", {
                        value: {{$row->id}},
                        text: "{{$row->title}}"
                    }));
                    @endforeach
                } else {
                    $("#select").append('<input type="text" class="form-control " id="client" name="external_name" placeholder="اكتب اسم الجهه" required>');
                }


            });
        });
    </script>

    @php $msg=session()->get("msg"); @endphp
    @if( session()->has("msg"))
        @if( $msg == "Success")
            <script>
                alertify.defaults = {
                    autoReset: true,
                    basic: false,
                    notifier: {
                        position: 'top-center'

                    }
                };

                alertify.success("تم بنجاح");
            </script>
        @elseif ( $msg == "Failed")
            <script>
                alertify.error("عفوا ! حدث خطأ ما");
            </script>
        @endif
    @endif
@endsection
