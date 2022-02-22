<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ph@ra | Aliv3 5hirts</title>
	<meta name="description" content="ecommerce ">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="base_url" content="{{ config('constants.BASE_URL') }}">
  <meta name="paypal_enviroment" content="{{ config('services.paypal.enviroment') }}">
  <meta name="openpay_id" content="{{ config('services.openpay.id') }}">
  <meta name="openpay_api_key" content="{{ config('services.openpay.api_key') }}">
  <meta name="openpay_mode" content="{{ config('services.openpay.mode') }}">

  <!-- SEO Analytics -->
  <meta name="keywords" content="Realidad Aumentada, RA, Tendencias, Augmented Reality, Playeras, Cuatro Punto Cero, Diseños Divertidos, Animación, Shirts, TShirts, Alive Shirts, Producto Mexicano, Hecho en México, Colección, Coleccionable, Ropa Deportiva, Ropa Coleccionable, Innovación, Innovativa, Innovativo, Innovando, Cuarta Revolucion Industrial, Licencias, Moda, Ropa Algodón, Ropa Elastano, Ropa Poliester, Ropa Nailon, Playeras Divertidas, Playeras Coleccionables, Phara, Pharalizate, Ph@ra, Ropa America, Ropa Cruz Azul, Ropa Rayados, Ropa Monterrey, Playeras, Rayados, Cruz Azul, America, Club América, eCommerce, eCommerce, eCommerce, Deportes, App, Deportivo"/>
  <meta name="description" content="Estilo y tecnología juntos en una playera animada, donde por medio de nuestra aplicación y la realidad aumentada podrás darle vida a tu estilo."/>
  <meta name="subject" content="Spreading Technology">
  <meta name="copyright"content="Ph@ra">
  <meta name="language" content="es">
  <meta name="abstract" content="Estilo y tecnología juntos en una playera animada, donde por medio de nuestra aplicación y la realidad aumentada podrás darle vida a tu estilo.">
  <meta name="topic" content="Estilo y tecnología juntos en una playera animada, donde por medio de nuestra aplicación y la realidad aumentada podrás darle vida a tu estilo.">
  <meta name="summary" content="Estilo y tecnología juntos en una playera animada, donde por medio de nuestra aplicación y la realidad aumentada podrás darle vida a tu estilo.">
  <meta name="Classification" content="Business">
  <meta name="owner" content="Ph@ra">
  <meta name="url" content="https://www.phara.shop">
  <meta name="identifier-URL" content="https://www.phara.shop">
  <meta http-equiv="Expires" content="0">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Cache-Control" content="no-cache">

  <!-- OpenGraph metadata-->
  <meta property="og:type" content="business.business">
  <meta property="og:title" content="Ph@ra Aliv3 5hirts">
  <meta property="og:url" content="https://www.phara.shop">
  <meta property="og:image" content="https://phara.shop/images/about.png">
  <meta property="business:contact_data:street_address" content="Benito Juárez">
  <meta property="business:contact_data:locality" content="Torreón">
  <meta property="business:contact_data:region" content="Coahuila">
  <meta property="business:contact_data:postal_code" content="27000">
  <meta property="business:contact_data:country_name" content="Mexico">
  <meta property="business:contact_data:email" content="contacto@phara.shop">
  <meta property="business:contact_data:phone_number" content="+52 (871) 716 7296">
  <meta property="business:contact_data:website" content="https://www.phara.shop">
  <meta property="place:location:latitude" content="25.538308">
  <meta property="place:location:longitude" content="-103.447100">
  <meta property="fb:app_id" content="Phara-2063078077311315">

  <!-- Redirects to official app market place -->
  <script src="{{ asset('js/redirect.js') }}" async></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135119680-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-135119680-1');
  </script>
  <meta name="google-site-verification" content="YWmFmnsADQ-3r2iC-rL-jhPxmTKoiBkhjrX-c_GkNrU" />

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '330510857602374');
      fbq('track', 'PageView');
    </script>
    <noscript>
     <img height="1" width="1" src="https://www.facebook.com/tr?id=330510857602374&ev=PageView&noscript=1"/>
   </noscript>
   <!-- End Facebook Pixel Code -->

  @yield('head-content')
  <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
  <link href="{{ asset('css/material-design-iconic-font.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
  <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
  @yield('css-plugin')
  <link href="{{ asset('css/slick.css') }}" rel="stylesheet">
  <link href="{{ asset('css/nice-select.css') }}" rel="stylesheet">
  <link href="{{ asset('css/meanmenu.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/venobox.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-select.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-social.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-social.less') }}" rel="application/octet-stream">
  <link href="{{ asset('css/bootstrap-social.scss') }}" rel="application/octet-stream">
  <link href="{{ asset('js/sweetalert/sweetalert.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
  <link href="{{ asset('css/card.css') }}" rel="stylesheet">
  <script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }} "></script>
  <style>
  /* The container */
  .container-radio {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  /* Hide the browser's default radio button */
  .container-radio input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
  }

  /* Create a custom radio button */
  .checkmark {
    position: absolute;
    top: 2px;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #eee;
    border: 1px solid #24bddf;
    border-radius: 50%;
  }

  /* On mouse-over, add a grey background color */
  .container-radio:hover input ~ .checkmark {
    background-color: #ccc;
  }

  /* When the radio button is checked, add a blue background */
  .container-radio input:checked ~ .checkmark {
    background-color: #24bddf;
  }

  /* Create the indicator (the dot/circle - hidden when not checked) */
  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }

  /* Show the indicator (dot/circle) when checked */
  .container-radio input:checked ~ .checkmark:after {
    display: block;
  }

  /* Style the indicator (dot/circle) */
  .container-radio .checkmark:after {
    top: 5px;
    left: 5px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
  }
