$(document).ready(function() {
  BASE_URL =  $('meta[name="base_url"]').attr('content');
  OPENPAY_ID =  $('meta[name="openpay_id"]').attr('content');
  OPENPAY_API_KEY =  $('meta[name="openpay_api_key"]').attr('content');
  OPENPAY_MODE =  $('meta[name="openpay_mode"]').attr('content');
  if (OPENPAY_MODE == 0) {
    MODE = false;
  } else {
    MODE = true;
  }
  console.log("openpay_mode " + MODE);
  ACCOUNT_GET = '/v1/customers';
  AVATAR_POST = '/v1/customers/avatar';
  lang = $('meta[name="language"]').attr('content');
  token = $('meta[name="token"]').attr('content');
  translationText(lang);
  validationsAccount();
  getAccount();
  editImageProfile();
  editAccount();
  listCards();
  deleteCard();
  addCard();
  clickBtnCancel();
  openPay();
  saveCard();
  clickButtonNew();
  clickButtonCancel();
  getAddressType();
  getAddress();
  saveAddress();
  editAddress();
  deleteAddress();
});

function translationText(lang) {
	if (lang === 'es') {
		text_edit_img = 'Editar imagen';
		text_loading = 'Cargando...';
		btn_edit = 'Editar';
		alert_succ_image = 'Imagen actualizada correctamente.';
		alert_danger_image = 'Imagen no ha sido actualizada, inténtalo nuevamente.';
		alert_success = 'Acción realizada correctamente.';
		alert_danger = 'Algo salió mal, inténtalo nuevamente.';
		alert_all_inputs = 'Todos los campos son obligatorios.';
		alert_delete_card = '¿Deseas eliminar la tarjeta?';
		alert_delete_address = '¿Deseas eliminar la dirección?';
		yes = 'Si';
		cancelled = 'Cancelado';
		btn_save = 'Guardar';
	} else if (lang === 'en') {
		text_edit_img = 'Edit image';
		text_loading = 'Loading...';
		btn_edit = 'Edit';
		alert_succ_image = 'Image updated correctly.';
		alert_danger_image = 'Image has not been updated, try again.';
		alert_success = 'Action performed correctly.';
		alert_danger = 'Something went wrong, try again.';
		alert_all_inputs = 'All fields are required.';
		alert_delete_card = 'Do you want to delete the card?';
		alert_delete_address = 'Do you want to delete the address?';
		yes = 'Yes';
		cancelled = 'cancelled';
		btn_save = 'Save';
	} else {
		text_edit_img = 'Editar imagen';
		text_loading = 'Cargando...';
		btn_edit = 'Editar';
		alert_succ_image = 'Imagen actualizada correctamente.';
		alert_danger_image = 'Imagen no ha sido actualizada, inténtalo nuevamente.';
		alert_success = 'Acción realizada correctamente.';
		alert_danger = 'Algo salió mal, inténtalo nuevamente.';
		alert_all_inputs = 'Todos los campos son obligatorios.';
		alert_delete_card = '¿Deseas eliminar la tarjeta?';
		alert_delete_address = '¿Deseas eliminar la dirección?';
		yes = 'Si';
		cancelled = 'Cancelado';
		btn_save = 'Guardar';
	}
}

/**
 * Validation account.
 */
 function validationsAccount() {
 	$("#edit-image").on('hidden.bs.modal', function () {
 		$('span[id=span-error]').text('');
 		$('input[type=file]').val('');
 	});
 	$('#avatar').change(function(event) {
 		$('.error-avatar').text('').fadeIn();
 	});
 }

/**
 * Gets the account.
 */
 function getAccount() {
 	$.ajax({
 		url: 'get_account',
 		type: 'GET',
 		dataType: 'json',
 	})
 	.done(function(response) {
 		console.log(response);
 		showImageProfile(response);
 		$('.text-code').text(response.data.codes[0].code);
 		$('input[name=first_name]').val(response.data.users.person.name);
 		$('input[name=last_name]').val(response.data.users.person.last_name);
 		$('input[name=phone_number]').val(response.data.phone_number);
 		$('input[name=rfc]').val(response.data.rfc);
 		$('input[name=email]').val(response.data.users.email);
 	})
 	.fail(function(errors) {
 		console.log(errors);
 	})
 	.always(function() {
 		console.log("complete");
 	});
 }

