@foreach($products as $product)
    <div class="col-md-6 col-lg-4">
        <div class="inbox-widget">
            <div class="inbox-item">
                <a data-id="{{$product->id}}" onclick="showcart({{$product->id}})" class="show-modal"
                   data-toggle="modal">
                    <div class="inbox-item-img"
                         style="float: right;margin-left: 5px;">

                        <img  src="{{$product->photo}}"
                            class="rounded-circle" alt="">
                    </div>
                    <p class="inbox-item-author">{{$product->title}}</p>

                </a>
            </div>
        </div>
    </div>
@endforeach
