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
    <h3 class="page-title">قائمة الفواتير</h1>
        @endsection

        @section('content')
            <div class="page-content-wrapper">
                <div class="container-fluid" dir="rtl">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <div class="">

                                    <div class="row">
                                        <div class="col-sm-1">
                                            <button type="button" id="filter" class="btn btn-purple waves-effect waves-light" role="button">
                                                فلتر
                                            </button>

                                        </div>
        
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="" placeholder="رقم الفاتورة"
                                                           name="order_id">
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-sm-2">
                                            <select class="form-control" name="order_type" id="order_type">
                                                <option value="">نوع الفاتورة</option>
                                                <option value="2">فاتورة شراء</option>
                                                <option value="1">فاتورة مرتجع</option>
                                            </select>
                                        </div>
                                        @if(\Illuminate\Support\Facades\Auth::user()->type == 0)
                                            <div class="col-sm-2">
                                                <select class="form-control" name="branch_id" id="branch_id">
                                                    <option value="">الفروع</option>
                                                    @foreach ($branches as $branche)
                                                        <option value="{{$branche->id}}"> {{$branche->name}} </option>
                                                    @endforeach
        
                                                </select>
                                            </div>
                                        @else
                                            <input type="hidden" id="branch_id" name="branch_id" id="branch_id_in" required
                                                   value="{{\Illuminate\Support\Facades\Auth::user()->branch_id}}">
        
                                        @endif
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="" id="client_phone" placeholder="رقم العميل"
                                                           name="client_phone">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="" id="itm_code"
                                                           placeholder="كود الصنف" name="itm_code" autocomplete="false">
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-sm-4 row">
                                            <label for="sdate" class="col-sm-4">من تاريخ</label>
                                            <input class="form-control col-sm-8" type="date" value=""
                                                   name="sdate" id="sdate">
                                        </div>
                                        <div class="col-sm-4 row">
                                            <label for="to_date" class="col-sm-4">الى تاريخ</label>
                                            <input class="form-control col-sm-8" type="date" value=""
                                                   name="to_date" id="to_date">
                                        </div>
        
        
                                    </div>
 
                            </div>



                            <hr>
                            <table id="datatable2" class="table table-striped table-bordered dt-responsive" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>رقم الفاتورة</th>
                                    <th>الفرع</th>
                                    <th>السعر</th>
                                    <th>الضريبة</th>
                                    <th>الاجمالي</th>
                                    <th>تم الانشاء</th>
                                    <th></th>
                                </tr>
                                </thead>

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

                $(function () {
                    sales();
                    function sales(sdate='', to_date = '', itm_code='', client_phone = '',order_id='', order_type = '', branch_id = '', branch_id_in = ''){
                    $('#datatable2').DataTable().destroy();

                        var table = $('#datatable2').DataTable({
                            processing: true,
                            serverSide: true,
                            autoWidth: false,
                            searching: false,
                            responsive: true,
                            aaSorting: [],
                            "dom": "<'card-header border-0 p-0 pt-6'<'card-title' <'d-flex align-items-center position-relative my-1'f> r> <'card-toolbar' <'d-flex justify-content-end add_button'B> r>>  <'row'l r> <''t><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
                            lengthMenu: [[10, 25, 50, 100, 250, -1], [10, 25, 50, 100, 250, "الكل"]],
                            "language": {
                                search: '',
                                searchPlaceholder: 'Search'
                            },
                            buttons: [
                                {
                                    extend: 'print',
                                    className: 'btn btn-primary',
                                    text: 'طباعه'
                                },
                                // {extend: 'pdf', className: 'btn btn-raised btn-danger', text: 'PDF'},
                                {
                                    extend: 'excel',
                                    className: 'btn btn-success',
                                    text: 'تصدير للاكسل'
                                },
                                // {extend: 'colvis', className: 'btn secondary', text: 'إظهار / إخفاء الأعمدة '}
                            ],
                            ajax: {
                                url: '{{ route('orders.datatable.data') }}',
                                data: {sdate:sdate, to_date:to_date, itm_code:itm_code, client_phone:client_phone, order_id:order_id, order_type:order_type, branch_id:branch_id, branch_id_in:branch_id_in }
                            },
                            columns: [
                                {data: 'id', name: 'id', "searchable": true, "orderable": true},
                                {data: 'branch', name: 'branch', "searchable": false, "orderable": true},
                                {data: 'total_sub', name: 'total_sub', "searchable": false, "orderable": true},
                                {data: 'total_tax', name: 'total_tax', "searchable": false, "orderable": true},
                                {data: 'total', name: 'total', "searchable": false, "orderable": true},
                                {data: 'created_at', name: 'created_at', "searchable": true, "orderable": true},
                                {data: 'actions', name: 'actions', "searchable": false, "orderable": false},
                            ]
                        });
                    }

                    $('#filter').click(function(){
                        var sdate = $('#sdate').val();
                        var to_date = $('#to_date').val();
                        var itm_code = $('#itm_code').val();
                        var client_phone = $('#client_phone').val();
                        var order_id = $('#order_id').val();
                        var order_type = $('#order_type').val();
                        var branch_id = $('#branch_id').val();
                        var branch_id_in = $('#branch_id_in').val();

                        $('#datatable2').DataTable().destroy();
                        sales(sdate, to_date, itm_code, client_phone, order_id, order_type, branch_id, branch_id_in);
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