/**
 * Shows the image profile.
 *
 * @param      {<type>}  response  The response
 */
 function showImageProfile(response) {
 	if (response.data.users.image_url != '') {
 		$('.box-profile-image').html('<br><img id="img-profile" src="'+response.data.users.image_url+'" width="100%" class="img-circle-profile">'+
 			'<a href="#edit-image" data-toggle="modal"  class="btn btn-dark edit-profile" style="color:white;">'+
 			'<i class="zmdi zmdi-edit" style="color:white;"></i>'+
 			'</a>');
 	} else {
 		$('.box-profile-image').html('<br><img id="img-profile" src="img/profile-crazy.png" width="100%" class="img-circle-profile">'+
 			'<a href="#edit-image" data-toggle="modal"  class="btn btn-dark edit-profile" style="color:white;">'+
 			'<i class="zmdi zmdi-edit" style="color:white;"></i>'+
 			'</a>');
 	}
 }

/**
 * Edit image profile.
 */
 function editImageProfile() {
 	$('#btn-edit-image').click(function(event) {
 		event.preventDefault();
 		if ($('input[name=avatar]').val() == '') {
 			$('#alert-avatar').show();
 			setTimeout(function(){
 				$('#alert-avatar').hide(2000);
 			}, 4000);
 		} else {
 			$('#btn-edit-image').html('<i class="fa fa-spinner fa-spin" style="color:white;"></i> '+ text_loading).prop('disabled', true);
 			var formData = new FormData($('#form-avatar')[0]);
 			$.ajax({
 				url: 'update_img',
 				type: 'POST',
 				cache: false,
 				contentType: false,
 				processData: false,
 				dataType: 'json',
 				data: formData,
 			})
 			.done(function(response) {
 				console.log(response);
 				if (response.errors == false) {
 					$('#img-profile').prop('src', response.data.public_image_url);
 					$('#edit-image').modal('hide');
 					swal(alert_succ_image, "", "success");
 				} else if (response.errors == true) {
 					$('.error-avatar').text(response.data.avatar[0]);
 				}
 				else {
 					swal(alert_danger_image, "", "error");
 				}
 			})
 			.fail(function(errors) {
 				swal(alert_danger_image, "", "error");
 			})
 			.always(function() {
 				$('#btn-edit-image').text(btn_edit).prop('disabled', false);
 			});
 		}
 	});
 }

 function editAccount() {
 	$('#btn-edit-account').click(function(event) {
 		event.preventDefault();
 		var name = $('input[name=first_name]').val();
 		var last_name = $('input[name=last_name]').val();
 		var phone_number = $('input[name=phone_number]').val();
 		var rfc = $('input[name=rfc]').val();
 		var email = $('input[name=email]').val();
 		if ($.trim(name) == '' || $.trim(last_name) == '' || $.trim(phone_number) == '' ||
 			$.trim(rfc) == '' || $.trim(email) == '') {
 			swal('', alert_all_inputs, 'warning');
 	} else {
 		$('#btn-edit-account').html('<i class="fa fa-spinner fa-spin" style="color:white;"></i> '+ text_loading).prop('disabled', true);
 		$.ajax({
 			url: 'update',
 			type: 'POST',
 			dataType: 'json',
 			data: {
 				name: name,
 				last_name: last_name,
 				phone_number: phone_number,
 				rfc: rfc,
 				email: email,
 			},
 		})
 		.done(function(response) {
 			console.log(response);
 			if (response.errors == false) {
 				getAccount();
 				swal(alert_success, "", 'success');
 			} else {
 				swal(alert_danger, "", 'danger');
 			}
 		})
 		.fail(function(errors) {
 			console.log(errors);
 			swal(alert_danger, "", 'danger');
 		})
 		.always(function() {
 			$('#btn-edit-account').text(btn_edit).prop('disabled', false);
 		});
 	}
 });
 }

 /*CARDS*/

/**
 * List of the cards
 */
 function listCards() {
 	$.ajaxSetup({
 		headers: {
 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 		}
 	});
 	$.get('getCards', function(data) {
 		var item = "";
 		$.each(data.data, function(index, val) {
 			item = item+'<a class="btn nav-link active edit-card" name="'+val.id+'">'+val.cards.brand+'</a></br>';
 		});
 		$('.cards-list-box').html(item);
 		editCard(data);
 	});
 }

