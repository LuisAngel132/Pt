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
	CART_GET = '/v1/cart';
	CART_DELETE = '/v1/cart';
	ADDRESSES_GET = '/v1/addresses';
	ADDRESSES_CREATE = '/v1/addresses';
	RESOURCES_GET_ADDRESS_TYPES = '/v1/resources/types/address';
	RESOURCES_GET_FESS = '/v1/resources/fees';
	ORDERS_CREATE = '/v1/orders';
	paypal_enviroment = $('meta[name="paypal_enviroment"]').attr('ccontent');

	deviceSessionId = OpenPay.deviceData.setup();
	lang = $('meta[name="language"]').attr('content');
	token = $('meta[name="token"]').attr('content');
	cartResponse = "";

	if (lang === 'es') {
		SHIPPING_PRICE_NORMAL = 99;
	}
	if (lang === 'en') {
		SHIPPING_PRICE_NORMAL = 6;
	}

	SHIPPING_PRICE = SHIPPING_PRICE_NORMAL;
	MAX_PRODUCTS = 3;
	flagShippingFree = false;
	flagAppliedPromotion = false;
	couponData = "";

	coupon = {
		id: "",
		data: "",
		code: "",
		applied: ""
	}
	COUPONS_VALIDATE = '/v1/coupons/'+ coupon.code +'/validate';

	initialOrderSummary = 0;
	orderSummary = {
		shipping: 0,
		charges: 0,
		discount: 0,
		discountPercent: 0,
		subtotal: 0,
		total: 0,
		totalNormal: 0,
		feesSummary: []
	}

	language = getTranslations();

	getTotal();
	getAddressTypes();
	getResourceFees();
	getAddresses(false, null);
	initPaypalPayments();
	openPay();
	saveCard();
	/*Save new address*/
	$("#save-address").click(function(event) {
		createAddressObject();
	});
	/*Generate order*/
	$("#generate-order").click(function() {
		if ($('input[name=accept-terms]').prop('checked') == false ) {
			swal("",languageObject[lang].accept_terms_checkout,"warning");
		} else {
			if ( $('select[id=type_payment]').val() == 1 ) {
				if (!validForm(false, false)) {
					createCardOrder();
				}
			}
			if ( $('select[id=type_payment]').val() == 2 ) {
				if (!validForm(false, false)) {
					createCardOrder();
				}
			}
			if ( $('select[id=type_payment]').val() == 3 ) {
				if (!validForm(false, true)) {
					createStoreOrder();
				}
			}
			if ( $('select[id="type_payment"]').val() == "" ) {
				swal("",languageObject[lang].select_a_payment_method,"warning");
			}
		}
	});
	/*Apply coupon*/
	$("#apply-coupon").click(function(){
		var code = $("#coupon_code").val();
		if ( code === "" ) {
			$("#alert-coupon").show();
			setTimeout(function(){
				$("#alert-coupon").hide(500);
			}, 2000);
		} else {
			couponValidate(code);
		}
	});
	/*Generate order with paypal*/
	$("#paypal-payment-validate").click(function(event){
		if ($('input[name=accept-terms]').prop('checked') == false ) {
			swal("",languageObject[lang].accept_terms_checkout,"warning");
		} else {
			if ( !validForm(true, false) ) {
				$('.collapse').collapse("toggle");
			}
		}
	});
	changeOrderDelivery();
});

