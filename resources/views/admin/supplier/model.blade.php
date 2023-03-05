<!--Morris Chart CSS -->
<link rel="stylesheet" href="{{ URL::asset('public/adminAssets/ar/plugins/morris/morris.css') }}">
<link href="{{ URL::asset('public/adminAssets/ar/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<form action="{{ route('admin.update_supplier.submit') }}" method="post" enctype="multipart/form-data">

    @csrf
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">الاسم </label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->title }}" name="title" required>
                </div>
            </div>

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">رقم الجوال </label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->phone }}" name="phone" required>
                </div>
            </div>

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">العنوان</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->address }}" name="address" >
                </div>
            </div>

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">رقم الحساب</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->num }}" name="num" >
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

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">مسؤول المبيعات</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->sales_name }}" name="sales_name">
                </div>
            </div>

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">جوال مسؤول المبيعات</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->phone2 }}" name="phone2">
                </div>
            </div>

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">البريد الالكتروني  </label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->email }}" name="email">
                </div>
            </div>

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">الرقم الضريبي  </label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->tax_number }}" name="tax_number">
                </div>
            </div>



        </div>

    </div>

    <input type="hidden" value="{{$data->id}}" name="id" />

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin: 0px .25rem;">اغلاق</button>
        <button type="submit" class="btn btn-primary">حفظ</button>
      </div>

</form>

<!-- Required datatable js -->
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>

<script>
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
