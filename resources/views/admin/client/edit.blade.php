@extends('admin.layouts.master')

@section('css')

@endsection

@section('breadcrumb')
<h3 class="page-title">العملاء</h1>
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

                    <form action="{{ route('admin.edit_client.submit') }}" method="post" enctype="multipart/form-data">

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
                                        <input class="form-control" minlength="6" pattern="[0-9]*" value="{{ $data->phone }}" name="phone" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">المدينة</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" value="{{ $data->city }}" name="city">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">العنوان</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" value="{{ $data->address }}" name="address" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">البريد الالكتروني</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="email" parsley-type="email" value="{{ $data->email }}" name="email" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">الموقع</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text"
                                               value="{{ $data->location }}" name="location">
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
                                <button onclick="window.location.href='{{ url('/admin/clients') }}'"type="button" class="btn btn-secondary waves-effect">
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