/**
 * Change order delivery.
 *
 * @return {[type]} [description]
 */
 function changeOrderDelivery() {
 	$('.send-address').click(function(event) {
 		event.preventDefault();
 		if (coupon.applied == false) {
 			if ( getProductsQuantity() >= MAX_PRODUCTS) {
 				$("#envio").text("$ " + parseFloat(0).toFixed(2) );
 				$("#pick_up_site").prop('checked', false);
 				var total_with_shipping = parseFloat(getSummaryTotal());
 				$("#amount").text("$ " +  parseFloat( total_with_shipping ).toFixed(2) );
 			} else {
 				$("#envio").text("$ " + parseFloat(99).toFixed(2) );
 				$("#pick_up_site").prop('checked', false);
 				var total_with_shipping = parseFloat(getSummaryTotal());
 				$("#amount").text("$ " +  parseFloat( total_with_shipping ).toFixed(2) );
 			}
 		}
 	});
 	$('.pick-up').click(function(event) {
 		event.preventDefault();
 		if (coupon.applied == false) {
 			if ( getProductsQuantity() >= MAX_PRODUCTS) {
 				$("#envio").text("$ " + parseFloat(0).toFixed(2) );
 				$("#pick_up_site").prop('checked', true);
 				var total_without_shipping = parseFloat(getSummaryTotal());
 				$("#amount").text("$ " +  parseFloat( total_without_shipping ).toFixed(2) );
 			} else {
 				$("#envio").text("$ " + parseFloat(0).toFixed(2) );
 				$("#pick_up_site").prop('checked', true);
 				var total_without_shipping = parseFloat(getSummaryTotal()) - parseFloat(SHIPPING_PRICE_NORMAL);
 				$("#amount").text("$ " +  parseFloat( total_without_shipping ).toFixed(2) );
 			}
 		}
 	});
 }

 function hideErrorMessages(flagPaypal, flagStore){
 	$("#referenceHelp").css('display','none');
 	$("#titleHelp").css('display','none');
 	$("#toHelp").css('display','none');
 	$("#messageHelp").css('display','none');

 	if (!flagPaypal, !flagStore) {
 		$("#paymentTypeHelp").css('display','none');
 	}
 }

 function validForm(flagPaypal, flagStore){
 	hideErrorMessages(flagPaypal);
 	var errors = false;

 	if ( !flagPaypal && !flagStore ) {
 		if ( $('select[id="type_payment"]').val() === "" ) {
 			errors = true;
 			$("#paymentTypeHelp").css('display','block');
 			$("#paymentTypeHelp").html(languageObject[lang].select_a_payment_method);
 			$('select[id="type_payment"]').focus();
 		}

 		if ( $('select[id="type_payment"]').val() !== "" ) {
 			if ( getPaymentSourceID() === "" ) {
 				errors = true;
 				swal("",languageObject[lang].select_a_card_to_complete_the_transaction,"warning");
 			}
 		}
 	}

 	/*Gift option*/
 	if ($("input[name=check][value=2]").prop('checked')) {
 		console.log("CHECKBOX CHECKED");
 	}

 	if ( $("input[name=check][value=2]").prop('checked') ) {

 		if ( $("input[name=title]").val() === "" ) {
 			errors = true;
 			console.log("TITLE VALUE " + $("input[name=title]").val() );
 			$("#titleHelp").css('display','block');
 			$("#titleHelp").html(languageObject[lang].add_a_title);
 			$("input[name=title]").focus();
 		}

 		if ( $("input[name=to]").val() === "" ) {
 			errors = true;
 			console.log("TITLE VALUE " + $("input[name=to]").val() );
 			$("#toHelp").css('display','block');
 			$("#toHelp").html(languageObject[lang].add_the_recipient);
 			$("input[name=to]").focus();
 		}

 		if ( $("textarea[name=message]").val() === "" ) {
 			errors = true;
 			console.log("TITLE VALUE " + $("textarea[name=message]").val() );
 			$("#messageHelp").css('display','block');
 			$("#messageHelp").html(languageObject[lang].add_a_message);
 			$("textarea[name=message]").focus();
 		}
 	}
 	console.log("ERRORS: " + errors);
 	return errors;
 }

 function getTranslations(language){
 	languageObject = {
 		es : {
 			valid_coupon : 'Cupón válido',
 			an_error_has_occurred : 'ha ocurrido un error',
 			an_error_has_not_found_code : 'El código ingresado no existe.',
 			you_have_already_applied_this_coupon: 'Ya has aplicado este cupón',
 			insufficient_quantity_of_products: 'Cantidad insuficiente de productos',
 			this_coupon_is_valid_in_the_purchase_of: 'Este cupón es válido en la compra de ',
 			or_more_products: ' o más productos ',
 			free_shipping: 'Envío gratis',
 			by_purchasing: 'por la compra de ',
 			processing_transaction_wait_a_moment: 'Procesando transacción espera un momento...',
 			successful_transaction: 'Transacción exitosa',
 			the_address_has_been_added: 'La dirección ha sido agregada',
 			add_a_reference: 'Agrega una referencia',
 			select_a_payment_method: 'Selecciona un método de pago',
 			add_a_title: 'Agrega un título',
 			add_the_recipient: 'Agrega el destinatario',
 			add_a_message: 'Agrega un mensaje',
 			select_a_card_to_complete_the_transaction: 'Selecciona una tarjeta para realizar la transacción',
 			the_code_is_not_valid: 'El código no es válido',
 			select_a_payment_method: 'Selecciona un método de pago',
 			error_transaccion_currency: 'Las transacciones realizadas a través de tiendas de conveniencia deben utilizar el formado de moneda local MXN',
 			loading: 'Cargando...',
 			save: 'Guardar',
 			accept_terms_checkout: 'Debes aceptar los términos y condiciones para realizar la compra.',
 		},
 		en : {
 			valid_coupon : 'Valid coupon',
 			an_error_has_occurred : 'an error has ocurred',
 			an_error_has_not_found_code : 'The code entered does not exist.',
 			you_have_already_applied_this_coupon: 'You have already applied this coupon',
 			insufficient_quantity_of_products: 'Insufficient quantity of products',
 			this_coupon_is_valid_in_the_purchase_of: 'This coupon is valid in the purchase of ',
 			or_more_products: ' or more products',
 			free_shipping: 'free shipping',
 			by_purchasing: 'by purchasing ',
 			processing_transaction_wait_a_moment: 'Processing transaction wait a moment...',
 			successful_transaction: 'Succesful transaction',
 			the_address_has_been_added: 'The address has been added',
 			add_a_reference: 'Add a reference',
 			select_a_payment_method: 'Select a payment method',
 			add_a_title: 'Add a title',
 			add_the_recipient: 'Add the recipient',
 			add_a_message: 'Add a message',
 			select_a_card_to_complete_the_transaction: 'Select a card to complete the transaction',
 			the_code_is_not_valid: 'The code is not valid',
 			select_a_payment_method: 'Select a payment method',
 			error_transaccion_currency: 'Transactions made through convenience stores must use the local currency MXN form',
 			loading: 'Loading...',
 			save: 'Save',
 			accept_terms_checkout: 'You must accept the terms and conditions to make the purchase.',
 		}
 	}
 }

/**
 * Validate coupon.
 *
 * @param  {string} code The code
 *
 * @return {[type]}      [description]
 */
 function couponValidate(code){
 	showProgress('Comprobando código');
 	$.ajax({
 		url: BASE_URL + '/v1/coupons/'+ code +'/validate',
 		type: 'GET',
 		headers:{
 			'Authorization': 'Bearer ' + token,
 			'Content-Type': 'application/json',
 			'Accept-Language': lang
 		},
 		dataType: 'json',
 	})
 	.done(function(response) {
 		console.log("COUPONS VALIDATE : " + JSON.stringify(response) );
 		if (response.type === "success") {
 			swal(response.data.code, languageObject[lang].valid_coupon, "success");
 			processCouponResponse(response.data);
 			$('.send-address').removeAttr('href');
 			$('.send-address').attr("style", "cursor: not-allowed;");
 			$('.pick-up').removeAttr('href');
 			$('.pick-up').attr("style", "cursor: not-allowed;"); 			
 		}
 		if (response.type === "danger") {
 			swal("", response.data ,"warning");
 		}
 		if (response.type === "errors") {
 			swal("", languageObject[lang].an_error_has_occurred ,"error");
 		}
 		if (response.type === "warning") {
 			swal("", languageObject[lang].an_error_has_occurred ,"warning");
 		}
 	}).fail(function(error) {
 		console.log("coupon validate response error " + JSON.stringify(error) );
 		swal("", languageObject[lang].an_error_has_not_found_code ,"warning");
 	}).always(function() {
 		console.log("coupon validate response complete");
 	});
 }

 /**
  * Proccess coupon response.
  *
  * @param  {[type]} data [description]
  *
  * @return {[type]}      [description]
  */
  function processCouponResponse(data){
  	if (freeShippingNormal) {
  		removeFreeShipping();
  	}

  	if ( coupon.id === "" ){
  		if ( data.discount_types[0].free_shipping === 1 ) {
  			freeShippingPromotion(data);
  		}
  		if ( data.discount_types[0].free_tshirts === 1 ) {
  		}
  		if ( data.discount_types[0].have_discount === 1 ) {
  			discountPromotion(data);
  		}
  	} else {
  		if ( coupon.id === data.id ) {
  			swal(languageObject[lang].you_have_already_applied_this_coupon, "","warning");
  		} else {
  			removeCoupon();
			// aplicar nuevo cupon
			if ( data.discount_types[0].free_shipping === 1 ) {
				freeShippingPromotion(data);
			}
			if ( data.discount_types[0].free_tshirts === 1 ) {
			}
			if ( data.discount_types[0].have_discount === 1 ) {
				discountPromotion(data);
			}
		}
	}
}

