
<div class="modal fade" id="rating_edit" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div class="text-radio">
                <input type="hidden" name="rating_title_1_edit" value="@lang('lang.rating_title_1')">
                <input type="hidden" name="rating_title_2_edit" value="@lang('lang.rating_title_2')">
                <input type="hidden" name="rating_title_3_edit" value="@lang('lang.rating_title_3')">
                <input type="hidden" name="rating_title_4_edit" value="@lang('lang.rating_title_4')">
                <input type="hidden" name="rating_title_5_edit" value="@lang('lang.rating_title_5')">
              </div>

              <form id="form-rating">
                <h3>@lang('lang.rating_title')</h3>
                @csrf
                <div class="alert alert-warning alert-dismissible" style="display: none" id="alert-stars">
                  <a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
                  <strong>@lang('lang.alert_warning')</strong>@lang('lang.alert_warning_stars')
                </div>
                <div class="alert alert-warning alert-dismissible" style="display: none" id="alert-comment">
                  <a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
                  <strong>@lang('lang.alert_warning')</strong>@lang('lang.alert_warning_comment')
                </div>
                <br>
                <p class="rating-edit-calif">
                  <input id="radio6" type="radio" name="rating_edit" value="5">
                  <label class="star" for="radio6">★</label>
                  <input id="radio7" type="radio" name="rating_edit" value="4">
                  <label class="star" for="radio7">★</label>
                  <input id="radio8" type="radio" name="rating_edit" value="3">
                  <label class="star" for="radio8">★</label>
                  <input id="radio9" type="radio" name="rating_edit" value="2">
                  <label class="star" for="radio9">★</label>
                  <input id="radio10" type="radio" name="rating_edit" value="1">
                  <label class="star" for="radio10">★</label>
                </p>
                <h4 class="text-info text-rating-select-edit"></h4>
                <div class="box-rate">
                  <input id="title_edit" type="hidden" class="form-control" name="title_edit"required placeholder="@lang('lang.rating_title_input')">
                  <input type="hidden" name="id_product_edit" value="{{ $order[0]['products_id'] }}">
                  <textarea class="form-control" rows="3" placeholder="@lang('lang.rating_description_input')" required name="description_edit"></textarea>
                </div>
                <input type="hidden" name="id_product">
                <input type="hidden" name="id_customer_rating">
                <button type="button" class="default-btn" id="edit-rating" >@lang('lang.rating_btn_send')</button>
              </form>
            <div class="col-md-2"></div>
            </div>

        </div>
      </div>
      <div class="modal-footer">
        <div class="input-product-cart">
          <input type="hidden" name="productcolor" id="id-product-color" value="">
        </div>
      </div>
    </div>
  </div>
</div>