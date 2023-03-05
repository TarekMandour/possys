@extends('admin.layouts.master');


@section('css')
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet"/>
    <style>
        .product-list-box {
            padding: 0px !important;
            margin-bottom: 10px !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <h1 class="page-title">طلبات اليوم فرع {{$data->first() ? $data->first()->Branch->name : ""}} </h1>
        @endsection

        @section('content')



            <div class="page-content-wrapper">
                <div class="container-fluid" dir="rtl">

                    <div class="card m-b-20">
                        <div class="card-body">

                            <div class="m-b-30">

                                <form action="{{ url('admin/cashier_today/'.$id) }}" id="fillter-branches" method="get">
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <select class="form-control select2 status" name="status">
                                                <option value=""> الحالة</option>
                                                <option @if(request()->get('status') == "pending") selected
                                                        @endif value="pending"> قيد الانتظار
                                                </option>
                                                <option @if(request()->get('status') == "processing") selected
                                                        @endif value="processing"> جاري التجهيز
                                                </option>
                                                <option @if(request()->get('status') == "confirmed") selected
                                                        @endif value="confirmed"> تم التجهيز
                                                </option>
                                                <option @if(request()->get('status') == "out_for_delivery") selected
                                                        @endif value="out_for_delivery"> خرج مع المندوب
                                                </option>
                                                <option @if(request()->get('status') == "delivered") selected
                                                        @endif value="delivered"> تم التوصيل
                                                </option>
                                                <option @if(request()->get('status') == "returned") selected
                                                        @endif value="returned"> ارجاع الطلب
                                                </option>
                                                <option @if(request()->get('status') == "failed") selected
                                                        @endif value="failed"> الغاء من العميل
                                                </option>
                                                <option @if(request()->get('status') == "canceled") selected
                                                        @endif value="canceled"> الغاء من الادارة
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <button type="submit" class="btn btn-teal waves-effect waves-light"
                                                    role="button">فلتر
                                            </button>
                                        </div>
                                    </div>
                            </div>
                            </form>
                            @if (session()->has('msg'))
                                <div class="alert alert-success">
                                    {{session()->get('msg')}}
                                </div>
                            @endif

                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th style="width: 25px;">#</th>
                                    <th style="width: 25px;"><input type="checkbox" id="checker"></th>
                                    <th>رقم الفاتورة</th>
                                    <th>العميل</th>
                                    <th>رقم الجوال</th>
                                    <th>السعر</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الطلب</th>
                                    <th>#</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $item=>$row)
                                    <tr>
                                        <td>{{$item+1}}</td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" value="{{$row->id}}"
                                                       name="check_delete{}" id="customControlInline{{$item+1}}">
                                                <label class="custom-control-label"
                                                       for="customControlInline{{$item+1}}"></label>
                                            </div>
                                        </td>
                                        <td>{{$row->id}}</td>
                                        <td>{{$row->client_name}}</td>
                                        <td>{{$row->client_phone}}</td>
                                        <td>{{$row->total_price}}</td>
                                        <td>
                                            @if ($row->status == 'pending')
                                                <span class="badge badge-primary">قيد الانتظار</span>
                                            @elseif ($row->status == 'confirmed')
                                                <span class="badge badge-purple">تم قبول الطلب</span>
                                            @elseif ($row->status == 'processing')
                                                <span class="badge badge-teal">جاري التجهيز</span>
                                            @elseif ($row->status == 'out_for_delivery')
                                                <span class="badge badge-lime">خرج مع المندوب</span>
                                            @elseif ($row->status == 'delivered')
                                                <span class="badge badge-success">تم التوصيل</span>
                                            @elseif ($row->status == 'returned')
                                                <span class="badge badge-pink">ارجاع الطلب</span>
                                            @elseif ($row->status == 'failed')
                                                <span class="badge badge-danger">الغاء من العميل</span>
                                            @elseif ($row->status == 'canceled')
                                                <span class="badge badge-danger">الغاء من الادارة</span>
                                            @else
                                                -----
                                            @endif
                                        </td>
                                        <td>{{$row->scheduled}}</td>
                                        <td>

                                            <a href="{{ url('/admin/show_order/'.$row->id) }}"
                                               class="btn btn-purple btn-sm waves-effect waves-light"><i
                                                    class="ti-eye"></i></a>
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
            <script
                src="{{ URL::asset('public/adminAssets/ar/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
            <script src="{{ URL::asset('public/adminAssets/ar/plugins/summernote/summernote-bs4.js') }}"></script>
        @endsection

        @section('script-bottom')
            <script>
                jQuery(document).ready(function () {
                    $('.summernote').summernote({
                        height: 300,                 // set editor height
                        minHeight: null,             // set minimum height of editor
                        maxHeight: null,             // set maximum height of editor
                        focus: true                 // set focus to editable area after initializing summernote
                    });

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


            </script>
@endsection
