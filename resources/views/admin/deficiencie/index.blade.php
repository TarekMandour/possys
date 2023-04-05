@extends('admin.layouts.master')

@section('css')
<!-- DataTables -->
<link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('public/adminAssets/ar/plugins/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css">

<!--Morris Chart CSS -->
<link rel="stylesheet" href="{{ URL::asset('public/adminAssets/ar/plugins/morris/morris.css') }}">
<link href="{{ URL::asset('public/adminAssets/ar/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('public/adminAssets/ar/plugins/alertify/css/alertify.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('public/adminAssets/ar/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<h3 class="page-title">تقرير النواقص</h1>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="">
                                
                        <form action="{{ route('admin.filter_deficiencie.submit') }}" id="fillter-branches"
                              method="get">
                            @csrf
                            <div class="row">

                                <div class="col-sm-1">
                                            
                                    <button type="submit" class="btn btn-purple waves-effect waves-light"
                                            role="button">فلتر
                                    </button>
                                </div>

                                @if(\Illuminate\Support\Facades\Auth::user()->type == 0)
                                    <div class="col-sm-2">
                                        <select class="form-control" name="branch_id">
                                            <option value="">الفروع</option>
                                            @foreach ($branches as $branche)
                                                <option value="{{$branche->id}}"> {{$branche->name}} </option>
                                            @endforeach

                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" id="branch_id" name="branch_id" required
                                           value="{{\Illuminate\Support\Facades\Auth::user()->branch_id}}">
                                @endif
                                
                                <div class="col-sm-4 row">
                                    <label for="sdate" class="col-sm-4">من تاريخ</label>
                                    <input class="form-control col-sm-8" type="date" value="{{Request::get('sdate')}}"
                                           name="sdate" id="sdate">
                                </div>

                                <div class="col-sm-4 row">
                                    <label for="to_date" class="col-sm-4">الى تاريخ</label>
                                    <input class="form-control col-sm-8" type="date" value="{{Request::get('to_date')}}"
                                           name="to_date" id="to_date">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="m-b-30">
                        @can('اضافة النواقص')

                        <a href="{{ url('/admin/create_deficiencie/') }}" class="btn btn-purple waves-effect waves-light" data-toggle="modal" data-target="#addModel" role="button">اضف جديد</a>
                        @endcan
                        @can('حذف النواقص')

                        <a href="#" id="btn_delete" data-token="{{ csrf_token() }}" class="btn btn-danger waves-effect waves-light" role="button">حذف</a>
                    @endcan
                    </div>

                    <table id="datatable" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th style="width: 25px;">#</th>
                            <th style="width: 25px;"><input type="checkbox" id="checker"></th>
                            <th>كود الصنف</th>
                            <th>اسم الصنف</th>
                            <th>المده</th>
                            <th>بواسطة</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item=>$row)
                            <tr>
                                <td>{{$item+1}}</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" value="{{$row->id}}" name="check_delete{}" id="customControlInline{{$item+1}}">
                                        <label class="custom-control-label" for="customControlInline{{$item+1}}"></label>
                                    </div>
                                </td>
                                <td>{{json_decode($row->product)->itm_code}}</td>
                                <td>{{json_decode($row->product)->title}}</td>
                                <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td>
                                <td>{{json_decode($row->admin)->name}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $data->onEachSide(5)->links() }}
                </div>
            </div>

            
        </div><!-- container -->
    </div> <!-- Page content Wrapper -->

    <!-- sample modal content -->
    <div id="addModel" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">اضافة جديده</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" dir="rtl">

                    <form method="post" action="{{ route('admin.create_deficiencie.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">كود الصنف </label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" value="" name="itm_code" id="itm_code" required>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">اسم الصنف</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" value="" onkeydown="itmnameFinder()" name="name" autocomplete="off" id="itm_name">
                                        <div id="bgsearch" style="height: 300px;overflow: hidden;overflow-y: auto;position: absolute;z-index: 99999999999;padding: 0px 0px;display:none;">
                                            <ul class="list-unstyled" id="inputitmname" style="padding-right: 0px;">
                                            </ul>
                                       </div>
                                    </div>
                                </div>

                                @if(\Illuminate\Support\Facades\Auth::user()->type == 0)
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-sm-12 col-form-label">الفرع</label>
                                        <div class="col-sm-12">
                                            <select class="form-control" id="branch_id" name="branch_id" required>
                                                @foreach ($branches as $branche)
                                                    <option value="{{$branche->id}}"> {{$branche->name}} </option>
                                                @endforeach
    
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" id="branch_id" name="branch_id" required
                                        value="{{\Illuminate\Support\Facades\Auth::user()->branch_id}}">
                                @endif

                            </div>
                        </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                      </div>
                    </form>

                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade bs-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card card-outline-info">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">تعديل</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" dir="rtl">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/alertify/js/alertify.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/pages/lightbox.js') }}"></script>
