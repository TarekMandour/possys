@extends('admin.layouts.master');

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
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/magnific-popup/magnific-popup.css') }}" rel="stylesheet"
          type="text/css">
@endsection

@section('breadcrumb')
    <h1 class="page-title">قائمة التحويلات</h1>
@endsection

@section('content')

    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="">
                        <form action="{{ route('admin.filter_transfer.submit') }}" id="fillter-branches" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-1">
                                    <button type="submit" class="btn btn-purple waves-effect waves-light" role="button">
                                        فلتر
                                    </button>
                                </div>

                                @if(\Illuminate\Support\Facades\Auth::user()->type == 0)
                                    <div class="col-sm-2">
                                        <select class="form-control" name="branch_from_id">
                                            <option value="">من الفرع</option>
                                            @foreach ($branches as $branche)
                                                <option value="{{$branche->id}}"> {{$branche->name}} </option>
                                            @endforeach

                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" id="branch_id" name="branch_from_id" required
                                           value="{{\Illuminate\Support\Facades\Auth::user()->branch_id}}">

                                @endif

                                <div class="col-sm-2" >
                                    <select class="form-control" name="branch_to_id">
                                        <option value="">الى الفرع</option>
                                        @foreach ($branches as $branche)
                                            <option value="{{$branche->id}}"> {{$branche->name}} </option>
                                        @endforeach

                                    </select>
                                </div>
                                
                                <div class="col-sm-6" style="text-align: left">
                                    @can('اضافة اذونات التحويل')

                                    <a href="{{url('admin/add-transfer')}}" class="btn btn-primary waves-effect waves-light" >
                                        تحويل جديد
                                    </a>
                                    @endcan
                                </div>


                            </div>

                        </form>
                    </div>

                    @if ($data)

                        <table id="datatable2" class="table  table-striped" cellspacing="0">
                            <thead>
                            <tr>
                                <th style="width: 25px;">#</th>
                                <th>من فرع</th>
                                <th>الى فرع</th>
                                <th>كود الصنف</th>
                                <th>الاسم</th>
                                <th>الكمية</th>
                                <th>تم الانشاء</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $item=>$row)
                                <tr>
                                    <td>{{$item+1}}</td>
                                    <td>
                                        {{App\Models\Branch::where('id',$row->branch_from_id)->first()->name}}
                                    </td>
                                    <td>
                                        {{App\Models\Branch::where('id',$row->branch_to_id)->first()->name}}
                                         </td>

                                    <td>  {{$row->itm_code}}</td>
                                    <td>  {{\App\Models\Post::where('itm_code',$row->itm_code)->first()->title_en}}</td>
                                    <td>  {{$row->qty}}</td>

                                    <td>{{Carbon\Carbon::parse($row->created_at)}}</td>

                                </tr>
                            @endforeach
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
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.colVis.min.js') }}"></script>

    <script src="{{ URL::asset('public/adminAssets/ar/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/alertify/js/alertify.js') }}"></script>
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

            //Buttons examples
            var table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis', 'print']
            });

            table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');


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
                                url: "{{route('admin.delete_order')}}",
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
