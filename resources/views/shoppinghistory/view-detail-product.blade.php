@extends('template.interno')
@section('contenido')
<!--Breadcrumb Start-->
<div class="breadcrumb-area pt-50 pb-50">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="breadcrumb-content">
          <ul>
            <li><a href="/">@lang('lang.menu_home')</a></li>
            <li class="active">
              <a href="single-product.html">@lang('lang.detail_product')</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Breadcrumb End-->
<!--Single Product Start-->
<div class="single-product-area pt-90">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <!--Tab Content Start-->
        <div class="tab-content product-details-large" id="myTabContent-3">
          @foreach ($products as $key => $product)
            @if ($key == 0)
              <div class="tab-pane fade show active" id="single-slide-{{ $key }}">
                <!--Single Product Image Start-->
                <div class="single-product-img img-full change-picture" >
                  <img src="{{$product->products->productsColors->first()->resources->public_image_url }}" alt="">
                  <!--a class="venobox" data-gall="gallery01" href={{ $product->products->productsColors->first()->resources->public_image_url }}"><i class="zmdi zmdi-zoom-in"></i></a-->
                </div>

                <!--Single Product Image End-->
              </div>
            @else
            @if ($product->products->productsColors->first()->resources)
              <div class="tab-pane fade" id="single-slide-{{ $key }}">
                  <!--Single Product Image Start-->
                  <div class="single-product-img img-full change-picture" >
                    <img src="{{$product->products->productsColors->first()->resources->public_image_url}}" alt="">
                    <!--a class="venobox" data-gall="gallery01" href="{{$product->products->productsColors->first()->resources->public_image_url }}"><i class="zmdi zmdi-zoom-in"></i></a-->
                  </div>
                  <!--Single Product Image End-->
                </div>
            @endif

            @endif
          @endforeach
        </div>
        <!--Tab Content End-->
        <!--Tab Menu Start-->
        <div class="single-product-menu">
          <div class="nav single-slide-menu" role="tablist">
            @foreach ($products as $key => $product_min)
              @if ($key == 0 )
                <div class="single-tab-menu img-full">
                  <a class="change-shirt" data-toggle="tab" href="#single-slide-{{ $key }}" name="{{$product_min->products->id  }}"><img src="{{$product_min->products->productsColors->first()->resources->public_image_url }}" alt=""></a>
                </div>
              @else
              @if ($product_min->products->productsColors->first()->resources)
                <div class="single-tab-menu img-full">
                  <a class="change-shirt" data-toggle="tab" href="#single-slide-{{ $key }}" name="{{$product_min->products->id  }}"><img src="{{ $product_min->products->productsColors->first()->resources->public_image_url }}" alt=""></a>
                </div>
              @endif

              @endif
            @endforeach
          </div>
        </div>
          <!--Tab Menu End-->
      </div>
      @foreach ($products as $key => $product_mins)
        @if ($key == 0)
         <div class="col-md-7">
            <div class="single-product-content">
              <h1 class="single-product-name">{{$product_mins->products->productTranslations->first()->name}}</h1>
              <div class="single-product-reviews">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
              </div>
              <div class="single-product-price">
                <div class="product-discount">
                  <span class="price text-uppercase">@lang('lang.currency_code') $ {{  number_format($product_mins->products->productTranslations->first()->price,2)}}</span>

                </div>
              </div>
               @if($id != "")
                @if(empty($products[0]->products->customerLikes[0]))
                <a href="#" class="remove" style="font-size: 20px;" name="{{ $products[0]->products_id }}"> <i class="zmdi zmdi-favorite-outline zmdi-hc-fw"></i></a>
                @else
                  <a href="#" class="remove" style="font-size: 20px;" name="{{ $products[0]->products_id }}"> <i class="zmdi zmdi-favorite zmdi-hc-fw"></i></a>
                @endif
              @endif
              <div class="product-info">
                <p>{{$product_mins->products->productTranslations->first()->description}}</p>
              </div>
              <div class="single-product-action">
                <form >

                    <div class="product-variants-item">
                      <span class="control-label">Color</span>
                      <ul class="procuct-color">
                        @foreach ($product_mins->products->productsColors as $key => $produc_color)
                          <li><a class="change_colors_active" name="{{ $produc_color->id }}"><span class="color" style="background-color:{{$produc_color->colors->hex }} "></span></a></li>
                        @endforeach
                      </ul>
                    </div>
                </form>
              </div>
            </div>
          </div>
        @endif
      @endforeach

    </div>
  </div>
</div>
<!--Single Product End-->
@endsection
@section('js')
<script src="js/script/js-product.js"></script>
<script src="js/javascript/favorite.js"></script>
@endsection
