$(document).ready(function(){
	BASE_URL =  $('meta[name="base_url"]').attr('content');
	CART_GET = '/v1/cart';
	CART_DELETE = '/v1/cart';
	CART_UPDATE = '/v1/cart';

	lang = $('meta[name="language"]').attr('content');
	token = $('meta[name="token"]').attr('content');

	cartResponse = "";
	language = getTranslations();
	verifyStockCart();
	cart();
	clickUpdateCart();
	getShippingTime(lang);

	$("#cart-checkout").click(function() {
		var subtotal = $("input[name=cant_cart]").val();
		var inputs;
		$("body").append('<form action="checkout" method="get"  class="checkout"></form>');
		$(".checkout").submit();
	});
});

/**
 * Verify stock in cart.
 */
 function verifyStockCart() {
 	$.ajax({
 		url: BASE_URL + CART_GET,
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
 		$.each(response.data, function(key, product_cart) {
 			var colors = product_cart.colors;
 			var num = key+1;
 			$.get('verify_stock/'+product_cart.pivot.products_id+'/'+
 				product_cart.pivot.colors_id+'/'+
 				product_cart.pivot.sizes_id+'/'+
 				product_cart.pivot.qty, function(data) {
 					if (data.fail == true) {
 						var filter_product_color = colors.filter(function (item) {
 							return item.products_id == product_cart.pivot.products_id 
 							&& item.colors_id == product_cart.pivot.colors_id 
 							&& item.sizes_id == product_cart.pivot.sizes_id;
 						});
 						var products = [];
 						var product = {
 							products_id: product_cart.pivot.products_id,
 							qty: filter_product_color[0].quantity,
 							sizes_id: product_cart.pivot.sizes_id,
 							colors_id: product_cart.pivot.colors_id
 						};
 						products.push(product);
 						var productsArray = {
 							products: products
 						}
 						var jsonParameters = JSON.stringify(productsArray);
 						console.log(jsonParameters);
 						$("#alert-update-cart").show();
 						sendValidation(jsonParameters);
 					}
 				});
 		});
 	}).fail(function(error) {
 		console.log("cart response error " + JSON.stringify(error) );
 	});
 }

/**
 * Gets the translations.
 *
 * @param      {<type>}  language  The language
 */
 function getTranslationsShipping(lang){
 	languageObject = {
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
 	}
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
 * Gets the translations.
 *
 * @param      {<type>}  language  The language
 */
 function getTranslations(language){
 	languageObject = {
 		es : {
 			updating_cart : 'Actualizando carrito',
 			updated_cart  : 'Carrito actualizado'
 		},
 		en : {
 			updating_cart : 'Updating cart',
 			updated_cart  : 'Updated cart'
 		}
 	}
 }

/**
 * Query of cart.
 */
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
 		console.log(response);
 		cartResponse = response;
 		processGetCartResponse(response.data);
 	}).fail(function(error) {
 		console.log("cart response error " + JSON.stringify(error) );
 	});
 }

