$(document).ready(function() {
	BASE_URL =  $('meta[name="base_url"]').attr('content');
	PRODUCT_GET = '/v1/products/';

	lang = $('meta[name="language"]').attr('content');
	token = $('meta[name="token"]').attr('content');

	products = JSON.parse( $("#products-variable-container").val() );
	console.log("FAVORITES PRODUCTS: " +JSON.stringify(products) );

	clickRemove();
	closeModalDetailProduct();

	$(".remove").click(function(){
		console.log( $(this).val() );
	});

	$('#open-modal').on('hidden.bs.modal', function() {
		$("#myTabContent").html("");
		$(".field-data").html("");
	})

	$('.sizes-guide').on('click', function() {
		$('#ship-box-size-guide').slideToggle(1000);		
	});
	getShippingTime(lang);
});

/**
 * Closes a modal detail product.
 */
 function closeModalDetailProduct() {
 	$("#open-modal").on('hidden.bs.modal', function () {
 		$('input[name=id]').val('');
 		$('#qty-stock').text('0');
 		$('.add-to-cart').hide();
 		$('.stock-label').hide();
 		$('#sizes').prop('selectedIndex',0);
 	});
 }

/**
 * Show stock of product color.
 */
 function inStockSize() {
 	$("#sizes").change(function(event) {
 		var id = $('input[name=id]').val();
 		var colors_id = "";
 		var sizes_id = $(this).val();
 		$.each( $(".select-color"), function( index, item ) {
 			if ( $(item).hasClass('selected') ) {
 				colors_id = $($(item).parent()).attr('name');
 			}
 		});
 		/*obtiene en la variable product el producto seleccionado*/
 		var product = "";
 		$.each(products, function(index,item){
 			if ( parseInt( id ) == parseInt( item.id ) ) {
 				product = item;
 			}
 		});
 		var x = true;
 		var qty = 0;
 		$.each(product.colors, function(index, val) {
 			if (val.colors_id == colors_id && val.sizes_id == sizes_id) {
 				console.log('2');
 				img_url = val.resources.galleries[0].public_image_url;
 				$('.img-full').html('<img src="'+img_url+'" alt="">');
 				qty = val.quantity;
 				return x = false;
 			} else if (val.colors_id == colors_id && val.sizes_id != sizes_id) {
 				console.log('color');
 				if (sizes_id == "") {
 					console.log('color, size null');
 					img_url = val.resources.galleries[0].public_image_url;
 					$('.img-full').html('<img src="'+img_url+'" alt="">');
 					qty = val.quantity;
 					return x = false;
 				} else {
 					console.log('color, size not null');
 					img_url = val.resources.galleries[0].public_image_url;
 					$('.img-full').html('<img src="'+img_url+'" alt="">');
 					qty = 0;
 					return x = false;
 				}
 			} else if (val.colors_id != colors_id && val.sizes_id == sizes_id) {
 				console.log('size');
 				if (colors_id == "") {
 					qty = val.quantity;
 					return x = false;
 				} else {
 					qty = 0;
 					return x = false;
 				}
 			} else {
 				console.log('ninguno');
 				qty = 0;
 			}
 		});
 		if (qty != 0) {
 			$('.add-to-cart').show();
 		} else {
 			$('.add-to-cart').hide();
 		}
 		$('#qty-stock').text(qty);
 	});
 }

 function showProductDetail() {

 	$(".search-product-detail").click(function(){
 		id = this.name;
 		$('input[name=id]').val(id);
 		var product = "";
 		$.each(products, function(index,item){
 			if ( parseInt( id ) == parseInt( item.id ) ) {
 				product = item;
 			}
 		});

 		console.log("FOUND PRODUCT: " + JSON.stringify(product) );
 		var productCart = {
 			products_id: product.colors[0].products_id,
 			colors_id: product.colors[0].colors_id,
 		}

 		$("#product-cart-info").val( JSON.stringify( productCart ) );

 		productColor ="";
 		productLink ="";
 		productClass="tab-pane fade show ";
 		productClassActive ="tab-pane fade show active";
 		like = "";
 		rate = "";
 		console.log(product);
 		if ( product.average_rating > 0 ) {
 			for ( var i = 0; i < 5; i++ ) {
 				if ( i < product.average_rating ) {
 					rate += '<i class="fa fa-star text-warning"></i>';
 				} else {
 					rate += '<i class="fa fa-star-o text-muted"></i>';
 				}
 			}
 		} else {
 			for ( var i = 0; i < 5; i++ ) {
 				rate += '<i class="fa fa-star-o text-muted"></i>';
 			}
 		}


 		productName = '<h1 class="single-product-name">'+product.translations[0].name+'</h1>';
 		productDesctiprion = '<p>'+product.translations[0].description+'</p>';
 		productPrice = '<span class="price text-uppercase">'+ " $ "+product.translations[0].price +' '+getCurrency() +'</span>';

 		if (product.customer_likes) {
 			if (product.customer_likes.length != 0) {
 				like = '<a class="remove like" style="font-size: 20px;" name="'+product.id+'"> <i class="zmdi zmdi-favorite zmdi-hc-fw text-danger"></i></a>';
 			} else {
 				like = '<a class="remove like" style="font-size: 20px;" name="'+product.id+'"> <i class="zmdi zmdi-favorite-outline zmdi-hc-fw"></i></a>';
 			}
 		} else {
 			like ="";
 		}

 		$.each(product.colors, function(index, val) {
 			if (index == 0) {
 				$("#id-product-color").val(val.id);
 				productResource ='<div class="tab-pane fade show active" id="single-slide'+val.resources.galleries[0].id+'" role="tabpanel" aria-labelledby="single-slide-tab-'+val.resources.galleries[0].id+'" >'+
 				'<div class="single-product-img img-full">'+
 				'<img src="'+val.resources.galleries[0].public_image_url+'" alt="">'+
 				'</div>'+
 				'</div>';
 			}
 			if (val.resources && val.colors) {
 				productColor += '<li><a class="change_active" name="'+val.colors_id+'"><span class="color select-color" name="'+val.colors_id+'" style="background-color:'+val.colors.hex+'"></span></a></li>';
 			}
 		});

 		$(".procuct-color").html(productColor);
 		$(".product-name-div").html(productName);
 		$(".product-discount").html(productPrice);
 		$(".product-info").html(productDesctiprion);
 		$(".product-details-large").html(productResource);
 		$('.single-product-reviews').html(rate);
		//$('.favorite').html(like);
		$(".select-color").click(function(){
			$.each($(".procuct-color li a span"), function(index, item){
				$($(item).parent()).css('border','2px solid white');
				$(item).removeClass('selected');
			});
			$($(this).parent()).css('border','2px solid tan');
			$(this).addClass('selected');

			var id = $('input[name=id]').val();
			var colors_id = "";
			var sizes_id = $('#sizes').val();
			$.each( $(".select-color"), function( index, item ) {
				if ( $(item).hasClass('selected') ) {
					colors_id = $($(item).parent()).attr('name');
				}
			});
			/*obtiene en la variable product el producto seleccionado*/
			var product = "";
			$.each(products, function(index,item){
				if ( parseInt( id ) == parseInt( item.id ) ) {
					product = item;
				}
			});
			var x = true;
			var qty = 0;
			$.each(product.colors, function(index, val) {
				if (val.colors_id == colors_id && val.sizes_id == sizes_id) {
					img_url = val.resources.galleries[0].public_image_url;
					$('.img-full').html('<img src="'+img_url+'" alt="">');
					qty = val.quantity;
					return x = false;
				} else if (val.colors_id == colors_id && val.sizes_id != sizes_id) {
					if (sizes_id == "") {
						img_url = val.resources.galleries[0].public_image_url;
						$('.img-full').html('<img src="'+img_url+'" alt="">');
						qty = val.quantity;
						return x = false;
					} else {
						img_url = val.resources.galleries[0].public_image_url;
						$('.img-full').html('<img src="'+img_url+'" alt="">');
						qty = 0;
						return x = false;
					}
				} else {
					qty = 0;
				}
			});
			if (qty != 0) {
				$('.add-to-cart').show();
			} else {
				$('.add-to-cart').hide();
			}
			$('#qty-stock').text(qty);
		});
		clickRemove();
		productResource = "";
		rate = "";
		/*
		$(".change_active").click(function() {
			id =this.name;
			$("#id-product-color").val(id);
			$.each(data, function(index, val) {
				$.each(val.products_colors, function(index, val) {
					if (val.id == id) {
						productResource ='<div class="tab-pane fade show active" id="single-slide'+val.resources.id+'" role="tabpanel" aria-labelledby="single-slide-tab-'+val.resources.id+'" >'+
						'<div class="single-product-img img-full">'+
						'<img src="'+val.resources.public_image_url+'" alt="">'+
						'</div>'+
						'</div>';
					}
				});
			});
			$(".product-details-large").html(productResource);
		});
		*/
	});
}

function clickRemove() {
	$('.remove').click(function(event) {
		var id = this.name;
		var inputs;
		inputs += '<input type="hidden" name="id" value="' + id + '" />';
		$("body").append('<form action="like" method="get"  class="formul">' +inputs+'</form>');
		$(".formul").submit();
	});
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

function getSize() {
	$.get('get_size', function(data) {
		var select = '<option value="" ></option>';
		$.each(data, function(index, val) {
			select += '<option value="'+val.id+'" >' + val.size+ '</option>';
			$("#sizes").html(select);
		});
		$(".nice-select").hide();
		$("#sizes").show();
	});
}

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
