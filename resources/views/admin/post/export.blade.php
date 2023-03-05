<table>
    <thead>
    <tr>
        <th>الباركود</th>
        <th>اسم المنتج</th>
        <th>السعر قبل الخصم</th>
        <th>السعر بعد الخصم</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $pro)
        <tr>
            <td>{{ $pro->itm_code }}</td>
            <td>{{ $pro->title }}</td>
            @if (isset($pro->StockLast->price_selling))
                <td>
                    {{ $price = round( $pro->StockLast->price_selling + ($pro->StockLast->price_selling * ($Settings->tax / 100) ) ,2) }}
                </td>
                <td>{{ round( $price - ($price * .25) ,2) }}</td>
            @else
                <td>0</td>
                <td>0</td>
            @endif
            
        </tr>
    @endforeach
    </tbody>
</table>