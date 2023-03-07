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

                    <form action="{{ route('admin.edit_post.submit') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="card m-b-20">
                            <div class="card-body">

                                @if ($errors->any())
                                    <div class="alert alert-danger mb-0">
                                        @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                @endif

                                

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
                                                            <option @if ($unit->num == $data->itm_unit1 ) selected @endif value="{{$unit->num}}">{{$unit->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">الوحدة الوسطى</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control select2" name="itm_unit2" required>
                                                        @foreach ($units as $item=>$unit)
                                                            <option @if ($unit->num == $data->itm_unit2 ) selected @endif value="{{$unit->num}}">{{$unit->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">الوحدة الصغرى</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control select2" name="itm_unit3" required>
                                                        @foreach ($units as $item=>$unit)
                                                            <option @if ($unit->num == $data->itm_unit3 ) selected @endif value="{{$unit->num}}">{{$unit->title}}</option>
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
                                                            name="content">{{$data->content}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label class="control-label">يطبق الضريبه</label>
                                                        <br>
                                                        <label class="radio">
                                                            <input type="radio" value="1" name="is_tax" @if ($data->is_tax == 1) checked @endif/>
                                                            نعم
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" value="0" name="is_tax" @if ($data->is_tax == 0) checked @endif/>
                                                            لا
                                                        </label>
                                                    </div>
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
                                                        src="" data-holder-rendered="true">
                                                    @else
                                                        <img class="img-thumbnail" id="get_photo_link"
                                                                style="width: 200px;" src="{{$data->photo}}"
                                                                data-holder-rendered="true">
                                                    @endif
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="form-group m-b-0">
                                                {{-- <div>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light m-r-5">
                                                        حفظ
                                                    </button>
                                                    <button type="reset" class="btn btn-secondary waves-effect">
                                                        الغاء
                                                    </button>
                                                </div> --}}
                                            </div>

                                        </div>

                                    </div> 

                                    <input type="hidden" value="{{$data->id}}" name="id"/>

                                    <div class="form-group m-b-0">

                                    </div>

                                

                            </div>
                        </div>

                        <div class="card m-b-20">
                            
                            <div class="card-body">
                                <div class="card-header">
                                    <h5>الخصائص</h5>
                                </div>
                            </div>

                            <div class="department" >
                                @foreach($data->attribute as $key=>$att)
                                <div class="row col-md-12 m-b-10 m-r-10 form_debart" >

                                    <div class="col-md-3 fv-row">
                                        <!--begin::Label-->
                                        <label class="required form-label">الخصائص </label>
                                        <!--end::Label-->
                                        <select class="form-control select2" onchange="myFunction()" id="itm_unit1" name="attribute[]" required>
                                            <option value="">---</option>
                                            @foreach (App\Models\Attribute::get() as $item=>$attri)
                                                <option value="{{$attri->id}}" @if($attri->id == $att->attribute_id) selected @endif >{{$attri->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 fv-row">
                                        <!--begin::Label-->
                                        <label class="required form-label">الاسم </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="attname[]" class="form-control mb-2" value="{{$att->attname}}" />
                                        <!--end::Input-->
                                    </div>

                                    <div class="col-md-2 fv-row">
                                        <!--begin::Label-->
                                        <label class="required form-label">التكلفة</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="number" name="attprice[]" class="form-control mb-2" value="{{$att->attprice}}" />
                                        <!--end::Input-->
                                    </div>


                                    <div class="col-md-1 remove_ro" style="" >
                                        <br>
                                        @if($key==0)
                                        <a href="javascript:;" onclick="add_debart($(this),event)"  id="add_debart" class="btn btn-success"><i class="ti-plus"></i> </a>
                                        @else
                                        <button class='btn btn-danger'  onclick='remove(this,event)'> <i class='fa fa-trash'> </i></button> 
                                        @endif
                                    </div>
                                    <input type="hidden" name="attid[]" value="{{$att->id}}">
                                </div>
                                @endforeach
                            </div>

                        </div>

                        <div class="card m-b-20">
                            
                            <div class="card-body">
                                <div class="card-header">
                                    <h5>الاضافات</h5>
                                </div>
                            </div>

                            <div class="department" >
                                @foreach($data->additional as $key=>$add)
                                <div class="row col-md-12 m-b-10 m-r-10 form_debart" >
                                    <div class="col-md-3 fv-row">
                                        <!--begin::Label-->
                                        <label class="required form-label">الاسم </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="addname[]" class="form-control mb-2" value="{{$add->addname}}" />
                                        <!--end::Input-->
                                    </div>

                                    <div class="col-md-2 fv-row">
                                        <!--begin::Label-->
                                        <label class="required form-label">التكلفة</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="number" name="addprice[]" class="form-control mb-2" value="{{$add->addprice}}" />
                                        <!--end::Input-->
                                    </div>


                                    <div class="col-md-1 remove_ro" style="" >
                                        <br>
                                        @if($key==0)
                                        <a href="javascript:;" onclick="add_debart($(this),event)"  id="add_debart" class="btn btn-success"><i class="ti-plus"></i> </a>
                                        @else
                                        <button class='btn btn-danger'  onclick='remove(this,event)'> <i class='fa fa-trash'> </i></button>
                                        
                                        @endif
                                        
                                    </div>
                                    <input type="hidden" name="addid[]" value="{{$add->id}}">
                                </div>
                                @endforeach
                            </div>

                        </div>
                        <div style="text-align: center;">
                            <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light m-r-5">
                                حفظ
                            </button>
                            <button onclick="window.location.href='{{ url('/admin/products') }}'"type="button" class="btn btn-secondary btn-lg waves-effect">
                                الغاء
                            </button>
                        </div>
                    </form>
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

<script>
    function myFunction() {
        var id =$('#itm_unit1').val()
        $("#itm_unit2").val(id);
        $("#itm_unit3").val(id);
    }
    function add_debart (e,a) {

    a.preventDefault();
    var remove="";
    remove="<br> <button class='btn btn-danger'  onclick='remove(this,event)'> <i class='fa fa-trash'> </i></button> ";
    //debart=e.parents('.row').find('.form_debart')
    x= e.parents(".department").find('.form_debart:first').clone();

    x.find('input').val('')
    y= x.find('.remove_ro').html(remove);

    e.parents(".department").append(x)


    }
    function remove(e,a) {
    a.preventDefault();
    $(e).parents('.form_debart').remove();
    }

</script>
@endsection
