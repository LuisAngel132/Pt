$(document).ready(function() {
	BASE_URL =  $('meta[name="base_url"]').attr('content');
	lang = $('meta[name="language"]').attr('content');
	token = $('meta[name="token"]').attr('content');
	//getOptionValue();
	option = $('select[id=type_payment]').val();
	console.log("PAYMENT OPTION SELECTED: " + option);
	$("select[id=type_payment]").change(function(){
		if ($('select[id=type_payment]').val() == 1 || $('select[id=type_payment]').val() == 2) {
			option = $('select[id=type_payment]').val();
			console.log("PAYMENT OPTION SELECTED: " + option);
			$(".tarjetas").html('');
			getCards();
		}
		if ($('select[id=type_payment]').val() == 3 || $('select[id=type_payment]').val() == '') {
			$(".tarjetas").html('');
		}
	});

});

function getOptionValue() {
	var option;
	tajeta = "";
	$("select[id=type_payment]").change(function(){
		if ($('select[id=type_payment]').val() == 1 || $('select[id=type_payment]').val() == 2) {
			option = $('select[id=type_payment]').val();
			$.get('get_card', function(data) {
        		//console.log(data);
        		if (data) {
        			$.each(data, function(index, val) {
        				if (val.payment_methods_id == option) {
        					tarjeta = '<div style="padding-top:20px; padding-bottom:10px: padding-left:10px; border-bottom: solid 1px grey;"><h4><b>'+val.cards.brand.toUpperCase()+" -"+ val.cards.last_4+'</b>: <input type="radio" name="card" value="'+val.cards.id+'"></h4></div><br>'
        					$(".tarjetas").html(tarjeta);
        				}
        			});

        		}else{
        			alert("aun no has registrado niguna tarjeta");
        		}
        	});
		}
	});
}


function getCards() {
	console.log('Getting option value');

	$.ajaxSetup({
		headers:{
			'Authorization': 'Bearer ' + token,
			'Content-Type': 'application/json',
			'Accept-Language': lang
		},
		dataType: 'json',
	});

	$.ajax({
		url: BASE_URL+'/v1/cards',
		type: 'GET',
		dataType: 'json',
	})
	.done(function(response) {
		console.log("get cards done " + JSON.stringify(response));
		setCardOption(response);
	}).fail(function(error) {
		console.log("get cards error " + JSON.stringify(error) );
	}).always(function() {
		console.log("get cards complete");
	});
}

function setCardOption(response){
	tajeta = "";
	console.log(response);
	if (response.data.length  > 0) {
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
