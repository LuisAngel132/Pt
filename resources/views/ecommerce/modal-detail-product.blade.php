<div class="modal fade" id="open-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document" style="margin: 0% auto !important;">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><b style="font-size: 25px;">&times;</b></span>
        </button>
      </div>

      <div class="modal-body">
        <input id="product-cart-info" type="hidden" name="">
        <div class="row">
          <div class="col-md-5">
            <div class="tab-content product-details-large" id="myTabContent">
            </div>
            <div class="single-product-menu">
            </div>
          </div>
          <div class="col-md-7">
            <div class="alerts">

              <div class="alert alert-warning alert-dismissible" style="display: none" id="alert-color">
                <a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
                <strong>@lang('lang.alert_warning')</strong>@lang('lang.alert_warning_color')
              </div>

              <div class="alert alert-warning alert-dismissible" style="display: none" id="alert-size">
                <a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
                <strong>@lang('lang.alert_warning')</strong>@lang('lang.alert_warning_size')
              </div>
              <div class="alert alert-warning alert-dismissible" style="display: none" id="alert-quantity">
                <strong>
                  <i class="fa fa-warning"></i>
                  @lang('lang.alert_warning_quantity')
                </strong>
              </div>
              <div class="alert alert-info alert-dismissible" style="display: none" id="alert-add-cart">
                <strong>
                  <i class="zmdi zmdi-shopping-cart-plus"></i>
                  @lang('lang.alert_succes_cart')
                </strong>
              </div>
              <div class="alert alert-warning alert-dismissible" style="display: none" id="alert-stock" role="alert">
                <strong>
                  <i class="fa fa-warning"></i>
                  @lang('lang.alert_warning_stock')
                </strong>
              </div>
              <div class="alert alert-warning alert-dismissible" style="display: none" id="alert-stock-verify" role="alert">
                <strong>
                  <i class="fa fa-warning"></i>
                  @lang('lang.alert_warning_stock_verify')
                  <span class="quantity-exist"></span>
                  @lang('lang.alert_pieces')
                </strong>
              </div>
            </div>
            <div class="single-product-content">
              <div class="product-name-div field-data"></div>
              <div class="product-info field-data"></div>
              <div class="single-product-price">
                <div class="product-discount field-data"></div>
              </div>
              <div class="single-product-reviews field-data"></div>
              <div class="favorite field-data"></div>
              <div class="shipping-time">

              </div>


              <div class="single-product-action">
                <form action="#">
                  <div class="product-variants">
                    <div class="product-variants-item col-md-3">
                      <span class="control-label">@lang('lang.select_size') </span>
                      <select  name="size" id="sizes">
                      </select><br>
                      <a class="btn sizes-guide" style="font-size: 11px; color: #24bddf; margin-left: -11px;">@lang('lang.what_size')</a>
                    </div>
                    <div class="product-variants-item col-md-9">
                      <span class="control-label">Color</span>
                      <ul class="procuct-color field-data">
                      </ul>
                    </div>
                  </div>
                  <div class="product-add-to-cart row product-variants-item" id="ship-box-size-guide" style="display: none;">
                    <div class="col-md-12">
                      <h4><b>@lang('lang.guide_sizes')</b></h4>
                    </div>
                    <div class="col-md-12">
                      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="pills-cm-tab" data-toggle="pill" href="#pills-cm" role="tab" aria-controls="pills-cm" aria-selected="true">CM</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="pills-inch-tab" data-toggle="pill" href="#pills-inch" role="tab" aria-controls="pills-inch" aria-selected="false">IN</a>
                        </li>
                      </ul>
                      <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-cm" role="tabpanel" aria-labelledby="pills-cm-tab">
                          <div class="row">
                            <div class="col-md-12">
                              <table class="table table-cm text-center">
                                <thead>
                                  <tr>
                                    <th>@lang('lang.guide_size')</th>
                                    <th>@lang('lang.guide_length')</th>
                                    <th>@lang('lang.guide_width')</th>
                                    <th>@lang('lang.guide_sleeve')</th>
                                  </tr>
                                </thead>
                                <tbody>

                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="pills-inch" role="tabpanel" aria-labelledby="pills-inch-tab">
                          <div class="row">
                            <div class="col-md-12">
                              <table class="table table-inch text-center">
                                <thead>
                                  <tr>
                                    <th>@lang('lang.guide_size')</th>
                                    <th>@lang('lang.guide_length')</th>
                                    <th>@lang('lang.guide_width')</th>
                                    <th>@lang('lang.guide_sleeve')</th>
                                  </tr>
                                </thead>
                                <tbody>

                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="product-add-to-cart row product-variants-item">
                    <div class="col-md-4">
                      <span class="control-label">@lang('lang.select_quantity') </span>
                      <div class="cart-plus-minus">
                        <input class="cart-plus-minus-box" type="text" name="quantity" value="1" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <center>
                        <div class="add">
                          <input type="hidden" name="id" id="id">
                          <button style="display: none;" class="add-to-cart" id="add-to-cart" type="button"><i class="zmdi zmdi-shopping-cart-plus"></i> @lang('lang.add_to_cart') </button>
                          <br>
                          <label class="badge badge-light stock-label" style="display: none;">
                            <i class="fa fa-cubes"></i> <label id="qty-stock">0</label>
                          @lang('lang.stock')</label>
                        </div>
                      </center>
                    </div>
                    <div class="col-md-2"></div>

                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="input-product-cart">
        <input type="hidden" name="styles_id" id="styles_id">
        <input type="hidden" name="types_id" id="types_id">
        <input type="hidden" name="genres_id" id="genres_id">
        <input type="hidden" name="productcolor" id="id-product-color" value="">
      </div>
    </div>
  </div>
</div>
