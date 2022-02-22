$(document).ready(function() {
	BASE_URL =  $('meta[name="base_url"]').attr('content');
	lang = $('meta[name="language"]').attr('content');
	token = $('meta[name="token"]').attr('content');
	getShippingTime(lang);
});

/**
 * Estimate shipping time.
 *
 * @return {[type]} [description]
 */
 function getShippingTime(lang) {
 	/*Traslations*/
 	var languageObject = {
 		es : {
 			text_day : 'Días hábiles estimados de envío',
 			date_outlet  : 'Fecha prevista de salida',
 			date_arrive  : 'Fecha prevista de llegada'
 		},
 		en : {
 			text_day : 'Estimated shipping days',
 			date_outlet  : 'Expected date of departure',
 			date_arrive  : 'Estimated date of arrival'
 		}
 	};

 	$.ajax({
 		url: BASE_URL+'/v1/resources/shipping/estimates',
 		type: 'GET',
 		headers:{
 			'Authorization': 'Bearer ' + token,
 			'Content-Type': 'application/json',
 			'Accept-Language': lang
 		},
 		dataType: 'json',
 	})
 	.done(function(response) {
 		console.log(response);
 		var time_estimate = '';
 		if (response.data.etd == null && response.data.eta == null) {
 			time_estimate = '<div><p style="font-size: 13px;"><b>'+languageObject[lang].text_day+': </b>'+response.data.default_eta_in_days+'</p></div>';
 			$('.shipping-time').html(time_estimate);
 		} else {
 			time_estimate = '<div><p style="font-size: 13px;"><b>'+languageObject[lang].date_outlet+':</b> '+response.data.etd+'</p>'+
 			'<p style="font-size: 13px;"><b>'+languageObject[lang].date_arrive+':</b> '+response.data.eta+'</p></div>';
 			$('.shipping-time').html(time_estimate);
 		}
 	})
 	.fail(function(error) {
 		console.log(error);
 	});
 }

