@extends('admin.layouts.master')

@section('css')
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
    <h3 class="page-title">المنتجات</h1>
        @endsection

        @section('content')
            <div class="page-content-wrapper">
                <div class="container-fluid" dir="rtl">
                    <div class="card m-b-20">
                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger mb-0">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            <form action="{{ route('admin.edit_post.submit') }}" method="post"
                                  enctype="multipart/form-data">

                                @csrf

                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الاسم عربي</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ $data->title }}" name="title" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الاسم انجليزي</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ $data->title_en }}" name="title_en">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">كود الصنف </label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="{{ $data->itm_code }}" name="itm_code">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الوحدة الكبرى</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" name="itm_unit1" required>
                                                    @foreach ($units as $item=>$unit)
                                                        <option @if ($unit->id == $data->itm_unit1 ) selected @endif value="{{$unit->id}}">{{$unit->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الوحدة الوسطى</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" name="itm_unit2" required>
                                                    @foreach ($units as $item=>$unit)
                                                        <option @if ($unit->id == $data->itm_unit2 ) selected @endif value="{{$unit->id}}">{{$unit->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الوحدة الصغرى</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" name="itm_unit3" required>
                                                    @foreach ($units as $item=>$unit)
                                                        <option @if ($unit->id == $data->itm_unit3 ) selected @endif value="{{$unit->id}}">{{$unit->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">عدد الوحدة الوسطى  </label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="number" value="{{ $data->mid }}" name="mid">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">عدد الوحدة الصغرى  </label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="number" value="{{ $data->sm }}" name="sm">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">القسم</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" name="cat_id" required>
                                                    @foreach ($categories as $item=>$cat)
                                                        <option @if ($cat->id == $data->cat_id ) selected @endif value="{{$cat->id}}">{{$cat->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">المحتوى</label>
                                            <div class="col-sm-12">
                                                <textarea id="textarea" class="form-control"
                                                          name="content" required>{{$data->content}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="control-label">منتج مميز ؟</label>
                                                    <br>
                                                    <label class="radio">
                                                        <input type="radio" value="1" name="is_show" @if ($data->is_show == 1) checked @endif/>
                                                        نعم
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" value="0" name="is_show" @if ($data->is_show == 0) checked @endif/>
                                                        لا
                                                    </label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="control-label">منتج مفعل ؟</label>
                                                    <br>
                                                    <label class="radio">
                                                        <input type="radio" value="1" name="status" @if ($data->status == 1) checked @endif/>
                                                        نعم
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" value="0" name="status" @if ($data->status == 0) checked @endif/>
                                                        لا
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الصورة</label>
                                            <div class="col-sm-12">
                                                <input type="file" class="filestyle" name="photo" id="photo_link"
                                                   data-buttonname="btn-secondary">
                                                <br>
                                                @if ($data->photo == Null)
                                                    <img class="img-thumbnail" id="get_photo_link" style="width: 200px;" 
                                                    src="{{ URL::asset('public/adminAssets\ar\images\gallery\dummy.jpg') }}" data-holder-rendered="true">
                                                @else
                                                    <img class="img-thumbnail" id="get_photo_link"
                                                            style="width: 200px;" src="{{$data->photo}}"
                                                            data-holder-rendered="true">
                                                @endif
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="form-group m-b-0">
                                            <div>
                                                <button type="submit" class="btn btn-primary waves-effect waves-light m-r-5">
                                                    حفظ
                                                </button>
                                                <button type="reset" class="btn btn-secondary waves-effect">
                                                    الغاء
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                </div> 

                                <input type="hidden" value="{{$data->id}}" name="id"/>

                                <div class="form-group m-b-0">
                                    <div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-r-5">
                                            حفظ
                                        </button>
                                        <button type="reset" class="btn btn-secondary waves-effect">
                                            الغاء
                                        </button>
                                    </div>
                                </div>

                            </form>

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
                    @if($data->attributes)
                let i = {{count($data->attributes)}} +1;
                    @else
                let i = 1;

                    @endif


                    @if($data->additions)
                let j = {{count($data->additions)}} +1;
                    @else
                let j = 1;

                @endif


                function add_new_attribute() {
                    $('#attributes_append').append('<div class="row">\n' +
                        '                                                     <div class="col-4">\n' +
                        '                                                         <label for="">الخاصية</label>\n' +
                        '                                                         <input class="form-control" type="text" name="attributess[' + i + '][attribute_name]" id="">\n' +
                        '                                                     </div>\n' +
                        '                                                     <div class="col-4">\n' +
                        '                                                         <label for="">الصفة</label>\n' +
                        '                                                         <input class="form-control" type="text" name="attributess[' + i + '][attribute_option]" id="">\n' +
                        '                                                     </div>\n' +
                        '                                                     <div class="col-3">\n' +
                        '                                                         <label for="">السعر الاضافي</label>\n' +
                        '                                                         <input class="form-control" type="number" name="attributess[' + i + '][attribute_price]" id="">\n' +
                        '                                                     </div>\n' +
                        '                                                     <div class="col-lg-1">\n' +
                        '                                                         <label for=""> </label>\n' +
                        '                                                         <button class="form-control btn btn-danger removeappend"  "> \n' +
                        '                                                        <i class="fa fa-trash"></i></button> \n' +
                        '                                                     </div>\n' +
                        '                                                 </div>'
                    )
                    ;
                    i++;
                }


                function add_new_addition() {
                    $('#additions_append').append('<div class="row">\n' +
                        '                                                     <div class="col-5">\n' +
                        '                                                         <label for="">الاضافة</label>\n' +
                        '                                                         <input class="form-control" type="text" name="addittions[' + j + '][addittion_name]" id="">\n' +
                        '                                                     </div>\n' +
                        '                                                     <div class="col-5">\n' +
                        '                                                         <label for="">السعر الاضافي</label>\n' +
                        '                                                         <input class="form-control" type="number" name="addittions[' + j + '][addittion_price]" id="">\n' +
                        '                                                     </div>\n' +
                        '                                                     <div class="col-lg-1">\n' +
                        '                                                         <label for=""> </label>\n' +
                        '                                                         <button class="form-control btn btn-danger removeappend"  "> \n' +
                        '                                                        <i class="fa fa-trash"></i></button> \n' +
                        '                                                     </div>\n' +
                        '                                                 </div>'
                    )
                    ;
                    j++;
                }


                $('#attributes_append').on('click', '.removeappend', function (e) {
                    e.preventDefault();
                    $(this).parent().parent().remove();
                });
                $('#additions_append').on('click', '.removeappend', function (e) {
                    e.preventDefault();
                    $(this).parent().parent().remove();
                });

            </script>
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

                document.getElementById('photo_link2').onchange = function (evt) {
                    var tgt = evt.target || window.event.srcElement,
                        files = tgt.files;

                    // FileReader support
                    if (FileReader && files && files.length) {
                        var fr = new FileReader();
                        fr.onload = function () {
                            document.getElementById('get_photo_link2').src = fr.result;
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
                document.getElementById('photo_link3').onchange = function (evt) {
                    var tgt = evt.target || window.event.srcElement,
                        files = tgt.files;

                    // FileReader support
                    if (FileReader && files && files.length) {
                        var fr = new FileReader();
                        fr.onload = function () {
                            document.getElementById('get_photo_link3').src = fr.result;
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
