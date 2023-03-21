@extends('admin.layouts.master')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/responsive.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet"
          type="text/css">
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/alertify/css/alertify.css') }}" rel="stylesheet"
          type="text/css">
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/magnific-popup/magnific-popup.css') }}" rel="stylesheet"
          type="text/css">
@endsection

@section('breadcrumb')
    <h3 class="page-title">ملخص المبيعات</h3>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="">
                        <form id="fillter-branches" method="get">

                            <div class="row">
                                <div class="col-sm-1">
                                    <button type="submit" class="btn btn-purple waves-effect waves-light" role="button">
                                        فلتر
                                    </button>
                                </div>
                                <div class="col-sm-4 row">
                                    <label for="sdate" class="col-sm-4">من تاريخ</label>
                                    <input class="form-control col-sm-8" type="date" value="{{Request::get('sdate')}}"
                                           name="sdate" id="sdate" required>
                                </div>

                                <div class="col-sm-4 row">
                                    <label for="to_date" class="col-sm-4">الى تاريخ</label>
                                    <input class="form-control col-sm-8" type="date" value="{{Request::get('to_date')}}"
                                           name="to_date" id="to_date" required>
                                </div>

                                <div class="col-sm-2">
                                    <select class="form-control" name="order_type">
                                        <option value="">نوع الفاتورة</option>
                                        <option value="2">فاتورة شراء</option>
                                        <option value="1">فاتورة مرتجع</option>
                                    </select>
                                </div>


                            </div>
                        </form>

                        <br>
                        <div>
                            <form action="{{url('admin/print-tax')}}" target="_blank" method="get">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" role="button">
                                           <i class="fa fa-print"></i> طباعة
                                        </button>
                                    </div>
                                    <div class="col-sm-2 row" style="display: none">
                                        <label for="sdate" class="col-sm-4">من تاريخ</label>
                                        <input class="form-control col-sm-8" type="date" value="{{Request::get('sdate')}}"
                                               name="sdate">
                                    </div>

                                    <div class="col-sm-2 row" style="display: none">
                                        <label for="to_date" class="col-sm-4">الى تاريخ</label>
                                        <input class="form-control col-sm-8" type="date" value="{{Request::get('to_date')}}"
                                               name="to_date">
                                    </div>


                                </div>
                            </form>
                        </div>
                    </div>

                    @if ($data)
                        <hr>
                        <table id="" class="table table-striped table-bordered dt-responsive" cellspacing="0">
                            <thead>
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>الضريبة</th>
                                <th>الاجمالي بعد الضرية</th>
                                <th>تم الانشاء</th>

                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $total_tax = 0;
                                $total_sub = 0;
                            @endphp
                            @foreach ($data as $item=> $row)
                                <tr>
                                    <td>
                                        {{$row[0]->order_id}}
                                    </td>
                                    <td>{{$row[0]->total_tax}}</td>
                                    <td>{{$row[0]->total_sub + $row[0]->total_tax}}</td>
                                    <td>{{ date('y-m-d', strtotime($row[0]->sdate))}}</td>
                                    @php
                                        $total_tax += $row[0]->total_tax;
                                        $total_sub += $row[0]->total_sub;
                                    @endphp
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="cart-box col-6">
                                <div class="cart-details">
                                    <div class="cart-details-title">
                                        اجمالى الضريبة
                                    </div>
                                    <div class="cart-details">
                                        {{$total_tax}}
                                        {{$Settings->currency}}
                                    </div>
                                </div>
                            </div>
                            <div class="cart-box col-6">
                                <div class="cart-details">
                                    <div class="cart-details-title">
                                        الاجمالى بعد الضريبة
                                    </div>
                                    <div class="cart-details">
                                        {{$total_tax + $total_sub  }}
                                        {{$Settings->currency}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

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
    <script
        src="{{ URL::asset('public/adminAssets/ar/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/pages/lightbox.js') }}"></script>
    <!-- Buttons examples -->
    <script
        src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.buttons.min.js')}}"></script>
    <script
        src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.bootstrap4.min.js"')}}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/pdfmake.min.js')}}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/vfs_fonts.js')}}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.print.min.js')}}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.colVis.min.js')}}"></script>
    <script
        src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.responsive.min.js') }}"></script>

@endsection

@section('script-bottom')
    <script>
        $(document).ready(function () {
            $('#datatable').DataTable({
                ordering: false
            });
            $('#datatable2').DataTable({
                paging: true,
                searching: false,
                ordering: false,
                info: true,
                dom: 'Bfrtip',
                buttons: [
                    {extend: "print", text: 'طباعه', title: '', className: 'btn btn-primary'},
                    {extend: "excel", text: 'تصدير للاكسل', title: '', className: 'btn btn-success'}
                ]
            });
        });

        $('#itm_code').keydown(function (e) {
            if ((e.keyCode || e.which) == 39) {
                this.form.submit();
            }
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
                                url: "{{route('admin.delete_purchas')}}",
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
