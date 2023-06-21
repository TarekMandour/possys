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

          <style>
            @media print {
                .hid {
                    display: none;
                }
    
                .card-blockquote {
                    border: none;
                }
                .card {
                    border: none !important;
                }
            }
        </style>
@endsection

@section('breadcrumb')
    <h3 class="page-title">تارجت الموظفين</h3>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="hid">
                        <form id="fillter-branches" method="get">

                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="d-print-none pull-right ml-3">
                                        <a href="javascript:;" onclick = "window.print()" class="btn btn-dark waves-effect waves-light "><i class="fa fa-print"></i></a>
                                    </div>
                                    <button type="submit" class="btn btn-purple waves-effect waves-light" role="button">
                                        فلتر
                                    </button>
                                </div>
                                @if(\Illuminate\Support\Facades\Auth::user()->type == 0)
                                    <div class="col-sm-4 ">
                                        <label for="to_date" class="col-sm-12">اختر الموظف</label>
                                        <select class="form-control col-sm-12" name="admin_id">
                                            @foreach ($admins as $adm)
                                            <option value="{{$adm->id}}" @if (Request::get('admin_id') == $adm->id ) selected @endif>{{$adm->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="admin_id" value="{{Auth::user()->id}}" />
                                @endif

                                <div class="col-sm-3 ">
                                    <label for="sdate" class="col-sm-12">من تاريخ</label>
                                    <input class="form-control col-sm-12" type="date" value="{{Request::get('sdate')}}"
                                           name="sdate" id="sdate">
                                </div>

                                <div class="col-sm-3 ">
                                    <label for="to_date" class="col-sm-12">الى تاريخ</label>
                                    <input class="form-control col-sm-12" type="date" value="{{Request::get('to_date')}}"
                                           name="to_date" id="to_date">
                                </div>


                            </div>
                        </form>

                    </div>

                    @if ($data)
                        <hr class="hid">
                        <table id="" class="table table-striped table-bordered dt-responsive" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الصنف</th>
                                <th>الكمية</th>
                                <th>اجمالي المبيعات</th>
                                <th>النسبه</th>

                            </tr>
                            </thead>
                            <tbody>

                                @php $total_qty = 0 ; $total_price = 0 ; $total_percent = 0 ;  @endphp
                                @foreach ($data as $item=> $row)
                                    <tr>
                                        <td>
                                            {{$item + 1}}
                                        </td>
                                        <td>
                                            {{$row['title']}} ({{$row['percent_num']}}%) 
                                            
                                        </td>
                                        <td>
                                            {{$row['qty']}}
                                        </td>
                                        <td>
                                            {{$row['price']}} {{$Settings->currency}}
                                        </td>
                                        <td>
                                            {{$row['percent']}} {{$Settings->currency}}
                                        </td>
                                    </tr>
                                    @php
                                        $total_qty += $row['qty'] ;
                                        $total_price += $row['price'] ;
                                        $total_percent += $row['percent'] ;
                                    @endphp
                                @endforeach
                                <tr style="font-weight: bold;text-align: center;">
                                    <td colspan="2">
                                        الاجمالي
                                    </td>

                                    <td>
                                        {{$total_qty}}
                                    </td>
                                    <td>
                                        {{$total_price}} {{$Settings->currency}}
                                    </td>
                                    <td>
                                        {{$total_percent}} {{$Settings->currency}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
