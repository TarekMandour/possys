@extends('admin.layouts.master') 

@section('css')
<link href="{{ URL::asset('public/adminAssets/ar/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" />
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
                    
                    <form action="{{ route('admin.edit_post.submit') }}" method="post" enctype="multipart/form-data">

                        @csrf
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#arabic" role="tab">التفاصيل</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#english" role="tab">الاسعار</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#other" role="tab">اخرى</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active p-3" id="arabic" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-8">
        
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">العنوان</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{ $data->title }}" name="title" required>
                                            </div>
                                        </div>
        
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">المحتوى</label>
                                            <div class="col-sm-12">
                                                <textarea id="textarea" class="form-control summernote" name="content" required>{{$data->content}}</textarea>
                                            </div>
                                        </div>
        
                                    </div>

                                    <div class="col-lg-4">
        
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الحالة</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="status_id" required>
                                                    @if ($data->status_id == 0)
                                                    <option value="0">مستعمل</option>
                                                    @elseif($data->status_id == 1)
                                                    <option value="1">جديد</option>
                                                    @elseif($data->status_id == 2)
                                                    <option value="2">جديد و مستعمل</option>
                                                    @endif
                                                    <option value="">---</option>
                                                    <option value="0">مستعمل</option>
                                                    <option value="1">جديد</option>
                                                    <option value="2">جديد و مستعمل</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">اللغة</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="lang" required>
                                                    @if ($data->lang == 'انجليزي')
                                                    <option value="انجليزي">انجليزي</option>
                                                    @elseif($data->lang == 'عربي')
                                                    <option value="عربي">عربي</option>
                                                    @endif
                                                    <option value="">---</option>
                                                    <option value="انجليزي">انجليزي</option>
                                                    <option value="عربي">عربي</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">المادة</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="subject_id" required>
                                                    @foreach ($subjects as $subject)
                                                        @if ($subject->id == $data->subject_id )
                                                            <option value="{{$subject->id}}">{{$subject->title}}</option>
                                                        @endif
                                                    @endforeach
                                                    <option value="">---</option>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{$subject->id}}">{{$subject->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">المرحلة التعليمية</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="level_id" required>
                                                    @foreach ($levels as $level)
                                                        @if ($level->id == $data->level_id )
                                                            <option value="{{$level->id}}">{{$level->title}}</option>
                                                        @endif
                                                    @endforeach
                                                    <option value="">---</option>
                                                    @foreach ($levels as $level)
                                                        <option value="{{$level->id}}">{{$level->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الناشر</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="publisher_id" required>
                                                    @foreach ($publishers as $publisher)
                                                        @if ($publisher->id == $data->publisher_id )
                                                            <option value="{{$publisher->id}}">{{$publisher->title}}</option>
                                                        @endif
                                                    @endforeach
                                                    <option value="">---</option>
                                                    @foreach ($publishers as $publisher)
                                                        <option value="{{$publisher->id}}">{{$publisher->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">القسم</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="cat_id" required>
                                                    @foreach ($categories as $item=>$cat)
                                                        @if ($cat->id == $data->cat_id )
                                                            <option value="{{$cat->id}}">{{$cat->title}}</option>
                                                        @endif
                                                    @endforeach
                                                    <option value="">---</option>
                                                    @foreach ($categories as $item=>$cat)
                                                        <option value="{{$cat->id}}">{{$cat->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
        
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="tab-pane p-3" id="english" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p>اسعار الكتب الجديده :</p>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">سعر البيع</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" value="{{ $data->new_price_sell }}" name="new_price_sell" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">سعر التأجير</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" value="{{ $data->new_price_leasing }}" name="new_price_leasing" required>
                                            </div>
                                        </div>
        
                                    </div>
                                    <div class="col-lg-6">
                                        <p>اسعار الكتب المستعملة :</p>
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">سعر البيع</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" value="{{ $data->used_price_sell }}" name="used_price_sell" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">سعر التأجير</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" value="{{ $data->used_price_leasing }}" name="used_price_leasing" required>
                                            </div>
                                        </div>
        
                                    </div>                                    
                                </div>
                            </div>
                            <div class="tab-pane p-3" id="other" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group text-center">
                                            <label class="pull-right">الصورة 1</label>
                                            <input type="file" class="filestyle" name="photo" id="photo_link" data-buttonname="btn-secondary">
                                            <br>
                                            @if ($data->photo == Null)
                                                <img class="img-thumbnail" id="get_photo_link" style="width: 200px;" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" data-holder-rendered="true">
                                            @else  
                                                <img class="img-thumbnail" id="get_photo_link" style="width: 200px;" src="{{ URL::asset('public/uploads/posts') }}/{{$data->photo}}" data-holder-rendered="true">
                                            @endif
                                            
                                        </div>

                                        <div class="form-group text-center">
                                            <label class="pull-right">الصورة 2</label>
                                            <input type="file" class="filestyle" name="photo_snd" id="photo_link2" data-buttonname="btn-secondary">
                                            <br>
                                            @if ($data->photo2 == Null)
                                                <img class="img-thumbnail" id="get_photo_link2" style="width: 200px;" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" data-holder-rendered="true">
                                            @else  
                                                <img class="img-thumbnail" id="get_photo_link2" style="width: 200px;" src="{{ URL::asset('public/uploads/posts') }}/{{$data->photo2}}" data-holder-rendered="true">
                                            @endif
                                            
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                    </div>
        
                                    <div class="col-lg-5">
        
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label class="control-label">منتج مميز ؟</label>
                                                <br>
                                                <label class="radio">
                                                <input type="radio" value="1" name="is_fav" @if ($data->is_fav == 1) checked @endif />
                                                نعم
                                                </label>
                                                <label class="radio">
                                                <input type="radio" value="0" name="is_fav" @if ($data->is_fav == 0) checked @endif/>
                                                لا
                                                </label>
                                            </div>
                                        </div>
        
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Meta Keywords</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{ $data->meta_keywords }}" name="meta_keywords">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">Meta Description</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{ $data->meta_description }}" name="meta_description">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        

                        <input type="hidden" value="{{$data->id}}" name="id" />

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
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/summernote/summernote-bs4.js') }}"></script>
@endsection

@section('script-bottom')
    <script>

        jQuery(document).ready(function(){
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
    </script>
@endsection