</style>
@yield('styles')
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
                  @if (!Auth::guest())
                  <div class="header-top-phone">
                    <p><span>{{ Auth::user()->people()->first()->full_name}}</span></p>
                  </div>
                  <div class="header-top-phone">
                    <p><span>{{ Auth::user()->email}}</span></p>
                  </div>
                  @endif
                </div>
              </div>
              <div class="col-md-6 col-12">
                <div class="header-top-menu text-right">
                  <ul>
                    <li class="drodown-show"><a href="#">@lang('lang.myaccount') <i class="zmdi zmdi-chevron-down"></i></a>
                      <ul class="ht-dropdown">
                        @if (Auth::guest())
                        <li><a href="{{ url('/login') }}"><i class="fa fa-sign-in" style="color: white;"></i> @lang('lang.login')</a></li>
                        <li><a href="{{ url('/register') }}"><i class="fa fa-user-plus" style="color: white;"></i> @lang('lang.register')</a></li>
                        @else

                        <li><a href="profile"><i class="fa fa-user" style="color: white;"></i> @lang('lang.profile')</a></li>
                        <li><a href="cart"><i class="fa fa-shopping-cart" style="color: white;"></i> @lang('lang.cart')</a></li>
                        <li><a href="favorites"><i class="fa fa-heart" style="color: white;"></i> @lang('lang.favorites')</a></li>
                        <li><a href="shopping-history"><i class="fa fa-shopping-basket" style="color: white;"></i> @lang('lang.history')</a></li>
                        <li><a href="{{ url('/logout') }}"
                          onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                          <i class="fa fa-sign-out" style="color: white;"></i> @lang('lang.logout')
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                        </form>
                      </li>
                      @endif
                    </ul>
                  </li>
                  <li class="drodown-show"><a href="#">@lang('lang.language') <i class="zmdi zmdi-chevron-down"></i></a>
                    <ul class="ht-dropdown">
                      <li><a href="{{ route('change_lang', ['lang' => 'es']) }}">@lang('lang.language_español')</a></li>
                      <li><a href="{{ route('change_lang', ['lang' => 'en']) }}">@lang('lang.language_ingles')</a></li>
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

                <p class="text-uppercase">@lang('lang.welcome') </p>

              </div>
            </div>
            <div class="col-md-4 col-xs-12">
              <div class="logo text-center" style="padding-top: 30px; padding-bottom: 30px;">
                <a href="/"><img src="img/logo_a.png" alt="" width="45%"></a>
              </div>
            </div>
            <div class="col-md-4 col-xs-12">
              <div class="shoppingcart-search-item text-right">
                <ul>
                  <li><!--a class="sidebar-trigger-search" href="#"><i class="zmdi zmdi-search"></i></a--></li>

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
                    <li class="{{ \Request::path() == '/' ? 'active' : '' }}"><a href="/">@lang('lang.menu_home')</a>
                    </li>
                    <li class="{{ \Request::path() == 'category' ? 'active' : '' }}"><a href="category">@lang('lang.menu_category')</a>
                    </li>
                    <li class="{{ \Request::path() == 'design' ? 'active' : '' }}">
                      <a href="design">@lang('lang.menu_desing')  <i class="zmdi"></i></a>
                    </li>
                    <li class="{{ \Request::path() == 'about' ? 'active' : '' }}"><a href="about">@lang('lang.menu_about')  <i class="zmdi"></i></a>
                    </li>
                    <li class="{{ \Request::path() == 'contact' ? 'active' : '' }}"><a href="contact">@lang('lang.menu_contact')  </a></li>
                    <li><a href="cart" class="cart-shop"><i class="zmdi zmdi-shopping-cart-plus {{ \Request::path() == 'cart' ? 'text-info' : '' }}"></i> <span id="nav-item-quantity" class="item-tot"></span></a>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="logo-3 d-none">
                <a href="/"><img src="img/logo_a.png" alt="" width="30%"></a>
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
  <!--div class="main-search-active">
  <div class="sidebar-search-icon">
  <button class="search-close"><span class="zmdi zmdi-close"></span></button>
  </div>
  <div class="sidebar-search-input">
  <form>
  <div class="form-search">
  <input id="search" class="input-text" value="" placeholder="Search Entire Store" type="search">
  <button>
  <i class="zmdi zmdi-search"></i>
  </button>
  </div>
  </form>
  </div>
