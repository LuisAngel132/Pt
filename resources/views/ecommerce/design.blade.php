@extends('template.interno')
@section('css-plugin')
<link href="css/magnific-popup.css" rel="stylesheet">
<meta name="token" content="{{ Session::get('token') }}">
<meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
@endsection
@section('contenido')
<input type="hidden"  id="designs-total" value="{{ $designs->count() }}" >
<!--Breadcrumb Start-->
<div class="breadcrumb-area pt-20 pb-20">
 <div class="container">
   <div class="row">
     <div class="col-md-12">
       <div class="breadcrumb-content">
         <ul>
           <li><a href="/"><b>@lang('lang.breadcrumb_index')</b></a></li>
           <li class="active"><b>@lang('lang.breadcrumb_designs')</b></li>
         </ul>
       </div>
     </div>
   </div>
 </div>
</div>
<!--Breadcrumb End-->
<!--Shop Area Start-->
<div class="shop-area pt-20">
 <div class="container">
   <div class="row">
     <div class="col-lg-9 order-1 order-lg-2">
       <div class="shop-layout">
         <div class="row">
          <div class="col-12">
            <div class="shop-banner">
              @if ($img_category != '')
              <div class="category-cover img-full">
                <img src="{{ $img_category->public_image_url }}" alt="">
              </div>
              @endif
            </div>
          </div>
        </div>
        <!--Grid & List View Start-->
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
      <!--Grid & List View Start-->
      <!--Shop Product -->
      <div class="shop-product">
       <div class="tab-content" id="myTabContent-2">
        <div class="tab-pane fade show active" id="grid">
          <div class="product-grid-view">
            <div class="row">
              <input id="designs-variable-container" type="hidden" name="" value="{{ json_encode($designs) }}">
              @foreach ($designs as $design)
              <div class="col-lg-3 col-md-3">
                <!--Single Product Start-->
                <div class="arubic-single-product">
                  <div class="product-img">
                    <a href="{{$design->designs->public_image_url}}"  class="image-popup-no-margins" data-design='{{ $design }}'>
                      <img class="first-img" src="{{$design->designs->public_image_url}}" alt="">
                    </a>
                    <div class="product-action">
                      <ul>
                        <li><a href="{{$design->designs->public_gif_url}}" class="image-popup-no-margins" data-design='{{ $design }}'><b>RA!</b></a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="product-content">
                    <h4><a style="cursor: default;">{{ $design->designs->nombre }}</a></h4>
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
               @foreach ($designs as $design)
               <div class="col-md-1"></div>
               <div class="col-md-5">
                <div class="arubic-single-product">
                  <div class="product-img shop-list-product">
                    <a href="{{$design->designs->public_image_url }}" class="image-popup-no-margins" data-design='{{ $design }}'>
                      <img class="first-img" src="{{$design->designs->public_image_url}}"alt="" width="80%">
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="product-content shop-list">
                  <h4><a style="cursor: default;">{{ $design->designs->nombre }}</a></h4>
                  <div class="product-action">
                    <ul>
                      <li><a href="{{$design->designs->public_gif_url}}" class="image-popup-no-margins" data-design='{{ $design }}'><b>RA!</b></a></li>
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
          <p id="paging-text"> @lang('lang.paginate')</p>
        </div>
        <div class="page-list">
          {{ $designs->appends(['id' => request('id')])->links() }}
        </div>
      </div>
      <!--Pagination End-->
    </div>
  </div>
  <!--Shop Product -->
</div>
</div>
<div class="col-lg-3 order-2 order-lg-1">
  <div class="shop-sidebar">
    <h4>@lang('lang.filter') </h4>

    @if ( request()->has('id') )
    <a href="{{ url('design') }}" class="btn btn-sm btn-block btn-warning btn-block text-capitalize"><i class="fa fa-times"></i> @lang('lang.clear_filters')</a>
    @endif

    <form action="design" action="get">
      <div class="filter-sub-title">
        <h5>@lang('lang.filter_categories') </h5>
        <div class="categori-checkbox">
          <ul class="category">
            @foreach($category as $key => $valor)
            <li>
              <label class="container-radio">
                <input class="radio-design" type="radio" name="id" value="{{ $valor['base_categories_id'] }}" onclick="window.location = '{{ request()->fullUrlWithQuery(['id' => $valor->base_categories_id, 'page' => 1]) }}'"
                {{ request('id') == $valor->base_categories_id ? 'checked' : '' }}>
                {{ $valor['category'] }}
                <span class="checkmark"></span>
              </label>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
      {{-- <button type="submit" class="default-btn" id="search-products">@lang('lang.filter_search') </button> --}}
    </form>
  </div>
</div>
</div>
</div>
</div>
<!--Shop Area End-->
@endsection
@section('js-plugin')
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/jquery.magnific-popup-init.js"></script>
<script src="js/script/design.js"></script>
@endsection
