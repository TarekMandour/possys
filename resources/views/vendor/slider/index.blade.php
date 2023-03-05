@extends('admin.layouts.master') 

@section('css')
<!-- DataTables -->
<link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('public/adminAssets/ar/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('public/adminAssets/ar/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('public/adminAssets/ar/plugins/alertify/css/alertify.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('public/adminAssets/ar/plugins/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('breadcrumb')
<h3 class="page-title">السلايدر</h1>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="m-b-30">
                        <a href="{{ url('/admin/create_slider/') }}" class="btn btn-purple waves-effect waves-light" role="button">اضف جديد</a>
                        <a href="#" id="btn_delete" data-token="{{ csrf_token() }}" class="btn btn-danger waves-effect waves-light" role="button">حذف</a>
                    </div>
                    @if (session()->has('msg'))
                        <div class="alert alert-success">
                                {{session()->get('msg')}}
                        </div>
                    @endif

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th style="width: 25px;">#</th>
                            <th style="width: 25px;"><input type="checkbox" id="checker"></th>
                            <th>العنوان</th>
                            <th>الترتيب</th>
                            <th>الصورة</th>
                            <th>#</th>
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
                                <td>{{$row->title1}}</td>
                                <td>{{$row->sort}}</td>
                                <td>
                                    @if ($row->photo == Null)
                                        ---
                                    @else
                                        <a class="image-popup-no-margins" title="{{$row->photo}}" href="{{ URL::asset('public/uploads/') }}/{{$row->photo}}"><div class="img-responsive">
                                            <img src="{{ URL::asset('public/uploads/') }}/{{$row->photo}}" width="45">
                                        </div></a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('/admin/show_slider/'.$row->id) }}" class="btn btn-purple btn-sm waves-effect waves-light"><i class="ti-eye"></i></a>
                                    <a href="{{ url('/admin/edit_slider/'.$row->id) }}" class="btn btn-info btn-sm waves-effect waves-light"><i class="ti-pencil-alt"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div><!-- container -->
    </div> <!-- Page content Wrapper -->
@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/alertify/js/alertify.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/pages/lightbox.js') }}"></script>
@endsection

@section('script-bottom')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            ordering: false
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
                        url: "{{route('admin.delete_slider')}}",
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
                                alertify.success("تم بنجاح");
                            } else {
                                alertify.error("عفوا ! حدث خطأ ما");
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
</script>
@endsection
