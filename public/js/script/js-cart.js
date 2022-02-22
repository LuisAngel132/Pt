$(document).ready(function() {
	BASE_URL =  $('meta[name="base_url"]').attr('content');
	CART_POST = '/v1/cart';

	lang = $('meta[name="language"]').attr('content');
	token = $('meta[name="token"]').attr('content');
	cartResponse = "";
	addToCart();
	translationText(lang);
	console.log("BASE URL: " + BASE_URL);
});

function translationText(lang) {
	if (lang === 'es') {
		text_loading = 'Cargando...';
		add_to_cart = 'Agregar al carrito';
	} else if (lang === 'en') {
		text_loading = 'Loading...';
		add_to_cart = 'Add to cart';
	} else {
		text_loading = 'Cargando...';
		add_to_cart = 'Agregar al carrito';
	}
}

function addToCart() {
	$("#add-to-cart").click(function(event) {
		size = $('select[name=size] option:selected').val();
		quantity = $("input[name=quantity]").val();
		product = $('input[name=id]').val();
		var colorsID = "";
		$.each( $(".select-color"), function( index, item ) {
			if ( $(item).hasClass('selected') ) {
				colorsID = $($(item).parent()).attr('name');
				console.log( "COLORS ID: " + colorsID );
			}
		});
		//var productInfo = JSON.parse( $("#product-cart-info").val() );
		var products = [];
		var product = {
			products_id: product,
			qty: quantity,
			sizes_id: size,
			colors_id: colorsID
		}
		products.push(product);
		var productsArray = {
			products: products
		}
		//console.log("PRODUCT CART ARRAY " + JSON.stringify(productsArray) );
		if ( colorsID === "" ) {
			$("#alert-color").show();
			setTimeout(function(){
				$("#alert-color").hide(500);
			}, 2000);
		} else if ( !$("input[name=quantity]").numeric()) {
			$("#alert-quantity").show();
			setTimeout(function(){
				$("#alert-quantity").hide(500);
			}, 2000);
		}else if ($("input[name=quantity]").val() <= 0)  {
			$("#alert-quantity").show();
			setTimeout(function(){
				$("#alert-quantity").hide(500);
			}, 2000);
		}else if ($('select[name=size]').val().trim() === '')  {
			$("#alert-size").show();
			setTimeout(function(){
				$("#alert-size").hide(500);
			}, 2000);
		} else if (parseInt(quantity) > parseInt($("#qty-stock").text())) {
			$("#alert-stock").show();
			setTimeout(function(){
				$("#alert-stock").hide(500);
			}, 2000);
		} else {
			if ( token === "" ) {
				window.open('login');
			} else {
				$('#add-to-cart').html('<i class="fa fa-spinner fa-spin"></i> '+text_loading).prop('disabled', true);
				$.get('verify_stock/'+product.products_id+'/'+product.colors_id+'/'+product.sizes_id+'/'+product.qty, function(data) {
					console.log(data);
					if (data.fail == true) {
						$(".quantity-exist").text(data.data.quantity);
						$("#alert-stock-verify").show();
						setTimeout(function(){
							$("#alert-stock-verify").hide(2000);
						}, 4000);
					} else {
						postAddCart( JSON.stringify(productsArray) );
					}
					$('#add-to-cart').html('<i class="zmdi zmdi-shopping-cart-plus"></i> '+add_to_cart).prop('disabled', false);
				});
			}
		}
	});
}
function postAddCart(jsonParamters) {
	$.ajaxSetup({
		headers:{
			'Authorization': 'Bearer ' + token,
			'Content-Type': 'application/json',
			'Accept-Language': lang
		},
		dataType: 'json',
	});
	$.ajax({
		url: BASE_URL + CART_POST,
		type: 'POST',
		dataType: 'json',
		data: jsonParamters
	})
	.done(function(response) {
		console.log("CART RESPONSE " + JSON.stringify(response) );
		if (response.type == "success") {
			$("#alert-add-cart").show();
			setTimeout(function(){
				$("#alert-add-cart").hide(500);
			}, 3000);
		} else {
			$("#alert-quantity").show();
			setTimeout(function(){
				$("#alert-quantity").hide(500);
			}, 3000);
		}
	}).fail(function(error) {
		console.log("cart response error " + JSON.stringify(error) );
	}).always(function() {
		console.log("cart response complete "  );
	});
}
function getCartShop() {
	var subtotal=0;
	var totalCompra=0;
	row = '<tr>';
	$.get('get_cart_shop', function(data) {
		//console.log(data);
		$.each(data, function(index, val) {
			//console.log(val);
			btnDelete = '<td class="product-remove"><a  class="btn delete-product" name="'+val.id+'"><i class="zmdi zmdi-close text-danger"></i></a></td>';
			img = val.product.resources.public_image_url;
			product = val.product.products.product_translations[0].name;
			currency = val.product.products.product_translations[0].langs.currency_code;
			price = val.product.products.product_translations[0].price;
			quantity = val.qty;
			size = val.sizes;

			totalprice =parseFloat(price*quantity).toFixed(2)
			total = numberWithCommas(totalprice);
			subtotal += price*quantity;
			subtotalcvarrito = numberWithCommas(parseFloat(subtotal).toFixed(2));
			row +=btnDelete+
			'<td class="product-thumbnail"><a href="#"><img src="'+img+'" alt="" width="120px"></a></td>'+
			'<td class="product-name"><a href="#">'+product+'</a></td>'+
			'<td class="product-name"><a href="#">'+size+'</a></td>'+
			'<td class="product-price"><span class="amount">'+"$ "+price+'</span></td>'+
			'<td class="product-quantity">'+
			'<div class="cart-plus-minus">'+
			'<input class="cart-plus-minus-box" type="text" name="'+val.id+'" value="'+quantity+'">'+
			'</div>'+
			'</td>'+
			'<td class="product-subtotal"><span class="amount">'+"$ "+total+'</span></td>'+
			'</tr> ';
		});

		$("#body-table-cart-shop").html(row);
		$("#cant-subtotal").html(currency+" $ "+subtotalcvarrito)
		$(".delete-product").click(function() {
			id = this.name;
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
					deleteProduct(id,cart_delete_product_confirm)
				} else {
					swal("", "", "error");
				}
			});
			//deleteProduct();
		});

		$("input[name=update_cart]").click(function() {
			//alert("click")
			inptCant = [];
			var input, cant;
			$.each(data, function(index, val) {
				input = val.id;
				cant = $("input[name="+val.id+"]").val();
				array = {
					'id': input,
					'cant': cant,
				}
				inptCant.push(array);
			});
			updateCart(inptCant);
		});
	});
}
function getCart() {
	$.get('get_cart', function(data) {
		$(".item-tot").html(data)
	});
}
function deleteProduct(id, cart_delete_product_confirm) {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type: "DELETE",
		url:"cart/"+id,
		success: function(result) {
			swal("", cart_delete_product_confirm, "success");
			setTimeout(function(){
				location.reload();
			}, 2000);
		}
	});
}
function updateCart(inptCant) {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.post('cart_update', {
		inptCant
	}, function(data, textStatus, xhr) {
		setTimeout(function(){
			location.reload();
		}, 2000);
	});
}
function checkout() {
	$("#cart-checkout").click(function() {
		var subtotal = $("input[name=cant_cart]").val();
		var inputs;
		$("body").append('<form action="checkout" method="get"  class="checkout"></form>');
		$(".checkout").submit();
	});
}
function numberWithCommas(number) {
	var parts = number.toString().split(".");
	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	return parts.join(".");
}