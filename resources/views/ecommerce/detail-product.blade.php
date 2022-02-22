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
                  <span class="price">@lang('lang.currency_code') {{$product_mins->products->productTranslations->first()->price}}</span>

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
                  <div class="product-variants">
                    <div class="product-variants-item">
                      <span class="control-label">@lang('lang.select_size')</span>
                      <select name="size" id="sizes">
                      </select>
                    </div>
                    <div class="product-variants-item">
                      <span class="control-label">Color</span>
                      <ul class="procuct-color">
                        @foreach ($product_mins->products->productsColors as $key => $produc_color)
                          <li><a class="change_colors_active" name="{{ $produc_color->id }}"><span class="color" style="background-color:{{$produc_color->colors->hex }} "></span></a></li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                  <div class="product-add-to-cart">
                    <span class="control-label">@lang('lang.select_quantity')</span>
                    <div class="cart-plus-minus">

                      <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1">
                    </div>
                    <div class="add">
                       <input type="text" name="productcolor" id="product-color-id" value="{{ $product_mins->products->productsColors->first()->id }}">
                      <button class="add-to-cart" id="add-to-cart" type="button"><i class="zmdi zmdi-shopping-cart-plus"></i> @lang('lang.add_to_cart') </button>
                      <span class="product-availability"><i class="zmdi zmdi-check"></i>  @lang('lang.stock') </span>
                    </div>

                  </div>
                </form>
              </div>
            </div>
          </div>
        @endif
      @endforeach

    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="single-product-review-and-description-area mt-60 mb-85">
          <!--Review And Description Tab Menu Start-->
          <ul class="nav dec-and-review-menu">
            <li>
              <a class="active" data-toggle="tab" href="#description">Description</a>
            </li>
            <li>
              <a data-toggle="tab" href="#product-details">Product Details</a>
            </li>
          </ul>
          <!--Review And Description Tab Menu End-->
          <!--Review And Description Tab Content Start-->
          <div class="tab-content product-review-content-tab" id="myTabContent-4">
            <div class="tab-pane fade show active" id="description">
              <div class="single-product-description">
                <p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which has since evolved into a full ready-to-wear collection in which every item is a vital part of a woman's wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>
              </div>
            </div>
            <div class="tab-pane fade" id="product-details">
              <div class="product-details">
                <div class="product-manufacturer">
                  <a href="#">
                    <img src="img/logo/logo.jpg" alt="">
                  </a>
                </div>
                <div class="product-reference">
                    <label class="label">Reference </label>
                    <span class="demo-list">demo_13</span>
                </div>
                <div class="product-quantities">
                  <label class="label">In stock</label>
                  <span class="item">300 Items</span>
                </div>
                <div class="product-out-of-stock"></div>
                <div class="product-features">
                  <h3>Data sheet</h3>
                  <div class="table-responsive">
                    <table class="table">
                          <tr>
                              <td>Compositions</td>
                              <td>Cotton</td>
                          </tr>
                          <tr>
                              <td>Styles</td>
                              <td>Casual</td>
                          </tr>
                          <tr>
                              <td>Properties</td>
                              <td>Short Sleeve</td>
                          </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
            <!--Review And Description Tab Content End-->
        </div>
      </div>
    </div>
  </div>
</div>
<!--Single Product End-->
@endsection
@section('js')
<script src="js/script/js-product.js"></script>
<script src="js/javascript/favorite.js"></script>
@endsection
