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
          <link rel="stylesheet" href="{{ URL::asset('public/adminAssets/ar/plugins/chartist/css/chartist.min.css') }}">
@endsection

@section('breadcrumb')
    <h3 class="page-title">تقرير المبيعات </h3>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">عدد الطلبات</h4>
                            <div id="chart-with-area" class="ct-chart ct-golden-section"></div>
                        </div>
                    </div>
                </div> <!-- end col -->

                <div class="col-lg-6">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">اجمالي الماليات</h4>
                            <div id="stacked-bar-chart" class="ct-chart ct-golden-section"></div>
                        </div>
                    </div>
                </div> <!-- end col -->

            </div> <!-- end row -->

            <div class="row">
                <div class="col-xl-6">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 m-b-30 header-title">اسعار الموردين</h4>
                            <div class="table-responsive">
                                <table class="table table-vertical">
                                    <tbody>
                                        @foreach ($suppliers as $key => $stc)                                        
                                            <tr>
                                                <td>
                                                    {{json_decode($stc['supplier'])->title}}
                                                    <p class="m-0 text-muted font-14">
                                                    الكمية : {{$stc['qty']}}<br>
                                                    تاريخ الانتهاء : {{Carbon\Carbon::parse($stc['expiry_date'])->format("Y-m-d")}}
                                                    </p>
                                                </td>
                                                <td><br>
                                                    <p class="m-0 text-muted font-14">
                                                        {{$stc['price_purchasing']}} {{$Settings->currency}} <br>
                                                        {{$stc['created_at']}}
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 m-b-30 header-title">المخزون في الفروع</h4>
                            <div class="table-responsive">
                                <table class="table table-vertical">
                                    <tbody>
                                        @foreach ($total_stocks as $key => $stc)                                        
                                            <tr>
                                                <td>
                                                    {{$total_stocks[$key]['branch']}}
                                                </td>
                                                <td>
                                                    {{$total_stocks[$key]['qty']}}
                                                    <p class="m-0 text-muted font-14">{{$product->unit1->title}}</p>
                                                </td>
                                                <td>
                                                    @if ($total_stocks[$key]['qty_mid'] != 0)
                                                    {{$total_stocks[$key]['qty_mid']}}
                                                    <p class="m-0 text-muted font-14">{{$product->unit2->title}}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($total_stocks[$key]['qty_sm'] != 0)
                                                    {{$total_stocks[$key]['qty_sm']}}
                                                    <p class="m-0 text-muted font-14">{{$product->unit3->title}}</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

        <script src="{{ URL::asset('public/adminAssets/ar/plugins/chartist/js/chartist.min.js') }}"></script>
        <script src="{{ URL::asset('public/adminAssets/ar/plugins/chartist/js/chartist-plugin-tooltip.min.js') }}"></script>


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

        new Chartist.Line('#chart-with-area', {
            labels: ["{{$month_result[0][0]}}", "{{$month_result[0][1]}}", "{{$month_result[0][2]}}", "{{$month_result[0][3]}}", "{{$month_result[0][4]}}", "{{$month_result[0][5]}}", "{{$month_result[0][6]}}", "{{$month_result[0][7]}}","{{$month_result[0][8]}}", "{{$month_result[0][9]}}", "{{$month_result[0][10]}}","{{$month_result[0][11]}}"],
            series: [
                [0,"{{$count_order[0]}}", "{{$count_order[1]}}", "{{$count_order[2]}}", "{{$count_order[3]}}", "{{$count_order[4]}}", "{{$count_order[5]}}", "{{$count_order[6]}}", "{{$count_order[7]}}", "{{$count_order[8]}}", "{{$count_order[9]}}", "{{$count_order[10]}}", "{{$count_order[11]}}"]
            ]
            }, {
            low: 0,
            showArea: true,
            plugins: [
                Chartist.plugins.tooltip()
            ]
        });

        new Chartist.Line('#chart-with-area2', {
            labels: ["{{$month_result[0][0]}}", "{{$month_result[0][1]}}", "{{$month_result[0][2]}}", "{{$month_result[0][3]}}", "{{$month_result[0][4]}}", "{{$month_result[0][5]}}", "{{$month_result[0][6]}}", "{{$month_result[0][7]}}","{{$month_result[0][8]}}", "{{$month_result[0][9]}}", "{{$month_result[0][10]}}","{{$month_result[0][11]}}"],
            series: [
                [0,"{{$price_selling_order[0]}}", "{{$price_selling_order[1]}}", "{{$price_selling_order[2]}}", "{{$price_selling_order[3]}}", "{{$price_selling_order[4]}}", "{{$price_selling_order[5]}}", "{{$price_selling_order[6]}}", "{{$price_selling_order[7]}}", "{{$price_selling_order[8]}}", "{{$price_selling_order[9]}}", "{{$price_selling_order[10]}}", "{{$price_selling_order[11]}}"]
            ]
            }, {
            low: 0,
            showArea: true,
            plugins: [
                Chartist.plugins.tooltip()
            ]
        });

        new Chartist.Bar('#stacked-bar-chart', {
            labels: ["{{$month_result[0][0]}}", "{{$month_result[0][1]}}", "{{$month_result[0][2]}}", "{{$month_result[0][3]}}", "{{$month_result[0][4]}}", "{{$month_result[0][5]}}", "{{$month_result[0][6]}}", "{{$month_result[0][7]}}","{{$month_result[0][8]}}", "{{$month_result[0][9]}}", "{{$month_result[0][10]}}","{{$month_result[0][11]}}"],
            series: [
                ["{{$price_selling_order[0]}}", "{{$price_selling_order[1]}}", "{{$price_selling_order[2]}}", "{{$price_selling_order[3]}}", "{{$price_selling_order[4]}}", "{{$price_selling_order[5]}}", "{{$price_selling_order[6]}}", "{{$price_selling_order[7]}}", "{{$price_selling_order[8]}}", "{{$price_selling_order[9]}}", "{{$price_selling_order[10]}}", "{{$price_selling_order[11]}}"],
                ["{{$price_purchasing_order[0]}}", "{{$price_purchasing_order[1]}}", "{{$price_purchasing_order[2]}}", "{{$price_purchasing_order[3]}}", "{{$price_purchasing_order[4]}}", "{{$price_purchasing_order[5]}}", "{{$price_purchasing_order[6]}}", "{{$price_purchasing_order[7]}}", "{{$price_purchasing_order[8]}}", "{{$price_purchasing_order[9]}}", "{{$price_purchasing_order[10]}}", "{{$price_purchasing_order[11]}}"]
            ]
            }, {
            stackBars: true,
            axisY: {
                labelInterpolationFnc: function(value) {
                return (value);
                }
            },
            plugins: [
                Chartist.plugins.tooltip()
            ]
            }).on('draw', function(data) {
            if(data.type === 'bar') {
                data.element.attr({
                style: 'stroke-width: 30px'
                });
            }
        });
    </script>
@endsection
