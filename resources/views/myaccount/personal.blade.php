<div class="row">
  <div class="col-lg-12 profile-title">
    <div>
      <h3>@lang('lang.profile_title_info_person')</h3>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-3 profile">
    <div class="box-profile-image text-center">
      {{-- Show image profile --}}
    </div>
    <br>
    <div class="box-code">
      <h3 class="title-code">@lang('lang.title_code'):</h3>
      <h5 class="text-code"></h5>
    </div>
  </div>
  <div class="col-lg-9 profile-info">
    <div class="box-profile-info">
      <form>
        <div class="row">
          <div class="col-md-6">
            <label>@lang('lang.first_name')</label>
            <input id="first_name" type="text" class="form-control" name="first_name" required="">

            <label>@lang('lang.register_last_name_form')</label>
            <input id="last_name" type="text" class="form-control" name="last_name" required="">

            <label>@lang('lang.profile_phone')</label>
            <input id="phone_number" type="text" class="form-control" name="phone_number" required="">

          </div>
          <div class="col-md-6">
            <label>RFC</label>
            <input id="rfc" type="rfc" class="form-control" name="rfc" style="text-transform:uppercase;" required="">

            <label>@lang('lang.register_email_form')</label>
            <input id="email" type="email" class="form-control" name="email" autocomplete="off" required="">
          </div>
          <div class="col-md-9"></div>
          <div class="col-md-3">
            <div class="button-box">
              <button type="button" class="default-btn" id="btn-edit-account">@lang('lang.profile_save_change')</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Edit Image Profile --}}
<div class="modal fade" id="edit-image" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">
            <form id="form-avatar">
              <h4>@lang('lang.profile_edit_picture')</h4>
              <br>
              <div class="alert alert-warning alert-dismissible" style="display: none" id="alert-avatar">
                <a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
                <strong>@lang('lang.alert_warning')</strong> @lang('lang.alert_warning_avatar')
              </div>
              <input type="file" class="form-control" name="avatar" id="avatar">
              <span id="span-error" class="error-avatar text-danger"></span>
              <br>
              <button type="button" class="default-btn" data-dismiss="modal">@lang('lang.profile_close_modal')</button>
              <button type="button" class="default-btn" id="btn-edit-image">@lang('lang.profile_save_change')</button>
            </form>
          <div class="col-md-1"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- End Modal Edit Image Profile --}}