@extends('template.interno')
@section('contenido')
@section('css-plugin')
<link rel="stylesheet" href="css/venobox.css">

@endsection
<!--Breadcrumb Start-->
<div class="breadcrumb-area pt-20 pb-20">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="breadcrumb-content">
          <ul>
           <li><a href="/"><b>@lang('lang.breadcrumb_index')</b></a></li>
           <li><a href="shopping-history"><b>@lang('lang.shopping_history')</b></a></li>
           <li class="active"><b>@lang('lang.reference_shopping'): {{ $order_id }}</b></li>
         </ul>
       </div>
     </div>
   </div>
 </div>
</div>
<!--Breadcrumb End-->
<div class="single-product-area pt-20">
  <div class="container">
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-4">
        <!--Tab Content Start-->
        <div class="tab-content product-details-large" id="myTabContent-3">
          @foreach($order as $product)
          @if ($loop->first)
          <div class="tab-pane fade show active" id="single-slide-{{ $product['id'] }}">
            <!--Single Product Image Start-->
            <div class="single-product-img img-fulls">
              @foreach($product['products']['colors'] as $color)
              @if($color['colors_id'] == $product['colors_id'] && $color['sizes_id'] == $product['sizes_id'])
              <img src="{{ $color['resources']['galleries'][0]['public_image_url'] }}" width="20%">
              <a class="venobox" data-gall="gallery01" href="{{ $color['resources']['galleries'][0]['public_image_url'] }}"><i class="zmdi zmdi-zoom-in"></i></a>
              @endif
              @endforeach
            </div>
            <!--Single Product Image End-->
          </div>
          @else
          <div class="tab-pane fade" id="single-slide-{{ $product['id'] }}">
            <!--Single Product Image Start-->
            <div class="single-product-img img-fulls">
              @foreach($product['products']['colors'] as $color)
              @if($color['colors_id'] == $product['colors_id'] && $color['sizes_id'] == $product['sizes_id'])
              <img src="{{ $color['resources']['galleries'][0]['public_image_url'] }}" alt="">
              <a class="venobox" data-gall="gallery01" href="{{ $color['resources']['galleries'][0]['public_image_url'] }}"><i class="zmdi zmdi-zoom-in"></i></a>
              @endif
              @endforeach
            </div>
            <!--Single Product Image End-->
          </div>
          @endif
          @endforeach
        </div>
        <!--Tab Content End-->
        <div class="single-product-action">
          <div class="product-add-to-cart">
            <!--Tab Menu Start-->
            <div class="single-product-menu">
              <div class="nav single-slide-menu" role="tablist">
                @foreach($order as $product)
                <div class="single-tab-menu">
                  @foreach($product['products']['colors'] as $color)
                  @if($color['colors_id'] == $product['colors_id'] && $color['sizes_id'] == $product['sizes_id'])
                  <a class="active change-product" data-toggle="tab" href="#single-slide-{{ $product['id'] }}" name="{{ $product['id'] }}" order_id="{{ $response['data']['id'] }}">
                    <img src="{{ $color['resources']['galleries'][0]['public_image_url'] }}" alt="" width="70%">
                  </a>
                  @endif
                  @endforeach
                </div>
                @endforeach
              </div>
            </div>
            <!--Tab Menu End-->
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="single-product-content">
          <h1 class="single-product-name name-product">{{ $order[0]['products']['translations'][0]['name'] }}</h1>
          <div class="product-info description-product">
            <p>{{ $order[0]['products']['translations'][0]['description'] }}</p>
          </div>
          <div class="single-product-price">
            <div class="product-discount">
              <span class="price price-product"> $ {{  number_format($order[0]['products']['translations'][0]['price'],2)}} </span> <span class="price text-uppercase"> {{ $currency }}</span>
            </div>
          </div>
          <div class="product-variants-item">
            <span class="control-label"><b>@lang('lang.size'):</b></span> <span class="control-label size-product">{{ $order[0]['sizes']['size'] }}</span>
          </div>
          <div class="product-variants-item">
            <span class="control-label"><b>@lang('lang.qty'):</b></span> <span class="control-label qty-product">{{  $order[0]['qty']}}</span>
          </div>
          <input type="hidden" name="product_id" value="{{ $order[0]['products_id'] }}">

        </div>
      </div>
      <div class="col-md-1"></div>
    </div>
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10">
        <div class="single-product-review-and-description-area mt-60 ">
          <ul class="nav dec-and-review-menu">
            <li>
             <a class="active" data-toggle="tab" href="#description">@lang('lang.rating_title')</a>
           </li>
         </ul>
         <div class="row">
          <div class="col-md-4">
            <div class="rating-user product-review-content-tab" style="display: none;">
              <b><h4><i class="fa fa-comment"></i> @lang('lang.your_comment')</h4></b>
              <br>
              <h6 class="rating-title"></h6>
              <div class="product-reviews-user"></div>
              <p style="word-wrap: break-word; text-align: justify;" class="rating-description"></p>
              <span class="option-rating"></span>
            </div>
            <div class="rating-user-btn" style="display: none;">
              @if ($response['data']['order_status_id'] == 8)
              @if ($errors->any())
              <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>@lang('lang.alert_warning')</strong>
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
              </div>
              @endif
              <button type="button" class="default-btn" id="new-rating" data-toggle="modal" href="#calificar">@lang('lang.rating_btn')</button>
              @endif

            </div>
          </div>
          <div class="col-md-3 text-center product-review-content-tab">
            <b><h2 class="rating-text"></h2></b>
            <div class="product-reviews">
            </div>
            <span>
              <span class="zmdi zmdi-account"></span>
              <span class="total-customer-rating"></span>
              <span>@lang('lang.total_rating')</span>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-1"></div>
  </div>
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
      <div class="single-product-review-and-description-area mt-60 mb-85">
        <!--Review And Description Tab Menu Start-->
        <ul class="nav dec-and-review-menu">
          <li>
           <a class="active" data-toggle="tab" href="#description">@lang('lang.detail_order')</a>
         </li>
       </ul>
       <!--Review And Description Tab Menu End-->
       <!--Review And Description Tab Content Start-->
       <div class="tab-content product-review-content-tab" id="myTabContent-4">
         <div class="tab-pane fade show active" id="description">
           <div class="single-product-description">

            <div class="product-add-to-cart col-md-4 col-xs-12">
              <span class="control-label"><b>Total</b></span>
              <span class="control-label text-uppercase"> {{   $response['data']['amount'],2}}</span>
            </div>

            <div class="product-add-to-cart col-md-4 col-xs-12">
              <span class="control-label"><b>@lang('lang.payment_method')</b></span>
              <span class="control-label">{{ $method }}</span>
            </div>

            <div class="product-add-to-cart col-md-4 col-xs-12">
              <span class="control-label"><b>@lang('lang.status_order')</b></span>
              <span class="control-label">{{ $response['data']['status']['translations'][0]['pivot']['status'] }}</span>
            </div>

            <div class="product-add-to-cart col-md-4 col-xs-12">
              <span class="control-label"><b>@lang('lang.quantity')</b></span>
              <span class="control-label">{{ $quantity }}</span>
            </div>

            @if ($response['data']['shipments'][0]['is_picking_up_at_location'] == false)
            <div class="product-add-to-cart col-md-4 col-xs-12">
              <span class="control-label"><b>@lang('lang.shipping_address')</b></span>
              <span class="control-label">{{ $address['addresses']['addresses']['street'] }} {{ $address['addresses']['addresses']['exterior_number'] }} {{ $address['addresses']['addresses']['city'] }}, {{ $address['addresses']['addresses']['state'] }}, {{ $address['addresses']['addresses']['country'] }} C.P {{ $address['addresses']['addresses']['zipcode'] }}</span>
            </div>
            @else
            <div class="product-add-to-cart col-md-4 col-xs-12">
              <span class="control-label"><b>@lang('lang.pick_up_address')</b></span>
              <span class="control-label">
                Av. Juárez #146 3er piso int-304, <br>
                Col. Centro <br>
                Torreón, Coahuila, México. <br>
                C.P. 27000
              </span>
            </div>
            @endif

            @if ($response['data']['shipments'][0]['is_picking_up_at_location'] == false)
            <div class="product-add-to-cart col-md-4 col-xs-12">
              <span class="control-label"><b>@lang('lang.type_address')</b></span>
              <span class="control-label">{{ $address['addresses']['types']['translations'][0]['pivot']['type'] }}: {{ $address['addresses']['types']['translations'][0]['pivot']['description'] }}</span>
            </div>
            @endif

            @if($response['data']['payment_methods_id'] == 3)
            <div class="product-add-to-cart col-md-4 col-xs-12">
              <span class="control-label"><b>@lang('lang.reference')</b></span>
              <span class="control-label">{{ $response['data']['reference'] }} </span>
            </div>
            @endif

            @if ($response['data']['shipments'][0]['is_picking_up_at_location'] == false)
            <div class="product-add-to-cart col-md-4 col-xs-12">
              <span class="control-label"><b>@lang('lang.tracking_status')</b></span>
              <span class="control-label">{{ $address['status']['translations'][0]['pivot']['status'] }} </span>
            </div>
            @endif

            @if($address['tracking_id'] != null)
            <div class="product-add-to-cart col-md-4 col-xs-12">
              <span class="control-label"><b>@lang('lang.tracking_number')</b></span>
              <span class="control-label">{{ $address['tracking_id'] }} </span>
            </div>
            @endif

            @if($response['data']['voucher_url'] != "")
            <div class="product-add-to-cart col-md-4 col-xs-12">
              <span class="control-label"><b>@lang('lang.view_reference')</b></span>
              <a href="{{ $response['data']['voucher_url'] }}" target="_blank"> <i class="fa fa-file"></i> @lang('lang.click')</a>
            </div>
            @endif

          </div>
        </div>
      </div>
      <!--Review And Description Tab Content End-->
    </div>
  </div>
</div>
<div class="col-md-1"></div>
</div>
</div>

</div>
@include('shoppinghistory.modal-calificar')
@include('shoppinghistory.modal-calificar-edit')
@endsection
@section('js')
<script src="js/javascript/shopping-history.js"></script>
@endsection
