@extends('template.interno')
@section('css-plugin')
<link href="css/magnific-popup.css" rel="stylesheet">
<meta name="token" content="{{ Session::get('token') }}">
<meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
@endsection

@section('styles')
<link rel="stylesheet" href="css/modal.css">
@stop

@section('contenido')
<!--Slider Area Start-->
<div class="slider-area">
  <div class="hero-slider owl-carousel">
    <!--Single Slider Start-->
    <div class="single-slider-3" style="background-image: url(img/sliders/bg-slider-0.jpg)">
      <div class="slider-progress"></div>
      <div class="container">
        <div class="hero-slider-content-3">
          <img src="img/emblemas/RA-emblema.png" width="100px" height="100px">
          <h1>#PHARALÍZATE</h1>
          <h3>@lang('lang.slider_0')</h3>
          <div class="slider-btn-2">
          </div>
        </div>
      </div>
    </div>
    <!--Single Slider End-->
    <!--Single Slider Start-->
    <div class="single-slider-3" style="background-image: url(img/sliders/bg-slider-1.jpg)">
      <div class="slider-progress"></div>
      <div class="container">
        <div class="hero-slider-content-3">
          <img src="img/emblemas/rayados-emblema.png" width="100px" height="100px">
          <h1>CLUB MONTERREY</h1>
          <h3>@lang('lang.slider_1')</h3>
          <div class="slider-btn-2">
          </div>
        </div>
      </div>
    </div>
    <!--Single Slider End-->
    <!--Single Slider Start-->
    <div class="single-slider-3" style="background-image: url(img/sliders/bg-slider-2.jpg)">
      <div class="slider-progress"></div>
      <div class="container">
        <div class="hero-slider-content-3">
          <img src="img/emblemas/america-emblema.png" width="100px" height="100px">
          <h1>S13mpre águilas</h1>
          <h3>@lang('lang.slider_2')</h3>
          <div class="slider-btn-2">
          </div>
        </div>
      </div>
    </div>
    <!--Single Slider End-->
    <!--Single Slider Start-->
    <div class="single-slider-3" style="background-image: url(img/sliders/bg-slider-3.jpg)">
      <div class="slider-progress"></div>
      <div class="container">
        <div class="hero-slider-content-3">
          <img src="img/emblemas/cruzazul-emblema.png" width="100px" height="100px">
          <h1>Llegó la Máquina</h1>
          <h3>@lang('lang.slider_3')</h3>
          <div class="slider-btn-2">

          </div>
        </div>
      </div>
    </div>
    <!--Single Slider End-->
  </div>
</div>
<!--Slider Area End-->

<!--Banner Section Area Start-->
<div class="banner-section-area mb-90">
  <div class="container-fluid ">
    <div id="banner-container">
      <!--Show banners-->
    </div>
  </div>
</div>
<!--Banner Section Area End-->

