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
    <h1 class="page-title">كشف حساب عميل | {{$client->name}}</h1>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="card m-b-20">
                <div class="card-body">


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
                            <th>التاريخ</th>
                            <th>بيان</th>
                            <th>دائن</th>
                            <th>مدين</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item=>$row)
                            <tr>
                                <td>{{$item+1}}</td>
                                <td>{{$row->trans_date}}</td>
                                <td>{{$row->notes}}</td>
                                <td>{{$row->in}}</td>
                                <td>{{$row->out}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class=" text-center">اجمالي داين</td>
                            <td class=" text-right">{{$in}}</td>
                        </tr>
                        <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class=" text-center">اجمالي مدين</td>
                            <td class=" text-right">{{$out}}</td>
                        </tr>
                        <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class=" text-center">الصافي</td>
                            <td class=" text-right">{{$total}}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div><!-- container -->
    </div> <!-- Page content Wrapper -->
@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
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
                                url: "{{route('admin.delete_client')}}",
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
