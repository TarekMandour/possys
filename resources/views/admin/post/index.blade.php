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
<h3 class="page-title">المنتجات</h1>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="m-b-30">
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{ url('/admin/create_post/') }}" class="btn btn-purple waves-effect waves-light" role="button">اضف جديد</a>
                                <a href="{{ url('/admin/import_products/') }}" class="btn btn-purple waves-effect waves-light" role="button"> رفع مجموعة اصناف</a>
                                <a href="{{ url('/admin/export-product/') }}" class="btn btn-dark waves-effect waves-light" role="button"> تصدير </a>
                                <a href="#" id="btn_delete" data-token="{{ csrf_token() }}" class="btn btn-danger waves-effect waves-light" role="button">حذف</a>
                            </div>

                            <div class="col-sm-6">
                                
                                <form action="{{ route('admin.filter_post.submit') }}" id="fillter-branches" method="post">
                                    @csrf

                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <input class="form-control" type="text" value="" id="itm_code" placeholder="كود الصنف" name="itm_code" autocomplete="false">
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="text" value="" id="title_search" placeholder="إسم الصنف" name="title" autocomplete="false">
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>

                    @if (session()->has('msg'))
                        <div class="alert alert-success">
                                {{session()->get('msg')}}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{session()->get('error')}}
                        </div>
                    @endif

                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">

                            <table id="tech-companies-1" class="table  table-striped" cellspacing="0">
                                <thead>
                                <tr>
                                    <th style="width: 25px;"><input type="checkbox" id="checker"></th>
                                    <th>كود الصنف</th>
                                    <th>الاسـم</th>
                                    <th>القسـم</th>
                                    <th>الحالة</th>
                                    <th>تم الانشاء</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item=>$row)
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" value="{{$row->id}}" name="check_delete{}" id="customControlInline{{$item+1}}">
                                                <label class="custom-control-label" for="customControlInline{{$item+1}}"></label>
                                            </div>
                                        </td>
                                        <td>{{$row->itm_code}}</td>
                                        <td>{{$row->title}}</td>
                                        <td>{{$row->category?$row->category->title : '---'}}</td>
                                        <td>{{($row->status == 1)?'مفعل' : 'غير مفعل'}}</td>
                                        <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td>
                                        <td>
                                            <a href="{{ url('/admin/edit_post/'.$row->id) }}" class="btn btn-info btn-sm waves-effect waves-light"><i class="ti-pencil-alt"></i></a>
                                        {{-- <a href="{{ url('/admin/reviews/'.$row->id) }}" title="التقييمات" class="btn btn-success btn-sm waves-effect waves-light"><i class="fa fa-star"></i></a>--}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    {{ $data->onEachSide(5)->links() }}

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

    $('#itm_code').keydown(function(e) {
        if ((e.keyCode || e.which) == 39)
        {
            this.form.submit();
        } else if ((e.keyCode || e.which) == 13) {
            this.form.submit();
        }
    });

    $('#title_search').keydown(function(e) {
        if ((e.keyCode || e.which) == 39)
        {
            this.form.submit();
        } else if ((e.keyCode || e.which) == 13) {
            this.form.submit();
        }
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
                                        url: "{{route('admin.delete_post')}}",
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
                                        fail: function(xhr, status, error) {
    console.log(xhr.responseText);
    console.log(status);
    console.log(error);
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
