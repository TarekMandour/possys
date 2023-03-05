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
                <div class="col-3">
                </div>
                <div class="col-6">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="invoice-title">
                                <h4 class="font-16">@if ($data[0]->order_type == 0)<strong> فاتورة ضريبية مبسطه </strong> @else <strong>اشعار مرتجع - فاتورة ضريبية مبسطه </strong>@endif
                                    <div class="d-print-none pull-left">
                                        <a href="{{ url('/admin/print_order/'.$data[0]->order_id) }}"
                                           class="btn btn-Teal waves-effect waves-light"><i
                                                class="fa fa-print"></i></a>

                                                @php
                                                    $check_return = \App\Models\Order::select('id')->where('order_return', $data[0]->order_id)->first();
                                                @endphp
                                                @if (!$check_return && $data[0]->order_type == 0)
                                        <a href="{{ url('/admin/return_order/'.$data[0]->order_id) }}"
                                           class="btn btn-danger"><i
                                                class="mdi mdi-keyboard-return"></i></a>
                                                @endif
                                    </div>
                                </h4>

                            </div>
                            <hr>
                            <div class="row">

                                <div class="col-12 text-right">
                                    <p class="right"><strong>{{$setting->title}}</strong>
                                        <br>
                                        @if ($data[0]->order_type == 0)
                                        رقم الفاتورة : {{$data[0]->order_id}} <br>
                                        @else
                                        رقم الفاتورة : {{$data[0]->order_id}} عن فاتورة رقم {{$data[0]->order_return}} <br>
                                        @endif
                                        تاريخ الفاتورة: <small class="timedate">{!! date('y-m-d | h:i a', strtotime($data[0]->created_at)) !!} </small><br>
                                        الرقم الضريبي: {{$setting->tax_num}}<br>
                                        الفرع: {{json_decode($data[0]->branch)->name}}<br>
                                        بواسطة: {{$data[0]->add_by_name}}<br>
                                        اسم العميل: {{json_decode($data[0]->client)->name}}<br></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                </div>
                <div class="col-3">
                </div>
                <div class="col-6">
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

                                                        <td class="text-center"><strong>اسم المنتج</strong></td>
                                                        <td class="text-center"><strong>الكمية</strong></td>
                                                        <th class="text-center"><strong>السعر</strong></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php 
                                                            $total_product = 0;
                                                        @endphp
                                                    @foreach ($data as $key => $pro)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{json_decode($pro->product)->title_en}}<br>
                                                                - {{$pro->unit_title}}<br>
                                                                @if ($pro->expiry_date)
                                                                {!! date('y-m-d', strtotime($pro->expiry_date)) !!}
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                الكمية: {{$pro->qty}}<br>
                                                                السعر: {{$pro->price_selling}}
                                                                @if ($pro->is_discount == 0)
                                                                <br>
                                                                @if ($pro->is_tax == 1)
                                                                الضريبة: {{round(($pro->price_selling * $pro->qty) * ($pro->tax_setting / 100), 2)}}
                                                                @endif
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if ($pro->is_tax == 1)
                                                                @if ($pro->is_discount == 0)
                                                                @php $tax = round(($pro->price_selling * $pro->qty) * ($pro->tax_setting / 100), 2); @endphp
                                                                @else
                                                                @php $tax = 0; @endphp
                                                                @endif
                                                                @else
                                                                @php $tax = 0; @endphp
                                                                @endif
                                                                {{round($tax + ($pro->price_selling * $pro->qty), 2)}}
                                                            </td>
                                                        </tr>
                                                        @php 
                                                            $total_product = round($total_product + ($pro->price_selling * $pro->qty), 2);
                                                        @endphp
                                                    @endforeach
                                                    
                                                    @if ($pro->is_discount > 0)
                                                        <tr>
                                                            <td colspan="2">اجمالي المنتجات: </td>
                                                            <td>{{$total_product}} {{$Settings->currency}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">خصم الفاتورة: <br> <small>{{$pro->discount_title}}<small></td>
                                                            <td>{{$total_discount = $total_product - $pro->total_sub }} {{$Settings->currency}}</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td colspan="2">الاجمالى قبل الضريبة: </td>
                                                        <td>{{$pro->total_sub}} {{$Settings->currency}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">اجمالى الضريبة:  </td>
                                                        <td>{{$pro->total_tax }} {{$Settings->currency}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">الاجمالى بعد  الضريبة:  </td>
                                                        <td>{{$pro->total_sub + $pro->total_tax }} {{$Settings->currency}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3" class="text-center">
                                                            {{$qrcode}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-center">
                                                            <?php echo $setting->address .' - ' . $setting->phone1 .' - ' . $setting->phone2 ; ?>
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
                <div class="col-3">
                </div>
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