</div-->
@yield('contenido')
<footer>
  <div class="footer-container">
    <div class="footer-top-area text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1 col-12">
            <div class="footer-logo">
              <a href="/"><img src="img/logo_a.png" alt="" width="20%"></a>
            </div>
            <div class="footer-nav">
              <nav>
                <ul>
                  <li><a href="about">@lang('lang.menu_about')</a></li>
                  <li><a href="faqs">Faqs</a></li>
                  <li><a href="contact">@lang('lang.menu_contact')</a></li>
                  @if (Auth::guest())
                  <li><a href="{{ url('/login') }}">@lang('lang.login')</a></li>
                  <li><a href="{{ url('/register') }}">@lang('lang.register')</a></li>
                  @endif
                </ul>
              </nav>
            </div>
            <div class="footer-social">
              <ul>
                <li><a target="_blank" href="https://www.facebook.com/phara.tshirts/"><i class="fa fa-facebook"></i></a></li>
                <!-- <li><a href="#"><i class="fa fa-twitter"></i></a></li> -->
                <!--  <li><a href="#"><i class="fa fa-youtube"></i></a></li> -->
                <!--  <li><a href="#"><i class="fa fa-google-plus"></i></a></li> -->
                <li><a target="_blank" href="https://www.instagram.com/phara.shop/?hl=en"><i class="fa fa-instagram"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom-area">
      <div class="container text-center">
        <p>© Copyright <a href="/">Ph@ra</a> @lang('lang.all_right') </p>
      </div>
    </div>
  </div>
</footer>

</div>
<script src="{{ asset('js/vendor/jquery-1.12.4.min.js') }} "></script>
<script src="{{ asset('js/console.js') }}" data-environment="{{ app()->environment() }}"></script>
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
<script src="{{ asset('js/bootstrap-select.js') }}" defer></script>
<script src="{{ asset('js/jquery.numeric.js') }}" defer></script>
<script src="{{ asset('js/plugins.js') }}" defer></script>
<script src="{{ asset('js/sweetalert/sweetalert.min.js') }}" defer></script>
<script src="{{ asset('js/sweetalert/jquery.sweet-alert.custom.js') }}" defer></script>
<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
<script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
<script src="{{ asset('js/platform.js') }}" defer></script>
<script src="{{ asset('js/facebook.events.js') }}" defer></script>
@yield('js-plugin')
<script src="{{ asset('js/main.js') }}" defer></script>
<script src="{{ asset('js/script/js-index.js') }}" defer></script>
<script src="{{ asset('js/script/js-cart.js') }}" defer></script>
<script src="{{ asset('js/script/alerts.js') }}" defer></script>
@yield('js')


@if (session()->has('_user_authenticated'))
<script type="text/javascript">
  $(document).ready(function() {
    facebook.events.userAuthenticated({
      customer_id: {{ session()->get('_user_authenticated') }}
    });
  });
</script>
@endif

@if (session()->has('_user_registered'))
<script type="text/javascript">
  $(document).ready(function() {
    facebook.events.userRegistered({
      customer_id: {{ session()->get('_user_registered') }}
    });
  });
</script>
@endif

</body>
</html>
