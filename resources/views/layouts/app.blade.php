<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | Phara</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/material-design-iconic-font.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('css/meanmenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
    <header>
      <div class="header-container">
        <!--Header Top Area Start-->
        <div class="header-top-area">
          <div class="container">
            <div class="row">
              <div class="col-md-6 col-12">
                <div class="contact-box">
                    <div class="header-top-phone">
                      <p>Call us : <span>(800) 123 4567</span></p>
                  </div>
                  <div class="header-top-phone">
                      <p>email : <span><a href="#">demo@hastech.company</a></span></p>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="header-top-menu text-right">
                  <ul>
                    <li class="drodown-show"><a href="#">@lang('lang.myaccount') <i class="zmdi zmdi-chevron-down"></i></a>
                        <ul class="ht-dropdown">
                            <li><a href="login.html">Login</a></li>
                            <li><a href="checkout.html">Checkout</a></li>
                            <li><a href="register.html">Register</a></li>
                            <li><a href="cart.html">Cart</a></li>
                            <li><a href="wishlist.html">Wishlist</a></li>
                        </ul>
                    </li>
                    <li class="drodown-show"><a href="#">@lang('lang.language') <i class="zmdi zmdi-chevron-down"></i></a>
                        <ul class="ht-dropdown">
                            <li><a href="{{ route('change_lang', ['lang' => 'es']) }}">Español</a></li>
                            <li><a href="{{ route('change_lang', ['lang' => 'en']) }}">English</a></li>
                        </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="header-middle-area">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-md-4 col-xs-12">
                <div class="wellcome-mes">
                  <p>@lang('lang.welcome') </p>
                </div>
              </div>
              <div class="col-md-4 col-xs-12">
                <div class="logo text-center">
                  <a href="index.html"><img src="img/logo/logo.jpg" alt=""></a>
                </div>
              </div>
              <div class="col-md-4 col-xs-12">
                <div class="shoppingcart-search-item text-right">
                  <ul>
                    <li><a class="sidebar-trigger-search" href="#"><i class="zmdi zmdi-search"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="header-bottom-area  header-sticky">
          <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="header-menu-area header-menu-3 text-center">
                        <nav>
                            <ul>
                                <li class="active"><a href="inicio">@lang('lang.menu_home')</a>
                                </li>
                                <li><a href="category">@lang('lang.menu_category')</a>
                                </li>
                                <li>
                                    <a href="design">@lang('lang.menu_desing')  <i class="zmdi"></i></a>
                                </li>
                                    <li><a href="#">@lang('lang.menu_about')  <i class="zmdi"></i></a>
                                    </li>
                                    <li><a href="contact">@lang('lang.menu_contact')  </a></li>
                                    <li><a href="cart" class="cart-shop"><i class="zmdi zmdi-shopping-cart-plus"></i> <span class="item-total"></span></a>
                              </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="logo-3 d-none">
                  <a href="index.html"><img src="img/logo/logo.jpg" alt=""></a>
                </div>
              </div>
              <div class="col-12">
                <div class="mobile-menu d-lg-none d-xl-none"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <main class="py-4">
      @yield('content')
    </main>
    <footer>
      <div class="footer-container">
        <div class="footer-top-area ptb-90 text-center">
          <div class="container">
            <div class="row">
              <div class="col-lg-10 offset-lg-1 col-12">
                <div class="footer-logo">
                  <a href="index.html"><img src="img/logo/logo.jpg" alt=""></a>
                </div>
                <div class="footer-nav">
                    <nav>
                        <ul>
                            <li><a href="#">Legal Notice</a></li>
                            <li><a href="#">Secure payment</a></li>
                            <li><a href="#">Prices drop</a></li>
                            <li><a href="shop.html">New products</a></li>
                            <li><a href="shop.html">Best sales</a></li>
                            <li><a href="about.html">About us</a></li>
                            <li><a href="contact.html">Contact us</a></li>
                            <li><a href="store.html">Stores</a></li>
                            <li><a href="login.html"> Login</a></li>
                            <li><a href="register.html"> Register</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="footer-social">
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
                <div class="footer-newsletter">
                   <form action="http://devitems.us11.list-manage.com/subscribe/post?u=6bbb9b6f5827bd842d9640c82&amp;id=05d85f18ef" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="popup-subscribe-form validate" target="_blank" novalidate>
                     <div id="mc_embed_signup_scroll">
                        <div id="mc-form" class="mc-form subscribe-form" >
                          <input id="mc-email" type="email" autocomplete="off" placeholder="Enter your email here" />
                          <button id="mc-submit">Subscribe !</button>
                        </div>
                     </div>
                   </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-bottom-area">
          <div class="container text-center">
            <p>© Copyright <a href="#">Ph@ra</a>@lang('lang.all_right') </p>
          </div>
        </div>
      </div>
    </footer>
  </div>
<script src="{{ asset('js/vendor/jquery-1.12.4.min.js') }}"></script>
  <script src="{{ asset('js/imagesloaded.pkgd.min.js') }} "></script>
  <script src="{{ asset('js/isotope.pkgd.min.js') }} "></script>
  <script src="{{ asset('js/jquery-ui.min.js') }} "></script>
  <script src="{{ asset('js/waypoints.min.js') }} "></script>
  <script src="{{ asset('js/owl.carousel.min.js') }} "></script>
  <script src="{{ asset('js/slick.min.js') }} "></script>
  <script src="{{ asset('js/jquery.nice-select.min.js') }} "></script>
  <script src="{{ asset('js/jquery.meanmenu.min.js') }} "></script>
  <script src="{{ asset('js/instafeed.min.js') }} "></script>
  <script src="{{ asset('js/jquery.scrollUp.min.js') }} "></script>
  <script src="{{ asset('js/wow.min.js') }} "></script>
  <script src="{{ asset('js/venobox.min.js') }} "></script>
  <script src="{{ asset('js/popper.min.js') }} "></script>
  <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
  <script src="{{ asset('js/plugins.js') }}" defer></script>
  <script src="{{ asset('js/main.js') }}" defer></script>
</body>
</html>
