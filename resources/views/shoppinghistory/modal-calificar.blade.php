<div class="modal fade" id="calificar" tabindex="-1" role="dialog" aria-hidden="true">
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
                <input type="hidden" name="rating_title_1" value="@lang('lang.rating_title_1')">
                <input type="hidden" name="rating_title_2" value="@lang('lang.rating_title_2')">
                <input type="hidden" name="rating_title_3" value="@lang('lang.rating_title_3')">
                <input type="hidden" name="rating_title_4" value="@lang('lang.rating_title_4')">
                <input type="hidden" name="rating_title_5" value="@lang('lang.rating_title_5')">
              </div>

              <form id="form-rating">
                <h3>@lang('lang.rating_title')</h3>
                @csrf
                <div class="alert alert-warning alert-dismissible" style="display: none" id="alert-stars-edit">
                  <a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
                  <strong>@lang('lang.alert_warning')</strong>@lang('lang.alert_warning_stars')
                </div>
                <div class="alert alert-warning alert-dismissible" style="display: none" id="alert-comment-edit">
                  <a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
                  <strong>@lang('lang.alert_warning')</strong>@lang('lang.alert_warning_comment')
                </div>
                <br>
                <p class="clasificacion">
                  <input id="radio1" type="radio" name="rating" value="5">
                  <label class="star" for="radio1">★</label>
                  <input id="radio2" type="radio" name="rating" value="4">
                  <label class="star" for="radio2">★</label>
                  <input id="radio3" type="radio" name="rating" value="3">
                  <label class="star" for="radio3">★</label>
                  <input id="radio4" type="radio" name="rating" value="2">
                  <label class="star" for="radio4">★</label>
                  <input id="radio5" type="radio" name="rating" value="1">
                  <label class="star" for="radio5">★</label>
                </p>
                <h4 class="text-info text-rating-select"></h4>
                <div class="box-rate">
                  <input id="title" type="hidden" class="form-control" name="title"required placeholder="@lang('lang.rating_title_input')">
                  <input type="hidden" name="id_product" value="{{ $order[0]['products_id'] }}">
                  <textarea class="form-control" rows="3" placeholder="@lang('lang.rating_description_input')" required name="description"></textarea>
                </div>
                <button type="button" class="default-btn" id="save-rating">@lang('lang.rating_btn_send')</button>
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

