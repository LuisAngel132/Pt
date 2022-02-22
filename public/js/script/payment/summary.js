$(document).ready(function() {
	$(".nice-select").hide();
	$("#country").show();
	$("#countrys").show();
	$("#address-select").show();
	$("#address-type").show();
	$("#type_payment").show();
	getPaymentType();
	//getFees();
	//clickAplicCupon();
	getCuponTrue();
	//getTotal();
});

/**
 * Gets the total.
 */


/**
 * Gets the payment type.
 */
 function getPaymentType() {
 	$.get('get_payment_type', function(data) {
 		var select = '<option value="" >...</option>';
 		$.each(data, function(index, val) {
 			if (val.payment_methods_id != 4) {
 				select += '<option value="'+val.payment_methods_id+'" >' + val.method+ '</option>';
 			}
 			$("#type_payment").html(select);
 		});
 	});
 }




/**
 * Posts a gift.
 *
 * @param      array  card            The card
 * @param      array  checkbox_value  The checkbox value
 */
 function postGift(card, checkbox_value) {
 	fail =	$("input[name=alert_fail]").val();
 	$.ajaxSetup({
 		headers: {
 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 		}
 	});
 	$.post('gifs', {
 		card, checkbox_value
 	}, function(data, textStatus, xhr) {
 		if (textStatus == "success") {
 			number = parseFloat(data.cost).toFixed(2)
 			var commaNum = numberWithCommas(number);
 			deleteCost = '<a class="btn delte-cost"><i class="fa fa-close text-danger"></i></a>';
 			$("#cost").html("$ "+commaNum + " "+ deleteCost);
 			getTotal();
 			swal("", data.message, data.status);
 		}else{
 			swal("", fail, 'error');
 		}
 	});
 }
/**
 * click Aplic Cupon
 */
 function clickAplicCupon() {
 	$("#apply-coupon").click(function() {
 		cupon = $("#coupon_code").val();
 		if ($("#coupon_code").val().trim() === "" ) {
 			alert("vacio")
 		}else{
 			postCupon(cupon);
 		}
 	});
 }

/**
 * Posts a cupon.
 *
 * @param      {string}  cupon   The cupon
 */
 function postCupon(cupon) {
 	console.log("Sending coupon");
 	console.log( "cupon " +  $('input[name="coupon_code"]').val() );
 	console.log( "cupon object" + JSON.stringify( { cupon: $('input[name="coupon_code"]').val() } ) );
 	$.ajaxSetup({
 		headers: {
 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 		}
 	});
 	$.post('cupon',JSON.stringify( {
 		cupon: $('input[name="coupon_code"]').val()
 	}), function(data, textStatus, xhr) {
 		console.log( "coupon response " + JSON.stringify(data) );
 		if (textStatus == "success") {
 			if (data.status == "success") {
 				$('input[name="codes_id"]').val(data.codes_id);
 				number = parseFloat(data.descuento).toFixed(2)
 				var commaNum = numberWithCommas(number);
 				$("#descount").html("$ "+commaNum );

 				if (data.envio == 0) {
 					$("#envio").html("$ 0.00");
 				}else{
 					numbers = parseFloat(data.envio).toFixed(2)
 					var commaNums = numberWithCommas(numbers);
 					$("#envio").html("$ "+commaNums);
 				}
 				getTotal();
 				getCuponTrue();
 				swal("", data.message, data.status);

 			}else{
 				swal("", data.message, data.status);

 			}
 		}
 	});
 }

 function getCuponTrue() {
 	$.get('cupon_true', function(data) {
		//alert(data)
		if (data == true) {
			$("#descount-cost").hide();
		}else{
			$("#descount-cost").show();
		}
	});
 }