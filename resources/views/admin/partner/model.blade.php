<!--Morris Chart CSS -->
<link rel="stylesheet" href="{{ URL::asset('public/adminAssets/ar/plugins/morris/morris.css') }}">
<link href="{{ URL::asset('public/adminAssets/ar/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />


<form action="{{ route('admin.update_partner.submit') }}" method="post" enctype="multipart/form-data">

    @csrf
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">الاســم</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->title }}" name="title" required>
                </div>
            </div>

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">الرابـط</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->link }}" name="link">
                </div>
            </div>

        </div>

        <div class="col-lg-6">

            <div class="form-group text-center">
                <label class="pull-right">شعار الشركة</label>
                <input type="file" class="filestyle" name="photo" id="photo_link2" data-buttonname="btn-secondary">
                <br>
                @if ($data->photo == Null)
                    <img class="img-thumbnail" id="get_photo_link2" style="width: 200px;" src="https://via.placeholder.com/200x150/EFEFEF/AAAAAA&amp;text=no+image/200x150/EFEFEF/AAAAAA&amp;text=no+image" data-holder-rendered="true">
                @else
                    <img class="img-thumbnail" id="get_photo_link2" style="width: 200px;" src="{{ URL::asset('public/uploads/') }}/{{$data->photo}}" data-holder-rendered="true">
                @endif
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