/**
 * Remove free shipping.
 *
 * @return {[type]} [description]
 */
 function removeFreeShipping(){
 	if (freeShippingNormal) {
 		flagAppliedPromotion = false;
 		flagShippingFree = false;

 		if ($("#pick_up_site").prop('checked') == true) {
 			SHIPPING_PRICE = 0;
 			orderSummary.shipping = SHIPPING_PRICE;
 			$("#envio").text("$ " + parseFloat(SHIPPING_PRICE).toFixed(2) );
 		} else {
 			SHIPPING_PRICE = SHIPPING_PRICE_NORMAL;
 			orderSummary.shipping = SHIPPING_PRICE;
 			$("#envio").text("$ " + parseFloat(SHIPPING_PRICE).toFixed(2) );
 		}

 		$("input[name=amount]").val( getSummaryTotal() );
 		$("#amount").text("$ " + parseFloat( getSummaryTotal() ).toFixed(2) );
 	}
 }

 function freeShippingPromotion(data){
 	if ( getProductsQuantity() >= data.discount_types[0].max_products  ) {
 		coupon.data = data;
 		coupon.id = data.id;
 		coupon.code = data.code;
 		coupon.applied = true;

 		SHIPPING_PRICE = 0;

 		$('input[name="codes_id"]').val(data.id);
 		$("input[name=amount]").val( getSummaryTotal() );
 		$("#amount").text("$ " +  parseFloat( getSummaryTotal() ).toFixed(2) );

 	} else {
 		swal(languageObject[lang].insufficient_quantity_of_products,
 			languageObject[lang].this_coupon_is_valid_in_the_purchase_of
 			+ data.discount_types[0].max_products + languageObject[lang].or_more_products ,"warning");
 	}
 }
 function discountPromotion(data){
 	if ( getProductsQuantity() >= data.discount_types[0].max_products  ) {
 		coupon.data = data;
 		coupon.id = data.id;
 		coupon.code = data.code;
 		coupon.applied = true;

 		discount = data.discount_types[0].discount_percent / 100;
 		orderSummary.discountPercent = discount;
 		discountQuantity = getSummaryTotal() * discount;
 		console.log("DESCUENTO CANTIDAD: " +  discountQuantity);
 		console.log("SUBTOTAL: " +  orderSummary.subtotal );


 		$('input[name="codes_id"]').val(data.id);

 		$("#descount").text("$ " + parseFloat(orderSummary.discount).toFixed(2));
 		$("#amount").text("$ " +  parseFloat( getSummaryTotal() ).toFixed(2) );

 	} else {
 		swal(languageObject[lang].insufficient_quantity_of_products,
 			languageObject[lang].this_coupon_is_valid_in_the_purchase_of
 			+ data.discount_types[0].max_products + languageObject[lang].or_more_products ,"warning");
 	}
 }
 function getSummaryTotal(){

 	var total = 0;
 	total += orderSummary.shipping;
 	total += orderSummary.charges;
 	total += orderSummary.subtotal;

 	orderSummary.discount = total * orderSummary.discountPercent;

 	total -= orderSummary.discount;

 	orderSummary.total = total;
 	return parseFloat( total ).toFixed(2);
 }
 function freeShippingNormal(){
 	if ( getProductsQuantity() >= MAX_PRODUCTS ) {
 		flagAppliedPromotion = true;
 		flagShippingFree = true;
 		SHIPPING_PRICE = 0;

 		$("#envio").text("$ " + parseFloat(SHIPPING_PRICE).toFixed(2) );

 		orderSummary.shipping = SHIPPING_PRICE;

 		$("input[name=amount]").val( getSummaryTotal() );
 		$("#amount").text("$ " + parseFloat( getSummaryTotal() ).toFixed(2) );

 		swal(languageObject[lang].free_shipping,
 			languageObject[lang].by_purchasing + 	MAX_PRODUCTS +
 			languageObject[lang].or_more_products,
 			"info");

 	} else {
 		total = parseFloat( getSummaryTotal() ).toFixed(2)
 		totall = parseFloat( getSummaryTotal() ).toFixed(2)
 		var total = numberWithCommas( getSummaryTotal() );
 		$("#amount").html("$ "+ total);
 		$("input[name=amount]").val(total);
 		$("input[name=amountt]").val(totall);
 	}
 }

 function removeCoupon(){
 	if ( coupon.data.discount_types[0].free_shipping === 1 ) {
 	}
 	if ( coupon.data.discount_types[0].free_tshirts === 1 ) {
 	}
 	if ( coupon.data.discount_types[0].have_discount === 1 ) {
 		console.log("MAX PRODUCTS:" + couponData.discount_types[0].max_products);
 		if ( getProductsQuantity() >= couponData.discount_types[0].max_products   ) {
 			discount = couponData.discount_types[0].discount_percent / 100;
 			orderSummary.total = orderSummary.total - (orderSummary.total * discount) ;
 			$("#descount").text("$ " + parseFloat(orderSummary.totalNormal * discount).toFixed(2));
 			$("#amount").text("$ " +  parseFloat(orderSummary.total).toFixed(2) );
 			$('input[name="codes_id"]').val(couponData.id);
 		}
 	}
 }
 function getTotal() {
 	envio =0;
 	descuento =0;
 	costo =0;
 	subtotal =0;
 	total =0;
 	$.get('valSession', function(data) {
 		cart();
 		console.log("ORDER VALUES: " + JSON.stringify(data) );
 		initialOrderSummary = data;
 		orderSummary.shipping = SHIPPING_PRICE;
 		orderSummary.charges = 0;
 		orderSummary.discount = data.descuento;
 		orderSummary.total = data.total;
 		orderSummary.subtotal = 0;
 		orderSummary.totalNormal = data.total;


 		envio = parseFloat(SHIPPING_PRICE).toFixed(2)
 		var envio = numberWithCommas(envio);
 		$("#envio").html("$ "+envio);
 		$("input[name=envio]").val(envio);

 		descuento = parseFloat(data.descuento).toFixed(2)
 		var descuento = numberWithCommas(descuento);
 		$("#descount").html("$ "+descuento);

 		costo = parseFloat(data.cost).toFixed(2)
 		var costo = numberWithCommas(costo);
 		$("#cost").html("$ "+costo);

 		subtotal = parseFloat(orderSummary.subtotal).toFixed(2)
 		var subtotal = numberWithCommas(subtotal);
 		$("#subtotal-carrito").html("$ "+subtotal);
 		$("input[name=subtotal]").val(subtotal);

 	});
 }

