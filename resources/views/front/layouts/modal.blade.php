<div class="col-sm-12 col-md-12 col-lg-12 pb-30">
    <div class="product-details-item">
        <div class="product-details-caption">
            @if(\Carbon\Carbon::now()->subDays(7) < $product->created_at)
                <div class="product-status product-status-danger mb-20">
                    New
                </div>
            @endif
            <h3 class="mb-20 color-white">{{$product->title}}</h3>

            <div class="product-details-price mb-20">
                @if($product->new_price_leasing > 0)
                    <h4>
                        {{$product->new_price_leasing}}ريال
                        <del style="color: grey">{{$product->new_price_sell}}ريال</del>
                    </h4>
                @else
                    <h4>
                        {{$product->new_price_sell}}ريال
                    </h4>
                @endif
            </div>
            @if($Settings->website_type == "sell")
                <form action="{{url('add-cart')}}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <div class="row">
                    @if($product->attributes)
                        <div class="col-sm-12 col-md-6 mb-20">
                            @php
                                $attrname = [];
                            @endphp
                            @foreach($product->attributes as $key => $att)
                                @if(!in_array($att->attribute_name , $attrname))
                                    <h4 style="color: grey">{{$att->attribute_name}}:</h4>
                                    @php
                                        $i =1;
                                        array_push($attrname ,$att->attribute_name )
                                    @endphp
                                @else
                                    @php
                                        $i++
                                    @endphp

                                @endif

                                {{--                                    <ul class="product-size-list">--}}

                                <div class="cart-check-box mb-10">
                                    <input type="radio" name="attribute[{{$att->attribute_name}}][option]" value="{{$att->attribute_name}},{{$att->attribute_option}},{{$att->attribute_price}}" @if($i==1) checked @endif id="{{$att->attribute_name}}{{$key}}">
                                    <label for="{{$att->attribute_name}}{{$key}}">
                                        {{$att->attribute_option}}
                                        (+{{$att->attribute_price}}ريال)
                                    </label>
                                    <input type="hidden" name="attribute[{{$att->attribute_name}}][name]"
                                       value="{{$att->attribute_name}}">
                                    <input type="hidden" name="attribute[{{$att->attribute_name}}][price]"
                                       value="{{$att->attribute_price}}">
                                </div>
                                
                                {{--                                    </ul>--}}
                            @endforeach
                        </div>
                    @endif
                    @if($product->additions)
                        <div class="col-sm-12 col-md-6 mb-20">
                            <h4 style="color: grey">الاضافات :</h4>
                                @foreach($product->additions as $key => $att)

                                <div class="col-sm-12">
                                    <div class="custom-control custom-checkbox mb-20">
                                        <input type="checkbox" class="custom-control-input" name="additions[{{$att->addittion_name}}][name]" value="{{$att->addittion_name}}" id="{{$att->addittion_name}}{{$key}}">
                                        <label class="custom-control-label" for="{{$att->addittion_name}}{{$key}}">
                                            {{$att->addittion_name}}
                                            (+{{$att->addittion_price}}ريال)
                                        </label>
                                    </div>
                                    <input type="hidden" name="additions[{{$att->addittion_name}}][price]"
                                       value="{{$att->addittion_price}}">
                                </div>

                                @endforeach
                        </div>
                    @endif
                    </div>
                    <div class="product-action-info mb-20">
                        <div class="d-flex flex-wrap align-items-center
                                    product-quantity">

                            <button class="btn btn-icon product-quantity-item" type="submit">
                                اضف الى العربة
                                <i class="flaticon-shopping-cart-black-shape"></i>
                            </button>

                            <div class="cart-quantity product-quantity-item">
                                <a class="qu-btn dec">-</a>
                                <input type="text" class="qu-input" value="1">
                                <input type="hidden" name="quantity" id="qu-input" value="1">


                                <a class="qu-btn inc">+</a>
                            </div>
                        </div>
                    </div>
                </form>
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