<!-- Feature Product Section Start -->
<div class="product-section mb-25">
  <div class="container">
    <div class="row">
      <!--Section Title Start-->
      <div class="col-12">
        <div class="section-title mb-50 text-center">
          <h2>@lang('lang.feature') </h2>
          <p>@lang('lang.feature_text') </p>
        </div>
      </div>
      <!--Section Title End-->
      <!--Product Start-->
      <div class="col-12">
        <div class="product-slider-wrap row">
          <input id="products-variable-container" type="hidden" name="" value="{{ json_encode($top) }}">
          <div class="product-slider owl-carousel">
            @if (count($top) <= 4)
            @foreach ($top->chunk(1) as $chunk)
            <div class="product-group">
              @foreach ($chunk as $product)
              <div id="{{ $product['id'] }}" class="arubic-single-product">
                <div class="product-img">
                  <a id="{{ $product['id'] }}" href="#open-modal" data-toggle="modal" name="{{ $product['id']}}" class="search-product-detail-top">
                    <img class="first-img" src="{{ $product['colors']['resources']['galleries'][0]['public_image_url'] }}">
                  </a>
                  <img class="design-gift" id="design-product-{{ $product['id'] }}" src="{{$product['product_designs'][0]['ar_preview']}}" style="margin-top: -285px; display: none;" >
                  <div class="product-action">
                    <ul>
                      <li>
                        <a id="{{ $product['id'] }}" href="#open-modal" data-toggle="modal" name="{{ $product['id']}}" class="search-product-detail-top">
                          <b><i class="zmdi zmdi-search"></i></b>
                        </a>
                      </li>
                      <li>
                        <a name="{{ $product['id']}}" data-design='{{ json_encode($product["product_designs"][0]) }}' class="show-design">
                          <b>RA!</b>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="product-content">
                  <h4>
                    <a id="{{ $product['id'] }}" href="#open-modal" data-toggle="modal" name="{{ $product['id']}}" class="search-product-detail-top">
                      {{ $product['translations'][0]['name'] }}
                    </a>
                  </h4>

                  <div class="product-reviews">
                    @if ($product['average_rating'] > 0)
                    @for ($i = 0; $i < 5 ; $i++)
                    @if ($i < $product['average_rating'])
                    <i class="fa fa-star text-warning"></i>
                    @else
                    <i class="fa fa-star-o text-muted"></i>
                    @endif
                    @endfor
                    @else
                    @for ($i = 0; $i < 5 ; $i++)
                    <i class="fa fa-star-o text-muted"></i>
                    @endfor
                    @endif
                  </div>

                  <div class="product-price">
                    <span class="price">$ {{ number_format($product['translations'][0]['price'],2) }} @lang('lang.currency_code')</span>
                  </div>
                  @php
                  $like = json_decode($product['liked_by_me'], true);
                  @endphp
                  @if($id != '')
                  @if($like == false)
                  <a  class="remove" style="font-size: 20px;" name="{{ $product['id'] }}"> <i class="zmdi zmdi-favorite-outline zmdi-hc-fw"></i></a>
                  @else
                  <a  class="remove" style="font-size: 20px;" name="{{ $product['id'] }}"> <i class="zmdi zmdi-favorite zmdi-hc-fw text-danger"></i></a>
                  @endif
                  @endif
                </div>

              </div>
              @endforeach
            </div>
            @endforeach
            @else
            @foreach ($top->chunk(2) as $chunk)
            <div class="product-group">
              @foreach ($chunk as $product)
              <div id="{{ $product['id'] }}" class="arubic-single-product">
                <div class="product-img">
                  <a id="{{ $product['id'] }}" href="#open-modal" data-toggle="modal" name="{{ $product['id']}}" class="search-product-detail-top">
                    <img class="first-img" src="{{ $product['colors']['resources']['galleries'][0]['public_image_url'] }}">
                  </a>
                  <img class="design-gift" id="design-product-{{ $product['id'] }}" src="{{$product['product_designs'][0]['ar_preview']}}" style="margin-top: -285px; display: none;" >
                  <div class="product-action">
                    <ul>
                      <li>
                        <a id="{{ $product['id'] }}" href="#open-modal" data-toggle="modal" name="{{ $product['id']}}" class="search-product-detail-top">
                          <b><i class="zmdi zmdi-search"></i></b>
                        </a>
                      </li>
                      <li>
                        <a name="{{ $product['id']}}" data-design='{{ json_encode($product["product_designs"][0]) }}' class="show-design">
                          <b>RA!</b>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="product-content">
                  <h4>
                    <a id="{{ $product['id'] }}" href="#open-modal" data-toggle="modal" name="{{ $product['id']}}" class="search-product-detail-top">
                      {{ $product['translations'][0]['name'] }}
                    </a>
                  </h4>

                  <div class="product-reviews">
                    @if ($product['average_rating'] > 0)
                    @for ($i = 0; $i < 5 ; $i++)
                    @if ($i < $product['average_rating'])
                    <i class="fa fa-star text-warning"></i>
                    @else
                    <i class="fa fa-star-o text-muted"></i>
                    @endif
                    @endfor
                    @else
                    @for ($i = 0; $i < 5 ; $i++)
                    <i class="fa fa-star-o text-muted"></i>
                    @endfor
                    @endif
                  </div>

                  <div class="product-price">
                    <span class="price">$ {{ number_format($product['translations'][0]['price'],2) }} @lang('lang.currency_code')</span>
                  </div>

                  @php
                  $like = json_decode($product['liked_by_me'], true);
                  @endphp
                  @if($id != '')
                  @if($like == false)
                  <a  class="remove" style="font-size: 20px;" name="{{ $product['id'] }}"> <i class="zmdi zmdi-favorite-outline zmdi-hc-fw"></i></a>
                  @else
                  <a  class="remove" style="font-size: 20px;" name="{{ $product['id'] }}"> <i class="zmdi zmdi-favorite zmdi-hc-fw text-danger"></i></a>
                  @endif
                  @endif
                </div>

              </div>
              @endforeach
            </div>
            @endforeach
            @endif
          </div>
        </div>
      </div>
      <!--Product End-->
    </div>
  </div>
