$(document).ready(function() {
	BASE_URL =  $('meta[name="base_url"]').attr('content');
	CART_GET = '/v1/cart';
	PRODUCTS_GET_CATEGORIES = '/v1/products/categories';
	PRODUCTS_GET_GENRES = '/v1/products/genres';
	LIKES_CREATE = '/v1/likes/';
	RESOURCES_GET_ADS = '/v1/resources/ads';

	lang = $('meta[name="language"]').attr('content');
	token = $('meta[name="token"]').attr('content');
	cartResponse = "";
	getShippingTime(lang);
	getAds();
	//showProductDetail();
	showSizesGuide();
	getGender();
	getStyle();
	filter();
	closeModalDetailProduct();
	inStockSize();

	products = JSON.parse( $("#products-variable-container").val() );
	/*Like*/
	$(".remove").click(function(){
		id = this.name;
		createLike(id, this);
	});
});

/**
 * Gets the ads.
 */
 function getAds(){
 	$.ajaxSetup({
 		headers:{
 			'Authorization': 'Bearer ' + token,
 			'Content-Type': 'application/json',
 			'Accept-Language': lang
 		},
 	});
 	$.ajax({
 		url: BASE_URL + RESOURCES_GET_ADS,
 		type: 'GET'
 	})
 	.done(function(response) {
		//console.log("REQUEST TO GET ADS : " + JSON.stringify(response) );
		processResponseAds(response.data);
	}).fail(function(error) {
		console.log("request to get ads error " + JSON.stringify(error) );
	});
}

/**
 * Show ads in banners.
 *
 * @param      {array}  data    The data
 */
 function processResponseAds(data){
 	var d = new Date();
 	var strDate = d.getFullYear() + "-" + ((d.getMonth()+1)<10?'0'+(d.getMonth()+1):(d.getMonth()+1)) + "-" + (d.getDate()<10?'0'+d.getDate():d.getDate());
 	$('#banner-container').html('<div id="testing" class="owl-carousel"></div>');
 	$.each(data,function(index,item){
 		/*Show banners of ads valid*/
 		if (moment(item.start_date) <= moment(strDate) && moment(item.end_date) >= moment(strDate)) {
 			$("#testing").append(
 				'<div class="item"><a target="_blank" href="'+item.site+'"><img src="'+item.translations[0].pivot.public_image_url+'" class="img-responsive"/></a></div>');
 		}
 	});
 	var owl = $("#testing");
 	owl.owlCarousel({
 		items: 4,
 		navigation: true
 	});
 }

/**
 * Creates a like.
 *
 * @param      {<type>}  id      The identifier
 * @param      {<type>}  item    The item
 */
 function createLike(id, item) {
 	$.ajaxSetup({
 		headers:{
 			'Authorization': 'Bearer ' + token,
 			'Content-Type': 'application/json',
 			'Accept-Language': lang
 		},
 	});
 	$.ajax({
 		url: BASE_URL + LIKES_CREATE + id,
 		type: 'POST'
 	})
 	.done(function(response) {
	 	//console.log("REQUEST TO CREATE LIKE : " + JSON.stringify(response) );
	 	processLikeResponse(response.data, item);
	 }).fail(function(error) {
	 	console.log("request to create like error " + JSON.stringify(error) );
	 });
	}

/**
 * Show like/dislike in products.
 *
 * @param      {<type>}  data    The data
 * @param      {<type>}  item    The item
 */
 function processLikeResponse(data, item){
 	if (data.attached.length > 0) {
 		$(item).html('<i class="zmdi zmdi-favorite zmdi-hc-fw text-danger"></i>');
 	}
 	if (data.detached.length > 0) {
 		$(item).html('<i class="zmdi zmdi-favorite-outline zmdi-hc-fw"></i>');
 	}
 }

/**
 * Gets the gender.
 */
 function getGender() {
 	$.get('get_gender', function(data) {
 		var input ="";
 		$.each(data, function(index, val) {
 			input += '<li><label><input type="radio" name="product-genre" value="'+val.product_genres_id+'"> '+val.genre+'</label></li>';
 		});
 		$(".gender").html(input);
 	});
 }

/**
 * Gets the style.
 */
 function getStyle() {
 	$.get('get_style', function(data) {
 		var input ="";
 		$.each(data, function(index, val) {
 			input += '<li><label><input type="checkbox" name="product-style" value="'+val.product_styles_id+'"> '+val.style+'</label></li>';
 		});
 		$(".style").html(input);
 	});
 }

