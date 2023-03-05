<table class="table table-hover">
    <thead>
    <tr>
        <th><a href="javascript:;void(0)" class="btn btn-danger" onclick="deleteCartall()">حذف الكل</a></th>
        <th>كود الصنف</th>
        <th>الاسم</th>
        <th>تاريخ الانتهاء</th>
        <th>الكمية</th>
        <th>الوحدة</th>
        <th>السعر</th>
        <th>الاجمالي قبل الضريبة</th>
        <th>الضريبة</th>
        <th>الاجمالى</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total_product = 0;
        $total_discount = 0;
        $pre_tax = 0 ;
        $total_sub = 0;
        $total_tax = 0;
        $total = 0;
        $is_discount = 0;
        $discount_price = 0;
        // dd(\App\Models\OrderCart::where('emp_id', Auth::user()->id)->get());
    @endphp
    @if(\App\Models\OrderCart::where('emp_id', Auth::user()->id)->get()->count())

        @foreach(\App\Models\OrderCart::where('emp_id', Auth::user()->id)->get() as $key=> $cart_item)
            @php
                $total_product = round($total_product + ($cart_item['price_selling'] * $cart_item['qty']), 2);
                if ($cart_item['is_tax'] == 1) {
                    $pre_price = $cart_item['price_selling'] * $cart_item['qty'] ;
                    $pre_discount = ($cart_item['price_selling'] * $cart_item['qty']) * ( $cart_item['discount'] / 100);
                    $total_tax = round($total_tax + ($pre_price - $pre_discount) * ($Settings->tax / 100), 2);
                }
                $is_discount += $cart_item['is_discount'];
                $discount_title = $cart_item['discount_title'];
            @endphp
            <tr @if($cart_item['expiry_date'] != null && Carbon\Carbon::parse($cart_item['expiry_date'])->diffInDays(Carbon\Carbon::now()) < 30) style="background-color: #ffd8cf" @endif>
                <td class="cancel">
                    <a href="javascript:;void(0)" class="btn btn-danger" onclick="deleteCart({{$cart_item['id']}})"><i class='fa fa-trash'></i></a>
                </td>
                <td class="td-product-name"><a href="javascript:;void(0)" class="text-purple" onclick="edit_itm_code({{$cart_item['id']}})" ><strong>{{$cart_item['itm_code']}}</strong></a></td>
                <td class="td-product-name">{{$cart_item['title_en']}}</td>
                <td class="td-product-name">
                    @if ($cart_item['expiry_date'])
                    {{Carbon\Carbon::parse($cart_item['expiry_date'])->format("Y-m-d")}}
                    @else
                        ----
                    @endif
                    
                </td>
                <td>
                    {{$cart_item['qty']}}
                </td>
                <td>
                    {{$cart_item['unit_title']}}
                </td>
                <td>
                    {{$cart_item['price_selling']}}
                </td>
                <td>
                    {{$cart_item['price_selling'] * $cart_item['qty']}}
                </td>
                <td>
                    @if ($cart_item['is_tax'] == 1)
                    {{$tax = round(($cart_item['price_selling'] * $cart_item['qty']) * ($Settings->tax / 100), 2)}}
                    @else
                    {{$tax = 0}}
                    @endif
                </td>
                <td>
                    {{round($tax + ($cart_item['price_selling'] * $cart_item['qty']), 2) }}
                </td>
            </tr>

        @endforeach

        

        @if ($is_discount > 0)
            <tr style="width: max-content">
                <td class="no-line" colspan="5"></td>
                <td colspan="3">اجمالي المنتجات: </td>
                <td colspan="2">{{$total_product}} {{$Settings->currency}}</td>
            </tr>
            <tr style="width: max-content">
                <td class="no-line" colspan="5"></td>
                <td colspan="3">خصم الفاتورة: <br> <small>{{$discount_title}}<small></td>
                <td colspan="2">{{$total_discount = round(( $cart_item['discount'] / 100) * $total_product, 2)}} {{$Settings->currency}}</td>
            </tr>
        @endif

        <tr style="width: max-content">
            <td class="no-line" colspan="5"></td>
            <td colspan="3">الاجمالى قبل الضريبة: </td>
            <td colspan="2">{{$total_sub = $total_product - $total_discount }} {{$Settings->currency}}</td>
        </tr>

        <tr style="width: max-content">
            <td class="no-line" colspan="5"></td>
            <td colspan="3">اجمالى الضريبة:  </td>
            <td colspan="2">{{$total_tax }} {{$Settings->currency}}</td>
        </tr>
        <tr style="width: max-content">
            <td class="no-line" colspan="5"></td>
            <td colspan="3">الاجمالى بعد  الضريبة:  </td>
            <td colspan="2">{{$total_sub + $total_tax }} {{$Settings->currency}}</td>
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
            url: "{{url('admin/DeleteCart')}}",
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


        document.getElementById('cash').value = '{{$total_sub + $total_tax }}';
        document.getElementById('online').value = 0;


</script>