/**
 * Edit card
 *
 * @param      {<type>}  data    The data
 */
 function editCard(data) {
 	$('.edit-card').click(function(event) {
 		var id = this.name;
 		$('#form-card-new').hide();
 		$('#form-card-edit').show();
 		$.each(data.data, function(index, val) {
 			if (val.id == id) {
 				console.log(val);
 				$('.detail-type-card').text(val.cards.brand + "-" + val.cards.last_4 );
 				$('input[name=name_edit]').val(val.cards.holder_name);
 				$('input[name=month_edit]').val(val.cards.exp_month);
 				$('input[name=year_edit]').val(val.cards.exp_year);
 				$("input:radio[name=method_edit][value=" + val.payment_methods_id + "]").prop('checked', 'checked');
 				$('input[name=id]').val(val.id);
 			}
 		});
 	});
 }

 /**
  * Delete card.
  */
  function deleteCard() {
  	$('#delete-card').click(function(event) {
  		event.preventDefault();
  		var id = $('input[name=id]').val();
  		swal({
  			title: alert_delete_card,
  			type: "warning",
  			showCancelButton: true,
  			confirmButtonColor: "#DD6B55",
  			confirmButtonText: yes,
  			cancelButtonText: "No",
  			closeOnConfirm: false,
  			closeOnCancel: false
  		},
  		function(isConfirm){
  			if (isConfirm) {
  				$.ajax({
  					url: 'delete-card/'+id,
  					type: 'GET',
  				})
  				.done(function(response) {
  					console.log(response);
  					if (response.errors == false) {
  						listCards();
  						$('#form-card-edit').hide();
  						$('#form-card-new').show();
  						swal(alert_success, "", 'success');
  					} else {
  						swal(alert_danger, "", 'danger');
  					}
  				})
  				.fail(function(errors) {
  					console.log(errors);
  					swal(alert_danger, "", 'danger');
  				});
  			} else {
  				swal(cancelled, "", "error");
  			}
  		});
  	});
  }

 /**
  * Adds a card.
  */
  function addCard() {
  	$('.add-card').click(function(event) {
  		$('#form-card-new').show();
  		$('#form-card-edit').hide();
  	});
  }

 /**
  * Click button cancel form card
  */
  function clickBtnCancel() {
  	$('.delete-btn').click(function(event) {
  		$('input[name=name]').val('');
  		$('input[name=card_number]').val('');
  		$('input[name=month]').val('');
  		$('input[name=year]').val('');
  		$('input[name=code]').val('');
  	});
  }

 /**
  * Opens a pay.
  */
  function openPay() {
  	OpenPay.setId(OPENPAY_ID);
  	OpenPay.setApiKey(OPENPAY_API_KEY);
  	OpenPay.setSandboxMode(MODE);
  	var deviceSessionId = OpenPay.deviceData.setup();
  	$('input[name=device_session_id]').val(deviceSessionId);
  }

 /**
  * Saves a card.
  */
  function saveCard() {
  	$('#save-new-card').click(function(event) {
  		event.preventDefault();
  		var validate_card = OpenPay.card.validateCardNumber($('input[name=card_number]').val());
  		var validate_cvc = OpenPay.card.validateCVC($('input[name=code]').val());
  		var validate_cvc_card = OpenPay.card.validateCVC($('input[name=code]').val(),$('input[name=card_number]').val());
  		var validate_expiration = OpenPay.card.validateExpiry($('input[name=month]').val(), $('input[name=year]').val());
  		var length_month = $('input[name=month]').val().length;
  		var length_year = $('input[name=year]').val().length;
  		var name = $('input[name=name]').val();
  		if ($.trim(name) == '') {
  			$('#alert-warning-name').show();
  			setTimeout(function(){
  				$("#alert-warning-name").hide(2000);
  			}, 4000);
  		} else if (validate_card == false) {
  			$('#alert-warning-numcard').show();
  			setTimeout(function(){
  				$("#alert-warning-numcard").hide(2000);
  			}, 4000);
  		} else if (length_month < 1 || length_month > 2 || length_year != 2) {
  			$('#alert-warning-monthyear').show();
  			setTimeout(function(){
  				$("#alert-warning-monthyear").hide(2000);
  			}, 4000);
  		} else if (validate_expiration == false) {
  			$('#alert-warning-expiration').show();
  			setTimeout(function(){
  				$("#alert-warning-expiration").hide(2000);
  			}, 4000);
  		} else if (validate_cvc == false) {
  			$('#alert-warning-cvc').show();
  			setTimeout(function(){
  				$("#alert-warning-cvc").hide(2000);
  			}, 4000);
  		} else if (validate_cvc_card == false) {
  			$('#alert-warning-cvc-card').show();
  			setTimeout(function(){
  				$("#alert-warning-cvc-card").hide(2000);
  			}, 4000);
  		} else {
  			OpenPay.token.extractFormAndCreate('form-card-new', success_callbak, error_callbak);
  		}
  	});

  	var success_callbak = function(response) {
  		$('#save-new-card').html('<i class="fa fa-spinner fa-spin" style="color: white;"></i> '+text_loading).prop('disabled', true);
  		var token_id = response.data.id;
  		var device_session_id = $('input[name=device_session_id]').val();
  		var method = $('input:radio[name=method]:checked').val();
  		$.ajax({
  			url: 'cards',
  			type: 'POST',
  			dataType: 'json',
  			data: {
  				method: method,
  				device_session_id: device_session_id,
  				token_id: token_id,
  			},
  		})
  		.done(function(response) {
  			console.log(response);
  			if (response.errors == false) {
  				$("#form-card-new")[0].reset();
  				listCards();
  				swal(alert_success, "", 'success');
  			} else if (response.errors == true) {
  				swal(response.data[0], "", 'warning');
  			} else {
  				swal(alert_danger, "", 'danger');
  			}
  		})
  		.fail(function(errors) {
  			console.log(errors);
  			swal(alert_danger, "", 'danger');
  		})
  		.always(function() {
  			$('#save-new-card').text(btn_save).prop('disabled', false);
  		});

  	};

  	var error_callbak = function(response) {
  		console.log(response);
  		$('#save-new-card').text(btn_save).prop('disabled', false);
  	};
  }

