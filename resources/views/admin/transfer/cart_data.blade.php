<table class="table table-hover">
    <thead>
    <tr>
{{--        <th><a href="javascript:;void(0)" class="btn btn-danger" onclick="deleteCartall()">حذف الكل</a></th>--}}
        <th>كود الصنف</th>
        <th>الاسم</th>
        <th>تاريخ الانتهاء</th>
        <th>الكمية</th>

    </tr>
    </thead>
    <tbody>

    @if(Session::get('transfer'))

        @foreach(Session::get('transfer') as $key=> $cart_item)

            <tr>
                <td class="cancel">
                    <a href="javascript:;void(0)" class="btn btn-danger" onclick="deletetransfer({{$key}})"><i class='fa fa-trash'></i></a>
                </td>
                <td class="td-product-name"><a href="javascript:;void(0)" class="text-purple" onclick="edit_itm_code({{$key}})" ><strong>{{$cart_item['itm_code']}}</strong></a></td>
                <td class="td-product-name">{{$cart_item['title_en']}}</td>
                <td class="td-product-name">{{$cart_item['expiry_date']}}</td>
                <td>
                    {{$cart_item['qty']}}
                </td>

            </tr>

        @endforeach

    @endif
    </tbody>
</table>

<script>
    function deletetransfer(id) {
        // var id = $(this).data('id');

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "GET",
            url: "{{url('admin/DeleteTransfer')}}",
            data: {"id": id},
            success: function (data) {
                console.log(data);
                $("#cart").html(data);

            }
        })
    }

    function deleteCartall() {
        // var id = $(this).data('id');

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "GET",
            url: "{{url('admin/alldeletordercart')}}",
            data: {"id": "all"},
            success: function (data) {
                console.log(data);
                $("#cart").html(data);

            }
        })
    }



</script>
