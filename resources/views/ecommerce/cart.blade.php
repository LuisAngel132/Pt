@extends('template.interno')
@section('head-content')
<meta name="token" content="{{ Session::get('token') }}">
<meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">

@stop

@section('styles')
<link href="{{ asset('css/progress-bar.css') }}" rel="stylesheet">
@stop

@section('contenido')
<div id="progress-animation-content" style="display: none">
  <div class="progress">
    <div class="indeterminate"></div>
  </div>
</div>
<!--Breadcrumb Start-->
<div class="breadcrumb-area pt-20 pb-20">
 <div class="container">
   <div class="row">
     <div class="col-md-12">
       <div class="breadcrumb-content">
         <ul>
           <li><a href="/"><b>@lang('lang.breadcrumb_index')</b></a></li>
           <li class="active"><b>@lang('lang.shopping_cart')</b></li>
         </ul>
       </div>
     </div>
   </div>
 </div>
</div>

<!--Breadcrumb End-->
<!--Shopping Cart Area Strat-->
<div class="Shopping-cart-area pt-20">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <input type="hidden" name="cart_delete_product" value="@lang('lang.cart_delete_product')">
        <input type="hidden" name="cart_alert_yes" value="@lang('lang.cart_alert_yes')">
        <input type="hidden" name="cart_alert_no" value="@lang('lang.cart_alert_no')">
        <input type="hidden" name="cart_delete_product_confirm" value="@lang('lang.cart_delete_product_confirm')">
      </div>
      <div class="col-md-4">
        <input type="hidden" name="cart_update_cart_confirm" value="@lang('lang.cart_update_cart_confirm')">
      </div>
      <div class="col-md-4"></div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <form action="#">
          <div class="table-content table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="cart-product-name">@lang('lang.remove')</th>
                  <th class="cart-product-name">@lang('lang.images')</th>
                  <th class="cart-product-name">@lang('lang.product')</th>
                  <th class="cart-product-name">@lang('lang.size')</th>
                  <th class="cart-product-name">@lang('lang.unit_price')</th>
                  <th class="cart-product-name">@lang('lang.quantity')</th>
                  <th class="cart-product-name">@lang('lang.total')</th>
                </tr>
              </thead>
              <tbody id="body-table-cart-shop">

              </tbody>
            </table>
          </div>
          <br>
          <span id="count" style="color: transparent;"></span>
          <div id="div-alerts">
          </div>
          <div style="display: none;" id="alert-update-cart">
            <strong class="text-danger">
              <i class="fa fa-warning text-danger"></i>
              @lang('lang.cart_update_stock')
            </strong>
          </div>
          <div class="row">
            <div class="shipping-time col-md-12" style="text-align: right;">

            </div>
            <div class="col-md-8"></div>
            <div class="col-md-4">
              <div class="coupon-all">
                <div class="coupon"></div>
                <div class="coupon2">
                  <input class="button" name="update_cart" value="@lang('lang.update_cart')" type="button">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4 ml-auto">
              <center>
                <div class="cart-page-total">
                  <ul>
                    <li>
                      <label><b>@lang('lang.cart_total'):</b>   <span id="cant-subtotal" class="text-uppercase"></span></label>
                    </li>
                  </ul>
                </div>
              </center>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="coupon-all">
                <div class="coupon"></div>
                <div class="coupon2">
                  <input class="button" id="cart-checkout" value="@lang('lang.cart_checkout')" type="button">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--Shopping Cart Area End-->
@endsection

@section('js')

<script src="js/script/cart.js"></script>

@endsection