/**
 * Click function button new address.
 */
 function clickButtonNew() {
 	$(".add-address").click(function() {
 		showFormNew();
 	});
 };

/**
 * Click function button cancel address.
 */
 function clickButtonCancel() {
 	$("#cancel-address").click(function() {
 		$("#form-address-new")[0].reset();
 	});
 };

/**
 * Shows the form edit address.
 */
 function showFormEdit() {
 	$("#form-address-new").hide();
 	$(".without-address").hide();
 	$("#form-address-edit").show();
 	$(".with-address").show();
 }

/**
 * Shows the form new address.
 */
 function showFormNew() {
 	$("#form-address-new").show();
 	$(".without-address").show();
 	$("#form-address-edit").hide();
 	$(".with-address").hide();
 }

/**
 * Gets the address type.
 */
 function getAddressType() {
 	$.get('get_address_type', function(data) {
 		var select = '<option value="" >...</option>';
 		$.each(data, function(index, val) {
 			select += '<option value="'+val.address_types_id+'" >' + val.type+ '</option>';
 			$("#address_types").html(select);
 			$("#address_types_edit").html(select);
 		});
 		$(".nice-select").hide();
 		$("#address_types").show();
 		$("#address_types_edit").show();
 	});
 }

/**
 * Gets the address.
 */
 function getAddress() {
 	var etiqueta = "";
 	$.get('get_address', function(data) {
 		if (data.length >0) {
 			showFormNew();
 			$.each(data, function(index, val) {
 				etiqueta += '<a class="btn nav-link active list-edit" id="v-pills-home-tab" data-toggle="pill"  role="tab" aria-controls="v-pills-home" aria-selected="true" name="'+val.addresses_id+'">'+val.address_types.address_type_translations[0].type+' </a></br>';
 			});
 			$(".address-list-box").html(etiqueta);
 		} else {
 			showFormNew();
 		}
 		$(".list-edit").click(function() {
 			var id = this.name;
 			showFormEdit();
 			$.each(data, function(index, val) {
 				if (val.addresses_id == id) {
 					getForm(val);
 				}
 			});
 		});
 	});
 }

/**
 * Gets the form.
 *
 * @param      {Function}  val     The value
 */
 function getForm(val) {
 	$("#addres_id").val(val.addresses_id);
 	$("#address_types_edit").val(val.address_types_id);
 	$("#street_edit").val(val.addresses.street);
 	$("#exterior_number_edit").val(val.addresses.exterior_number);
 	$("#interior_number_edit").val(val.addresses.interior_number);
 	$("#zipcode_edit").val(val.addresses.zipcode);
 	$("#town_edit").val(val.addresses.town);
 	$("#city_edit").val(val.addresses.city);
 	$("#state_edit").val(val.addresses.state);
 	$("#countrys_edit").val(val.addresses.country);
 	$("#description_edit").val(val.addresses.description);
 	$(".text-type-address").html(val.address_types.address_type_translations[0].type);
 }

