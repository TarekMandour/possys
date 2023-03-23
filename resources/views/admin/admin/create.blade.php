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
                            @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    {{session()->get('error')}}
                                </div>
                            @endif

                            <form action="{{ route('admin.create_admin.submit') }}" method="post"
                                  enctype="multipart/form-data">

                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الاسم
                                                بالكامل</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{ old('name') }}"
                                                       name="name" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">رقم
                                                الجوال</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" value="{{ old('phone') }}"
                                                       name="phone" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">البريد
                                                الالكتروني</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="email" parsley-type="email"
                                                       value="{{ old('email') }}" name="email" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>كلمة المرور</label>
                                                <div>
                                                    <input type="password" id="pass2" class="form-control" required
                                                           name="password1"
                                                           placeholder="كلمة المرور"/>
                                                </div>
                                                <div class="m-t-10">
                                                    <input type="password" class="form-control" required
                                                           name="password2"
                                                           data-parsley-equalto="#pass2"
                                                           placeholder="تأكيد كلمة المرور"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input"
                                                   class="col-sm-12 col-form-label">النوع</label>
                                            <div class="col-sm-12">
                                                <select name="type" id="type" class="form-control">
                                                    <option value="0">مسؤول النظام</option>
                                                    <option value="1">تابع لفرع</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group" id="branch" style="display: none">
                                            <label for="example-text-input"
                                                   class="col-sm-12 col-form-label">الفرع</label>
                                            <div class="col-sm-12">
                                                <select name="branch_id" class="form-control">
                                                    <option value="">اختر الفرع</option>
                                                    @foreach(\App\Models\Branch::all() as $branch)
                                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الصلاحية</label>
                                            <div class="col-sm-12">
                                                <select class="form-control select2" name="roles">
                                                    @foreach ($roles as $item=>$row)
                                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label class="control-label">هل نشط ؟</label>
                                                <br>
                                                <label class="radio">
                                                    <input type="radio" value="1" name="is_active" checked/>
                                                    نعم
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" value="0" name="is_active"/>
                                                    لا
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group text-center">
                                            <label class="pull-right">صورة البروفايل</label>
                                            <input type="file" class="filestyle" name="profile" id="photo_link"
                                                   data-buttonname="btn-secondary" value="{{ old('profile') }}" >
                                            <br>
                                            <img class="img-thumbnail" id="get_photo_link" style="width: 200px;"
                                                 src="{{ URL::asset('public/adminAssets\ar\images\gallery\dummy.jpg') }}"
                                                 data-holder-rendered="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m-b-0">
                                    <div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-r-5">
                                            حفظ
                                        </button>
                                        <button onclick="window.location.href='{{ url('/admin/admins') }}'"type="button" class="btn btn-secondary waves-effect">
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

            <script>
                $('#type').on('change', function () {
                    if (this.value != 0) {
                        $('#branch').css('display', 'block');
                    } else {
                        $('#branch').css('display', 'none');
                    }
                });
            </script>
@endsection