/**
 * Proccess get cart.
 *
 * @param      {<type>}  data    The data
 */
 function processGetCartResponse(data) {
 	subtotalcvarrito = 0;
 	currency = "";
 	var img = '';
 	var size = '';
 	var subtotal=0;
 	var totalCompra=0;
 	row = '<tr>';
 	$.each(data, function( index, item ) {
 		console.log(item);
 		var product = {
 			products_id: item.pivot.products_id,
 			sizes_id: item.pivot.sizes_id,
 			colors_id: item.pivot.colors_id,
 		}
 		inputInfo = '<input id="' +item.id+'" class="delete-product-info" type="hidden" value="'+  encodeURIComponent(JSON.stringify(product))+'" ></input>';
 		btnDelete = '<td class="product-remove product-id"><a  class="btn delete-product" name="'+item.pivot.products_id+'" data-color="'+item.pivot.colors_id+'" data-size="'+item.pivot.sizes_id+'"><i class="zmdi zmdi-close text-danger"></i></a></td>';
 		$.each(item.colors, function(i, color) {
 			if (color.colors_id == product.colors_id && color.sizes_id == product.sizes_id) {
 				img = color.resources.galleries[0].public_image_url;
 				size = color.sizes.size;
 				stock = color.quantity;
 			}
 		});
 		name = item.translations[0].name;
 		currency = getCurrency();
 		formattedPrice  = item.translations[0].formatted_price;
 		price = item.translations[0].price;
 		quantity = item.pivot.qty;
 		totalprice = parseFloat( price * quantity ).toFixed( 2 )
 		total = numberWithCommas( totalprice );
 		subtotal += price*quantity;
 		subtotalcvarrito = numberWithCommas(parseFloat(subtotal).toFixed(2));

 		row += inputInfo;
 		row +=btnDelete+
 		'<td class="product-thumbnail"><img src="'+ img +'" alt="" width="120px"></td>'+
 		'<td class="product-price"><span class="amount">'+ name +'</span></td>'+
 		'<td class="product-price"><span class="amount">'+ size +'</span></td>'+
 		'<td class="product-price"><span class="amount">'+"$ "+ price+' '+currency+'</span></td>'+
 		'<td class="product-quantity">'+
 		'<div class="cart-plus-minus">'+
 		'<input class="cart-plus-minus-box product-item-quantity" type="text" name="'+ item.id +'" data-color="'+item.pivot.colors_id+'" data-size="'+item.pivot.sizes_id+'" data-stock="'+stock+'" value="'+ quantity +'">'+
 		'</div>'+
 		'</td>'+
 		'<td class="product-subtotal"><span class="amount">'+"$ "+ total + ' '+currency+'</span></td>'+
 		'</tr> ';
 	});

 	$("#nav-item-quantity").html( getProductsQuantity() );
 	$("#body-table-cart-shop").html(row);
 	$("#cant-subtotal").html("$ "+subtotalcvarrito+' '+currency);
 	/*Delete product of cart*/
 	$(".delete-product").click(function() {
 		var products_id = this.name;
 		var colors_id = $(this).data('color');
 		var sizes_id = $(this).data('size');
 		var array = [];
 		var product = {
 			products_id:parseInt(products_id),
 			colors_id:colors_id,
 			sizes_id:sizes_id
 		};
 		array.push(product);
 		var products = {
 			products:array
 		};
 		var jsonParameters = JSON.stringify(products);
 		/*$.each( $(".delete-product-info"),  function(index,item){
 			if (id == item.id ) {
 				product = JSON.parse(decodeURIComponent( $(item).val() ))
 			}
 		});*/
 		/*console.log("PRODUCT TO DELETE " + JSON.stringify(product) );
 		console.log("PRODUCT TO DELETE: "  + product );*/
 		var cart_delete_product = 	$("input[name=cart_delete_product]").val();
 		var cart_alert_yes = $("input[name=cart_alert_yes]").val();
 		var cart_alert_no = 	$("input[name=cart_alert_no]").val();
 		var cart_delete_product_confirm = $("input[name=cart_delete_product_confirm]").val();
 		swal({
 			title: "",
 			text: cart_delete_product,
 			type: "warning",
 			showCancelButton: true,
 			confirmButtonColor: "#DD6B55",
 			confirmButtonText: cart_alert_yes,
 			cancelButtonText: cart_alert_no,
 			closeOnConfirm: false,
 			closeOnCancel: false
 		},
 		function(isConfirm){
 			if (isConfirm) {
 				deleteCart(jsonParameters);
 			} else {
 				swal("", "", "error");
 			}
 		});
 	});

 }

 function clickUpdateCart() {
 	/*Update cart*/
 	$("input[name=update_cart]").click(function() {
 		$('#div-alerts').html('');
 		var array_validate_stock = [];
 		var array_stock = [];
 		var notification = '';
 		$.each($('.product-item-quantity'), function(index, val) {
 			var quantity = $(this).val();
 			var stock = $(this).data('stock');
 			array_stock.push(stock);
 			if (quantity > stock) {
 				array_validate_stock.push('No');
 			} else {
 				array_validate_stock.push('Si');
 			}
 		});
 		console.log(array_validate_stock);
 		var if_exist = $.inArray('No', array_validate_stock);
 		if (if_exist >= 0) {
 			$.each(array_validate_stock, function(index, val) {
 				var position = index+1;
 				if (val == "No") {
 					notification += '<div class="alert alert-warning alert-dismissible alert-qty-'+index+1+'">'+
 					'<a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>'+
 					'<strong><i class="fa fa-warning"></i> ¡Atención!</strong> El producto '+position+' de tu carrito, no cuenta con la cantidad solicitada. <strong>Existencias: '+array_stock[index]+'</strong>'+
 					'</div>';
 				}
 			});
 			swal.close();
 			$('#div-alerts').html(notification);
 			cart();
 		} else {
 			swal.close();
 			$('#div-alerts').html('');
 			showProgress( languageObject[lang].updating_cart );
 			updateCartProucts( getProductToUpdate() );
 		}
 		/*$('span[id=count]').text('');
 		showProgress( languageObject[lang].updating_cart );
 		updateCartProucts( getProductToUpdate() );*/
 	});
 }

