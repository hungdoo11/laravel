<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel </title>
    <link href='http://fonts.googleapis.com/css?family=Dosis:300,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/dest/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/dest/vendors/colorbox/example3/colorbox.css">
    <link rel="stylesheet" href="assets/dest/rs-plugin/css/settings.css">
    <link rel="stylesheet" href="assets/dest/rs-plugin/css/responsive.css">
    <link rel="stylesheet" title="style" href="assets/dest/css/style.css">
    <link rel="stylesheet" href="assets/dest/css/animate.css">
    <link rel="stylesheet" title="style" href="assets/dest/css/huong-style.css">

    <style>
        .beta-dropdown.cart-body {
            display: none;
            position: absolute;
            background: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            z-index: 1000;
            min-width: 300px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .beta-select {
            position: relative;
            cursor: pointer;
        }

        .cart {
            position: relative;
        }
    </style>

</head>

<body>

    <div id="header">
        <div class="header-top">
            <div class="container">
                <div class="pull-left auto-width-left">
                    <ul class="top-menu menu-beta l-inline">
                        <li><a href=""><i class="fa fa-home"></i> 90-92 Lê Thị Riêng, Bến Thành, Quận 1</a></li>
                        <li><a href=""><i class="fa fa-phone"></i> 0163 296 7751</a></li>
                    </ul>
                </div>
                <div class="pull-right auto-width-right">
                    <ul class="top-details menu-beta l-inline">
                        @if(Auth::check())
                        <li><a href="#"><i class="fa fa-user"></i>Chào bạn {{ Auth::user()->full_name }}</a></li>
                        <li><a href="{{ route('getlogout') }} "><i class="fa fa-user"></i>Đăng xuất</a></li>
                        @else
                        <li><a href="{{ route('getsignin') }}">Đăng kí</a></li>
                        <li><a href="{{ route('getlogin') }}">Đăng nhập</a></li>
                        @endif


                    </ul>
                </div>
                <div class="clearfix"></div>
            </div> <!-- .container -->
        </div> <!-- .header-top -->
        <div class="header-body">
            <div class="container beta-relative">
                <div class="pull-left">
                    <a href="" id="logo"><img src="assets/dest/images/logo-cake.png" width="200px" alt=""></a>
                </div>
                <div class="pull-right beta-components space-left ov">
                    <div class="space10">&nbsp;</div>
                    <div class="beta-comp">
                        <form role="search" method="get" id="searchform" action="{{ route('shop.index') }}">
                            <input type="text" value="{{ $search ?? '' }}" name="s" id="s" placeholder="Nhập từ khóa..." />
                            <button class="fa fa-search" type="submit" id="searchsubmit"></button>
                        </form>
                    </div>

                    <div class="beta-comp">
                        @if(Session::has('cart'))
                        <div class="cart">
                            <div class="beta-select">
                                <a href="{{ route('banhang.shopping_cart') }}" style="text-decoration: none; color: inherit;">
                                    <i class="fa fa-shopping-cart"></i> Giỏ hàng (
                                    @if(Session::has('cart'))
                                    {{ Session('cart')->totalQty }}
                                    @else
                                    Trống
                                    @endif
                                    ) <i class="fa fa-chevron-down"></i>
                                </a>
                            </div>

                            <div class="beta-dropdown cart-body">
                                @if(isset($productCarts) && !empty($productCarts))
                                @foreach($productCarts as $product)
                                <div class="cart-item">
                                    <a class="cart-item-delete" href="{{ route('banhang.xoagiohang', $product['item']['id']) }}"><i class="fa fa-times"></i></a>
                                    <div class="media">
                                        <a class="pull-left" href="#"><img src="/source/image/product/{{ $product['item']['image'] }}" alt=""></a>
                                        <div class="media-body">
                                            <span class="cart-item-title">{{ $product['item']['name'] }}</span>
                                            <span class="cart-item-amount">{{ $product['qty'] }}*<span>
                                                    @if($product['item']['promotion_price'] == 0)
                                                    {{ number_format($product['item']['unit_price']) }}
                                                    @else
                                                    {{ number_format($product['item']['promotion_price']) }}
                                                    @endif
                                                </span></span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <p>Giỏ hàng trống</p>
                                @endif

                                <div class="cart-caption">
                                    <div class="cart-total text-right">Tổng tiền: <span class="cart-total-value">{{ $cart->totalPrice ?? 0 }}</span></div>
                                    <div class="clearfix"></div>
                                    <div class="center">
                                        <div class="space10">&nbsp;</div>
                                        <a href="{{ route('banhang.getdathang') }}" class="beta-btn primary text-center">Đặt hàng <i class="fa fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- <div class="beta-comp">


                        @if(Session::has('cart'))
                        <p>Total Qty: {{ Session('cart')->totalQty }}</p>
                        @endif

                        <div class="cart">
                            <div class="beta-select">
                                <a href="{{ route('banhang.shopping_cart') }}" style="text-decoration: none; color: inherit;">
                                    <i class="fa fa-shopping-cart"></i> Giỏ hàng (
                                    @if(Session::has('cart'))
                                    {{ Session('cart')->totalQty }}
                                    @else
                                    Trống
                                    @endif
                                    ) <i class="fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>
                    </div> -->
                    <div class="clearfix"></div>
                </div> <!-- .container -->
            </div> <!-- .header-body -->
            <div class="header-bottom" style="background-color: #0277b8;">
                <div class="container">
                    <a class="visible-xs beta-menu-toggle pull-right" href="#"><span class='beta-menu-toggle-text'>Menu</span> <i class="fa fa-bars"></i></a>
                    <div class="visible-xs clearfix"></div>
                    <nav class="main-menu">
                        <ul class="l-inline ov">
                            <li><a href="{{url('/index')}}">Trang chủ</a></li>
                            <li><a href="{{url('/product')}}">Sản phẩm</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ url('/product_type') }}">Sản phẩm 1</a></li>
                                    <li><a href="{{ url('/product_type') }}">Sản phẩm 2</a></li>
                                    <li><a href="{{ url('/product_type') }}">Sản phẩm 3</a></li>

                                </ul>
                            </li>
                            <li><a href="{{url('/about')}}">Giới thiệu</a></li>
                            <li><a href="{{url('/contacts')}}">Liên hệ</a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </nav>
                </div> <!-- .container -->
            </div> <!-- .header-bottom -->
        </div> <!-- #header -->

        <div class="container">
            @yield('content')
        </div>

        <div id="footer" class="color-div">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="widget">
                            <h4 class="widget-title">Instagram Feed</h4>
                            <div id="beta-instagram-feed">
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="widget">
                            <h4 class="widget-title">Information</h4>
                            <div>
                                <ul>
                                    <li><a href="blog_fullwidth_2col.html"><i class="fa fa-chevron-right"></i> Web Design</a></li>
                                    <li><a href="blog_fullwidth_2col.html"><i class="fa fa-chevron-right"></i> Web development</a></li>
                                    <li><a href="blog_fullwidth_2col.html"><i class="fa fa-chevron-right"></i> Marketing</a></li>
                                    <li><a href="blog_fullwidth_2col.html"><i class="fa fa-chevron-right"></i> Tips</a></li>
                                    <li><a href="blog_fullwidth_2col.html"><i class="fa fa-chevron-right"></i> Resources</a></li>
                                    <li><a href="blog_fullwidth_2col.html"><i class="fa fa-chevron-right"></i> Illustrations</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="col-sm-10">
                            <div class="widget">
                                <h4 class="widget-title">Contact Us</h4>
                                <div>
                                    <div class="contact-info">
                                        <i class="fa fa-map-marker"></i>
                                        <p>30 South Park Avenue San Francisco, CA 94108 Phone: +78 123 456 78</p>
                                        <p>Nemo enim ipsam voluptatem quia voluptas sit asnatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="widget">
                            <h4 class="widget-title">Newsletter Subscribe</h4>
                            <form action="#" method="post">
                                <input type="email" name="your_email">
                                <button class="pull-right" type="submit">Subscribe <i class="fa fa-chevron-right"></i></button>
                            </form>
                        </div>
                    </div>
                </div> <!-- .row -->
            </div><!-- .container -->
        </div> <!-- #footer -->
        <div class="copyright">
            <div class="container">
                <p class="pull-left">Privacy policy. (&copy;) 2014</p>
                <p class="pull-right pay-options">
                    <a href="#"><img src="assets/dest/images/pay/master.jpg" alt="" /></a>
                    <a href="#"><img src="assets/dest/images/pay/pay.jpg" alt="" /></a>
                    <a href="#"><img src="assets/dest/images/pay/visa.jpg" alt="" /></a>
                    <a href="#"><img src="assets/dest/images/pay/paypal.jpg" alt="" /></a>
                </p>
                <div class="clearfix"></div>
            </div><!-- .container -->
        </div> <!-- .copyright -->


        <!-- include js files -->
        <script src="assets/dest/js/jquery.js"></script>
        <script src="assets/dest/vendors/jqueryui/jquery-ui-1.10.4.custom.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="assets/dest/vendors/bxslider/jquery.bxslider.min.js"></script>
        <script src="assets/dest/vendors/colorbox/jquery.colorbox-min.js"></script>
        <script src="assets/dest/vendors/animo/Animo.js"></script>
        <script src="assets/dest/vendors/dug/dug.js"></script>
        <!-- <script src="assets/dest/js/scripts.min.js"></script> -->
        <script src="assets/dest/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
        <script src="assets/dest/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
        <script src="assets/dest/js/waypoints.min.js"></script>
        <script src="assets/dest/js/wow.min.js"></script>
        <!--customjs-->
        <script src="assets/dest/js/custom2.js"></script>
        <script>
            $(document).ready(function($) {
                $(window).scroll(function() {
                    if ($(this).scrollTop() > 150) {
                        $(".header-bottom").addClass('fixNav')
                    } else {
                        $(".header-bottom").removeClass('fixNav')
                    }
                })
            })
        </script>
        <script>
            /* <![CDATA[ */
            jQuery(document).ready(function($) {
                'use strict';


                try {
                    if ($(".animated")[0]) {
                        $('.animated').css('opacity', '0');
                    }
                    $('.triggerAnimation').waypoint(function() {
                        var animation = $(this).attr('data-animate');
                        $(this).css('opacity', '');
                        $(this).addClass("animated " + animation);

                    }, {
                        offset: '80%',
                        triggerOnce: true
                    });
                } catch (err) {

                }

                var wow = new WOW({
                    boxClass: 'wow', // animated element css class (default is wow)
                    animateClass: 'animated', // animation css class (default is animated)
                    offset: 150, // distance to the element when triggering the animation (default is 0)
                    mobile: false // trigger animations on mobile devices (true is default)
                });
                wow.init();
                // NUMBERS COUNTER START
                $('.numbers').data('countToOptions', {
                    formatter: function(value, options) {
                        return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                    }
                });

                // start timer
                $('.timer').each(count);

                function count(options) {
                    var $this = $(this);
                    options = $.extend({}, options || {}, $this.data('countToOptions') || {});
                    $this.countTo(options);
                } // NUMBERS COUNTER END 

                // color box

                //color
                jQuery('#style-selector').animate({
                    left: '-213px'
                });

                jQuery('#style-selector a.close').click(function(e) {
                    e.preventDefault();
                    var div = jQuery('#style-selector');
                    if (div.css('left') === '-213px') {
                        jQuery('#style-selector').animate({
                            left: '0'
                        });
                        jQuery(this).removeClass('icon-angle-left');
                        jQuery(this).addClass('icon-angle-right');
                    } else {
                        jQuery('#style-selector').animate({
                            left: '-213px'
                        });
                        jQuery(this).removeClass('icon-angle-right');
                        jQuery(this).addClass('icon-angle-left');
                    }
                });


            });

            /* ]]> */
        </script>
        <script type="text/javascript">
            $(function() {
                // this will get the full URL at the address bar
                var url = window.location.href;

                // passes on every "a" tag
                $(".main-menu a").each(function() {
                    // checks if its the same on the address bar
                    if (url == (this.href)) {
                        $(this).closest("li").addClass("active");
                        $(this).parents('li').addClass('parent-active');
                    }
                });
            });
        </script>
        <script>
            jQuery(document).ready(function($) {
                'use strict';

                // color box

                //color
                jQuery('#style-selector').animate({
                    left: '-213px'
                });

                jQuery('#style-selector a.close').click(function(e) {
                    e.preventDefault();
                    var div = jQuery('#style-selector');
                    if (div.css('left') === '-213px') {
                        jQuery('#style-selector').animate({
                            left: '0'
                        });
                        jQuery(this).removeClass('icon-angle-left');
                        jQuery(this).addClass('icon-angle-right');
                    } else {
                        jQuery('#style-selector').animate({
                            left: '-213px'
                        });
                        jQuery(this).removeClass('icon-angle-right');
                        jQuery(this).addClass('icon-angle-left');
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function($) {
                $(window).scroll(function() {
                    if ($(this).scrollTop() > 150) {
                        $(".header-bottom").addClass('fixNav')
                    } else {
                        $(".header-bottom").removeClass('fixNav')
                    }
                })
            })
        </script>
        <script>
            $(document).ready(function($) {
                $('.beta-select a').off('click'); // Xóa tất cả sự kiện click hiện có
                $('.beta-select a').on('click', function(e) {
                    e.stopPropagation(); // Ngăn chặn sự kiện lan truyền
                    window.location.href = $(this).attr('href'); // Chuyển hướng thủ công
                });
            });
        </script>
        <script>
            $(document).ready(function($) {
                // Toggle the cart dropdown when clicking on .toggle-cart
                $('.toggle-cart').on('click', function(e) {
                    e.preventDefault();
                    $(this).closest('.cart').find('.beta-dropdown.cart-body').slideToggle();
                });

                // Close the dropdown if clicking outside
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.cart').length) {
                        $('.beta-dropdown.cart-body').slideUp();
                    }
                });
            });
        </script>
        <script>
            jQuery(document).ready(function($) {
                'use strict';

                // color box

                //color
                jQuery('#style-selector').animate({
                    left: '-213px'
                });

                jQuery('#style-selector a.close').click(function(e) {
                    e.preventDefault();
                    var div = jQuery('#style-selector');
                    if (div.css('left') === '-213px') {
                        jQuery('#style-selector').animate({
                            left: '0'
                        });
                        jQuery(this).removeClass('icon-angle-left');
                        jQuery(this).addClass('icon-angle-right');
                    } else {
                        jQuery('#style-selector').animate({
                            left: '-213px'
                        });
                        jQuery(this).removeClass('icon-angle-right');
                        jQuery(this).addClass('icon-angle-left');
                    }
                });
            });
        </script>
</body>

</html>