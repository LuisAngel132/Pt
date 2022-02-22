@extends('template.interno')
@section('contenido')
@section('css-plugin')
<link href="css/magnific-popup.css" rel="stylesheet">
<meta name="token" content="{{ Session::get('token') }}">
<meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
@endsection
<!--Breadcrumb Start-->
<div class="breadcrumb-area pt-20 pb-20">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="breadcrumb-content">
          <ul>
           <li><a href="/"><b>@lang('lang.breadcrumb_index')</b></a></li>
           <li><b>@lang('lang.myaccount')</b></li>
           <li class="active"><b>@lang('lang.favorites')</b></li>
         </ul>
       </div>
     </div>
   </div>
 </div>
</div>
<!--Breadcrumb End-->
<div class="wishlist-area pt-20">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <form action="#">
          <div class="table-content table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="product-remove">@lang('lang.delete')</th>
                  <th class="product-thumbnail">@lang('lang.design')</th>
                  <th class="cart-product-name">@lang('lang.product')</th>
                  <th class="cart-product-name">@lang('lang.genero')</th>
                  <th class="cart-product-name">@lang('lang.style')</th>
                  <th class="product-price">@lang('lang.price')</th>
                </tr>
              </thead>
              <tbody>
                <input id="products-variable-container" type="hidden" name="" value="{{ json_encode($favorites) }}">
                @foreach($favorites as $favorite)
                <tr>
                  <td class="product-remove"><a title="@lang('lang.delete_favorite')"  name="{{ $favorite['id'] }}" class="remove" value="{{ $favorite['id'] }}"><i class="zmdi zmdi-favorite text-danger"></a></td>
                    <td class="product-thumbnail"><a href="{{ $favorite['product_designs'][0]['design_url'] }}" class="image-popup-no-margins"><img src="{{ $favorite['product_designs'][0]['ar_preview'] }}" width="200px" height="200px;"></a></td>
                    <td class="product-name">
                      <a id="{{ $favorite['id'] }}" href="#open-modal" data-toggle="modal" name="{{ $favorite['id']}}" class="search-product-detail-top">
                        <b style="font-size: 20px; color: #24bddf;">{{ $favorite['translations'][0]['name'] }}</b>
                      </a>
                      <br>
                      <span class="amount">
                        {{ $favorite['translations'][0]['description'] }}
                        <span class="amount">
                        </td>
                        <td class="product-name">
                          <span class="amount">
                            {{ $favorite['genres']['translations'][0]['pivot']['genre'] }}
                          </span>
                        </td>
                        <td class="product-name">
                          <span class="amount">
                            {{ $favorite['styles']['translations'][0]['pivot']['style'] }}
                          </span>
                        </td>
                        <td class="product-price"><span class="amount">$ {{ $favorite['translations'][0]['price'] }} @lang('lang.currency_code')</span></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      @include('ecommerce.modal-detail-product')
      @endsection
      @section('js-plugin')
      <script src="js/jquery.magnific-popup.min.js"></script>
      <script src="js/jquery.magnific-popup-init.js"></script>
      @endsection
      @section('js')

      <script src="js/script/js-product.js"></script>
      <script src="js/javascript/favorite.js"></script>
      <script src="js/javascript/product-detail.js"></script>
      @endsection