/**
 * Saves an address.
 */
 function saveAddress() {
 	$('#save-new-address').click(function(event) {
 		event.preventDefault();
 		var street = $('input[name=street]').val();
 		var exterior_number = $('input[name=exterior_number]').val();
 		var town = $('input[name=town]').val();
 		var city = $('input[name=city]').val();
 		var zipcode = $('input[name=zipcode]').val();
 		var country = $('select[name=country]').val();
 		var address_types = $('select[name=address_types]').val();
 		if ($.trim(street) == '' || $.trim(exterior_number) == '' ||
 			$.trim(town) == '' || $.trim(city) == '' ||
 			$.trim(zipcode) == '' || $.trim(country) == '' ||
 			$.trim(address_types) == '') {
 			$('#alert-warning-add-address').show();
 		setTimeout(function(){
 			$("#alert-warning-add-address").hide(2000);
 		}, 4000);
 	} else {
 		$('#save-new-address').html('<i class="fa fa-spinner fa-spin" style="color: white;"></i> '+text_loading).prop('disabled', true);
 		var formData = new FormData($('#form-address-new')[0]);
 		$.ajax({
 			url: 'address',
 			type: 'POST',
 			cache: false,
 			contentType: false,
 			processData: false,
 			dataType: 'json',
 			data: formData,
 		})
 		.done(function(response) {
 			console.log(response);
 			if (response.errors == false) {
 				getAddress();
 				showFormEdit();
 				$("#form-address-new")[0].reset();
 				swal(alert_success, "", 'success');
 			} else {
 				swal(alert_danger, "", 'danger');
 			}
 		})
 		.fail(function(errors) {
 			console.log(errors);
 			swal(alert_danger, "", 'danger');
 		})
 		.always(function() {
 			$('#save-new-address').text(btn_save).prop('disabled', false);
 		});
 	}
 });
 }

/**
 * Edit an address.
 */
 function editAddress() {
 	$('#save-edit-address').click(function(event) {
 		event.preventDefault();
 		var street = $('input[id=street_edit]').val();
 		var exterior_number = $('input[id=exterior_number_edit]').val();
 		var town = $('input[id=town_edit]').val();
 		var city = $('input[id=city_edit]').val();
 		var zipcode = $('input[id=zipcode_edit]').val();
 		var country = $('select[id=countrys_edit]').val();
 		var address_types = $('select[id=address_types_edit]').val();
 		if ($.trim(street) == '' || $.trim(exterior_number) == '' ||
 			$.trim(town) == '' || $.trim(city) == '' ||
 			$.trim(zipcode) == '' || $.trim(country) == '' ||
 			$.trim(address_types) == '') {
 			$('#alert-warning-edit-address').show();
 		setTimeout(function(){
 			$("#alert-warning-edit-address").hide(2000);
 		}, 4000);
 	} else {
 		$('#save-edit-address').html('<i class="fa fa-spinner fa-spin" style="color: white;"></i> '+text_loading).prop('disabled', true);
 		var formData = new FormData($('#form-address-edit')[0]);
 		$.ajax({
 			url: 'address/edit',
 			type: 'POST',
 			cache: false,
 			contentType: false,
 			processData: false,
 			dataType: 'json',
 			data: formData,
 		})
 		.done(function(response) {
 			console.log(response);
 			if (response.errors == false) {
 				getAddress();
 				showFormEdit();
 				$("#form-address-edit")[0].reset();
 				swal(alert_success, "", 'success');
 			} else {
 				swal(alert_danger, "", 'danger');
 			}
 		})
 		.fail(function(errors) {
 			console.log(errors);
 			swal(alert_danger, "", 'danger');
 		})
 		.always(function() {
 			$('#save-edit-address').text(btn_edit).prop('disabled', false);
 		});
 	}
 });
 }

 function deleteAddress() {
 	$('#delete-address').click(function(event) {
 		event.preventDefault();
 		var id = $('input[name=addres_id]').val();
 		swal({
 			title: alert_delete_address,
 			type: "warning",
 			showCancelButton: true,
 			confirmButtonColor: "#DD6B55",
 			confirmButtonText: yes,
 			cancelButtonText: "No",
 			closeOnConfirm: false,
 			closeOnCancel: false
 		},
 		function(isConfirm){
 			if (isConfirm) {
 				$.ajax({
 					url: 'address/'+id,
 					type: 'DELETE',
 				})
 				.done(function(response) {
 					console.log(response);
 					if (response.errors == false) {
 						getAddress();
 						showFormEdit();
 						$("#form-address-edit")[0].reset();
 						swal(alert_success, "", 'success');
 					} else {
 						swal(alert_danger, "", 'danger');
 					}
 				})
 				.fail(function(errors) {
 					console.log(errors);
 					swal(alert_danger, "", 'danger');
 				});
 			} else {
 				swal(cancelled, "", "error");
 			}
 		});
 	});
 }