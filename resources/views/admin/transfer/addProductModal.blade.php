<div class="col-sm-12 col-md-12 col-lg-12 pb-30" dir="rtl">
    <div class="product-details-item">
        <div class="product-details-caption">
            @if ($product)
                <form id="add-cart-admin">
                    @csrf

                    <input type="hidden" name="itm_code" value="{{$product->itm_code}}">
                    <input type="hidden" name="title_en" value="{{$product->title_en}}">
                    <input type="hidden" name="sessin_id" value="{{$sessin_id}}">
                    <input type="hidden" name="branch_from_id" value="{{$branch_from_id}}">
                    <input type="hidden" name="branch_to_id" value="{{$branch_to_id}}">

                    <table id="" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                           width="100%">
                        <tbody>
                        <tr>

                            <th width="100">تاريخ الانتهاء</th>
                            <th>
                                <select class="form-control" id="expiry_date" name="expiry_date">
                                    @foreach ($stock as $stk)
                                        <option value="{{$stk->expiry_date}}"> {{$stk->expiry_date}} </option>
                                    @endforeach
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th>الكمية</th>
                            <th><input class="form-control" type="number" value="{{$qty}}" id="qty" name="qty"></th>
                        </tr>
                        </tbody>
                    </table>

                    <button type="button" id="submit" class="btn btn-success waves-effect waves-light">اضف الى الطلب
                    </button>
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

<script>
    $(document).ready(function () {
        $("#submit").on("click", function (event) {
            $.ajax({
                type: "POST",
                url: "{{url('admin/edittransfer')}}",
                data: $('#add-cart-admin').serialize(),
                success: function (data) {
                    $("#cart").html(data);
                    $(".cartmodal").modal('hide');
                    document.getElementById('itm_code').value = '';
                    document.getElementById("itm_code").focus();
                }
            });
        });
    });

</script>
