<!--Morris Chart CSS -->
<link rel="stylesheet" href="{{ URL::asset('public/adminAssets/ar/plugins/morris/morris.css') }}">
<link href="{{ URL::asset('public/adminAssets/ar/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<form action="{{ route('admin.update_level.submit') }}" method="post" enctype="multipart/form-data">

    @csrf
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">اسم القسم</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->title }}" name="title" required>
                </div>
            </div>

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">متفرع من</label>
                <div class="col-sm-12">
                    <select class="form-control select2" name="parent">
                        <option value="0">قسم رئيسي</option>
                        @foreach ($query as $item=>$que)
                            @if ($que->id == $data->parent)
                            <option value="{{$que->id}}" selected>{{$que->title}}</option>
                            @endif
                            <option value="{{$que->id}}">{{$que->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

        <div class="col-lg-6">

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">الكلمات الدلالية</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->meta_keywords }}" name="meta_keywords">
                </div>
            </div>

            <div class="form-group">
                <label for="example-text-input" class="col-sm-12 col-form-label">الوصف</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" value="{{ $data->meta_description }}" name="meta_description">
                </div>
            </div>

            <div class="form-group text-center">
                <label class="pull-right">صورة القسم</label>
                <input type="file" class="filestyle" name="photo" id="photo_link2" data-buttonname="btn-secondary">
                <br>
                @if ($data->photo == Null)
                    <img class="img-thumbnail" id="get_photo_link2" style="width: 200px;" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" data-holder-rendered="true">
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