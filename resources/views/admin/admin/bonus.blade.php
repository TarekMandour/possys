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
<h3 class="page-title">تارجت الموظفين</h1>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="m-b-30">
                        <a href="" class="btn btn-purple waves-effect waves-light" data-toggle="modal" data-target="#addModel" role="button">اضف جديد</a>
                        <a href="#" id="btn_delete" data-token="{{ csrf_token() }}" class="btn btn-danger waves-effect waves-light" role="button">حذف</a>
                    </div>

                    <table id="datatable" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th style="width: 25px;">#</th>
                            <th style="width: 25px;"><input type="checkbox" id="checker"></th>
                            <th>اسم المنتج</th>
                            <th>النسبه</th>
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
                                <td>{{json_decode($row['product'])->title}}</td>
                                <td>{{$row['percent'] * 100}} %</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div><!-- container -->
    </div> <!-- Page content Wrapper -->

    <!-- sample modal content -->
    <div id="addModel" class="modal fade bs-add-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">اضافة جديده</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" dir="rtl">

                        <div class="row">
                            <div class="col-lg-6">

                                <div class="col-sm-12">
                                    <input class="form-control" name="itm_code" type="text" value="" id="itm_code"
                                           placeholder="كود الصنف">
                                    
                                </div>
                                <br>

                                <div class="col-sm-12">
                                    <input class="form-control" name="name" type="text"
                                       value="" onkeydown="itmnameFinder()" autocomplete="off"
                                       placeholder="اسم الصنف" id="itm_name">
                                       <div id="bgsearch" style="height: 300px;overflow: hidden;overflow-y: auto;position: absolute;z-index: 99999999999;padding: 0px 0px;display:none;">
                                            <ul class="list-unstyled" id="inputitmname" style="padding-right: 0px;">
                                            </ul>
                                       </div>
                                    
                                </div>

                            </div>

                            <div class="col-lg-6">

                                <div class="col-sm-12">
                                    <input class="form-control" name="percent" type="number" value="" id="percent"
                                    placeholder="النسبه">
                            </div>
                        </div>
                        <br><br>
                        <input type="hidden" id="admin_id" value="{{$admin_id}}" name="admin_id" />
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                      </div>


                </div>
                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.print.min.js') }}"></script>
    
@endsection

@section('script-bottom')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    columns: ':visible',
                    text: '<i class="fa fa-print"></i>',
                    className: 'btn btn-purple waves-effect waves-light',
                    exportOptions: {
                    columns: [ 0, 2, 3]
                }
                }
            ]
        });
        $('#datatable2').DataTable({
            paging: false,
            searching: true,
            ordering: false,
            info: false
        });
    });


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
                        url: "{{route('admin.delete_bonus')}}",
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

    var delayTimer;

    $("#itm_code").on("input", function() {
            var itm_code = $("#itm_code").val();
            var admin_id = $("#admin_id").val();
            var percent = $("#percent").val();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            if (percent > 0) {
                clearTimeout(delayTimer);
                delayTimer = setTimeout(function() {

                    $.ajax({
                        type: "GET",
                        url: "{{url('admin/create_bonus')}}",
                        data: {"itm_code": itm_code, "admin_id": admin_id, "percent": percent},
                        success: function (data) {
                            if(data.msg) {
                                if(data.msg == "faild") {
                                    document.getElementById('itm_code').value = '';
                                    document.getElementById("itm_code").focus();
                                } else {
                                    location.reload();
                                }
                                document.getElementById('itm_code').value = '';
                                document.getElementById("itm_code").focus();
                            } else {
                                document.getElementById('itm_code').value = '';
                                document.getElementById("itm_code").focus();
                            }
                        }
                    })   

                }, 250);  
            } else {
                alert("ادخل النسبه اولا");
            } 
            
    });

    $('#itm_name').keyup(function (e) {
        if ((e.keyCode || e.which) == 39) {
            $("#itm_name").val("");
            var selectElement = document.getElementById('inputitmname');
            selectElement.innerHTML = '';
            document.getElementById('bgsearch').style.display = 'none';
        }
    });

    function set_itm_code(itm) { 
        $("#itm_name").val("");
        var selectElement = document.getElementById('inputitmname');
        selectElement.innerHTML = '';

        document.getElementById('bgsearch').style.display = 'none';

        var itm_code = itm;
        var admin_id = $("#admin_id").val();
        var percent = $("#percent").val();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        if (percent > 0) {

            $.ajax({
            type: "GET",
            url: "{{url('admin/create_bonus')}}",
            data: {"itm_code": itm_code, "admin_id": admin_id, "percent": percent},
            success: function (data) {
                if(data.msg) {
                    if(data.msg == "faild") {
                        document.getElementById('itm_code').value = '';
                        document.getElementById("itm_code").focus();
                    } else {
                        location.reload();
                    }
                    document.getElementById('itm_code').value = '';
                    document.getElementById("itm_code").focus();
                } else {
                    document.getElementById('itm_code').value = '';
                    document.getElementById("itm_code").focus();
                }
            }
        })   

        } else {
            alert("ادخل النسبه اولا");
        }
    }

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
            $('#inputitmname').append('<li onclick="set_itm_code('+new_list[i].itm_code+')" style="font-size: 12px;font-weight: bold;padding: 7px 10px;border-top: 1px solid #e3e3e3;border-bottom: 1px solid #e3e3e3;background: #ffffff;">- '+new_list[i].title+'</li>');
            }
            else
            $('#inputitmname').append('<li onclick="set_itm_code('+new_list[i].itm_code+')" style="font-size: 12px;font-weight: bold;padding: 7px 10px;border-top: 1px solid #e3e3e3;border-bottom: 1px solid #e3e3e3;background: #ffffff;">- '+new_list[i].title+'</li>');             
            }
                
            }
        })
        } else {
            document.getElementById('bgsearch').style.display = 'none';
        }
        
    }

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
