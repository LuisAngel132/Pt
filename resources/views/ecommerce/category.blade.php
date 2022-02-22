@extends('template.interno')
@section('css-plugin')
<meta name="token" content="{{ Session::get('token') }}">
<meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
@endsection
@section('contenido')
<!--Breadcrumb Start-->
<input type="hidden"  id="products-total" value="{{ $producs->count() }}" >
<input id="categories-variable-container" type="hidden" name=""  value="{{ json_encode($categories) }}">
<div class="breadcrumb-area pt-20 pb-20">
  <div class="container">
   <div class="row">
     <div class="col-md-12">
       <div class="breadcrumb-content">
         <ul>
           <li><a href="/"><b>@lang('lang.breadcrumb_index')</b></a></li>
           <li class="active"><b>@lang('lang.breadcrumb_categories')</b></li>
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
                @if ($selectedCategory = $categories->where('base_categories_id', request('categories_id'))->first())
                <h4>{{ $selectedCategory->category }}</h4>
                <div class="category-cover img-full">
                  <img src="{{ $selectedCategory->baseCategories->public_image_url }}" alt="">
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
                  <a id="grid-style" class="active" data-toggle="tab" href="#grid"><i class="zmdi zmdi-view-module"></i></a>
                </li>
                <li>
                  <a id="list-style" data-toggle="tab" href="#list"><i class="zmdi zmdi-view-list"></i></a>
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
                   <input id="products-variable-container" type="hidden" name="" value="{{ json_encode($producs) }}">
                   @foreach ($producs as $produc)
                   @if (count($produc->productsColors) != 0)
                   @if ($produc->productsColors->first()->resources)
                   <div class="col-lg-4 col-md-4">
                    <!--Single Product Start-->
                    <div class="arubic-single-product">
                      <div class="product-img">
                        <a id="{{ $produc->id }}" href="#open-modal" data-toggle="modal" name="{{ $produc->id}}" class="search-product-detail">
                          <img class="first-img" src="{{$produc->productsColors->first()->resources->galleries[0]->public_image_url }}" alt="">
                        </a>
                        <img class="design-gift" id="design-product-{{ $produc->id }}" src="{{$produc->productsDesigns[0]->designs->public_gif_url}}" style="margin-top: -285px; display: none;" >
                        <div class="product-action">
                          <ul>
                            <li>
                              <a  href="#open-modal" data-toggle="modal" name="{{ $produc->id}}" class="search-product-detail"><b><i class="zmdi zmdi-search"></i></b></a></li>
                              <li>
                                <a name="{{ $produc->id}}" data-design="{{ $produc->productsDesigns[0]->designs }}" class="show-design"><b>RA!</b></a>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="product-content">
                          <h4><a id="{{ $produc->id }}" href="#open-modal" data-toggle="modal" name="{{ $produc->id}}" class="search-product-detail">{{ $produc->productTranslations->first()->name}}</a></h4>

                          <div class="product-reviews">
                            @if ($produc->average_rating > 0)
                            @for ($i = 0; $i < 5 ; $i++)
                            @if ($i < $produc->average_rating)
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

                          <div class="product-des">
                            <p>{{ $produc->productTranslations->first()->description}}</p>
                          </div>

                          <div class="product-price">
                            <span class="price">$ {{ number_format($produc->productTranslations->first()->price,2)}} @lang('lang.currency_code')</span>
                          </div>
                          @if($auth != '')
                          @if(count($produc->customerLikes) == 0)
                          <a  class="remove" style="font-size: 20px;" name="{{ $produc['id'] }}"> <i class="zmdi zmdi-favorite-outline zmdi-hc-fw"></i></a>
                          @else
                          <a  class="remove" style="font-size: 20px;" name="{{ $produc['id'] }}"> <i class="zmdi zmdi-favorite zmdi-hc-fw text-danger"></i></a>
                          @endif
                          @endif
                        </div>
                      </div>
                      <!--Single Product End-->
                    </div>
                    @endif
                    @endif

                    @endforeach
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="list">
                <div class="product-list-view">
                  @foreach ($producs as $produc)
                  @if (count($produc->productsColors) != 0)
                  @if ($produc->productsColors->first()->resources)
                  <div class="product-list-item">
                   <div class="row">
                     <!--Single List Product Start-->
                     <div class="col-md-4">
                      <div class="arubic-single-product">
                        <div class="product-img shop-list-product">
                         <a id="{{ $produc->id }}" href="#open-modal" data-toggle="modal" name="{{ $produc->id}}" class="search-product-detail">
                           <img class="first-img" src="{{$produc->productsColors->first()->resources->galleries[0]->public_image_url }}" alt="">
                         </a>
                         <img class="design-gift" id="design-product-list-{{ $produc->id }}" src="{{$produc->productsDesigns[0]->designs->public_gif_url}}" style="margin-top: -285px; display: none;" >
                       </div>
                     </div>
                   </div>
                   <div class="col-md-8">
                    <div class="product-content shop-list">
                      <h4><a href="#open-modal" data-toggle="modal" name="{{ $produc->id}}" class="search-product-detail">{{ $produc->productTranslations->first()->name}}</a></h4>

                      <div class="product-reviews">
                        @if ($produc->average_rating > 0)
                        @for ($i = 0; $i < 5 ; $i++)
                        @if ($i < $produc->average_rating)
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

                      <div class="product-des">
                        <p>{{ $produc->productTranslations->first()->description}}</p>
                      </div>

                      <div class="product-price">
                        <span class="price">$ {{ number_format($produc->productTranslations->first()->price,2)}} @lang('lang.currency_code')</span>
                      </div>

                      @if($auth != '')
                      @if(count($produc->customerLikes) == 0)
                      <a  class="remove" style="font-size: 20px;" name="{{ $produc['id'] }}"> <i class="zmdi zmdi-favorite-outline zmdi-hc-fw"></i></a>
                      @else
                      <a  class="remove" style="font-size: 20px;" name="{{ $produc['id'] }}"> <i class="zmdi zmdi-favorite zmdi-hc-fw text-danger"></i></a>
                      @endif
                      @endif

                      <div class="product-action">
                        <ul>
                          <li><a href="#open-modal" data-toggle="modal" name="{{ $produc->id}}" class="search-product-detail"><b><i class="zmdi zmdi-search"></i></b></a></li>
                          <li>
                            <a name="{{ $produc->id}}" data-design="{{ $produc->productsDesigns[0]->designs }}" class="show-design-list"><b>RA!</b></a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <!--Single List Product Start-->
                </div>
              </div>
              @endif
              @endif
              @endforeach
            </div>
          </div>



          <!--Pagination Start-->
          <div class="pagination-product d-md-flex justify-content-md-between align-items-center">
            <div class="showing-product">
              <p id="paging-text"> @lang('lang.paginate') </p>
            </div>
            <div class="page-list">
              {{ $producs->appends(['categories_id' => request('categories_id'),'styles_id' => request('styles_id'),'genres_id' => request('genres_id')])->links() }}
            </div>
          </div>
          <!--Pagination End-->





          <div class="pagination">

          </div>
        </div>
      </div>
      <!--Shop Product -->
    </div>
  </div>
  <div class="col-lg-3 order-2 order-lg-1">
   <!--category Widget Start-->
   <div class="shop-sidebar">
     <h4>@lang('lang.filter_categories') </h4>
     <div id="shop-cate-toggle" class="category-menu sidebar-menu sidbar-style">
      <ul class="category-sub-menu">
        @foreach ($categories as $category)
        <li>
          <a class="link_category {{ request('categories_id') == $category->base_categories_id ? 'active' : '' }}"
            href="{{ request()->fullUrlWithQuery(['categories_id' => $category->base_categories_id, 'page' => 1]) }}">{{ $category->category }}</a>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
    <!--category Widget Start-->

    <!--Filter Widget Start-->
    <div class="shop-sidebar">
     <h4>@lang('lang.filter') </h4>

     @if (request()->has('categories_id') || request()->has('styles_id') || request()->has('genres_id'))
     <a href="{{ url('category') }}" class="btn btn-sm btn-block btn-warning btn-block text-capitalize"><i class="fa fa-times"></i> @lang('lang.clear_filters')</a>
     @endif

     <!--Properties Checkbox Start-->
     <form action="" id="form-filter">
       <div class="filter-sub-title">
         <h5>@lang('lang.filter_gender') </h5>
         <div class="categori-checkbox">
          <ul>
            @foreach ($genres as $item)
            <li>
              <label class="container-radio">
                <input type="radio" name="genres_id" value="{{ $item->product_genres_id }}"
                onclick="window.location = '{{ request()->fullUrlWithQuery(['genres_id' => $item->product_genres_id, 'page' => 1]) }}'"
                {{ request('genres_id') == $item->product_genres_id ? 'checked' : '' }}>
                {{ $item->genre }}
                <span class="checkmark"></span>
              </label>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
      <!--Properties Checkbox End-->
      <!--Styles Checkbox Start-->
      <div class="filter-sub-title">
       <h5>@lang('lang.filter_style') </h5>
       <div class="categori-checkbox">
        <ul>
          @foreach ($styles as $item)
          <li>
            <label class="container-radio">
              <input type="radio" name="styles_id" value="{{ $item->product_styles_id }}"
              onclick="window.location = '{{ request()->fullUrlWithQuery(['styles_id' => $item->product_styles_id, 'page' => 1]) }}'"
              {{ request('styles_id') == $item->product_styles_id ? 'checked' : '' }}>
              {{ $item->style }}
              <span class="checkmark"></span>
            </label>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </form>
  <!--Styles Checkbox End-->

</div>
<!--Filter Widget Start-->
</div>
</div>
</div>
</div>
<!--Shop Area End-->
@include('ecommerce.modal-detail-product')
@endsection
@section('js')
<script src="js/script/category.js"></script>
@endsection
