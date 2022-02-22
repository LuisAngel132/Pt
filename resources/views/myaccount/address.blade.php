 <div class="row">
  <div class="col-lg-12 profile-title">
    <div class="profile-title-box">
      <h3>@lang('lang.profile_title_address')</h3>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-3 address">
    <div class="add-address-box">
      <a class="btn add-address" data-toggle="tooltip" title="@lang('lang.profile_address_add')" data-placement="bottom">
        <img src="img/plus.png" width="50%">
      </a>
    </div>
    <div class="address-list">
      <h3 class="title-address">@lang('lang.profile_address_list'):</h3>
      <div class="nav flex-column nav-pills address-list-box" id="v-pills-tab" role="tablist" aria-orientation="vertical">

        </div>
    </div>
  </div>
  <div class="col-lg-9 address-box">
    <div class="box-addresss-info">
      <!--Form address new-->
      @include('myaccount.partials.form_address_new')
      <!--end Form address new-->
      <!--Form address edit-->
      @include('myaccount.partials.form_address_edit')
      <!--end Form address edit-->
    </div>
  </div>
</div>