/**
 * Gets the size.
 *
 * @param      {string}  id      The identifier
 */
 function getSize(id) {
 	$('#sizes').prop('selectedIndex',0);
 	$.get('get_size/'+id, function(data) {
 		var select = '<option value="" ></option>';
 		$.each(data, function(i, size) {
 			select += '<option value="'+size[0].sizes_id+'" >' + size[0].size.size+ '</option>';
 			$("#sizes").html(select);
 		});
 		$(".nice-select").hide();
 		$("#sizes").show();
 	});
 }

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
 		if (sizes_id == '' && colors_id == '' || sizes_id != '' && colors_id == '' || sizes_id == '' && colors_id != '') { /*vacios || size, null || null, color*/
 			$('.add-to-cart').hide();
 			$('.stock-label').hide();
 		} else if (sizes_id != '' && colors_id != '') { /*size, color*/
 			var product = "";
 			$.each(products, function(index,item){
 				if ( parseInt( id ) == parseInt( item.id ) ) {
 					product = item;
 				}
 			});
 			var array_in_stock = [];
 			$.each(product.products_colors, function(index, val) {
 				if (val.sizes_id == sizes_id && val.colors_id == colors_id) {
 					array_in_stock.push(val);
 				}
 			});
 			if (array_in_stock.length == 0) {
 				$('.add-to-cart').hide();
 				$('.stock-label').hide();
 			} else {
 				var qty = array_in_stock[0].quantity;
 				if (qty != 0) {
 					$('.add-to-cart').show();
 					$('.stock-label').show();
 					$('#qty-stock').text(qty);
 				} else {
 					$('.add-to-cart').show();
 					$('.stock-label').show();
 				}
 			}
 		} else {
 			$('.add-to-cart').hide();
 			$('.stock-label').hide();
 		}
 	});
 }

