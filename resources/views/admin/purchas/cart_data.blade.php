<table class="table table-hover">
    <thead>
    <tr>
        <th><a href="javascript:;void(0)" class="btn btn-danger" onclick="deleteCartall()">حذف الكل</a></th>
        <th>الاسم</th>
        <th>السعر</th>
        <th>الكمية</th>
        <th>الاجمالي قبل الضريبة</th>
        <th>الضريبة</th>
        <th>الاجمالى</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total_sub = 0;
        $total_tax = 0;
        $total = 0;
        // dd(Session::get('cartPurchas'));
    @endphp
    @if(\App\Models\PurchasCart::where('emp_id', Auth::user()->id)->get()->count())

        @foreach(\App\Models\PurchasCart::where('emp_id', Auth::user()->id)->get() as $key=> $cart_item)
            @php
                $total_sub = round($total_sub + ($cart_item['price_purchasing'] * $cart_item['qty']),2);
                if ($cart_item['is_tax'] == 1) {
                    $total_tax = round($total_tax + ($cart_item['price_purchasing'] * $cart_item['qty']) * ($Settings->tax / 100),2);
                }
                
            @endphp
            <tr>
                <td class="cancel"><a href="javascript:;void(0)" class="btn btn-danger" onclick="deleteCart({{$cart_item['id']}})"><i class='fa fa-trash'></i></a></td>
                <td class="td-product-name">{{$cart_item['title_en']}}</td>
                <td>
                    {{$cart_item['price_purchasing']}}
                </td>
                <td>
                    {{$cart_item['qty']}}
                </td>
                <td>
                    {{$cart_item['price_purchasing'] * $cart_item['qty']}}
                </td>
                <td>
                    @if ($cart_item['is_tax'] == 1)
                    {{$tax = ($cart_item['price_purchasing'] * $cart_item['qty']) * ($Settings->tax / 100)}}
                    @else
                    {{$tax = 0}}
                    @endif
                </td>
                <td>
                    {{round($tax + ($cart_item['price_purchasing'] * $cart_item['qty']),2) }}
                </td>
            </tr>

        @endforeach
        <tr style="width: max-content;">
            <td class="no-line"></td>
            <td colspan="5">الاجمالى قبل الضريبة: </td>
            <td>{{$total_sub}} {{$Settings->currency}}</td>
        </tr>

        <tr style="width: max-content;">
            <td class="no-line"></td>
            <td colspan="5">اجمالى الضريبة:  </td>
            <td>{{$total_tax }} {{$Settings->currency}}</td>
        </tr>
        <tr style="width: max-content">
            <td class="no-line" ></td>
            <td colspan="5">الاجمالى بعد  الضريبة:  </td>
            <td>{{$total_sub + $total_tax }} {{$Settings->currency}}</td>
        </tr>
    @endif
    </tbody>
</table>

<script>
    function deleteCart(id) {
        // var id = $(this).data('id');

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "GET",
            url: "{{url('admin/deletpurchasecart')}}",
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
            url: "{{url('admin/alldeletpurchasecart')}}",
            data: {"id": "all"},
            success: function (data) {
                console.log(data);
                $("#cart").html(data);

            }
        })
    }


        document.getElementById('cash').value = '{{$total_sub + $total_tax }}';
        document.getElementById('online').value = 0;

</script>
