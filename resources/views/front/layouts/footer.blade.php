<!-- footer blade -->
<footer class="bg-overlay-1 bg-black">
    <div class="footer-upper pt-100 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-4 order-2 order-lg-1">
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 order-1 order-lg-2">
                    <div class="footer-content-item text-start text-lg-center">
                        <div class="footer-logo">
                            <a href="javascript:(void);"><img
                                    src="{{ URL::asset('public/uploads/posts') }}/{{$Settings->logo1}}" alt="logo"></a>
                        </div>
                        <ul class="footer-details footer-address">
                            <li> {{$Settings->address}}</li>
                            <li><span>الخط الساخن :</span><a
                                    href="tel: {{$Settings->phone1}}"> {{$Settings->phone1}}</a></li>
                        </ul>
                        <div class="footer-follow">
                            <p>تابعنا على:</p>
                            <ul class="social-list social-list-white">
                                <li><a href="{{$Settings->facebook}}"><i class="flaticon-facebook"></i></a></li>
                                <li><a href="{{$Settings->twitter}}"><i class="flaticon-twitter"></i></a></li>
                                <li><a href="{{$Settings->linkedin}}"><i class="flaticon-linkedin"></i></a></li>
                                <li><a href="{{$Settings->youtube}}"><i class="flaticon-youtube"></i></a></li>
                                <li><a href="{{$Settings->instagram}}"><i class="flaticon-instagram-1"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 order-3">
                </div>
            </div>
        </div>
    </div>
    <div class="footer-lower">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="footer-lower-item">
                    <div class="footer-copyright-text footer-copyright-text-red">
                        <p>Copyright ©{{\Carbon\Carbon::now()->format('Y')}} Design &amp; Developed By <a
                                href="https://arabiacode.com/" target="_blank">Arabiacode</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<div class="cart-modal-wrapper">
    <div class="cart-modal modal-item">
        <div class="cart-modal-header">
            <h3 class="color-white">سلة الشراء</h3>
            <div class="cart-modal-close">
                <i class="flaticon-cancel"></i>
            </div>
        </div>
        <div class="cart-modal-body">
            <h2 class="color-white">الطلب</h2>
            @php
                $total = 0;
            @endphp
            @if(Session::get('cart'))
            @foreach(Session::get('cart') as $key=>  $cart_item)
                @php
                    $total = $total + $cart_item['price'] * $cart_item['quantity'];
                @endphp
                <div class="cart-modal-product">
                    <div class="cart-modal-thumb">
                        <a href="{{url('/home')}}">
                            <img src="{{$cart_item['product']->photo}}" alt="product">
                        </a>
                    </div>
                    <div class="cart-modal-content">
                        <h4><a href="javascript:(void);">{{$cart_item['product']->title}}</a></h4>
                        <div class="cart-modal-action">
                            <div class="cart-modal-action-item">
                                <div class="cart-modal-quantity">
                                    <p>{{$cart_item['quantity']}}</p>
                                    <p>x</p>
                                    <p class="cart-quantity-price">ريال {{$cart_item['price']}}</p>
                                </div>
                            </div>
                            <div class="cart-modal-action-item">
                                <div class="cart-modal-delete">
                                    <a href="{{url('delete-cart/'.$key)}}"><i class="icofont-ui-delete"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @endif
            <div class="cart-modal-total">
                <p>الاجمالي</p>
                <h3>ريال {{$total}}</h3>
            </div>
            <div class="cart-modal-button">
                <a href="{{url('show-cart')}}" class="btn full-width">رؤية سلة الشراء</a>
                <div class="cart-modal-close">  <a href="javascript:(void);" class="btn btn-yellow full-width">  تابع التسوق</a></div>
            </div>


        </div>
    </div>
</div>


<div class="scroll-top" id="scrolltop">
    <div class="scroll-top-inner">
        <span><i class="flaticon-up-arrow"></i></span>
    </div>
</div>

<!-- The Modal -->
{{--<div id="myModal" class="modal cartmodal">--}}

{{--    <!-- Modal content -->--}}
{{--    <div class="modal-content">--}}
{{--        <span class="close">&times;</span>--}}

{{--    </div>--}}

{{--</div>--}}

<div class="modal fade cartmodal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card card-outline-info">
            <div class="modal-header card-header">
                <h3 class="modal-title" id="myLargeModalLabel" style="color: grey">اضف الى العربة</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="{{url('public/front')}}\js\jquery-3.5.1.min.js"></script>
<script src="{{url('public/front')}}\js\bootstrap.bundle.min.js"></script>
<script src="{{url('public/front')}}\js\jquery-ui.js"></script>
<script src="{{url('public/front')}}\js\jquery.timepicker.min.js"></script>
<script src="{{url('public/front')}}\js\jquery.magnific-popup.min.js"></script>
<script src="{{url('public/front')}}\js\owl.carousel.min.js"></script>
<script src="{{url('public/front')}}\js\slick.min.js"></script>
<script src="{{url('public/front')}}\js\jquery.themepunch.revolution.min.js"></script>
<script src="{{url('public/front')}}\js\jquery.themepunch.tools.min.js"></script>
<script src="{{url('public/front')}}\js\extensions\revolution.extension.actions.min.js"></script>
<script src="{{url('public/front')}}\js\extensions\revolution.extension.carousel.min.js"></script>
<script src="{{url('public/front')}}\js\extensions\revolution.extension.kenburn.min.js"></script>
<script src="{{url('public/front')}}\js\extensions\revolution.extension.layeranimation.min.js"></script>
<script src="{{url('public/front')}}\js\extensions\revolution.extension.migration.min.js"></script>
<script src="{{url('public/front')}}\js\extensions\revolution.extension.navigation.min.js"></script>
<script src="{{url('public/front')}}\js\extensions\revolution.extension.parallax.min.js"></script>
<script src="{{url('public/front')}}\js\extensions\revolution.extension.slideanims.min.js"></script>
<script src="{{url('public/front')}}\js\extensions\revolution.extension.video.min.js"></script>
<script src="{{url('public/front')}}\js\jquery-jvectormap-2.0.5.min.js"></script>
<script src="{{url('public/front')}}\js\jquery-jvectormap-world-mill.js"></script>
<script src="{{url('public/front')}}\js\wow.min.js"></script>
<script src="{{url('public/front')}}\js\jquery.ajaxchimp.min.js"></script>
<script src="{{url('public/front')}}\js\form-validator.min.js"></script>
<script src="{{url('public/front')}}\js\contact-form-script.js"></script>
<script src="{{url('public/front')}}\js\jquery.meanmenu.min.js"></script>
<script src="{{url('public/front')}}\js\script.js"></script>

<script>
    // Get the modal
    function myBtn(value) {
        var modal = document.getElementById("myModal");

        modal.style.display = "block";

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }

</script>
@yield('script')

</body>

</html>