</div>
<!-- Feature Product Section End -->
<!-- Call To Action Start -->
<div class="call-to-action-area mb-85">
  <div class="container">
    <div class="contact-static text-center">
      <div class="action-logo mb-20">
        <img src="img/phara-parallax.png" alt="">
        <br>
        <p style="color: white; font-size: 30px;">@lang('lang.text_1') <strong style="color: white; font-size: 30px;">@lang('lang.text_2')</strong><br>
          @lang('lang.text_3') <strong style="color: white; font-size: 30px;">@lang('lang.text_4')</strong> @lang('lang.text_5')</p>
        </div>
        <a class="call-action-btn" target="_blank" href="https://play.google.com/store/apps/details?id=com.asta.t_shirtapp"><img src="img/play-store.png" width="200px"></a>
        <a class="call-action-btn" target="_blank" href="https://itunes.apple.com/mx/app/ph-ra/id1360061103?mt=8"><img src="img/app-store.png" width="200px"></a>
      </div>
    </div>
  </div>
  <!-- Call To Action End -->

  <div class="product-section mb-25">
    <div class="container">
      <div class="row">
        <!--Section Title Start-->
        <div class="col-12">
          <div class="section-title mb-50 text-center">
            <h2>@lang('lang.new_products') </h2>
            <p>@lang('lang.new_products_text') </p>
          </div>
        </div>
        <!--Section Title End-->
        <!--Product Start-->
        <div class="col-12">
          <div class="product-slider-wrap row">
            <input id="products-variable-container" type="hidden" name="" value="{{ json_encode($productsnew) }}">
            <div class="product-slider owl-carousel">
              @foreach ($productsnew as $product)
              <div class="product-group">
                @if (count($product->productsColors) != 0)
                @if ($product->productsColors->first()->resources)
                <div id="{{ $product->id }}" class="arubic-single-product">
                  <div class="product-img">
                    <a id="{{ $product->id }}" href="#open-modal" data-toggle="modal" name="{{ $product->id}}" class="search-product-detail-top">
                      <img class="first-img" src="{{ $product->productsColors->first()->resources->galleries[0]->public_image_url }}">
                    </a>
                    <img class="design-gift" id="design-product-news-{{ $product->id }}" src="{{$product->productsDesigns[0]->designs->public_gif_url}}" style="margin-top: -285px; display: none;" >
                    <span class="new-sticker">@lang('lang.etiq_new')</span>
                    <div class="product-action">
                      <ul>
                        <li>
                          <a id="{{ $product->id }}" href="#open-modal" data-toggle="modal" name="{{ $product->id}}" class="search-product-detail-top">
                            <b><i class="zmdi zmdi-search"></i></b>
                          </a>
                        </li>
                        <li>
                          <a name="{{ $product->id}}" data-design="{{ json_encode($product->productsDesigns[0]->designs) }}" class="show-design-news">
                            <b>RA!</b>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="product-content">
                    <h4>
                      <a id="{{ $product->id }}" href="#open-modal" data-toggle="modal" name="{{ $product->id}}" class="search-product-detail-top">
                        {{ $product->productTranslations->first()->name }}
                      </a>
                    </h4>
                    <div class="product-price">
                      <span class="price">$ {{ number_format($product->productTranslations->first()->price,2) }} @lang('lang.currency_code')</span>
                    </div>
                    {{-- @if($id != '')
                    @if(count($product->customerLikes) == 0)
                    <a  class="remove" style="font-size: 20px;" name="{{ $product['id'] }}"> <i class="zmdi zmdi-favorite-outline zmdi-hc-fw"></i></a>
                    @else
                    <a  class="remove" style="font-size: 20px;" name="{{ $product['id'] }}"> <i class="zmdi zmdi-favorite zmdi-hc-fw text-danger"></i></a>
                    @endif
                    @endif --}}
                  </div>
                </div>
                @endif
                @endif
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <!--Product End-->
      </div>
    </div>
  </div>
  <!-- Product Catalog Area Start -->

  <!-- Product Catalog Area Start -->
  <!-- Feature Section Start -->
  <div class="feature-section gray-bg mb-90 pt-80 pb-50 text-center">
    <div class="container">
      <div class="row">
        <!--Single Feature Start-->
        <div class="col-md-4 col-12 mb-30">
          <div class="arubic-single-feature">
            <div class="feature-icon">
              <img src="img/feature/envio.png" alt="" width="30%">
            </div>
            <div class="feature-content">
              <h3>@lang('lang.free_shipping') </h3>
              <p>@lang('lang.free_shipping_text') </p>
            </div>
          </div>
        </div>
        <!--Single Feature End-->
        <!--Single Feature Start-->
        <div class="col-md-4 col-12 mb-30">
          <div class="arubic-single-feature">
            <div class="feature-icon">
              <img src="img/feature/seguro.png" alt="" width="30%">
            </div>
            <div class="feature-content">
              <h3>@lang('lang.confidence')</h3>
              <p>@lang('lang.confidence_text')</p>
            </div>
          </div>
        </div>
        <!--Single Feature End-->
        <!--Single Feature Start-->
        <div class="col-md-4 col-12 mb-30">
          <div class="arubic-single-feature">
            <div class="feature-icon">
              <img src="img/feature/payment.png" alt="" width="30%">
            </div>
            <div class="feature-content">
              <h3>@lang('lang.payment')</h3>
              <p>@lang('lang.payment_text')</p>
            </div>
          </div>
        </div>
        <!--Single Feature End-->
      </div>
      <br>
      <div class="row" style="background-color: white;">
        <div class="col-md-4">
          <img src="img/cards/logo-card-1.jpg" style="width: 100%;">
        </div>
        <div class="col-md-4">
          <img src="img/cards/logo-card-2.jpg" style="width: 100%;">
        </div>
        <div class="col-md-4">
          <img src="img/cards/logo-card-3.jpg" style="width: 100%;">
        </div>
      </div>
      <div class="row">
        <div class="col-md-2 col-12"></div>
        <div class="col-md-8 col-12">
          <label>@lang('lang.openpay_text'):</label><br>
          <img src="{{ asset('img/openpay.png') }}">
        </div>
        <div class="col-md-2 col-12"></div>
      </div>
    </div>
  </div>
  <!-- Feature Section End -->
  @include('ecommerce.modal-detail-product')
  @endsection
  @section('js-plugin')
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/jquery.magnific-popup-init.js"></script>
  <script src="js/moment.js"></script>
  @endsection
  @section('js')
  <script src="js/script/js-category.js"></script>
  <script src="js/script/js-product.js"></script>
  <script src="js/javascript/product-detail.js"></script>
  @endsection