/**
 * Create order with payment method is store.
 *
 * @return {[type]} [description]
 */
 function createStoreOrder () {
 	var giftMesseageObject = getGiftMessageObject();
 	/*Validation of shipping amount*/
 	if ($( "#pick_up_site" ).prop('checked') == true) {
 		var SHIPPING_AMOUNT = 0;
 	}  else {
 		if (getProductsQuantity() >= MAX_PRODUCTS) {
 			if (coupon.applied == false) {
 				var SHIPPING_AMOUNT = 0;
 			} else {
 				var SHIPPING_AMOUNT = SHIPPING_PRICE_NORMAL;
 			}
 		} else {
 			var SHIPPING_AMOUNT = SHIPPING_PRICE_NORMAL;
 		}
 	}
 	var order = {
 		method: "store",
 		currency: getCurrency(),
 		is_billable: $( "#is_billable" ).prop('checked'),
 		payment_method_id: $('select[id="type_payment"]').val(),
 		is_picking_up_at_location: $( "#pick_up_site" ).prop('checked'),
 		addresses_id: $('select[name="address-user"]').val(),
 		origin: "web",
 		description:  $('textarea[name="descriptions"]').val(),
 		products: getProducts(),
 		codes_id: $('input[name="codes_id"]').val(),
 		shipping_amount: SHIPPING_AMOUNT.toString(),
 		fees: getFeesArray(),
 		gift_message: {
 			title: giftMesseageObject.title,
 			to: giftMesseageObject.to,
 			message: giftMesseageObject.message
 		}
 	}

 	if ( !$('input[name="codes_id"]').val() ) {
 		delete order.codes_id;
 	}
 	if ($('textarea[name="descriptions"]').val() == '' ) {
 		delete order.description;
 	}
 	if (giftMesseageObject.title == '' || giftMesseageObject.to == '' || giftMesseageObject.message) {
 		delete order.gift_message;
 	}
 	if ($( "#pick_up_site" ).prop('checked') == true ) {
 		delete order.addresses_id;
 	}

 	checkboxArray = $("input[name=check]");
 	$.each(checkboxArray, function( index, item ) {
 		if ( !$(item).prop('checked') ) {
 			if ($(this).val() == 1) {
 				delete order.fees;
 			}
 			if ($(this).val() == 2) {
 				delete order.gift_message;
 			}
 		}
 	});

 	sendOrder( JSON.stringify(order) );
 }

 /**
  * Create order with payment method is debit or credit card.
  *
  * @return {[type]} [description]
  */
  function createCardOrder () {
  	var giftMesseageObject = getGiftMessageObject();
  	/*Validation of shipping amount*/
  	if ($( "#pick_up_site" ).prop('checked') == true) {
  		var SHIPPING_AMOUNT = 0;
  	}  else {
  		if (getProductsQuantity() >= MAX_PRODUCTS) {
  			if (coupon.applied == false) {
  				var SHIPPING_AMOUNT = 0;
  			} else {
  				var SHIPPING_AMOUNT = SHIPPING_PRICE_NORMAL;
  			}
  		} else {
  			var SHIPPING_AMOUNT = SHIPPING_PRICE_NORMAL;
  		}
  	}
  	var order = {
  		method: "card",
  		currency: getCurrency(),
  		is_billable: $( "#is_billable" ).prop('checked'),
  		payment_method_id: $('select[id="type_payment"]').val(),
  		is_picking_up_at_location: $( "#pick_up_site" ).prop('checked'),
  		addresses_id: $('select[name="address-user"]').val(),
  		payment_source_id: getPaymentSourceID(),
  		device_session_id: deviceSessionId,
  		origin: "web",
  		description:  $('textarea[name="descriptions"]').val(),
  		products: getProducts(),
  		codes_id: $('input[name="codes_id"]').val(),
  		shipping_amount: SHIPPING_AMOUNT.toString(),
  		fees: getFeesArray(),
  		gift_message: {
  			title: giftMesseageObject.title,
  			to: giftMesseageObject.to,
  			message: giftMesseageObject.message
  		}
  	}

  	if ( !$('input[name="codes_id"]').val() ) {
  		delete order.codes_id;
  	}
  	if ($('textarea[name="descriptions"]').val() == '' ) {
  		delete order.description;
  	}
  	if (giftMesseageObject.title == '' || giftMesseageObject.to == '' || giftMesseageObject.message) {
  		delete order.gift_message;
  	}
  	if ($( "#pick_up_site" ).prop('checked') == true ) {
  		delete order.addresses_id;
  	}

  	$.each(checkboxArray, function( index, item ) {
  		if ( !$(item).prop('checked') ) {
  			if ($(this).val() == 1) {
  				delete order.fees;
  			}
  			if ($(this).val() == 2) {
  				delete order.gift_message;
  			}
  		}
  	});

  	sendOrder( JSON.stringify(order) );
  }

 /**
  * Create order with payment method paypal.
  *
  * @param  {[type]} amount              [description]
  * @param  {[type]} paypalTransactionID [description]
  *
  * @return {[type]}                     [description]
  */
  function createPaypalOrder (amount, paypalTransactionID) {
  	var giftMesseageObject = getGiftMessageObject();
  	/*Validation of shipping amount*/
  	if ($( "#pick_up_site" ).prop('checked') == true) {
  		var SHIPPING_AMOUNT = 0;
  	}  else {
  		if (getProductsQuantity() >= MAX_PRODUCTS) {
  			if (coupon.applied == false) {
  				var SHIPPING_AMOUNT = 0;
  			} else {
  				var SHIPPING_AMOUNT = SHIPPING_PRICE_NORMAL;
  			}
  		} else {
  			var SHIPPING_AMOUNT = SHIPPING_PRICE_NORMAL;
  		}
  	}
  	var order = {
  		method: "store",
  		currency: getCurrency(),
  		is_billable: $( "#is_billable" ).prop('checked'),
  		payment_method_id: 4,
  		is_picking_up_at_location: $( "#pick_up_site" ).prop('checked'),
  		addresses_id: $('select[name="address-user"]').val(),
  		paypal_trasaction_id: paypalTransactionID,
  		amount: getSummaryTotal().toString(),
  		origin: "web",
  		description:  $('textarea[name="descriptions"]').val(),
  		products: getProducts(),
  		codes_id: $('input[name="codes_id"]').val(),
  		shipping_amount: SHIPPING_AMOUNT.toString(),
  		fees: getFeesArray(),
  		gift_message: {
  			title: giftMesseageObject.title,
  			to: giftMesseageObject.to,
  			message: giftMesseageObject.message
  		}
  	}

  	if ( !$('input[name="codes_id"]').val() ) {
  		delete order.codes_id;
  	}
  	if ($('textarea[name="descriptions"]').val() == '' ) {
  		delete order.description;
  	}
  	if (giftMesseageObject.title == '' || giftMesseageObject.to == '' || giftMesseageObject.message) {
  		delete order.gift_message;
  	}
  	if ($( "#pick_up_site" ).prop('checked') == true ) {
  		delete order.addresses_id;
  	}

  	checkboxArray = $("input[name=check]");
  	$.each(checkboxArray, function( index, item ) {
  		if ( !$(item).prop('checked') ) {
  			if ($(this).val() == 1) {
  				delete order.fees;
  			}
  			if ($(this).val() == 2) {
  				delete order.gift_message;
  			}
  		}
  	});

  	sendOrder( JSON.stringify(order) );
  }
  function sendOrder(jsonParamters) {
  	console.log(jsonParamters);
  	console.log("SENDING ORDER");
  	showProgress(languageObject[lang].processing_transaction_wait_a_moment);
  	delete $.ajaxSettings.headers["'X-CSRF-TOKEN'"];
  	$.ajaxSetup({
  		headers:{
  			'Authorization': 'Bearer ' + token,
  			'Content-Type': 'application/json',
  			'Accept-Language': lang
  		},
  		dataType: 'json',
  	});
  	$.ajax({
  		url: BASE_URL + ORDERS_CREATE,
  		type: 'POST',
  		dataType: 'json',
  		data: jsonParamters
  	})
  	.done(function(response) {
  		console.log(response);
  		if (response.type === "success") {
  			console.log("ORDER SUCCESS DONE");
  			console.log("PRODUCTS TO DELETE "  + JSON.stringify( getProductsToDelete() ) );
  			if (response.data.voucher_url != null)  {
  				window.open(response.data.voucher_url);
  			}
  			deleteCart( getProductsToDelete() );
  		} else if (response.errors === true && response.type == "danger") {
  			swal(response.data[0], "", "warning");
  		} else if (response.type === "errors") {
  			swal("",languageObject[lang].an_error_has_occurred,"error");
  		} else if (response.type === "warning") {
  			swal("",languageObject[lang].an_error_has_occurred,"warning");
  		} else if (response.type === "danger") {
  			swal( "", languageObject[lang].error_transaccion_currency, "error" );
  		} else {
  			swal("",languageObject[lang].an_error_has_occurred,"error");
  		}
  		console.log("send order done " + JSON.stringify(response));
  	}).fail(function(error) {
  		console.log(error);
  		swal("",languageObject[lang].an_error_has_occurred,"error");
  		console.log("send order error " + JSON.stringify(error) );
  	}).always(function() {
  		console.log("send order complete");
  	});
  }
  function clearFieldsAddressForm(){
  	$('#ship-box').prop('checked', false);
  	$('input[name="state"]').val('');
  	$('input[name="city"]').val('');
  	$('input[name="street"]').val('');
  	$('input[name="exterior_number"]').val('');
  	$('input[name="interior_number"]').val('');
  	$('input[name="zipcode"]').val('');
  	$('textarea[name="description"]').val('');
  	$('#ship-box-info').slideToggle(1000);
  }
  function processCreateAddress(response){
  	if (response.type === "success") {
  		swal(languageObject[lang].the_address_has_been_added, "", "success");
  	} else{
  		swal(languageObject[lang].an_error_has_occurred, "", "error");
  	}
  }
  function getAddresses(newAddress, id){
  	$.ajaxSetup({
  		headers:{
  			'Authorization': 'Bearer ' + token,
  			'Content-Type': 'application/json',
  			'Accept-Language': lang
  		},
  		dataType: 'json',
  	});
  	$.ajax({
  		url: BASE_URL + ADDRESSES_GET,
  		type: 'GET'
  	})
  	.done(function(response) {
  		console.log("GET ADDDRESS RESPONSE " + JSON.stringify( response ) );
  		processAddresses(response.data, newAddress, id);
  	}).fail(function(error) {
  		console.log("addresses response error " + JSON.stringify(error) );
  	}).always(function() {
  		console.log("addresses response complete");
  	});
  }
  function processAddresses(data, newAddress, id){
  	var select = '';
  	if (data.length >0) {
  		$.each(data, function(index, address) {
  			select += '<option value="'+address.id+'" >' + address.addresses.street + '</option>';
  			if (index==0) {
  				formAddressShow(address);
  			}
  			if (newAddress && address.id == id) {
  				formAddressShow(address);
  			}
  		});
  		$("#address-type").html(select);
  		if (newAddress) {
  			$("#address-type").val(id);
  			$("#address-type").focus();
  		}
  		$(".show-address").show();
  		$(".not-address").hide();
  	} else{
  		$(".show-address").hide();
  		$(".not-address").show();
  		setTimeout(function(){
  			$(".not-address").hide(2000);
  		}, 3000);
  	}
  	$("#address-type").change(function() {
  		id = $(this).val();
  		$.each(data, function(index, val) {
  			if (val.id == id) {
  				formAddressShow(val);
  			}
  		});
  	});
  }
  function formAddressShow(val) {
  	address = "";
  	address = '<strong>'+val.addresses.street+" "+val.addresses.exterior_number+'</strong><br>'+
  	val.addresses.city+ " ("+val.addresses.zipcode+")"+'<br>'+
  	val.addresses.state+" " +val.addresses.country +'<br>'+
  	"Ref: "+val.addresses.description;
  	$("#detail-address").html(address);
  }
  function getAddressTypes(){
  	$.ajaxSetup({
  		headers:{
  			'Authorization': 'Bearer ' + token,
  			'Content-Type': 'application/json',
  			'Accept-Language': lang
  		},
  		dataType: 'json',
  	});

  	$.ajax({
  		url: BASE_URL + RESOURCES_GET_ADDRESS_TYPES,
  		type: 'GET'
  	})
  	.done(function(response) {
		//console.log("METHOD GET ADDRESS TYPES: " + JSON.stringify(response) );
		processAddressTypes(response.data);
	}).fail(function(error) {
		console.log("address types response error " + JSON.stringify(error) );
	}).always(function() {
		console.log("address types response complete");
	});
}
function processAddressTypes(data){
	var select = '';
	$.each(data, function(index, val) {
		//console.log("ADDRESS TYPES: " + JSON.stringify(val) );
		select += '<option value="'+val.id+'" >' + val.translations[0].pivot.type+ '</option>';
		$("#address-select").html(select);
	});
}
function getProductsQuantity(){
	products = getProducts();
	quantity = 0;
	$.each( products , function( index, value ) {
		quantity += value.quantity;
	});
	console.log("PRODUCTS QUANTITY: " + quantity);
	return quantity;
}
function getResourceFees(){
	$.ajaxSetup({
		headers:{
			'Authorization': 'Bearer ' + token,
			'Content-Type': 'application/json',
			'Accept-Language': lang
		},
		dataType: 'json',
	});
	$.ajax({
		url: BASE_URL + RESOURCES_GET_FESS,
		type: 'GET'
	})
	.done(function(response) {
		if (response.data.length != 0) {
			processFeesResponse(response.data);
		} else {
			$('.gift-options').hide();
		}
		

	}).fail(function(error) {
		console.log("address types response error " + JSON.stringify(error) );
	}).always(function() {
		console.log("address types response complete");
	});
}
function processFeesResponse(data){
	$('.gift-options').show();
	console.log("FEES ARRAY:" );
	console.log(orderSummary.feesSummary);
	console.log("FEES ARRAY CLEAR:" );
	orderSummary.feesSummary.length = 0;
	console.log(orderSummary.feesSummary);

	var check = "";
	$.each(data, function(index, val) {
		console.log("FEE ARRAY INDEX: " + index );
		feeSummary = {
			id: val.id,
			price: val.translations[0].pivot.price
		}
		console.log("FEE SUMMARY OBJECT: " + feeSummary );
		orderSummary.feesSummary.push( feeSummary );
		check += '<label class="container-radio">'+val.translations[0].pivot.name+" $  "+    val.translations[0].pivot.price +' <input type="checkbox" name="check" value="'+val.id+'"><span class="checkmark"></span></label>'
	});

	$(".form-row-first").html(check);
	console.log("FEES ARRAY:");
	console.log( orderSummary.feesSummary );
	setFeesListener();
}
function setFeesListener(){
	$(document).on("click","input[name=check]", function(){
		if (this.checked) {
			if ($(this).val() == 2) {
				$(".card-form").show();
			}
		} else {
			if ($(this).val() == 2) {
				$("input[name=title]").val('');
				$("input[name=to]").val('');
				$("input[name=message]").val('');
				$(".card-form").hide();
			}
		}

		if (this.checked) {
			checkID = $(this).val();
			$.each(orderSummary.feesSummary, function( index, value ) {
				if (value.id == checkID ) {
					orderSummary.charges += parseFloat( value.price );
					orderSummary.total += parseFloat( value.price );
					$("span[name=charges]").text("$ " + parseFloat(orderSummary.charges).toFixed(2) );
					$("#amount").text("$ " + parseFloat( getSummaryTotal() ).toFixed(2));

				}
			});
		} else {
			$.each(orderSummary.feesSummary, function( index, value ) {
				if (value.id == checkID) {
					orderSummary.charges -= parseFloat( value.price );
					orderSummary.total -= parseFloat( value.price );
					$("span[name=charges]").text("$ " + parseFloat(orderSummary.charges).toFixed(2) );
					$("#amount").text("$ " + parseFloat( getSummaryTotal() ).toFixed(2));
				}
			});
		}
		$("#descount").text("$ " + parseFloat(orderSummary.discount).toFixed(2) );

		console.log("DISCOUNT: " + parseFloat( orderSummary.discount).toFixed(2) );




	});
}
function getFees() {
	var check = "";
	warning =	$("input[name=alert_warning]").val();
	error =	$("input[name=alert_error]").val();
	success =	$("input[name=alert_success]").val();
	title =	$("input[name=title]");
	to =	$("input[name=to]");
	message =	$("textarea[name=message]");
	$.get('get_fees', function(data) {
		$.each(data, function(index, val) {
			feeSummary = {
				id: val.id,
				price: val.fee_translations[0].price
			}
			orderSummary.feesSummary.push( feeSummary );
			check += '<label>'+val.fee_translations[0].name+" $  "+    val.fee_translations[0].price+' <input type="checkbox" name="check" value="'+val.id+'"></label>'
		});
		$(".form-row-first").html(check);
		$("#accept-card").click(function() {
			var checkbox_value = [];
			card = {
				'title' : title.val(),
				'to' : to.val(),
				'message' : message.val(),
			}
			rowcollection = $("input[name=check]:checked");
			rowcollection.each(function(index,elem){
				var  id = this.value;
				checkbox_value.push(id);
			});
			if (checkbox_value.length == 0) {
				swal("", error, 'error');
			}else{
				$.each(checkbox_value, function(index, val) {
					if (val == 2) {
						if (title.val().trim() === '' || to.val().trim() === '' || message.val().trim()=== '') {
							swal("", warning, 'warning');
						}
					}
				});
				postGift(card, checkbox_value);
			}
		});
	});
}
function createAddressObject(){
	var address = {
		country: 'MX',
		state: $('input[name="state"]').val(),
		city: $('input[name="city"]').val(),
		street: $('input[name="street"]').val(),
		exterior_number: $('input[name="exterior_number"]').val(),
		interior_number: $('input[name="interior_number"]').val(),
		zipcode: parseInt( $('input[name="zipcode"]').val() ),
		description: $('textarea[name="description"]').val(),
		type: parseInt( $('select[name="address_types"]').val() ),
		is_default: false,
	}
	if ( $.trim($('input[name="state"]').val()) == '' ||
		$.trim($('input[name="city"]').val()) == '' ||
		$.trim($('input[name="street"]').val())== '' ||
		$.trim($('input[name="exterior_number"]').val()) == '' ||
		$.trim($('input[name="interior_number"]').val()) == '' ||
		$.trim($('input[name="zipcode"]').val()) == '' ||
		$.trim($('textarea[name="description"]').val()) == '' ||
		$.trim($('select[name="address_types"]').val()) == '' ) {
		$('#alert-validation-address').show();
	setTimeout(function(){
		$("#alert-validation-address").hide(2000);
	}, 3000);
} else {
	createAddress( JSON.stringify(address) );
}
}
function createAddress(jsonParamters){
	$.ajaxSetup({
		headers:{
			'Authorization': 'Bearer ' + token,
			'Content-Type': 'application/json',
			'Accept-Language': lang
		},
		dataType: 'json',
	});
	$.ajax({
		url: BASE_URL + ADDRESSES_CREATE,
		type: 'POST',
		dataType: 'json',
		data: jsonParamters
	})
	.done(function(response) {
		if (response.type === "success") {
			clearFieldsAddressForm();
			getAddresses(true, response.data.id);
		}
		processCreateAddress(response);
	}).fail(function(error) {
		console.log("create address error " + JSON.stringify(error) );
	}).always(function() {
		console.log("create address complete");
	});
}
function numberWithCommas(number) {
	var parts = number.toString().split(".");
	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	return parts.join(".");
}
function initListeners(){
}
function  initPaypalPayments(){
	var total;
	var currency;
	var address;
	var is_billable;
	paypal.Button.render({
    // Configure environment
    env: 'sandbox',
    client: {
    	sandbox: 'AeHb7O56qh62c4JNa1xR_dxnegQJnlGeBQ7JhBVDa2p44i02AsZqvzUd2d1-CsucXPNasp55dBRHCA4-',
    	production: 'EDf1GDz4bDfDBHRBt-7qQ2BxQ0Sf7z4HYBGsgfGkREaWT0Gp64G-_FcvMNNzreAoMVaBNYdCEW2Uh5F1'
    },
    // Customize button (optional)
    locale: 'en_US',
    style: {
    	label: 'paypal',
      size:  'responsive',    // small | medium | large | responsive
      shape: 'rect',     // pill | rect
      color: 'blue',     // gold | blue | silver | black
      tagline: false
  },
    // Set up a payment
    payment: function (data, actions) {
     // console.log(currency);
     return actions.payment.create({
     	transactions: [{
     		amount: {
     			total: getSummaryTotal(),
     			currency: $("input[name=currency]").val()
     		}
     	}]
     });
 },
    // Execute the payment
    onAuthorize: function (data, actions) {
     //console.log(actions);
     return actions.payment.execute()
     .then(function (data) {
     	console.log("PAYPAL TRANSACTION RESULT: " + JSON.stringify( data ) );
     	total = getSummaryTotal();
     	envio = $("input[name=envio]").val();
     	createPaypalOrder(total, data.id);
     });
 }
}, '#paypal-button');
}
function showProgress(message){
	var string = $("#progress-animation-content").html().toString();
	swal({
		title: string,
		type: 'info',
		html: true,
		text: message,
		showConfirmButton: false
	})
}
function cart() {
	$.ajaxSetup({
		headers:{
			'Authorization': 'Bearer ' + token,
			'Content-Type': 'application/json',
			'Accept-Language': lang
		},
		dataType: 'json',
	});

	$.ajax({
		url: BASE_URL + CART_GET,
		type: 'GET'
	})
	.done(function(response) {
		//console.log("RESPONSE CART: " + JSON.stringify(response) );
		cartResponse = response;
		setSubtotal();
		getProducts();
		freeShippingNormal();
	}).fail(function(error) {
		console.log("cart response error " + JSON.stringify(error) );
	}).always(function() {
		console.log("cart response complete");
	});
}
function setSubtotal(){
	checkoutSubtotal = 0;
	$.each(cartResponse.data, function(index,item){
		console.log("CART ITEM " + JSON.stringify(item));
		var itemPrice = item.pivot.qty * item.translations[0].price;
		checkoutSubtotal += itemPrice;
	});

	orderSummary.subtotal = checkoutSubtotal;

	$("#subtotal-carrito").html( "$ " + orderSummary.subtotal );
	$("input[name=subtotal]").val( orderSummary.subtotal );
}
function deleteCart(jsonParameters) {
	$.ajaxSetup({
		headers:{
			'Authorization': 'Bearer ' + token,
			'Content-Type': 'application/json',
			'Accept-Language': lang
		},
		dataType: 'json',
	});
	$.ajax({
		url: BASE_URL + CART_DELETE,
		type: 'DELETE',
		dataType: 'json',
		data: jsonParameters
	})
	.done(function(response) {
		console.log("RESPONSE DELETE CART: " + JSON.stringify(response) );
		swal({
			title:languageObject[lang].successful_transaction,
			text: "",
			type: "success"
		}, function() {

			window.location.href = '/shopping-history';
		});
	}).fail(function(error) {
		console.log("cart response error " + JSON.stringify(error) );
	}).always(function() {
		console.log("cart response complete");
	});
}
function getProducts(){
	var products = [];
	$.each(cartResponse.data, function( index, item ) {
		var product = {
			id: item.pivot.products_id,
			sizes_id: item.pivot.sizes_id,
			colors_id: item.pivot.colors_id,
			quantity: item.pivot.qty
		}
		products.push(product);
	});
	return products;
}
function getProductsToDelete(){
	var products = [];
	$.each(cartResponse.data, function( index, item ) {
		var product = {
			products_id: item.pivot.products_id,
			sizes_id: item.pivot.sizes_id,
			colors_id: item.pivot.colors_id,
		}
		products.push(product);
	});
	var productsArray = {
		products: products
	}
	return JSON.stringify(productsArray);
}
function getGiftMessageObject(){
	var giftMesseageObject = {
		title: "",
		to: "",
		message: ""
	}
	checkboxArray = $("input[name=check]");
	$.each(checkboxArray, function( index, item ) {
		if ( $(item).val() == 2 ) {
			if ( $(item).prop('checked') ) {
				giftMesseageObject.title = $('input[name="title"]').val();
				giftMesseageObject.to = $('input[name="to"]').val();
				giftMesseageObject.message = $('textarea[name="message"]').val();

			} else {
				giftMesseageObject.title = "";
				giftMesseageObject.to = "";
				giftMesseageObject.message = "";

			}
		}
	});
	return giftMesseageObject;
}
function getFeesArray(){
	var fees = [];
	checkboxArray = $("input[name=check]");
	$.each(checkboxArray, function( index, item ) {
		if ( $(item).prop('checked') ) {
			var fee = {
				id: $(item).val(),
				quantity: 1
			}
			fees.push(fee);
		}
	});
	return fees;
}
function getCurrency(){
	currency = "";
	if (lang === 'es') {
		currency = 'mxn';
	}
	if (lang === 'en') {
		currency = 'usd';
	}
	return currency;
}
function getPaymentSourceID(){
	var paymentSourceID = ""
	checkboxCardArray = $("input[name=card]");
	$.each(checkboxCardArray, function( index, item ) {
		if ( $(item).prop('checked') ) {
			//console.log( "PAYMENT SOURCE ID: " + $(this).val()  );
			paymentSourceID = $(this).val();
		}
	});

	return paymentSourceID;
}

 /**
  * Opens a pay.
  */
  function openPay() {
  	OpenPay.setId(OPENPAY_ID);
  	OpenPay.setApiKey(OPENPAY_API_KEY);
  	OpenPay.setSandboxMode(MODE);
  	var deviceSessionId = OpenPay.deviceData.setup();
  	$('input[name=device_session]').val(deviceSessionId);
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
  		$('#save-new-card').html('<i class="fa fa-spinner fa-spin"></i> '+languageObject[lang].loading).prop('disabled', true);
  		var token_id = response.data.id;
  		var device_session_id = $('input[name=device_session]').val();
  		var method = $('input:radio[name=method]:checked').val();
  		var json = {
  			method: method,
  			token: token_id,
  			device_session_id: device_session_id,
  			is_default: true
  		};
  		var jsonParameters = JSON.stringify(json);
  		$.ajaxSetup({
  			headers:{
  				'Authorization': 'Bearer ' + token,
  				'Content-Type': 'application/json',
  				'Accept-Language': lang
  			},
  			dataType: 'json',
  		});
  		$.ajax({
  			url: BASE_URL + '/v1/cards',
  			type: 'POST',
  			dataType: 'json',
  			data: jsonParameters
  		})
  		.done(function(response) {
  			console.log(response);
  			if (response.errors == false) {
  				$("#form-card-new")[0].reset();
  				$('#ship-box-card').slideToggle(1000);
  				$('#alert-succ-add-card').show();
  				$('input[id=btn-box-card]').prop('checked', false);
  				setTimeout(function(){
  					$("#alert-succ-add-card").hide(2000);
  				}, 4000);
  				openPay();
  				getCardsCheckout();
  			} else if (response.errors == true) {
  				swal(response.data[0], "", 'warning');
  			}else {
  				$('#alert-warning-add-card').show();
  				setTimeout(function(){
  					$("#alert-warning-add-card").hide(2000);
  				}, 4000);
  			}
  		})
  		.fail(function(errors) {
  			console.log(errors);
  			$('#alert-warning-add-card').show();
  			setTimeout(function(){
  				$("#alert-warning-add-card").hide(2000);
  			}, 4000);
  		})
  		.always(function() {
  			$('#save-new-card').text(languageObject[lang].save).prop('disabled', false);
  		});
  	};

  	var error_callbak = function(response) {
  		console.log(response);
  		$('#alert-warning-add-card').show();
  		setTimeout(function(){
  			$("#alert-warning-add-card").hide(2000);
  		}, 4000);
  		$('#save-new-card').text(languageObject[lang].save).prop('disabled', false);
  	};
  }

 /**
  * Gets the cards checkout.
  */
  function getCardsCheckout() {
  	var type = $('select[id=type_payment]').val();
  	$.ajax({
  		url: BASE_URL+'/v1/cards',
  		headers:{
  			'Authorization': 'Bearer ' + token,
  			'Content-Type': 'application/json',
  			'Accept-Language': lang
  		},
  		type: 'GET',
  		dataType: 'json',
  	})
  	.done(function(response) {
  		console.log("get cards done " + JSON.stringify(response));
  		setCardsSelect(response);
  	}).fail(function(error) {
  		console.log("get cards error " + JSON.stringify(error) );
  	});
  }

 /**
  * Sets the cards select.
  *
  * @param      {<type>}  response  The response
  */
  function setCardsSelect(response) {
  	$('#save-new-card').text(languageObject[lang].save).prop('disabled', false);
  	$(".tarjetas").html('');
  	tarjeta = '';
  	if (response.data.length > 0) {
  		$.each(response.data, function(index, val) {
  			if (val.payment_methods_id == option) {
  				tarjeta = '<div class="row" style="margin-top: 10px;margin-left: 2px;margin-right: 2px;">'+
  				'<div class="col-md-12">'+
  				'<h5><label class="container-radio-register"><b>'+val.cards.brand.toUpperCase()+" - "+ val.cards.last_4+'</b>'+
  				'<input type="radio" name="card" value="'+ val.cards.payment_source_id + '">'+
  				'<span class="checkmark-radio"></span></h5></label>'+
  				'</div>'+
  				'</div><br>';
  				$(".tarjetas").append(tarjeta);
  			}
  		});
  	} else{
  		$('.not-cards').show();
  		setTimeout(function(){
  			$(".not-cards").hide(2000);
  		}, 3000);
  	}
  }


