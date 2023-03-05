@extends('admin.layouts.master') 

@section('css')

@endsection

@section('breadcrumb')
<h3 class="page-title">المديرين</h1>
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
                    
                    <form action="{{ route('admin.edit_admin.submit') }}" method="post" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">الاسم بالكامل</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" value="{{ $data->name }}" name="name" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">رقم الجوال</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" value="{{ $data->phone }}" name="phone" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">البريد الالكتروني</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="email" parsley-type="email" value="{{ $data->email }}" name="email" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                    <label>كلمة المرور</label>
                                    <div>
                                        <input type="password" id="pass2" class="form-control" value="{{ $data->password }}" required name="password"
                                                placeholder="كلمة المرور"/>
                                    </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">هل نشط ؟</label>
                                        <br>
                                        <label class="radio">
                                        <input type="radio" value="1" name="is_active" @if ($data->is_active == 1) checked @endif />
                                        نعم
                                        </label>
                                        <label class="radio">
                                        <input type="radio" value="0" name="is_active" @if ($data->is_active == 0) checked @endif/>
                                        لا
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group text-center">
                                    <label class="pull-right">صورة البروفايل</label>
                                    <input type="file" class="filestyle" name="profile" id="photo_link" data-buttonname="btn-secondary">
                                    <br>
                                    @if ($data->photo == Null)
                                        <img class="img-thumbnail" id="get_photo_link" style="width: 200px;" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" data-holder-rendered="true">
                                    @else  
                                        <img class="img-thumbnail" id="get_photo_link" style="width: 200px;" src="{{ URL::asset('public/uploads/') }}/{{$data->photo}}" data-holder-rendered="true">
                                    @endif
                                    
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
@endsection

@section('script-bottom')
    <script>
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
