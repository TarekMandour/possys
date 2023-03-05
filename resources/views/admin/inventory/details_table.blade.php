<table class="table table-hover">
    <thead>
    <tr>

        <th>كود الصنف</th>
        <th>الاسم</th>
        <th>الكمية</th>

    </tr>
    </thead>
    <tbody>
    @foreach($details as $key =>$item)
        <tr>
            <td class="td-product-name"><strong>{{$item->itm_code}}</strong>
            </td>
            <td class="td-product-name">{{\App\Models\Post::where('itm_code',$item->itm_code)->first()->title_en}}</td>
            <td class="td-product-name"><input
                    onchange="editQty({{$item->id}} , this.value)"
                    class="form-control col-md-3" type="number"
                    value="{{$item->qty}}" name="qty" id="qty"></td>



        </tr>
    @endforeach

    </tbody>
</table>
