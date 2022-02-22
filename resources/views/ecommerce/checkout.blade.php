<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Ph@ra |</title>
	<meta name="description" content="ecommerce ">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="token" content="{{ Session::get('token') }}">
	<meta name="base_url" content="{{ config('constants.BASE_URL') }}">
	<meta name="openpay_id" content="{{ config('services.openpay.id') }}">
	<meta name="openpay_api_key" content="{{ config('services.openpay.api_key') }}">
	<meta name="openpay_mode" content="{{ config('services.openpay.mode') }}">
	<meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">


	<meta name="paypal_sandbox_key" content="{{ config('services.paypal.sandbox_key') }}">
	<meta name="paypal_production_key" content="{{ config('services.paypal.production_key') }}">

	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
	<link href="{{ asset('css/material-design-iconic-font.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/animate.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/slick.css') }}" rel="stylesheet">
	<link href="{{ asset('css/nice-select.css') }}" rel="stylesheet">
	<link href="{{ asset('css/meanmenu.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/venobox.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bootstrap-select.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bootstrap-social.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bootstrap-social.less') }}" rel="application/octet-stream">
	<link href="{{ asset('css/bootstrap-social.scss') }}" rel="application/octet-stream">
	<link href="{{ asset('js/sweetalert/sweetalert.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
	<link href="{{ asset('css/progress-bar.css') }}" rel="stylesheet">

	<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
	<style>
	/* The container */
	.container-radio {
		display: block;
		position: relative;
		padding-left: 35px;
		margin-bottom: 12px;
		cursor: pointer;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	/* Hide the browser's default radio button */
	.container-radio input {
		position: absolute;
		opacity: 0;
		cursor: pointer;
	}

	/* Create a custom radio button */
	.checkmark {
		position: absolute;
		top: 2px;
		left: 0;
		height: 20px;
		width: 20px;
		background-color: #eee;
		border: 1px solid #24bddf;
	}

	/* On mouse-over, add a grey background color */
	.container-radio:hover input ~ .checkmark {
		background-color: #ccc;
	}

	/* When the radio button is checked, add a blue background */
	.container-radio input:checked ~ .checkmark {
		background-color: #24bddf;
	}

	/* Create the indicator (the dot/circle - hidden when not checked) */
	.checkmark:after {
		content: "";
		position: absolute;
		display: none;
	}

	/* Show the indicator (dot/circle) when checked */
	.container-radio input:checked ~ .checkmark:after {
		display: block;
	}

	/* Style the indicator (dot/circle) */
	.container-radio .checkmark:after {
		top: 5px;
		left: 5px;
		width: 8px;
		height: 8px;
		background: white;
	}
	/*Radio*/
	/* The container */
	.container-radio-register {
		position: relative;
		padding-left: 35px;
		margin-bottom: 12px;
		cursor: pointer;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	/* Hide the browser's default radio button */
	.container-radio-register input {
		position: absolute;
		opacity: 0;
		cursor: pointer;
	}

	/* Create a custom radio button */
	.checkmark-radio {
		position: absolute;
		top: -1px;
		left: 0;
		height: 20px;
		width: 20px;
		background-color: #eee;
		border: 1px solid #24bddf;
		border-radius: 50%;
	}

	/* On mouse-over, add a grey background color */
	.container-radio-register:hover input ~ .checkmark-radio {
		background-color: #ccc;
	}

	/* When the radio button is checked, add a blue background */
	.container-radio-register input:checked ~ .checkmark-radio {
		background-color: #24bddf;
	}

	/* Create the indicator (the dot/circle - hidden when not checked) */
	.checkmark-radio:after {
		content: "";
		position: absolute;
		display: none;
	}

	/* Show the indicator (dot/circle) when checked */
	.container-radio-register input:checked ~ .checkmark-radio:after {
		display: block;
	}

	/* Style the indicator (dot/circle) */
	.container-radio-register .checkmark-radio:after {
		top: 5px;
		left: 5px;
		width: 8px;
		height: 8px;
		border-radius: 50%;
		background: white;
	}
</style>

</head>
<body>
	<div id="progress-animation-content" style="display: none">
		<div class="progress">
			<div class="indeterminate"></div>
		</div>
	</div>
	<div class="breadcrumb-area pt-20 pb-20">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="breadcrumb-content">
						<ul>
							<li><a href="/"><b>@lang('lang.breadcrumb_index')</b></a></li>
							<li><a href="cart"><b>@lang('lang.shopping_cart')</b></a></li>
							<li class="active"><b>Checkout</b></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="checkout-area pt-20">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-12">
					<div class="checkbox-form">
						<div class="row col-md-12">
							<br>
							<h3>@lang('lang.order_delivery')</h3>
						</div>
						<div class="row col-md-12">
							<div class="single-product-review-and-description-area mb-85">
								<ul class="nav dec-and-review-menu">
									<li>
										<a class="active send-address" data-toggle="tab" href="#send-address">@lang('lang.send_at_home')</a>
									</li>
									<li>
										<a class="pick-up" data-toggle="tab" href="#pick-up">@lang('lang.pick_up_on_site')</a>
									</li>
								</ul>
								<div class="tab-content product-review-content-tab" id="myTabContent-4">
									<div class="tab-pane fade show active" id="send-address">
										<div class="row address-personal">
											<div class="checkbox-form">
												<div class="row show-address" style="display: none;">
													<div class="col-md-12">
														<div class="checkout-form-list">
															<label>@lang('lang.checkout_select_address') <span class="required">*</span></label>
															<select class="form-control" name="address-user" id="address-type">
															</select>
														</div>
													</div>
													<br>
													<div class="col-md-12">
														<br>
														<h3>@lang('lang.checkout_detail_address')</h3>
													</div>
													<div class="col-md-12">
														<address id="detail-address">
														</address>
													</div>
												</div>
												<div class="alert alert-warning alert-dismissible not-address" style="display: none">
													<a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
													<strong>@lang('lang.alert_warning')</strong>@lang('lang.checkout_address_no_have')
												</div>
												<br>
												{{-- Dirrefrent address --}}
												<div class="different-address">
													<div class="ship-different-title">
														<h3>
															<label class="container-radio">
																@lang('lang.checkout_address_different')
																<input id="ship-box" type="checkbox" class="new-address">
																<span class="checkmark"></span>
															</label>
														</h3>
													</div>
													<div id="ship-box-info">
														<div class="alert alert-warning alert-dismissible" style="display: none" id="alert-validation-address">
															<a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
															<strong>@lang('lang.alert_warning')</strong>@lang('lang.alert_warning_address')
														</div>
														<form id="form-new-address">
															<div class="col-md-12">
																<table style="width:100%">
																	<thead></thead>
																	<tbody>
																		<tr>
																			<td width="50%">
																				{{-- <div class="country-select clearfix">
																					<label>@lang('lang.profile_address_country') <span class="required">*</span></label>
																					<select class="form-control" required name="country" id="countrys">
																						<option value="AF">Afghanistan</option>
																						<option value="AX">Åland Islands</option>
																						<option value="AL">Albania</option>
																						<option value="DZ">Algeria</option>
																						<option value="AS">American Samoa</option>
																						<option value="AD">Andorra</option>
																						<option value="AO">Angola</option>
																						<option value="AI">Anguilla</option>
																						<option value="AQ">Antarctica</option>
																						<option value="AG">Antigua and Barbuda</option>
																						<option value="AR">Argentina</option>
																						<option value="AM">Armenia</option>
																						<option value="AW">Aruba</option>
																						<option value="AU">Australia</option>
																						<option value="AT">Austria</option>
																						<option value="AZ">Azerbaijan</option>
																						<option value="BS">Bahamas</option>
																						<option value="BH">Bahrain</option>
																						<option value="BD">Bangladesh</option>
																						<option value="BB">Barbados</option>
																						<option value="BY">Belarus</option>
																						<option value="BE">Belgium</option>
																						<option value="BZ">Belize</option>
																						<option value="BJ">Benin</option>
																						<option value="BM">Bermuda</option>
																						<option value="BT">Bhutan</option>
																						<option value="BO">Bolivia, Plurinational State of</option>
																						<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
																						<option value="BA">Bosnia and Herzegovina</option>
																						<option value="BW">Botswana</option>
																						<option value="BV">Bouvet Island</option>
																						<option value="BR">Brazil</option>
																						<option value="IO">British Indian Ocean Territory</option>
																						<option value="BN">Brunei Darussalam</option>
																						<option value="BG">Bulgaria</option>
																						<option value="BF">Burkina Faso</option>
																						<option value="BI">Burundi</option>
																						<option value="KH">Cambodia</option>
																						<option value="CM">Cameroon</option>
																						<option value="CA">Canada</option>
																						<option value="CV">Cape Verde</option>
																						<option value="KY">Cayman Islands</option>
																						<option value="CF">Central African Republic</option>
																						<option value="TD">Chad</option>
																						<option value="CL">Chile</option>
																						<option value="CN">China</option>
																						<option value="CX">Christmas Island</option>
																						<option value="CC">Cocos (Keeling) Islands</option>
																						<option value="CO">Colombia</option>
																						<option value="KM">Comoros</option>
																						<option value="CG">Congo</option>
																						<option value="CD">Congo, the Democratic Republic of the</option>
																						<option value="CK">Cook Islands</option>
																						<option value="CR">Costa Rica</option>
																						<option value="CI">Côte d'Ivoire</option>
																						<option value="HR">Croatia</option>
																						<option value="CU">Cuba</option>
																						<option value="CW">Curaçao</option>
																						<option value="CY">Cyprus</option>
																						<option value="CZ">Czech Republic</option>
																						<option value="DK">Denmark</option>
																						<option value="DJ">Djibouti</option>
																						<option value="DM">Dominica</option>
																						<option value="DO">Dominican Republic</option>
																						<option value="EC">Ecuador</option>
																						<option value="EG">Egypt</option>
																						<option value="SV">El Salvador</option>
																						<option value="GQ">Equatorial Guinea</option>
																						<option value="ER">Eritrea</option>
																						<option value="EE">Estonia</option>
																						<option value="ET">Ethiopia</option>
																						<option value="FK">Falkland Islands (Malvinas)</option>
																						<option value="FO">Faroe Islands</option>
																						<option value="FJ">Fiji</option>
																						<option value="FI">Finland</option>
																						<option value="FR">France</option>
																						<option value="GF">French Guiana</option>
																						<option value="PF">French Polynesia</option>
																						<option value="TF">French Southern Territories</option>
																						<option value="GA">Gabon</option>
																						<option value="GM">Gambia</option>
																						<option value="GE">Georgia</option>
																						<option value="DE">Germany</option>
																						<option value="GH">Ghana</option>
																						<option value="GI">Gibraltar</option>
																						<option value="GR">Greece</option>
																						<option value="GL">Greenland</option>
																						<option value="GD">Grenada</option>
																						<option value="GP">Guadeloupe</option>
																						<option value="GU">Guam</option>
																						<option value="GT">Guatemala</option>
																						<option value="GG">Guernsey</option>
																						<option value="GN">Guinea</option>
																						<option value="GW">Guinea-Bissau</option>
																						<option value="GY">Guyana</option>
																						<option value="HT">Haiti</option>
																						<option value="HM">Heard Island and McDonald Islands</option>
																						<option value="VA">Holy See (Vatican City State)</option>
																						<option value="HN">Honduras</option>
																						<option value="HK">Hong Kong</option>
																						<option value="HU">Hungary</option>
																						<option value="IS">Iceland</option>
																						<option value="IN">India</option>
																						<option value="ID">Indonesia</option>
																						<option value="IR">Iran, Islamic Republic of</option>
																						<option value="IQ">Iraq</option>
																						<option value="IE">Ireland</option>
																						<option value="IM">Isle of Man</option>
																						<option value="IL">Israel</option>
																						<option value="IT">Italy</option>
																						<option value="JM">Jamaica</option>
																						<option value="JP">Japan</option>
																						<option value="JE">Jersey</option>
																						<option value="JO">Jordan</option>
																						<option value="KZ">Kazakhstan</option>
																						<option value="KE">Kenya</option>
																						<option value="KI">Kiribati</option>
																						<option value="KP">Korea, Democratic People's Republic of</option>
																						<option value="KR">Korea, Republic of</option>
																						<option value="KW">Kuwait</option>
																						<option value="KG">Kyrgyzstan</option>
																						<option value="LA">Lao People's Democratic Republic</option>
																						<option value="LV">Latvia</option>
																						<option value="LB">Lebanon</option>
																						<option value="LS">Lesotho</option>
																						<option value="LR">Liberia</option>
																						<option value="LY">Libya</option>
																						<option value="LI">Liechtenstein</option>
																						<option value="LT">Lithuania</option>
																						<option value="LU">Luxembourg</option>
																						<option value="MO">Macao</option>
																						<option value="MK">Macedonia, the former Yugoslav Republic of</option>
																						<option value="MG">Madagascar</option>
																						<option value="MW">Malawi</option>
																						<option value="MY">Malaysia</option>
																						<option value="MV">Maldives</option>
																						<option value="ML">Mali</option>
																						<option value="MT">Malta</option>
																						<option value="MH">Marshall Islands</option>
																						<option value="MQ">Martinique</option>
																						<option value="MR">Mauritania</option>
																						<option value="MU">Mauritius</option>
																						<option value="YT">Mayotte</option>
																						<option value="MX">Mexico</option>
																						<option value="FM">Micronesia, Federated States of</option>
																						<option value="MD">Moldova, Republic of</option>
																						<option value="MC">Monaco</option>
																						<option value="MN">Mongolia</option>
																						<option value="ME">Montenegro</option>
																						<option value="MS">Montserrat</option>
																						<option value="MA">Morocco</option>
																						<option value="MZ">Mozambique</option>
																						<option value="MM">Myanmar</option>
																						<option value="NA">Namibia</option>
																						<option value="NR">Nauru</option>
																						<option value="NP">Nepal</option>
																						<option value="NL">Netherlands</option>
																						<option value="NC">New Caledonia</option>
																						<option value="NZ">New Zealand</option>
																						<option value="NI">Nicaragua</option>
																						<option value="NE">Niger</option>
																						<option value="NG">Nigeria</option>
																						<option value="NU">Niue</option>
																						<option value="NF">Norfolk Island</option>
																						<option value="MP">Northern Mariana Islands</option>
																						<option value="NO">Norway</option>
																						<option value="OM">Oman</option>
																						<option value="PK">Pakistan</option>
																						<option value="PW">Palau</option>
																						<option value="PS">Palestinian Territory, Occupied</option>
																						<option value="PA">Panama</option>
																						<option value="PG">Papua New Guinea</option>
																						<option value="PY">Paraguay</option>
																						<option value="PE">Peru</option>
																						<option value="PH">Philippines</option>
																						<option value="PN">Pitcairn</option>
																						<option value="PL">Poland</option>
																						<option value="PT">Portugal</option>
																						<option value="PR">Puerto Rico</option>
																						<option value="QA">Qatar</option>
																						<option value="RE">Réunion</option>
																						<option value="RO">Romania</option>
																						<option value="RU">Russian Federation</option>
																						<option value="RW">Rwanda</option>
																						<option value="BL">Saint Barthélemy</option>
																						<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
																						<option value="KN">Saint Kitts and Nevis</option>
																						<option value="LC">Saint Lucia</option>
																						<option value="MF">Saint Martin (French part)</option>
																						<option value="PM">Saint Pierre and Miquelon</option>
																						<option value="VC">Saint Vincent and the Grenadines</option>
																						<option value="WS">Samoa</option>
																						<option value="SM">San Marino</option>
																						<option value="ST">Sao Tome and Principe</option>
																						<option value="SA">Saudi Arabia</option>
																						<option value="SN">Senegal</option>
																						<option value="RS">Serbia</option>
																						<option value="SC">Seychelles</option>
																						<option value="SL">Sierra Leone</option>
																						<option value="SG">Singapore</option>
																						<option value="SX">Sint Maarten (Dutch part)</option>
																						<option value="SK">Slovakia</option>
																						<option value="SI">Slovenia</option>
																						<option value="SB">Solomon Islands</option>
																						<option value="SO">Somalia</option>
																						<option value="ZA">South Africa</option>
																						<option value="GS">South Georgia and the South Sandwich Islands</option>
																						<option value="SS">South Sudan</option>
																						<option value="ES">Spain</option>
																						<option value="LK">Sri Lanka</option>
																						<option value="SD">Sudan</option>
																						<option value="SR">Suriname</option>
																						<option value="SJ">Svalbard and Jan Mayen</option>
																						<option value="SZ">Swaziland</option>
																						<option value="SE">Sweden</option>
																						<option value="CH">Switzerland</option>
																						<option value="SY">Syrian Arab Republic</option>
																						<option value="TW">Taiwan, Province of China</option>
																						<option value="TJ">Tajikistan</option>
																						<option value="TZ">Tanzania, United Republic of</option>
																						<option value="TH">Thailand</option>
																						<option value="TL">Timor-Leste</option>
																						<option value="TG">Togo</option>
																						<option value="TK">Tokelau</option>
																						<option value="TO">Tonga</option>
																						<option value="TT">Trinidad and Tobago</option>
																						<option value="TN">Tunisia</option>
																						<option value="TR">Turkey</option>
																						<option value="TM">Turkmenistan</option>
																						<option value="TC">Turks and Caicos Islands</option>
																						<option value="TV">Tuvalu</option>
																						<option value="UG">Uganda</option>
																						<option value="UA">Ukraine</option>
																						<option value="AE">United Arab Emirates</option>
																						<option value="GB">United Kingdom</option>
																						<option value="US">United States</option>
																						<option value="UM">United States Minor Outlying Islands</option>
																						<option value="UY">Uruguay</option>
																						<option value="UZ">Uzbekistan</option>
																						<option value="VU">Vanuatu</option>
																						<option value="VE">Venezuela, Bolivarian Republic of</option>
																						<option value="VN">Viet Nam</option>
																						<option value="VG">Virgin Islands, British</option>
																						<option value="VI">Virgin Islands, U.S.</option>
																						<option value="WF">Wallis and Futuna</option>
																						<option value="EH">Western Sahara</option>
																						<option value="YE">Yemen</option>
																						<option value="ZM">Zambia</option>
																						<option value="ZW">Zimbabwe</option>
																					</select>
																				</div> --}}
																				<div class="country-select">
																					<label>@lang('lang.checkout_select_address_type') <span class="required">*</span></label>
																					<select class="form-control" name="address_types" id="address-select" required>
																					</select>
																				</div>
																			</td>
																			<td width="50%">
																				<div class="checkout-form-list">
																					<label>@lang('lang.profile_address_street')
																						<span class="required">*</span>
																					</label>
																					<input type="text" required name="street">
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td width="50%">
																				<div class="checkout-form-list">
																					<label>@lang('lang.profile_address_interior_number') <span class="required">*</span></label>
																					<input type="text" name="interior_number">
																				</div>
																			</td>
																			<td width="50%">
																				<div class="checkout-form-list">
																					<label>@lang('lang.profile_address_exterior_number') <span class="required">*</span></label>
																					<input placeholder="" type="text" required name="exterior_number">
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td width="50%">
																				<div class="checkout-form-list">
																					<label>@lang('lang.profile_address_city')
																						<span class="required">*</span>
																					</label>
																					<input type="text" required name="city">
																				</div>
																			</td>
																			<td width="50%">
																				<div class="checkout-form-list">
																					<label>@lang('lang.profile_address_state')<span class="required">*</span></label>
																					<input placeholder="" type="text" required name="state">
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td width="50%">
																				<div class="checkout-form-list">
																					<label>@lang('lang.profile_address_zipcode') <span class="required">*</span></label>
																					<input placeholder="" type="text" required name="zipcode">
																				</div>
																			</td>
																			<td width="50%">
																				<div class="order-notes">
																					<div class="checkout-form-list">
																						<label>@lang('lang.profile_address_description') <span class="required">*</span></label>
																						<textarea id="checkout-mess" cols="30" rows="3" name="description" required></textarea>
																					</div>
																				</div>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</div>
															<div class="col-md-12">
																<div class="order-button-payment">
																	<input value="@lang('lang.checkout_card_aceptar')" type="button" id="save-address">
																</div>
															</div>
															<br>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="pick-up">
										<div class="checkbox-form">
											<label>Av. Juárez #146 3er piso int-304, </label><br>
											<label>Col. Centro </label><br>
											<label>Torreón, Coahuila, México. </label><br>
											<label>C.P. 27000</label><br>
											<div class="checkout-form-list">
												<label class="container-radio">
													@lang('lang.accept_pick_up_on_site')
													<input name="pick_up_site" type="checkbox" id="pick_up_site" disabled="true">
													<span class="checkmark"></span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="checkbox-form">
							<div class="order-notes">
								<div class="checkout-form-list">
									<label>@lang('lang.checkout_more_info')</label>
									<textarea id="checkout-mess" cols="30" rows="10" placeholder="@lang('lang.checkout_more_info_placeholder')" name="descriptions"></textarea>

									<small style="display: none;" id="referenceHelp" class="text-danger">

									</small>

								</div>
							</div>
							<a href="cart"><div class="return-back">
								<i class="fa fa-long-arrow-left"></i> @lang('lang.back_cart')
							</div></a>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-12">
					<div class="your-order">
						<div class="row" id="descount-cost">
							<div class="col-12">
								<div class="coupon-accordion">
									<!--Accordion Start-->
									<div class="gift-options" style="display: none;">
										<h5><b><i class="fa fa-gift"></i> @lang('lang.checkout_add_gift')</b> <span id="showlogin">@lang('lang.checkout_add_gift_clic')</span></h5>
										<div id="checkout-login" class="coupon-content">
											<div class="coupon-info">
												<p id="checkbox-fees-container" class="form-row-first">
												</p>
												<div class="checkbox-form card-form" style="display: none">
													<input type="hidden" name="alert_warning" value="@lang('lang.checkout_alert_card_empty')">
													<input type="hidden" name="alert_error" value="@lang('lang.checkout_alert_card_select_warning')">
													<input type="hidden" name="alert_success" value="@lang('lang.checkout_alert_card_select_success')">
													<input type="hidden" name="alert_fail" value="@lang('lang.checkout_alert_card_select_error')">
													<div class="col-md-12">
														<div class="order-notes">
															<div class="checkout-form-list">
																<input type="text" required name="title" placeholder="@lang('lang.checkout_card_title')">
																<small style="display: none;" id="titleHelp" class="text-danger"></small>
															</div>

														</div>
													</div>
													<div class="col-md-12">
														<div class="order-notes">
															<div class="checkout-form-list">
																<input type="text" required name="to" placeholder="@lang('lang.checkout_card_to')">
																<small style="display: none;" id="toHelp" class="text-danger"></small>
															</div>

														</div>
													</div>
													<div class="col-md-12">
														<div class="order-notes">
															<div class="checkout-form-list">
																<textarea name="message" required rows="2" placeholder="@lang('lang.checkout_card_message')"></textarea>
																<small style="display: none;" id="messageHelp" class="text-danger"></small>
															</div>

														</div>
													</div>
												</div>
												<div class="button-box">
													<button style="display: none;" type="submit" class="default-btn" id="accept-card">@lang('lang.checkout_card_aceptar')</button>
												</div>
											</div>
										</div>
									</div>
									<h5><b><i class="fa fa-tag"></i> @lang('lang.checkout_have_coupon')</b> <span id="showcoupon">@lang('lang.checkout_have_coupon_click')</span></h5>
									<div id="checkout_coupon" class="coupon-checkout-content">
										<div class="alert alert-warning alert-dismissible" style="display: none" id="alert-coupon">
											<a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
											<strong>@lang('lang.alert_warning')</strong>@lang('lang.alert_warning_coupon')
										</div>
										<div class="coupon-info">
											<p class="checkout-coupon">
												<input type="hidden" id="codes_id" name="codes_id" value="">
												<input id="coupon_code" class="input-text" name="coupon_code" placeholder="@lang('lang.coupon_code')" type="text">
												<input class="button" name="apply_coupon" value="@lang('lang.apply_coupon')" type="submit" id="apply-coupon">
											</p>
										</div>
									</div>
									<h5></h5>
									<!--Accordion End-->
								</div>
							</div>
						</div>
						<h3>@lang('lang.checkout_your_order')</h3>
						<div class="your-order-table table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th class="cart-product-name"><b>@lang('lang.checkout_product')</b></th>
										<th class="cart-product-total"><b>@lang('lang.checkout_total')</b></th>
									</tr>
								</thead>
								<tbody>
									<tr class="cart-subtotal">
										<td>@lang('lang.checkout_subtotal_cart')</td>
										<td><span class="amount" id="subtotal-carrito"></span></td>
									</tr>
									<tr class="cart_item">
										<td class="cart-product-name">@lang('lang.checkout_envio')</td>
										<td class="cart-product-total"><span class="amount" id="envio"></span></td>
									</tr>
									<tr class="cart_item">
										<td class="cart-product-name">@lang('lang.checkout_cargos')</td>
										<td class="cart-product-total"><span class="amount" id="cost" name="charges"></span></td>
									</tr>
									<tr class="cart_item">
										<td class="cart-product-name">@lang('lang.checkout_descuento')</td>
										<td class="cart-product-total"><span class="amount text-info" id="descount"></span></td>
									</tr>
								</tbody>
								<tfoot>
									<tr class="order-total">
										<th><b>@lang('lang.checkout_total_order')</b></th>
										<td><strong><span class="amount" id="amount"></span></strong></td>
										<input type="hidden" name="amountt">
										<input type="hidden" name="amount">
										<input type="hidden" name="currency" value="@lang('lang.currency_code')">
										<input type="hidden" name="envio">
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="shipping-time">

						</div>
						<div class="payment-method">
							<input type="hidden" name="alert_description" value="@lang('lang.summary_alert_description')">
							<div class="checkout-form-list">
								<label class="container-radio">
									@lang('lang.summary_is_billable')
									<input name="is_billable" type="checkbox" id="is_billable" checked="checked">
									<span class="checkmark"></span>
								</label>
							</div>
							<div class="alert alert-warning alert-dismissible not-cards" style="display: none">
								<a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
								<strong>@lang('lang.alert_warning')</strong>@lang('lang.checkout_no_cards')
							</div>
							<div class="alert alert-success alert-dismissible" style="display: none" id="alert-succ-add-card">
								<a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
								<strong>@lang('lang.alert_success')</strong> @lang('lang.alert_success_add_card')
							</div>
							<h4>@lang('lang.checkout_select_type_payment') <span class="required text-danger"> *</span></h4>
							{{-- Different card --}}
							<div class="different-address">
								<div class="ship-different-title">
									<label class="container-radio">
										@lang('lang.checkout_add_card')
										<input id="btn-box-card" type="checkbox" class="new-card">
										<span class="checkmark"></span>
									</label>
								</div>
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
								<div id="ship-box-card">
									<form method="post" action="cards" id="form-card-new">
										@csrf
										<input type="hidden" name="token_id" id="token_id" />
										<input type="hidden" name="device_session" id="device_session" />
										<div class="row">
											<div class="col-md-12">
												<div class="card-expl">
													<label>@lang('lang.type_card')</label>
													<div class="input-radio">
														<div class="row">
															<div class="col-md-3">
																<label class="container-radio-register">
																	<input name="method" value="1" type="radio" checked="checked">
																	@lang('lang.credit')
																	<span class="checkmark-radio"></span>
																</label>
																<br>
																<div class="credit"></div>
															</div>
															<div class="col-md-9 img-responsive">
																<label class="container-radio-register">
																	<input name="method" value="2" type="radio">
																	@lang('lang.debit')
																	<span class="checkmark-radio"></span>
																</label>
																<br>
																<div class="debit"></div>
															</div>
														</div>
													</div>
												</div>
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
												<input style="height: 30px !important;" id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="off" required data-openpay-card="holder_name">
											</div>
											<div class="col-md-6">
												<label>@lang('lang.card_number')</label>
												<input style="height: 30px !important;" id="card_number" type="text" class="form-control" name="card_number" value="{{ old('card_number') }}" min="1" oninput="validity.valid||(value='');" autocomplete="off" required data-openpay-card="card_number"maxlength = "16" pattern="[0-9]+">
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<label>@lang('lang.expiration_date') (MM/YY)</label>
												<div class="row">
													<div class="col-md-6">
														<input style="height: 30px !important;" id="month" type="number" class="form-control" name="month" value="{{ old('month') }}" min="0" oninput="validity.valid||(value='');" placeholder="@lang('lang.month')" required data-openpay-card="expiration_month" max="12">
													</div>
													<div class="col-md-6">
														<input style="height: 30px !important;" id="year" type="number" class="form-control" name="year" value="{{ old('year') }}" min="0" oninput="validity.valid||(value='');" placeholder="@lang('lang.year')" required data-openpay-card="expiration_year" max="99">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<label>@lang('lang.security_code')</label>
												<div class="sctn-col cvv">
													<div class="sctn-col half l">
														<input style="height: 30px !important;" id="code" type="text" class="form-control" name="code" value="{{ old('code') }}" autocomplete="off" min="1" oninput="validity.valid||(value='');" required data-openpay-card="cvv2" maxlength = "4" pattern="[0-9]+">
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
												<br>
												<img src="{{ asset('img/cvv.png') }}">
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
											</div>
											<div class="col-md-6">
												<div class="button-box">
													<button type="submit" class="default-btn" id="save-new-card">@lang('lang.profile_address_save')</button>
												</div>
											</div>
										</div>
									</form>

								</div>
							</div>
							{{-- end different card --}}
							<select class="form-control" id="type_payment" name="payment-type" >
							</select>
							<br>
							<div class="checkout-form-list">
								<div class="tarjetas"></div>
							</div>


							<input type="hidden" name="alert_select_type_payment" value="@lang('lang.summary_alert_select_type_payment')">
							<small style="display: none;" id="paymentTypeHelp" class="text-danger">

							</small>

							<div class="checkout-form-list">
								<label class="container-radio">
									<a href="about">@lang('lang.accept_terms_checkout')</a>
									<input name="accept-terms" type="checkbox" id="accept-terms">
									<span class="checkmark"></span>
								</label>
							</div>

							<form id="pago">

							</form>

							<h4>@lang('lang.checkout_others_methods_buy')</h4>
							<div id="paypal-container" class="checkout-form-list">

								<button type="button" id="paypal-payment-validate"
								style="padding: 0px;  border: none; margin: 0px; background-color: transparent; " class="btn">
								<i  class="fab fa-cc-paypal" style="font-size: 40px;"></i>
							</button>




						</div>

						<div class="collapse" id="collapseExample">
							<div id="paypal-button">
							</div>
						</div>

						<div class="order-button-payment">
							<input value="@lang('lang.checkout_place_order')" type="button" id="generate-order">
						</div>



					</div>
					<br>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="token_id" id="token_id">
	<footer>


		<div class="footer-container">
			<div class="footer-top-area text-center">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="row payment-method">
								<div class="col-md-3">
									<img src="img/tarjetaDebito.png" width="100%">
								</div>
								<div class="col-md-3">
									<img src="img/tarjetascreditp.png" width="100%">
								</div>
								<div class="col-md-3">
									<img src="img/paypal.png" width="100%">
								</div>
								<div class="col-md-3">
									<img src="img/tiendaspagos.png" width="100%">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="footer-bottom-area">
				<div class="container text-center">
					<p>© Copyright <br><a href="/">Ph@ra</a> <br>@lang('lang.all_right') </p>
				</div>
			</div>
		</div>
	</footer>
</div>
<script src="{{ asset('js/vendor/jquery-1.12.4.min.js') }} "></script>
<script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }} "></script>
<script src="{{ asset('js/imagesloaded.pkgd.min.js') }} "></script>
<script src="{{ asset('js/isotope.pkgd.min.js') }} "></script>
<script src="{{ asset('js/jquery-ui.min.js') }} "></script>
<script src="{{ asset('js/waypoints.min.js') }} "></script>
<script src="{{ asset('js/owl.carousel.min.js') }} "></script>
<script src="{{ asset('js/slick.min.js') }} "></script>
<script src="{{ asset('js/jquery.nice-select.min.js') }} "></script>
<script src="{{ asset('js/jquery.meanmenu.min.js') }} "></script>
<script src="{{ asset('js/instafeed.min.js') }} "></script>
<script src="{{ asset('js/jquery.scrollUp.min.js') }} "></script>
<script src="{{ asset('js/wow.min.js') }} "></script>
<script src="{{ asset('js/venobox.min.js') }} "></script>
<script src="{{ asset('js/popper.min.js') }} "></script>
<script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
<script src="{{ asset('js/bootstrap-select.js') }}" defer></script>
<script src="{{ asset('js/jquery.numeric.js') }}" defer></script>
<script src="{{ asset('js/plugins.js') }}" defer></script>

<script src="js/sweetalert/sweetalert.min.js" defer></script>
<script src="js/sweetalert/jquery.sweet-alert.custom.js" defer></script>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="{{ asset('js/main.js') }}" defer></script>
<script src="{{ asset('js/script/js-index.js') }}" defer></script>
<script src="{{ asset('js/script/js-cart.js') }}" defer></script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
<script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
<script type="text/javascript">
	OpenPay.setId('mjclxkjzw1n2fu5oo1le');
	OpenPay.setApiKey('pk_b4db52de68ba42d09e28ef3d6cab143e');
	OpenPay.setSandboxMode(true);
	var deviceSessionId = OpenPay.deviceData.setup("pago", "device_session_id");
</script>
<script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
<script src="js/script/js-checkout.js"></script>
<script src="js/script/payment/address.js"></script>
<script src="js/script/payment/summary.js"></script>
<script src="js/script/card.js"></script>
<script src="js/script/generateOrder.js"></script>
<script src="js/script/paypal.js"></script>
<script src="js/script/payment/transaction.js"></script>
</body>
</html>
