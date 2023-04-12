@extends('admin.layouts.master') 

@section('css')
@if (Request::segment(1) == 'ar')
@else
@endif
@endsection

@section('breadcrumb')
<h3 class="page-title">المديرين</h1>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
            <div class="card m-b-20">
                <div class="card-body">

                    @if ($errors->any())
                    <div class="alert alert-danger mb-0">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif				
                    
                    <form action="{{ route('admin.create_role.submit') }}" method="post" enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">الاسم</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" value="{{ old('name') }}" name="name" required>
                                    </div>
                                </div>

                                
                                <label for="example-text-input" class="col-sm-12 col-form-label">الصلاحيات</label>
                                @php
                                $i = 1;
                                @endphp
                                <div class="form-group">
                                    @foreach ($permissions as $permission)
                                    @if (str_contains($permission->name, 'التحكم'))

                                    <div class="custom-control custom-checkbox" style="margin-left: 100px;margin-bottom: 10px;margin-top: 20px;">
                                        <input class="custom-control-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="{{$i}}"">
                                        <label style="font-weight: 600;font-size: 16px !important;" class="custom-control-label" for="{{$i}}"">{{ $permission->name }}</label>
                                    </div>
                                    @else
                                    <div class="custom-control custom-checkbox" style="margin-left: 100px">
                                        <input class="custom-control-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="{{$i}}"">
                                        <label class="custom-control-label" for="{{$i}}"">{{ $permission->name }}</label>
                                    </div>
                                    @endif
                                    @php
                                    $i++;
                                    @endphp
                                @endforeach
                                </div>

                                <div class="form-group m-b-0">
                                    <div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-r-5">
                                            حفظ
                                        </button>
                                        <button onclick="window.location.href='{{ url('/admin/roles') }}'" type="reset" class="btn btn-secondary waves-effect">
                                            الغاء
                                        </button>
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
    @if (Request::segment(1) == 'ar')
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
    @else
    <script src="{{ URL::asset('public/adminAssets/en/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
    @endif
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