/**
 * Shows the product detail.
 */
 function showProductDetail() {
 	$(".search-product-detail").click(function(event) {
 		var id = this.id;
 		getSizesGuide();
 		getSize(id);
 		$('input[name=id]').val(id);
 		var product = "";
 		$.each(products, function(index,item){
 			if ( parseInt( id ) == parseInt( item.id ) ) {
 				product = item;
 			}
 		});

 		var productCart = {
 			products_id: product.products_colors[0].products_id,
 			colors_id: product.products_colors[0].colors_id,
 		}
 		$("#product-cart-info").val( JSON.stringify( productCart ) );

 		productColor ="";
 		productLink ="";
 		productClass="tab-pane fade show ";
 		productClassActive ="tab-pane fade show active";
 		like = "";
 		rate = "";
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
 		$('input[name=styles_id]').val(product.product_styles_id);
 		$('input[name=types_id]').val(product.product_types_id);
 		$('input[name=genres_id]').val(product.product_genres_id);
 		productName = '<h1 class="single-product-name">'+product.product_translations[0].name+'</h1>';
 		productDesctiprion = '<p>'+product.product_translations[0].description+'</p>';
 		productPrice = '<span class="price text-uppercase">'+" $ "+product.product_translations[0].price +' '+ getCurrency() +'</span>';

 		if (product.customer_likes) {
 			if (product.customer_likes.length != 0) {
 				like = '<a class="remove like" style="font-size: 20px;" name="'+product.id+'"> <i class="zmdi zmdi-favorite zmdi-hc-fw text-danger"></i></a>';
 			} else {
 				like = '<a class="remove like" style="font-size: 20px;" name="'+product.id+'"> <i class="zmdi zmdi-favorite-outline zmdi-hc-fw"></i></a>';
 			}
 		} else {
 			like ="";
 		}
 		var array_colors = [];
 		$.each(product.products_colors, function(index, val) {
 			array_colors.push(val);
 			if (index == 0) {
 				$("#id-product-color").val(val.id);
 				productResource ='<div class="tab-pane fade show active" id="single-slide'+val.resources.id+'" role="tabpanel" aria-labelledby="single-slide-tab-'+val.resources.id+'" >'+
 				'<div class="single-product-img img-full">'+
 				'<img src="'+val.resources.galleries[0].public_image_url+'" alt="">'+
 				'</div>'+
 				'</div>';
 			}
 		});
 		/*obtener colores únicos array multidimencional: http://sunnybahree.blogspot.com/2016/01/how-to-get-unique-items-or-values-from_14.html*/
 		var incautos = [];
 		var uniqueColors = [];
 		$.each(array_colors, function(index, product_color) {
 			if (! incautos [product_color.colors_id]) {
 				incautos [product_color.colors_id] = true ;
 				uniqueColors.push(product_color);
 			}
 		});
 		$.each(uniqueColors, function(i, color) {
 			if (color.resources) {
 				productColor += '<li><a class="change_active" name="'+color.colors_id+'"><span class="color select-color" name="'+color.colors_id+'" style="background-color:'+color.colors.hex+'"></span></a></li>';
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

 			var product = "";
 			$.each(products, function(index,item){
 				if ( parseInt( id ) == parseInt( item.id ) ) {
 					product = item;
 				}
 			});
 			/*cambia imagen del producto con el color seleccionado*/
 			var array_resource = [];
 			$.each(product.products_colors, function(index, val) {
 				if (val.colors_id == colors_id) {
 					array_resource.push(val);
 				}
 			});
 			img_url = array_resource[0].resources.galleries[0].public_image_url;
 			$('.img-full').html('<img src="'+img_url+'" alt="">');
 			/*end color del producto*/
 			/*hide/show botón de agregar al carrito*/
 			if (sizes_id == '' && colors_id == '' || sizes_id != '' && colors_id == '' || sizes_id == '' && colors_id != '') { /*vacios || size, null || null, color*/
 				$('.add-to-cart').hide();
 				$('.stock-label').hide();
 			} else if (sizes_id != '' && colors_id != '') { /*size, color*/
 				var array_in_stock = [];
 				$.each(product.products_colors, function(index, val) {
 					if (val.sizes_id == sizes_id && val.colors_id == colors_id) {
 						array_in_stock.push(val);
 					}
 				});
 				if (array_in_stock.length == 0) {
 					$('.add-to-cart').hide();
 					$('.stock-label').hide();
 				} else {
 					var qty = array_in_stock[0].quantity;
 					if (qty != 0) {
 						$('.add-to-cart').show();
 						$('.stock-label').show();
 						$('#qty-stock').text(qty);
 					} else {
 						$('.add-to-cart').show();
 						$('.stock-label').show();
 					}
 				}
 			} else {
 				$('.add-to-cart').hide();
 				$('.stock-label').hide();
 			}
 			/*end hide/show botón de agregar al carrito*/
 		});
 		productResource = "";
 		rate = "";
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

/**
 * Show section of sizes guide.
 *
 * @return {[type]} [description]
 */
 function showSizesGuide() {
 	$("#open-modal").on('hidden.bs.modal', function () {
 		$('input[name=quantity]').val(1);
 	});
 	$('.sizes-guide').on('click', function() {
 		$('#ship-box-size-guide').slideToggle(1000);		
 	});
 }

/**
 * Filter sizes guide.
 *
 * @return {[type]} [description]
 */
 function getSizesGuide() {
 	$.ajax({
 		url: BASE_URL+'/v1/products/sizes-guide',
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
 		showTableGuide(response);
 	})
 	.fail(function(error) {
 		console.log(error);
 	});
 }

 function showTableGuide(response) {
 	var styles_id = $('input[name=styles_id]').val();
 	var types_id = $('input[name=types_id]').val();
 	var genres_id = $('input[name=genres_id]').val();
 	var cm = '';
 	var inch = '';
 	var array_sizes = [];
 	$.each(response.data, function(index, val) {
 		if (val.styles.id == styles_id && val.types.id == types_id && val.genres.id == genres_id) {
 			array_sizes.push(val);
 		}
 	});
 	function sort(a,b){
 		a = a.sizes[0].id;
 		b = b.sizes[0].id;
 		if(a > b) {
 			return 1;
 		} else if (a < b) {
 			return -1;
 		}
 		return 0;
 	}
 	var array_ordered = array_sizes.sort(sort);
 	$.each(array_ordered, function(index, val) {
 		cm += '<tr>'+
 		'<td>'+val.sizes[0].size+'</td>'+
 		'<td>'+val.sizes[0].pivot.shirt_length_cm+'</td>'+
 		'<td>'+val.sizes[0].pivot.chest_width_cm+'</td>'+
 		'<td>'+val.sizes[0].pivot.sleeve_length_cm+'</td>'+
 		'</tr>';
 		inch += '<tr>'+
 		'<td>'+val.sizes[0].size+'</td>'+
 		'<td>'+val.sizes[0].pivot.shirt_length_in+'</td>'+
 		'<td>'+val.sizes[0].pivot.chest_width_in+'</td>'+
 		'<td>'+val.sizes[0].pivot.sleeve_length_in+'</td>'+
 		'</tr>';
 	});
 	$('table.table-cm tbody').html(cm);
 	$('table.table-inch tbody').html(inch);
 }

/**
 * Filter by genre.
 */
 function filter() {
 	style =[];
 	$("#send-filter").click(function() {
 		id_category = $("input[name=id_category]").val();
 		genero = $('input:radio[name=product-genre]:checked').val();
 		$("input:checkbox:checked").each(function() {
 			style.push($(this).val());
 		});
 		if (!genero) {
 			genero = 0;
 		}
 		if (genero == 0 && style.length == 0) {
 			alert("selecciona al menos un filtro")
 		} else{
 			postFilter(genero, style, id_category)
 		}
 	});
 }

/**
 * Posts a filter.
 *
 * @param      {string}  genero       The genero
 * @param      {string}  style        The style
 * @param      {string}  id_category  The identifier category
 */
 function postFilter(genero, style, id_category) {
 	inputs ="";
 	inputs = '<input type="hidden" name="genero" value="' + genero + '" />'+
 	'<input type="hidden" name="style" value="' + style + '" />'+
 	'<input type="hidden" name="id" value="' + id_category + '" />';
 	$("body").append('<form action="category" method="get"  class="address-delete">' +inputs+'</form>');
 	$(".address-delete").submit();
 }

/**
 * Gets the currency.
 *
 * @return     {string}  The currency.
 */
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
