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
    <style>
        @media print {
            .hid {
                display: none;
            }

            .card-blockquote {
                border: none;
            }
        }
    </style>
@endsection

@section('breadcrumb')

    <h1 class="page-title">تفاصيل الطلب</h1>
@endsection

@section('content')

    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="invoice-title">
                                <h4 class="font-16">@if ($data[0]->order_type == 0)<strong> فاتورة ضريبية مبسطه </strong> @else <strong>اشعار مرتجع - فاتورة ضريبية مبسطه </strong>@endif
                                    <div class="d-print-none pull-left">
                                        <a href="{{ url('/admin/print_purchas/'.$data[0]->order_id) }}"
                                            class="btn btn-Teal waves-effect waves-light"><i
                                                    class="fa fa-print"></i></a>
                                        <a href="{{ url('/admin/barcode_purchas/'.$data[0]->order_id) }}"
                                    class="btn btn-Teal waves-effect waves-light"><i
                                        class="fa fa-barcode"></i></a>
                                                @php
                                                    $check_return = \App\Models\Purchas::select('id')->where('order_return', $data[0]->order_id)->first();
                                                @endphp
                                                @if (!$check_return && $data[0]->order_type == 0)
                                        <a href="{{ url('/admin/return_purchas/'.$data[0]->order_id) }}"
                                           class="btn btn-danger"><i
                                                class="mdi mdi-keyboard-return"></i></a>
                                                @endif
                                    </div>
                                </h4>

                            </div>
                            <hr>
                            <div class="row">

                                <div class="col-4 text-right">
                                    <address>
                                        @if ($data[0]->order_type == 0)
                                        رقم الفاتورة # {{$data[0]->order_id}} <br>
                                        @else
                                        رقم الفاتورة # {{$data[0]->order_id}} عن فاتورة رقم {{$data[0]->order_return}} <br>
                                        @endif
                                        تاريخ اصدار الفاتورة: {{$data[0]->created_at}} <br>
                                        تاريخ التوريد: {{$data[0]->sdate}} <br>
                                    </address>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <div class="panel panel-default">
                                        <div class="p-2">
                                            <h3 class="panel-title font-20"><strong>ملخص الطلب</strong></h3>
                                        </div>
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <td><strong>#</strong></td>
                                                        <td class="text-center"><strong>الاسم </strong></td>
                                                        <td class="text-center"><strong>السعر</strong></td>
                                                        <td class="text-center"><strong>الكمية</strong></td>
                                                        <td class="text-center"><strong>الاجمالي قبل الضريبة</strong></td>
                                                        <td class="text-center"><strong>الضريبة</strong></td>
                                                        <td class="text-center"><strong>الاجمالي</strong></td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $total_purcase = 0; $total_ptatcase = 0; ?>
                                                    @foreach ($data as $key => $pro)
                                                    <?php $total_purcase += ($pro->qty * $pro->price_purchasing); ?>
                                                        <tr>
                                                            <td>{{$key + 1}}</td>
                                                            <td class="text-center">{{json_decode($pro->product)->title_en}}</td>
                                                            <td class="text-center">{{$pro->price_purchasing}}</td>
                                                            <td class="text-center">{{$pro->qty}}</td>
                                                            <td class="text-center">{{$pro->price_purchasing * $pro->qty}}</td>
                                                            <td class="text-center">
                                                                @if ($pro->is_tax == 1)
                                                                @php $tax = round(($pro->price_purchasing * $pro->qty) * ($Settings->tax / 100),2) @endphp
                                                                @else
                                                                @php $tax = 0; @endphp
                                                                @endif
                                                                {{$tax}}
                                                                <?php $total_ptatcase += $tax; ?>
                                                            </td>
                                                            <td class="text-center">{{ round($tax + ($pro->price_purchasing * $pro->qty),2)}}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>الاجمالى قبل الضريبة: </strong></td>
                                                        <td class="thick-line text-center">{{$total_purcase}}
                                                            {{$Settings->currency}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="thick-line text-center">
                                                            <strong>اجمالى الضريبة: </strong></td>
                                                        <td class="thick-line text-center">{{$total_ptatcase}}
                                                            {{$Settings->currency}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="thick-line text-center">
                                                            <strong>الاجمالي</strong></td>
                                                        <td class="thick-line text-center">{{$total_purcase + $total_ptatcase}}
                                                            {{$Settings->currency}}
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row -->
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
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
            $('#datatable').DataTable();
            $('#datatable2').DataTable();
        });

        $("#btn_delete").click(function (event) {
            event.preventDefault();
            var checkIDs = $(".blockquote-footer input:checkbox:checked").map(function () {
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
                                url: "{{route('admin.delete_orderStatus')}}",
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
@endsection