@endsection

@section('script-bottom')
<script>


    $("#checker").click(function(){
        var items = document.getElementsByTagName("input");

        for(var i=0; i<items.length; i++){
            if(items[i].type=='checkbox') {
                if (items[i].checked==true) {
                    items[i].checked=false;
                } else {
                    items[i].checked=true;
                }
            }
        }

    });

    $("#btn_delete").click(function(event){
        event.preventDefault();
        var checkIDs = $("#datatable input:checkbox:checked").map(function(){
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
                        url: "{{route('admin.delete_deficiencie')}}",
                        type: 'post',
                        dataType: "JSON",
                        data: {
                            "id": checkIDs,
                            "_method": 'post',
                            "_token": token,
                        },
                        success: function (data) {
                            if(data.msg == "Success") {
                                location.reload();
                            } else {
                            }
                        },
                        fail: function(xhrerrorThrown){

                        }
                    });
                } else {
                    console.log(isConfirm);
                }
            });
        }

    });

    function itmnameFinder() {

        var search_text=document.getElementById("itm_name").value;
        if (search_text && search_text.length > 2){
            $.ajax({
            method: 'post',
            url: "{!!route('liveitemSearch')!!}",
            data: {
            "_token": "{{ csrf_token() }}",
                "search_text":search_text
            },
            complete: function (result) {

            var new_list=result.responseJSON.results;
            var selectElement = document.getElementById('inputitmname');
            selectElement.innerHTML = '';

            document.getElementById('bgsearch').style.display = 'block';

            var temp;
            for(i = 0; i < new_list.length; i++)
            {
            if(i==0){
            $('#inputitmname').append('<li onclick="set_itm_code('+new_list[i].itm_code+',\''+new_list[i].title+'\')" style="font-size: 12px;font-weight: bold;padding: 7px 10px;border-top: 1px solid #e3e3e3;border-bottom: 1px solid #e3e3e3;background: #ffffff;">- '+new_list[i].title+'</li>');
            }
            else
            $('#inputitmname').append('<li onclick="set_itm_code('+new_list[i].itm_code+',\''+new_list[i].title+'\')" style="font-size: 12px;font-weight: bold;padding: 7px 10px;border-top: 1px solid #e3e3e3;border-bottom: 1px solid #e3e3e3;background: #ffffff;">- '+new_list[i].title+'</li>');             
            }
                
            }
        })
        } else {
            document.getElementById('bgsearch').style.display = 'none';
        }
        
    }

    var delayTimer;

    function set_itm_code(itm,title) { 
        $("#itm_name").val("");
        var selectElement = document.getElementById('inputitmname');
        selectElement.innerHTML = '';

        document.getElementById('bgsearch').style.display = 'none';

        var itm_code = itm;
        document.getElementById("itm_code").value = itm_code;
        document.getElementById("itm_name").value = title;
    }

    $("#itm_code").on("input", function() {
        var itm_code = $("#itm_code").val();

        var branch_id = $("#branch_id").val();
        
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        clearTimeout(delayTimer);
        delayTimer = setTimeout(function() {

            $.ajax({
                type: "GET",
                url: "{{url('admin/getname')}}",
                data: {"itm_code": itm_code, "branch_id": branch_id},
                success: function (data) {
                    // var audio = new Audio("{{ URL::asset('public/adminAssets/ar/barcode-beep.mp3') }}");
                    // audio.volume = .5;
                    // audio.play();

                    document.getElementById("itm_name").value = data;
                }
            }) 

        }, 300);  
        
    });

</script>

@php $msg=session()->get("msg"); @endphp
@if( session()->has("msg"))
    @if( $msg == "Success")
        <script>
            alertify.defaults = {
                autoReset:true,
                basic:false,
                notifier:{
                    position:'top-center'

                }
            };

            alertify.success("تم بنجاح");
        </script>
    @elseif ( $msg == "Failed")
        <script>
            alertify.error("عفوا ! حدث خطأ ما");
        </script>
    @endif
@endif
@endsection
