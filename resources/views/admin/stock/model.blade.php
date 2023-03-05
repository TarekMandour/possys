


<div class="col-sm-12 col-md-12 col-lg-12 pb-30" dir="rtl">
    <div class="product-details-item">
        <div class="product-details-caption">
            @if ($product)
            <form action="{{ route('admin.edit_stock.submit') }}" method="post">
                @csrf

                <input type="hidden" name="id" value="{{$stock->id}}">
                <input type="hidden" name="itm_code" value="{{$stock->itm_code}}">

                <table id="" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <th width="100">كود الصنف</th>
                            <th>{{$product->itm_code}}</th>
                            <th width="100">اسم الصنف</th>
                            <th>{{$product->title_en}}</th>
                        </tr>
                        <tr>
                            <th>سعر الشراء</th>
                            <th><input class="form-control" type="number" value="{{$stock->price_purchasing}}" step="0.01" id="price_purchasing" name="price_purchasing"></th>
                            <th>الكمية</th>
                            <th><input class="form-control" type="number" value="{{$stock->qty}}" id="qty" name="qty"></th>
                        </tr>
                        <tr>
                            <th>سعر البيع</th>
                            <th><input class="form-control" type="number" value="{{$stock->price_selling}}" step="0.01" id="price_selling" name="price_selling"></th>
                            <th>سعر البيع الادنى</th>
                            <th><input class="form-control" type="number" value="{{$stock->price_minimum_sale}}" step="0.01" id="price_minimum_sale" name="price_minimum_sale"></th>
                        </tr>
                        <tr>
                            <th>تاريخ الانتاج</th>
                            @if(!empty($stock->production_date)) 
                            <th><input type="date" class="form-control" name="production_date"   value="{{Carbon\Carbon::parse($stock->production_date)->format("Y-m-d")}}" placeholder="تاريخ الانتاج" id="datepicker"></th>
                            @else
                            <th><input type="date" class="form-control" name="production_date"   value="" placeholder="تاريخ الانتاج" id="datepicker"></th>
                            @endif
                            
                            <th>تاريخ الانتهاء </th>
                            @if(!empty($stock->production_date)) 
                            <th><input type="date" class="form-control" name="expiry_date" value="{{Carbon\Carbon::parse($stock->expiry_date)->format("Y-m-d")}}" placeholder="تاريخ الانتهاء" id="datepicker2"></th>
                            @else
                            <th><input type="date" class="form-control" name="expiry_date" value="" placeholder="تاريخ الانتهاء" id="datepicker2"></th>
                            @endif
                            
                        </tr>

                    </tbody>
                </table>

                <button type="submit" class="btn btn-success waves-effect waves-light">حفظ</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">الغاء</button>

            </form>
            @else
            <address>
                <strong>لا يوجد صنف لهذا الرقم</strong>
            </address>
            @endif

        </div>
    </div>
</div>

<script>
    $(".qu-btn").on("click", function (e) {
        var btn = $(this), inp = btn.siblings(".qu-input").val();
        if (btn.hasClass("inc")) {
            var i = parseFloat(inp) + 1;
        } else {
            if (inp > 1) (i = parseFloat(inp) - 1) < 2 && $(".dec").addClass("deact"); else i = 1;
        }
        btn.addClass("deact").siblings("input").val(i)
        getElementById("qu-input").val(i);
    })
</script>
