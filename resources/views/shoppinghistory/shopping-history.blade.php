@extends('template.interno')
@section('contenido')
@section('css-plugin')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
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
           <li class="active"><b>@lang('lang.shopping_history')</b></li>
         </ul>
       </div>
     </div>
   </div>
 </div>
</div>


<div class="shop-area pt-20">
  <div class="container">
   @if(Session::has('success'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
     {{ Session::get('success') }}
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>
   @endif
   @if(Session::has('error'))
   <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ Session::get('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <div class="row">
    <div class="col-lg-9 order-1 order-lg-2">
      <div class="shop-layout">
        <div class="shop-topbar-wrapper d-md-flex justify-content-md-between align-items-center">
          <div class="grid-list-option">
            <ul class="nav">
              <li>
                <a class="active" data-toggle="tab" href="#grid"><i class="zmdi zmdi-view-module"></i></a>
              </li>
              <li>
                <a data-toggle="tab" href="#list"><i class="zmdi zmdi-view-list"></i></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="shop-product">
          <div class="tab-content" id="myTabContent-2">
           <div class="tab-pane fade show active" id="grid">
             <div class="product-grid-view">
               <input id="orders-container" type="hidden" name="" value="{{ json_encode( $orders ) }}">

               <div class="row">
                 @foreach ($orders as $order)
                 <div class="col-lg-4 col-md-4">
                   <!--Single Product Start-->
                   <div class="arubic-single-product">
                     <div class="product-img">
                       <a name="{{ $order->id }}"  class="btn image-popup-no-margins detail">
                         @foreach($productsColor as $color)
                         @if($color->products_id == $order->orderProducts[0]->products_id && $color->colors_id == $order->orderProducts[0]->colors_id && $color->sizes_id == $order->orderProducts[0]->sizes_id)
                         <img class="first-img" src="{{ $color->resources->galleries[0]->public_image_url }}" alt="">
                         @endif
                         @endforeach
                       </a>
                       <div class="product-action">
                         <ul>
                          @if ($order->orderStatus->id == 6)
                          <li><a href="https://www.logistics.dhl/mx-es/home/rastreo.html?tracking-id={{ $order->shipments[0]->tracking_id }}" target="_blanck" name="{{ $order->id }}"  title="@lang('lang.follow_shipping')"><i class="zmdi zmdi-truck"></i></a></li>
                          @endif
                          <!--li><a class="btn reference" name="{{ $order->id }}"  title="@lang('lang.view_reference')"><i class="zmdi zmdi-file-text"></i></a></li-->
                          @if ($order->orderStatus->id == 8)
                          <li><a href=".Devolution" class="btn devolution" name="{{ $order->id }}" title="@lang('lang.devolution')" data-toggle="modal"><i class="zmdi zmdi-mail-reply"></i></a></li>
                          @endif
                          @if ($order->orderStatus->id == 1 || $order->orderStatus->id == 4)
                          <li><a href=".Cancel" class="cancel" name="{{ $order->id }}" order_id="{{ $order->order_id }}" data-toggle="modal" title="@lang('lang.cancellation')"><i class="zmdi zmdi-close text-danger"></i></a></li>
                          @endif
                        </ul>
                      </div>
                    </div>
                    <div class="product-content">
                     <h4><a name="{{ $order->id }}"  class="detail">@lang('lang.reference_shopping'): {{ $order->order_id }}</a></h4>
                     <div class="product-price">
                       <span class="price text-uppercase"> $ {{  number_format($order->amount,2)}} {{ $order->currency }}</span>
                     </div>
                     <div class="product-des">
                       <p>{{ $order->orderStatus->orderStatusTranslations[0]->status }}</p>
                     </div>
                   </div>
                 </div>
                 <!--Single Product End-->
               </div>
               @endforeach

             </div>
           </div>
         </div>

         <!--En lista-->
         <div class="tab-pane fade" id="list">
           <div class="product-list-view">
            <div class="product-list-item">
              <div class="row">
                <!--Single List Product Start-->
                @foreach ($orders as $order)
                <div class="col-md-1"></div>
                <div class="col-md-5">
                 <div class="arubic-single-product">
                   <div class="product-img shop-list-product">
                     <a name="{{ $order->id }}" class="btn detail">
                       @foreach($productsColor as $color)
                       @if($color->products_id == $order->orderProducts[0]->products_id && $color->colors_id == $order->orderProducts[0]->colors_id && $color->sizes_id == $order->orderProducts[0]->sizes_id)
                       <img class="first-img" src="{{ $color->resources->galleries[0]->public_image_url }}">
                       @endif
                       @endforeach
                     </a>
                   </div>
                 </div>
               </div>
               <div class="col-md-6">
                 <div class="product-content shop-list">
                   <h4><a name="{{ $order->id }}"  class="detail">@lang('lang.reference_shopping'): {{ $order->order_id }}</a></h4>
                   <div class="product-price">
                     <span class="price text-uppercase"> $ {{  number_format($order->amount,2)}}</span>
                   </div>
                   <div class="product-des">
                     <p>{{ $order->orderStatus->orderStatusTranslations[0]->status }}</p>
                   </div>
                   <div class="product-action">
                     <ul>
                       @if ($order->orderStatus->id == 6)
                       <li><a href="https://www.logistics.dhl/mx-es/home/rastreo.html?tracking-id={{ $order->shipments[0]->tracking_id }}" target="_blanck" name="{{ $order->id }}"  title="@lang('lang.follow_shipping')"><i class="zmdi zmdi-truck"></i></a></li>
                       @endif
                       @if ($order->orderStatus->id == 8)
                       <li><a href=".Devolution" class="btn devolution" name="{{ $order->id }}" title="@lang('lang.devolution')" data-toggle="modal"><i class="zmdi zmdi-mail-reply"></i></a></li>
                       @endif
                       @if ($order->orderStatus->id == 1 || $order->orderStatus->id == 4)
                       <li><a href=".Cancel" class="cancel" name="{{ $order->id }}" order_id="{{ $order->order_id }}" data-toggle="modal" title="@lang('lang.cancellation')"><i class="zmdi zmdi-close text-danger"></i></a></li>
                       @endif
                     </ul>
                   </div>
                 </div>
               </div>
               <!--Single List Product Start-->
               @endforeach

             </div>
           </div>
         </div>
       </div>
       <!--Pagination Start-->
       <div class="pagination-product d-md-flex justify-content-md-between align-items-center">
         <div class="showing-product">
           <!--p> @lang('lang.paginate')</p-->
         </div>
         <div class="page-list">
          {{ $orders->appends(['id' => request('id')])->links() }}
        </div>
      </div>
      <!--Pagination End-->
    </div>
  </div>
</div>
</div>
<div class="col-lg-3 order-2 order-lg-1">
  <div class="shop-sidebar">
   <h4>@lang('lang.filter') </h4>

   @if ( request()->has('id') )
   <a href="{{ url('shopping-history') }}" class="btn btn-sm btn-block btn-warning btn-block text-capitalize"><i class="fa fa-times"></i> @lang('lang.clear_filters')</a>
   @endif

   <form action="shopping-history" action="get">
    <div class="filter-sub-title">
      <h5>@lang('lang.order_status') </h5>
      <div class="categori-checkbox">
        <ul class="status">
          @foreach($order_status['data'] as $status)
          <li>
            <label class="container-radio">
              <input type="radio" name="status" value="{{ $status['id'] }}" onclick="window.location = '{{ request()->fullUrlWithQuery(['id' => $status['id'], 'page' => 1]) }}'"
              {{ request('id') == $status['id'] ? 'checked' : '' }}>
              {{ $status['translations'][0]['pivot']['status'] }}
              <span class="checkmark"></span>
            </label>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
    {{--  <button type="submit" class="default-btn" id="search-products">@lang('lang.filter_search') </button> --}}
  </form>
</div>
</div>
</div>
</div>
</div>


<!--modal-->
<div class="modal fade Cancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">@lang('lang.cancel_order')</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <form action="postCancel" method="POST">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="">@lang('lang.cancel_reason')</label>
            <textarea name="reason" id="reason" cols="30" rows="3" placeholder="@lang('lang.cancel_reason_placeholder')"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id" id="id">
          <input type="hidden" name="id_order" id="id_order">
          <button type="submit" class="default-btn">@lang('lang.cancel_btn')</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--end modal-->

<!--modal-->
<div class="modal fade Devolution" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">@lang('lang.return_order')</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <form action="postDevolution" method="POST">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="">@lang('lang.return_reason')</label>
            <textarea name="reason" id="reason" cols="30" rows="3" placeholder="@lang('lang.return_reason_placeholder')"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id" id="id">
          <input type="hidden" name="id_order" id="id_order">
          <input type="hidden" name="products" id="products">
          <button type="submit" class="default-btn">@lang('lang.return_btn')</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--end modal-->
@endsection
@section('js')
<script src="js/javascript/shopping-history.js"></script>
@endsection
