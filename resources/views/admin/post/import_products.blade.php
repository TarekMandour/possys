@extends('admin.layouts.master')

@section('css')
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet"/>
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://bootswatch.com/superhero/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{url('public/front/multiple/jquery.dropdown.css') }}">
@endsection

@section('breadcrumb')
    <h3 class="page-title">رفع مجموعة اصناف</h1>
        @endsection

        @section('content')
            <div class="page-content-wrapper">
                <div class="container-fluid" dir="rtl">
                    <div class="card m-b-20">
                        <div class="card-body">

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if (isset($errors) && $errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif

                            @if (session()->has('failures'))

                                <table class="table table-danger">
                                    <tr>
                                        <th>Row</th>
                                        <th>Attribute</th>
                                        <th>Errors</th>
                                        <th>Value</th>
                                    </tr>

                                    @foreach (session()->get('failures') as $validation)
                                        <tr>
                                            <td>{{ $validation->row() }}</td>
                                            <td>{{ $validation->attribute() }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($validation->errors() as $e)
                                                        <li>{{ $e }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                {{ $validation->values()[$validation->attribute()] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>

                            @endif

                            <form action="{{ route('admin.import_products.submit') }}" method="post"
                                  enctype="multipart/form-data">

                                @csrf
                            
                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="example-text-input" class="col-sm-12 col-form-label">الملف</label>
                                            <div class="col-sm-12">
                                                <input type="file" class="filestyle" name="import_file" data-buttonname="btn-secondary">
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

                                    <div class="col-lg-6">                                     
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
