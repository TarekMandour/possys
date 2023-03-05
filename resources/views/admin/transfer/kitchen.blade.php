@extends( 'admin.layouts.master');


@section('css')
    <link href="{{ URL::asset('public/adminAssets/ar/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet"/>
    <style>
        .product-list-box {
            padding: 0px !important;
            margin-bottom: 10px !important;
        }
    </style>
@endsection

@section('breadcrumb')

    <h1 class="page-title">المطبخ </h1>

@endsection

@section('content')



    <div id="Kitchen">
        <img src="{{url('public/uploads/burger.gif')}}" alt="loading" width="100%" height="100%">
    </div>


@endsection

@section('script')
    <script
        src="{{ URL::asset('public/adminAssets/ar/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ URL::asset('public/adminAssets/ar/plugins/summernote/summernote-bs4.js') }}"></script>
@endsection

@section('script-bottom')


    <script>


        jQuery(document).ready(function () {
            setInterval(function () {
                $.ajax({
                    type: "get",
                    url: "{{url('/')}}/admin/kitchen_data/{{$branch_id}}",
                    success: function (data) {
                        // var result = JSON.parse(data);
                        console.log(data);
                        $('#Kitchen').html(data);


                    }
                });
            }, 5000);//time in milliseconds
        });
    </script>


    <script>

        function myFunction(id) {

            $.ajax({
                type: "get",
                url: "{{url('/')}}/admin/order_confirmed/" + id,
                success: function (data) {
                    this.disabled = true;
                    this.value = 'جارى التحميل...';
                }
            });
        }
    </script>

@endsection
