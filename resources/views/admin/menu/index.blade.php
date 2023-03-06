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
<!-- Nestable css -->
<link href="{{ URL::asset('public/adminAssets/ar/plugins/nestable/jquery.nestable.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
<h3 class="page-title">المديرين</h1>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="rtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <form method="post" action="{{ route('admin.create_menu.submit') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-8">

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">العنوان</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="" name="title" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الترتيب</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" value="0" name="sort">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">متفرع من</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="parent">
                                                    <option value="0"> رئيسي</option>
                                                    @foreach ($data as $item=>$row)
                                                        <option value="{{$row->id}}">{{$row->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">النوع</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" id="type" name="type">
                                                    <option type="0" value="0">---</option>
                                                    <option type="1" value="1">رابط</option>
                                                    <option type="2" value="2">صفحات</option>
                                                    <option type="3" value="3">اقسام</option>
{{--                                                    <option type="4" value="4">مواد</option>--}}
{{--                                                    <option type="5" value="5">مراحل تعليمية</option>--}}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group" id="link" style="display: none;">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">ادخل الرابط</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="" name="link">
                                            </div>
                                        </div>

                                        <div class="form-group" id="page" style="display: none;">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">اختر صفحة</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="page">
                                                    <option value="0">---</option>
                                                    @foreach ($pages as $page)
                                                        <option value="{{$page->id}}">{{$page->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group" id="category" style="display: none;">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">اختر قسم</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="category">
                                                    <option value="0">---</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group" id="subject" style="display: none;">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">اختر مادة</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="subject">
                                                    <option value="0">---</option>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{$subject->id}}">{{$subject->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group" id="level" style="display: none;">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">اختر مرحلة تعليمية</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="level">
                                                    <option value="0">---</option>
                                                    @foreach ($levels as $level)
                                                        <option value="{{$level->id}}">{{$level->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group text-center">
                                            <label class="pull-right">صورة</label>
                                            <input type="file" class="filestyle" name="photo" id="photo_link" data-buttonname="btn-secondary">
                                            <br>
                                                <img class="img-thumbnail" id="get_photo_link" style="width: 200px;" src="{{ URL::asset('public/adminAssets\ar\images\gallery\dummy.jpg') }}" data-holder-rendered="true">
                                        </div>

                                    </div>

                                    <div class="col-lg-4">



                                    </div>
                                </div>

                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                              </div>
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->

                <div class="col-lg-6">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="m-b-30">
                                <a href="#" id="btn_delete" data-token="{{ csrf_token() }}" class="btn btn-danger waves-effect waves-light" role="button">حذف</a>
                            </div>

                            <div class="custom-dd dd" id="nestable_list_2">
                                <ol class="dd-list">
                                    @foreach ($data as $item=>$row)
                                    <div class="custom-control custom-checkbox" style="position: absolute;z-index: 9;">
                                        <input class="custom-control-input" type="checkbox" value="{{$row->id}}" name="check_delete{}" id="customControlInline{{$item+1}}">
                                        <label class="custom-control-label" for="customControlInline{{$item+1}}"></label>
                                    </div>
                                    <li class="dd-item" data-id="15">
                                        <div class="dd-handle">
                                            {{$row->title}}
                                        </div>
                                        @php
                                            $subm = \App\Models\Menu::where('parent',$row->id)->orderBy('sort','asc')->get();
                                            $item = $data->count();
                                        @endphp
                                        @if ($subm->count() > 0)
                                        <ol class="dd-list">
                                            @foreach ($subm as $sub_item)
                                            <div class="custom-control custom-checkbox" style="position: absolute;z-index: 9;">
                                                <input class="custom-control-input" type="checkbox" value="{{$sub_item->id}}" name="check_delete{}" id="customControlInline{{$item+1}}">
                                                <label class="custom-control-label" for="customControlInline{{$item+1}}"></label>
                                            </div>
                                            <li class="dd-item" data-id="16">
                                                <div class="dd-handle">
                                                    {{$sub_item->title}}
                                                </div>
                                            </li>
                                            @php
                                            $item++;
                                        @endphp
                                            @endforeach
                                        </ol>
                                        @endif
                                    </li>
                                    @endforeach
                                </ol>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

        </div><!-- container -->
    </div> <!-- Page content Wrapper -->

    <div class="modal fade bs-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card card-outline-info">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">اضافة جديده</h5>
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
    <!--script for this page only-->
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/nestable/jquery.nestable.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/pages/nestable-init.js') }}"></script>
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

    $(".edit-Advert").click(function(){
        var id=$(this).data('id')
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "GET",
            url: "{{url('admin/edit_menu')}}",
            data: {"id":id},
            success: function (data) {
                $(".bs-edit-modal-lg .modal-body").html(data)
                $(".bs-edit-modal-lg").modal('show')
                $(".bs-edit-modal-lg").on('hidden.bs.modal',function (e){
                    //   $('.bs-edit-modal-lg').empty();
                    $('.bs-edit-modal-lg').hide();
                })
            }
        })
    })

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
        var checkIDs = $("#nestable_list_2 input:checkbox:checked").map(function(){
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
                        url: "{{route('admin.delete_menu')}}",
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

    document.getElementById('photo_link').onchange = function (evt) {
        var tgt = evt.target || window.event.srcElement,
            files = tgt.files;

        // FileReader support
        if (FileReader && files && files.length) {
            var fr = new FileReader();
            fr.onload = function () {
                document.getElementById('get_photo_link').src = fr.result;
                //alert(fr.result);
            }
            fr.readAsDataURL(files[0]);
        }

        // Not supported
        else {
            // fallback -- perhaps submit the input to an iframe and temporarily store
            // them on the server until the user's session ends.
        }
    }

    $('#type').change(function() {

        var type = document.getElementById("type").value ;

        if ( type == 0) {
            document.getElementById('link').style.display = 'none';
            document.getElementById('page').style.display = 'none';
            document.getElementById('category').style.display = 'none';
            document.getElementById('subject').style.display = 'none';
            document.getElementById('level').style.display = 'none';
        } else if ( type == 1 ) {
            document.getElementById('link').style.display = 'block';
            document.getElementById('page').style.display = 'none';
            document.getElementById('category').style.display = 'none';
            document.getElementById('subject').style.display = 'none';
            document.getElementById('level').style.display = 'none';
        } else if ( type == 2 ) {
            document.getElementById('link').style.display = 'none';
            document.getElementById('page').style.display = 'block';
            document.getElementById('category').style.display = 'none';
            document.getElementById('subject').style.display = 'none';
            document.getElementById('level').style.display = 'none';
        } else if ( type == 3 ) {
            document.getElementById('link').style.display = 'none';
            document.getElementById('page').style.display = 'none';
            document.getElementById('category').style.display = 'block';
            document.getElementById('subject').style.display = 'none';
            document.getElementById('level').style.display = 'none';
        } else if ( type == 4 ) {
            document.getElementById('link').style.display = 'none';
            document.getElementById('page').style.display = 'none';
            document.getElementById('category').style.display = 'none';
            document.getElementById('subject').style.display = 'block';
            document.getElementById('level').style.display = 'none';
        } else if ( type == 5 ) {
            document.getElementById('link').style.display = 'none';
            document.getElementById('page').style.display = 'none';
            document.getElementById('category').style.display = 'none';
            document.getElementById('subject').style.display = 'none';
            document.getElementById('level').style.display = 'block';
        }
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
