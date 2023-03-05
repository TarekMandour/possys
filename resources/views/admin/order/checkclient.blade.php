<div class="col-sm-12 col-md-12 col-lg-12 pb-30" dir="rtl">
    <div class="product-details-item">
        <div class="product-details-caption">
            @if ($client)

            <address>
                <strong>{{$client->name}}</strong><br>
                {{$client->phone}}<br>
                {{$client->code}}<br>
                @if ($client->address)
                {{$client->address}}<br>
                @endif
                @if ($client->email)
                {{$client->email}}<br>
                @endif
                @if ($client->location)
                {{$client->location}}<br>
                @endif
            </address>
            @else
            <form id="add-cart-admin">
                @csrf

                <table id="" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <th>الاسم</th>
                            <th><input class="form-control" type="text" value="" id="name" name="name" required></th>
                            <th>رقم الجوال</th>
                            <th><input class="form-control" type="text" value="{{$client_phone}}" id="phone" name="phone" required></th>
                        </tr>
                        <tr>
                            <th>كود العميل </th>
                            <th colspan="3"><input class="form-control" type="text" value="{{rand( 11111, 99999)}}" id="code" name="code"></th>
                        </tr>
                        <tr>
                            <th>البريد الالكتروني</th>
                            <th colspan="3"><input class="form-control" type="text" value="" id="email" name="email"></th>
                        </tr>
                        <tr>
                            <th>العنوان</th>
                            <th colspan="3"><input class="form-control" type="text" value="" id="address" name="address"></th>
                        </tr>
                        <tr>
                            <th>الموقع</th>
                            <th colspan="3"><input class="form-control" type="text" value="" id="location" name="location"></th>
                        </tr>
                    </tbody>
                </table>

                <button type="button" id="submit" class="btn btn-success waves-effect waves-light">اضف </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">الغاء</button>

            </form>
            @endif

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $("#submit").on("click", function (event) {
            $.ajax({
                type: "POST",
                url: "{{url('admin/addclientorder')}}",
                data: $('#add-cart-admin').serialize(),
                success: function (data) {
                    $(".clientmodel").modal('hide');
                    document.getElementById('client_id').value = data;
                    document.getElementById('itm_code').value = '';
                    document.getElementById("itm_code").focus();
                }
            });
        });
    });

</script>
