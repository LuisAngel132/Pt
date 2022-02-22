 <div class="row">
 	<div class="col-lg-12 profile-title">
 		<div class="profile-title-box">
 			<h3>@lang('lang.credit_cards')</h3>
 		</div>
 	</div>
 </div>
 <div class="row">
 	<div class="col-lg-12">
 		<div class="alert alert-warning alert-dismissible" style="display: none" id="alert-warning-add-card">
 			<a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
 			<strong>@lang('lang.alert_warning')</strong> @lang('lang.alert_warning_add_card')
 		</div>
 		<div class="alert alert-warning alert-dismissible" style="display: none" id="alert-warning-numcard">
 			<a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
 			<strong>@lang('lang.alert_warning')</strong> @lang('lang.alert_warning_numcard')
 		</div>
 		<div class="alert alert-warning alert-dismissible" style="display: none" id="alert-warning-cvc">
 			<a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
 			<strong>@lang('lang.alert_warning')</strong> @lang('lang.alert_warning_cvc')
 		</div>
 		<div class="alert alert-warning alert-dismissible" style="display: none" id="alert-warning-cvc-card">
 			<a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
 			<strong>@lang('lang.alert_warning')</strong> @lang('lang.alert_warning_cvc_card')
 		</div>
 		<div class="alert alert-warning alert-dismissible" style="display: none" id="alert-warning-expiration">
 			<a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
 			<strong>@lang('lang.alert_warning')</strong> @lang('lang.alert_warning_expiration')
 		</div>
 		<div class="alert alert-warning alert-dismissible" style="display: none" id="alert-warning-monthyear">
 			<a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
 			<strong>@lang('lang.alert_warning')</strong> @lang('lang.alert_warning_monthyear')
 		</div>
 		<div class="alert alert-warning alert-dismissible" style="display: none" id="alert-warning-name">
 			<a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
 			<strong>@lang('lang.alert_warning')</strong> @lang('lang.alert_warning_name')
 		</div>
 	</div>
 </div>
 <div class="row">
 	<div class="col-lg-3 address">
 		<div class="add-address-box">
 			<a class="btn add-card" data-toggle="tooltip" title="@lang('lang.new_card')" data-placement="bottom">
 				<img src="img/plus.png" width="50%">
 			</a>
 		</div>
 		<div class="address-list">
 			<h3 class="title-address">@lang('lang.my_cards'):</h3>
 			<div class="nav flex-column nav-pills cards-list-box" id="v-pills-tab" role="tablist" aria-orientation="vertical">
 			</div>
 		</div>
 	</div>
 	<div class="col-lg-9 address-box">
 		<div class="box-addresss-info">
 			<form method="post" action="cards" id="form-card-new">
 				@csrf
 				<input type="hidden" name="token_id" id="token_id" />
 				<input type="hidden" name="device_session_id" id="device_session_id" />
 				<div class="row">
 					<div class="col-md-12">
 						<label>@lang('lang.type_card')</label>
 					</div>
 					<div class="col-md-3 col-12">
 						<label class="container-radio">
 							<input name="method" value="1" type="radio" checked="checked">
 							@lang('lang.credit')
 							<span class="checkmark"></span>
 						</label>
 					</div>
 					<div class="col-md-9 col-12">
 						<label class="container-radio">
 							<input name="method" value="2" type="radio">
 							@lang('lang.debit')
 							<span class="checkmark"></span>
 						</label>
 					</div>
 				</div>
 				<div class="row">
 					<div class="col-md-3">
 						<img src="{{ asset('img/cards1.png') }}" style="width: 100%;">
 					</div>
 					<div class="col-md-9">
 						<img src="{{ asset('img/cards2.png') }}" style="width: 100%;">
 					</div>
 				</div>
 				<div class="row">
 					<div class="col-md-6">
 						<label>@lang('lang.name_owner')</label>
 						<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="off" required data-openpay-card="holder_name">
 					</div>
 					<div class="col-md-6">
 						<label>@lang('lang.card_number')</label>
 						<input id="card_number" type="text" class="form-control" name="card_number" value="{{ old('card_number') }}" min="1" oninput="validity.valid||(value='');" autocomplete="off" required data-openpay-card="card_number" maxlength = "16" pattern="[0-9]+">
 					</div>
 				</div>
 				<div class="row">
 					<div class="col-md-6">
 						<label>@lang('lang.expiration_date') (MM/YY)</label>
 						<div class="row">
 							<div class="col-md-6">
 								<input id="month" type="number" class="form-control" name="month" value="{{ old('month') }}" min="0" oninput="validity.valid||(value='');" placeholder="@lang('lang.month')" required data-openpay-card="expiration_month" max="12">
 							</div>
 							<div class="col-md-6">
 								<input id="year" type="number" class="form-control" name="year" value="{{ old('year') }}" min="0" oninput="validity.valid||(value='');" placeholder="@lang('lang.year')" required data-openpay-card="expiration_year" max="99">
 							</div>
 						</div>
 					</div>
 					<div class="col-md-6">
 						<div class="row">
 							<div class="col-md-6">
 								<label>@lang('lang.security_code')</label>
 								<input id="code" type="text" class="form-control" name="code" value="{{ old('code') }}" autocomplete="off" min="1" oninput="validity.valid||(value='');" required data-openpay-card="cvv2" maxlength = "4" pattern="[0-9]+">
 							</div>
 							<div class="col-md-6">
 								<img src="{{ asset('img/cvv.png') }}" style="margin-top: 34px;">
 							</div>
 						</div>
 					</div>
 				</div>
 				<div class="row">
 					<div class="col-md-6">
 						<br>
 						<img src="{{ asset('img/openpay.png') }}">
 					</div>
 					<div class="col-md-6">
 						<div class="button-box">
 							<button type="submit" class="default-btn" id="save-new-card">@lang('lang.profile_address_save')</button>
 							<button type="button" class="delete-btn">@lang('lang.profile_address_cancel')</button>
 						</div>
 					</div>
 				</div>
 			</form>

 			<form method="post" action="update-card" id="form-card-edit" style="display: none">
 				@csrf
 				<div class="row">
 					<div class="col-md-12">
 						<div>
 							<h5>@lang('lang.card'): </h5>
 							<h5 class="detail-type-card"></h5>
 						</div>
 					</div>
 				</div>
 				<br>
 				<div class="row">
 					<div class="col-md-6">
 						<label>@lang('lang.name_owner')</label>
 						<input id="name_edit" type="text" class="form-control" name="name_edit" value="{{ old('name_edit') }}" autocomplete="off" required data-openpay-card="holder_name" readonly>
 					</div>
 					<div class="col-md-6">
 						<label>@lang('lang.expiration_date') (MM/YY)</label>
 						<div class="row">
 							<div class="col-md-6">
 								<input id="month_edit" type="number" class="form-control" name="month_edit" value="{{ old('month_edit') }}" min="1" oninput="validity.valid||(value='');" placeholder="@lang('lang.month')" required data-openpay-card="expiration_month" size="2" readonly>
 							</div>
 							<div class="col-md-6">
 								<input id="year_edit" type="number" class="form-control" name="year_edit" value="{{ old('year_edit') }}" min="1" oninput="validity.valid||(value='');" placeholder="@lang('lang.year')" required data-openpay-card="expiration_year" size="2" readonly>
 							</div>
 						</div>
 					</div>
 				</div>
 				<div class="row">
 					<div class="col-md-6">
 						<label>@lang('lang.type_card')</label>
 						<div class="input-radio">
 							<div class="row">
 								<div class="col-md-3">
 									<label class="container-radio">
 										<input name="method_edit" value="1" type="radio">
 										@lang('lang.credit')
 										<span class="checkmark"></span>
 									</label>
 								</div>
 								<div class="col-md-3">
 									<label class="container-radio">
 										<input name="method_edit" value="2" type="radio">
 										@lang('lang.debit')
 										<span class="checkmark"></span>
 									</label>
 								</div>
 							</div>
 						</div>
 					</div>
 					<div class="col-md-3"></div>
 					<div class="col-md-3">
 						<div class="button-box">
 							<input id="id" type="hidden" class="form-control" name="id" required>
 							<button type="button" class="default-btn" id="delete-card">@lang('lang.profile_address_delete')</button>
 						</div>
 					</div>
 				</div>
 			</form>
 		</div>
 	</div>
 </div>
