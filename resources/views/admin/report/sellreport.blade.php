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
    <h3 class="page-title">تقرير المبيعات </h3>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="">
                        <form id="fillter-branches" method="get">

                            <div class="row">
                                <div class="col-sm-2">
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
                                <br>
                                <br>

                                <div class="col-sm-6 row" style="padding-right: 16%">
                                    <label for="to_date" class="col-sm-4">الموظفين</label>
                                    <select name="user_id" class="form-control col-sm-8" id="">
                                        <option value=""> اختر الموظف</option>
                                        @foreach(\App\Models\Admin::all() as $admin)
                                            <option @if(Request::get('user_id') == $admin->id) selected @endif value="{{$admin->id}}">{{$admin->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4 row">
                                    <label for="to_date" class="col-sm-4">الموردين</label>
                                    <select name="supplier_id" class="form-control col-sm-8" id="">
                                        <option value=""> اختر المورد</option>
                                        @foreach(\App\Models\Supplier::all() as $admin)
                                            <option  @if(Request::get('supplier_id') == $admin->id) selected @endif value="{{$admin->id}}">{{$admin->sales_name}} - {{$admin->title}}</option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>
                        </form>

                        <br>

                    </div>
                    <div class="page-content-wrapper">

                        <div class="container-fluid" dir="rtl">

                            <div class="row">
                                <div class="col-md-6 col-xl-3">
                                    <div class="mini-stat clearfix bg-white">
                                <span class="mini-stat-icon bg-purple mr-0 float-left"><i
                                        class="mdi mdi-square-inc-cash"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-purple">{{ceil($total_sales)}}</span>
                                            اجمالى المبيعات
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="mini-stat widget-chart-sm clearfix bg-white">
                                <span class="mini-stat-icon bg-dark mr-0 float-left"><i
                                        class="mdi mdi-percent"></i></span>
                                        <div class="mini-stat-info text-right">
                                            <span class="counter text-dark">{{ceil($total_tax)}}</span>
                                            اجمالى الضريبة على المبيعات
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="mini-stat widget-chart-sm clearfix bg-white">
                                <span class="mini-stat-icon bg-purple mr-0 float-left"><i
                                        class="mdi mdi-backup-restore"></i></span>
                                        <div class="mini-stat-info text-right">
                                            <span class="counter text-purple">{{ceil($total_return)}}</span>
                                            اجمالى مرتجعات المبيعات
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="mini-stat clearfix bg-white">
                                <span class="mini-stat-icon bg-purple mr-0 float-left"><i
                                        class="mdi mdi-square-inc-cash"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-purple">{{ceil($pricepurchasing)}}</span>
                                            اجمالى التكلفه
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-xl-4">
                                    <div class="mini-stat clearfix bg-white">
                                <span class="mini-stat-icon bg-dark mr-0 float-left"><i
                                        class="mdi mdi-square-inc-cash"></i></span>
                                        <div class="mini-stat-info">
                                            <span class="counter text-purple">{{ceil($total_buy)}}</span>
                                            اجمالى المشتريات
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="mini-stat widget-chart-sm clearfix bg-white">
                                <span class="mini-stat-icon bg-purple mr-0 float-left"><i
                                        class="mdi mdi-percent"></i></span>
                                        <div class="mini-stat-info text-right">
                                            <span class="counter text-purple">{{ceil($total_buy_tax)}}</span>
                                            اجمالى الضريبه على المشتريات
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4">
                                    <div class="mini-stat widget-chart-sm clearfix bg-white">
                                <span class="mini-stat-icon bg-dark mr-0 float-left"><i
                                        class="mdi mdi-backup-restore"></i></span>
                                        <div class="mini-stat-info text-right">
                                            <span class="counter text-dark">{{ceil($total_buy_return)}}</span>
                                            اجمالى مرتجعات المشتريات
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>


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
