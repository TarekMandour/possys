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
@endsection

@section('breadcrumb')
    <h3 class="page-title">المديرين</h1>
        @endsection

        @section('content')
            <div class="page-content-wrapper">
                <div class="container-fluid" dir="rtl">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <div class="m-b-30">
                                <a href="{{ url('/admin/create_admin/') }}"
                                   class="btn btn-purple waves-effect waves-light" role="button">اضف جديد</a>
                                <a href="#" id="btn_delete" data-token="{{ csrf_token() }}"
                                   class="btn btn-danger waves-effect waves-light" role="button">حذف</a>
                            </div>
                            @if (session()->has('msg'))
                                <div class="alert alert-success">
                                    {{session()->get('msg')}}
                                </div>
                            @endif

                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th><input type="checkbox" id="checker"></th>
                                    <th>الاسم</th>
                                    <th>رقم الجوال</th>
                                    <th>البريد الالكتروني</th>
                                    <th>النوع</th>
                                    <th>تاريخ الانشاء</th>
                                    <th>#</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $item=>$row)
                                    <tr>
                                        <td>{{$item+1}}</td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" value="{{$row->id}}"
                                                       name="check_delete{}" id="customControlInline{{$item+1}}">
                                                <label class="custom-control-label"
                                                       for="customControlInline{{$item+1}}"></label>
                                            </div>
                                        </td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->phone}}</td>
                                        <td>{{$row->email}}</td>
                                        <td>@if($row->type==0)
                                                مدير
                                            @elseif($row->type==1)
                                                كاشير
                                            @else
                                                مطبخ
                                            @endif
                                        </td>
                                        <td>{{$row->created_at}}</td>
                                        <td>
                                            @if (Auth::user()->id == 1)
                                            <a href="{{ url('/admin/bonus/'.$row->id) }}" target="_blank" title="تعيين منتجات " class="btn btn-dark btn-sm waves-effect waves-light"><i class="mdi mdi-chart-bar"></i></a>
                                            @endif
                                            <a href="{{ url('/admin/show_admin/'.$row->id) }}"
                                               class="btn btn-purple btn-sm waves-effect waves-light"><i
                                                    class="ti-eye"></i></a>
                                            <a href="{{ url('/admin/edit_admin/'.$row->id) }}"
                                               class="btn btn-info btn-sm waves-effect waves-light"><i
                                                    class="ti-pencil-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div><!-- container -->
            </div> <!-- Page content Wrapper -->
        @endsection

        @section('script')
        <!-- Required datatable js -->
            <script
                src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/jquery.dataTables.min.js') }}"></script>
            <script
                src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
            <script src="{{ URL::asset('public/adminAssets/ar/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
            <script src="{{ URL::asset('public/adminAssets/ar/plugins/alertify/js/alertify.js') }}"></script>
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
                                        url: "{{route('admin.delete_admin')}}",
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
                                                alertify.error("عفوا ! حدث خطأ ما");
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
