@extends('admin.layouts.master')

@section('css')
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet"/>
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://bootswatch.com/superhero/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{url('public/front/multiple/jquery.dropdown.css') }}">
@endsection

@section('breadcrumb')
    <h3 class="page-title">الاصناف والمنتجات</h1>
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

                            <form action="{{ route('admin.create_post.submit') }}" method="post"
                                  enctype="multipart/form-data">

                                @csrf
                            
                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الاسم عربي</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text"
                                                       value="{{ old('title') }}" name="title">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الاسم انجليزي</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text"
                                                       value="{{ old('title_en') }}" name="title_en">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">كود الصنف </label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text"
                                                       value="{{ old('itm_code') }}" name="itm_code">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الوحدة الكبرى</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" name="itm_unit1" required>
                                                    <option value="">---</option>
                                                    @foreach ($units as $item=>$unit)
                                                        <option value="{{$unit->id}}">{{$unit->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الوحدة الوسطى</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" name="itm_unit2" required>
                                                    <option value="">---</option>
                                                    @foreach ($units as $item=>$unit)
                                                        <option value="{{$unit->id}}">{{$unit->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الوحدة الصغرى</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" name="itm_unit3" required>
                                                    <option value="">---</option>
                                                    @foreach ($units as $item=>$unit)
                                                        <option value="{{$unit->id}}">{{$unit->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">عدد الوحدة الوسطى  </label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="number"
                                                       value="{{ old('mid') }}" name="mid">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">عدد الوحدة الصغرى  </label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="number"
                                                       value="{{ old('sm') }}" name="sm">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">القسم</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" name="cat_id" required>
                                                    <option value="">---</option>
                                                    @foreach ($categories as $item=>$cat)
                                                        <option value="{{$cat->id}}">{{$cat->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">المحتوى</label>
                                            <div class="col-sm-12">
                                                <textarea id="textarea" class="form-control"
                                                          name="content" required></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="control-label">منتج مميز ؟</label>
                                                    <br>
                                                    <label class="radio">
                                                        <input type="radio" value="1" name="is_show"/>
                                                        نعم
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" value="0" name="is_show" checked/>
                                                        لا
                                                    </label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="control-label">منتج مفعل ؟</label>
                                                    <br>
                                                    <label class="radio">
                                                        <input type="radio" value="1" name="status" checked/>
                                                        نعم
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" value="0" name="status"/>
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
                                                <img class="img-thumbnail" id="get_photo_link" style="width: 200px;"
                                                    src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&amp;text=no+image/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                                    data-holder-rendered="true">
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
            <script type="text/javascript"
                    src="{{url('public/front/multiple/mock.js') }}"></script>

            <script type="text/javascript"
                    src="{{url('public/front/multiple/jquery.dropdown.js') }}"></script>
            <script>
                $('.dropdown-mul-2').dropdown({
                    limitCount: 5,
                    searchable: true,

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

            </script>
@endsection