/**
 * Gets the product to delete.
 *
 * @param      {<type>}  id       The identifier
 * @param      {<type>}  product  The product
 * @return     {<type>}  The product to delete.
 */
 function getProductToDelete(id, product){
 	var products = [];
 	products.push( product );
 	itemIndex = 0;
 	$.each(cartResponse.data, function( index, item ) {
 		if ( item.id == id ) {
 			itemIndex = index;
 		}
 	});
 	cartResponse.data.splice( itemIndex , 1 );
 	var productsArray = {
 		products: products
 	}
 	console.log("CART RESPONSE ITEMS: " + JSON.stringify( cartResponse ) );
 	return JSON.stringify(productsArray);
 }

/**
 * Gets the product to update.
 *
 * @return     {<type>}  The product to update.
 */
 function getProductToUpdate(){
 	var products = [];
 	$.each(cartResponse.data, function(index, item) {
 		var product = {
 			products_id: item.pivot.products_id,
 			qty: item.pivot.qty,
 			sizes_id: item.pivot.sizes_id,
 			colors_id: item.pivot.colors_id,
 		}
 		products.push(product);
 	});
 	var productsArray = {
 		products: products
 	}
 	$.each( $(".product-item-quantity"), function( index1, item1 ) {
 		$.each( productsArray.products , function(index2, item2) {
 			if ($(item1).attr('name') == item2.products_id && $(item1).data('color') == item2.colors_id && $(item1).data('size') == item2.sizes_id) {
 				item2.qty = $(item1).val();
 			}
 		});
 	});
 	$.each( $(".product-item-quantity"), function( index1, item1 ) {
 		$.each(cartResponse.data , function(index2, item2) {
 			if ( $(item1).attr('name') == item2.id && $(item1).data('color') == item2.pivot.colors_id && $(item1).data('size') == item2.pivot.sizes_id) {
 				item2.pivot.qty = $(item1).val();
 			}
 		});
 	});
	//console.log("CART RESPONSE " + JSON.stringify(cartResponse) );
	return JSON.stringify(productsArray);
}
function showProgress(message){
	var string = $("#progress-animation-content").html().toString();
	swal({
		title: string,
		type: 'info',
		html: true,
		text: message,
		showConfirmButton: false,
	})
}

/**
 * Update cart
 *
 * @param      {<type>}  jsonParameters  The json parameters
 */
 function updateCartProucts(jsonParameters) {
 	sendValidation(jsonParameters);
 }

 function sendValidation(jsonParameters) {
 	console.log(jsonParameters);
 	$.ajaxSetup({
 		headers:{
 			'Authorization': 'Bearer ' + token,
 			'Content-Type': 'application/json',
 			'Accept-Language': lang
 		},
 		dataType: 'json',
 	});
 	$.ajax({
 		url: BASE_URL + CART_UPDATE,
 		type: 'POST',
 		dataType: 'json',
 		data: jsonParameters
 	})
 	.done(function(response) {
 		console.log(response);
 		if (response.type === "success") {
 			cart();
 			swal({
 				title: languageObject[lang].updated_cart,
 				text: "",
 				type: "success",
 				showConfirmButton: false,
 				timer: 1000
 			});
 		} else{
 			swal({
 				title: "",
 				text: "",
 				type: "error",
 				showConfirmButton: false,
 				timer: 1000
 			});
 		}

 	}).fail(function(error) {
 		console.log("cart response error " + JSON.stringify(error) );
 		console.log(error);
 		swal({
 			title: "",
 			text: error.responseJSON.data[0],
 			type: "error",
 			showConfirmButton: false,
 			timer: 5000
 		});
 	}).always(function() {
 		console.log("cart response complete");
 	});
 }

 function deleteCart(jsonParameters) {
 	console.log(jsonParameters);
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
 		console.log(response);
 		cart();
 		var cart_delete_product_confirm = $("input[name=cart_delete_product_confirm]").val();
 		swal({
 			title: cart_delete_product_confirm,
 			text: "",
 			type: "success",
 			showConfirmButton: false,
 			timer: 1000
 		});
 	}).fail(function(error) {
 		console.log("cart response error " + JSON.stringify(error) );
 	}).always(function() {
 		console.log("cart response complete");
 	});
 }
 function getCurrency(){
 	currency = "";
 	if (lang === 'es') {
 		currency = 'MXN';
 	}
 	if (lang === 'en') {
 		currency = 'USD';
 	}
 	return currency;
 }
 function getProductsQuantity(){
 	products = getProducts();
 	quantity = 0;
 	$.each( products , function( index, value ) {
 		quantity += parseInt( value.quantity );
 	});
 	console.log("PRODUCTS QUANTITY: " + quantity);
 	return quantity;
 }
 function getProducts(){
 	var products = [];
	//console.log("CART RESPONSE: " +  JSON.stringify(cartResponse) );
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