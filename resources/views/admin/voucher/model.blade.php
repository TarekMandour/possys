<!--Morris Chart CSS -->
<link rel="stylesheet" href="{{ URL::asset('public/adminAssets/ar/plugins/morris/morris.css') }}">
<link href="{{ URL::asset('public/adminAssets/ar/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<form action="{{ route('admin.update_branch.submit') }}" method="post" enctype="multipart/form-data">

    @csrf
    <div class="row">
        <div class="col-lg-12">

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">اسم الفرع</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->name }}" name="name" required>
                </div>
            </div>
            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">رقم الجوال</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->phone }}" name="phone">
                </div>
            </div>
            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">العنوان</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->address }}" name="address">
                </div>
            </div>
            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">الموقع على الخريطة</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->location }}" name="location">
                </div>
            </div>

        </div>


    </div>

    <input type="hidden" value="{{$data->id}}" name="id" />

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin: 0px .25rem;">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
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
