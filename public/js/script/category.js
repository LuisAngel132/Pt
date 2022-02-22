$(document).ready(function() {
	BASE_URL =  $('meta[name="base_url"]').attr('content');
	LIKES_CREATE = '/v1/likes/';
	token = $('meta[name="token"]').attr('content');
	lang = $('meta[name="language"]').attr('content');
	products = JSON.parse( $("#products-variable-container").val() )['data'];
	getShippingTime(lang);
	showSizesGuide();
	showProductDetail();
	getCategory();
	getGender();
	getStyle();
	filter();
	closeModalDetailProduct();
	inStockSize();
	showDesign();
	showDesignList();
	removeGift();
	getTranslations();

	productsGenreArray = [];
	productsStyleArray = [];
	showProductsArray = [];
	productsTotal = $("#products-total").val();

	$("#paging-text").html(languageObject[lang].showing + " " +  productsTotal + " " + languageObject[lang].products);

	$("#list-style").click(function(event) {
		if ( showProductsArray.length > 0 ) {
			showProductsList(true);
		}
	});

	$("#grid-style").click(function(event){
		if ( showProductsArray.length > 0 ) {
			showProductsGrid(true);
		}
	});
	/*Like*/
	$(".remove").click(function(){
		id = this.name;
		createLike(id, this);
	});
});

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
 * Removes a gift.
 */
 function removeGift() {
 	$('img.design-gift').click(function(event) {
 		var id = this.id;
 		$('#'+id).attr('style',  'display: none; margin-top: -285px;');
 		$('#'+id).removeClass('visible');
 	});
 }

/**
 * Shows the design.
 */
 function showDesign() {
 	$('.show-design').click(function(event) {
		let id = this.name;
		
		let design = $(this).data('design');

		facebook.events.arDesignViewed({
			name: design.nombre,
		});
		
 		if ($('#design-product-'+id).hasClass( "visible" )) {
 			$('#design-product-'+id).attr('style',  'display: none; margin-top: -285px;');
 			$('#design-product-'+id).removeClass('visible');
 		} else {
 			$('#design-product-'+id).attr('style',  'margin-top: -285px;');
 			$('#design-product-'+id).addClass('visible');
 		}
 	});
 }

/**
 * Shows the design list.
 */
 function showDesignList() {
 	$('.show-design-list').click(function(event) {
 		let id = this.name;
		
		let design = $(this).data('design');

		facebook.events.arDesignViewed({
			name: design.nombre,
		});

 		if ($('#design-product-list-'+id).hasClass( "visible" )) {
 			$('#design-product-list-'+id).attr('style',  'display: none; margin-top: -285px;');
 			$('#design-product-list-'+id).removeClass('visible');
 		} else {
 			$('#design-product-list-'+id).attr('style',  'margin-top: -285px;');
 			$('#design-product-list-'+id).addClass('visible');
 		}
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
 * Shows the products list.
 *
 * @param      {<type>}  bind    The bind
 */
 function showProductsList(bind){
 	if ( $( "#list-style" ).hasClass( 'active' ) || bind) {
 		console.log("METHOD: SHOW PRODUCT LIST");
 		console.log(showProductsArray);
 		$.each( $(".arubic-single-product"), function(index, item){
 			var show = false;
 			$.each(showProductsArray, function(index2, item2){
 				if ( parseInt(item.children[0].children[0].id) === parseInt(item2) ) {
 					show = true;
 				}
 			});
 			if (show) {
 				$(item).parent().css('display', 'block');
 			} else {
 				$(item).parent().css('display', 'none');
 			}
 		});

 		$.each( $(".product-list-item"), function( intex, item ) {
 			var show = false;
 			$.each( showProductsArray, function( index2, item2 ) {
 				if ( parseInt( $( item ).find( ".search-product-detail" )[0].id ) === parseInt(item2) ) {
 					show = true;
 				}
 			});
 			if (show) {
 				$( item ).css( 'display', 'block' );

 			} else {
 				$( item ).css( 'display', 'none' );
 			}
 		});
 	}
 }

/**
 * Shows the products grid.
 *
 * @param      {<type>}  bind    The bind
 */
 function showProductsGrid(bind){
 	if ( $("#grid-style").hasClass('active') || bind ) {
 		console.log("METHOD: SHOW PRODUCT GRID");
 		$.each( $(".arubic-single-product"), function(index, item){
 			var show = false;
 			$.each(showProductsArray, function(index2, item2){
 				if ( parseInt(item.children[0].children[0].id) === parseInt(item2) ) {
 					show = true;
 				}
 			});
 			if (show) {
 				$(item).parent().css('display', 'block');

 			} else {
 				$(item).parent().css('display', 'none');
 			}
 		});

 		$.each( $(".product-list-item"), function( intex, item ) {
 			var show = false;
 			$.each( showProductsArray, function( index2, item2 ) {
 				if ( parseInt( $( item ).find( ".search-product-detail" )[0].id ) === parseInt(item2) ) {
 					show = true;
 				}
 			});
 			if (show) {
 				$( item ).css( 'display', 'block' );

 			} else {
 				$( item ).css( 'display', 'none' );
 			}
 		});


 	}
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

 		$('input[name="product-style"]').change(function(){
 			var checked = $(this).is(':checked');
 			var product_styles_id = $(this).val();
 			showProductsArray = [];
 			productsStyleArray = [];

 			if (checked) {
 				$.each(products, function(index, item){
 					if ( parseInt(product_styles_id) === parseInt(item.product_styles_id) ) {
 						productsStyleArray.push(item.id);
 					}
 				});
 			}

 			if ( productsGenreArray.length > 0) {
 				if (checked) {
 					$.each(productsStyleArray, function(index, item) {
 						$.each(productsGenreArray, function(index2, item2) {
 							if ( item === item2 ) {
 								showProductsArray.push(item);
 							}
 						});
 					});
 				} else {
 					showProductsArray = productsGenreArray;
 				}
 			} else {
 				showProductsArray = productsStyleArray;
 			}

 			console.log("SHOW PRODUCTS ARRAY");
 			console.log(showProductsArray);

 			$("#paging-text").html(languageObject[lang].showing + " " +  showProductsArray.length + " " + languageObject[lang].products);
 			showProductsGrid(false);
 			showProductsList(false);
 		});
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
 * Click remove.
 */
 function clickRemove() {
 	$('.remove').click(function(event) {
 		var id = this.name;
 		var inputs;
 		inputs += '<input type="hidden" name="id" value="' + id + '" />';
 		$("body").append('<form action="like" method="get"  class="formul">' +inputs+'</form>');
 		$(".formul").submit();
 	});
 }

/**
 * Fiter genre.
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
 			alert("selecciona almenos un filtro")
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

/**
 * Shows the product detail.
 */
 function showProductDetail() {
 	$(".search-product-detail").click(function(event) {
 		$('.single-product-menu').html('');
 		getSizesGuide();
 		var id = this.name;
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
 		products_gallery = product.products_colors;


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
 		productPrice = '<span class="price text-uppercase">'+" $ "+product.product_translations[0].price+ ' ' + getCurrency()+'</span>';

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
 			if (color.resources && color.is_active == 1) {
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
		 
 		console.log('product', product);
 		
 		facebook.events.viewContent({
			product_design: product.products_designs[0].designs.nombre,
			product_name: product.product_translations[0].name,
			product_description: product.product_translations[0].description,
			product_currency: product.product_translations[0].langs_id == 1 ? 'MXN' : 'USD',
			product_value: product.product_translations[0].price,
		});

 		if (product.products_colors[0].resources.galleries.length > 1) {
 			var galleries_image = '';
 			var li_image_indicator = '';
 			$.each(product.products_colors[0].resources.galleries, function(index, gallery) {
 				if (index == 0) {
 					galleries_image += '<div class="single-tab-menu img-full">'+
 					'<a class="active show-gallery" data-toggle="tab" id="'+gallery.id+'">'+
 					'<img src="'+gallery.public_image_url+'" alt="">'+
 					'</a>'+
 					'</div>';
 				} else {
 					galleries_image += '<div class="single-tab-menu img-full">'+
 					'<a class="show-gallery" data-toggle="tab" id="'+gallery.id+'">'+
 					'<img src="'+gallery.public_image_url+'" alt="">'+
 					'</a>'+
 					'</div>';
 				} 
 			});
 			var slider_galleries = '<div class="nav single-slide-menu" role="tablist">'+
 			galleries_image+
 			'</div>';
 			$('.single-product-menu').html(slider_galleries);
 			$('.single-slide-menu').slick({
 				infinite: true,
 				slidesToShow: 6,
 				slidesToScroll: 6,
 				dots: false,
 				prevArrow: '<i class="fa fa-angle-left"></i>',
 				nextArrow: '<i class="fa fa-angle-right slick-next-btn"></i>',
 			});
 		} else {
 			$('.single-product-menu').html('');
 		}

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
 			$('.single-product-img').html('<img src="'+img_url+'" alt="">');
 			/*end color del producto*/

 			if (array_resource[0].resources.galleries.length > 1) {
 				var galleries_image = '';
 				var li_image_indicator = '';
 				$.each(array_resource[0].resources.galleries, function(index, gallery) {
 					if (index == 0) {
 						galleries_image += '<div class="single-tab-menu img-full">'+
 						'<a class="active show-gallery" data-toggle="tab" id="'+gallery.id+'">'+
 						'<img src="'+gallery.public_image_url+'" alt="">'+
 						'</a>'+
 						'</div>';
 					} else {
 						galleries_image += '<div class="single-tab-menu img-full">'+
 						'<a class="show-gallery" data-toggle="tab" id="'+gallery.id+'">'+
 						'<img src="'+gallery.public_image_url+'" alt="">'+
 						'</a>'+
 						'</div>';
 					} 
 				});
 				var slider_galleries = '<div class="nav single-slide-menu" role="tablist">'+
 				galleries_image+
 				'</div>';
 				$('.single-product-menu').html(slider_galleries);
 				$('.single-slide-menu').slick({
 					infinite: true,
 					slidesToShow: 6,
 					slidesToScroll: 6,
 					dots: false,
 					prevArrow: '<i class="fa fa-angle-left"></i>',
 					nextArrow: '<i class="fa fa-angle-right slick-next-btn"></i>',
 				});

 				$('.show-gallery').click(function(event) {
 					var id = this.id;
 					var array_galleries = [];
 					$.each(products_gallery, function(index, color) {
 						if (color.resources.galleries.length > 0) {
 							$.each(color.resources.galleries, function(index, gallery) {
 								array_galleries.push(gallery);
 							});
 						}
 					});
 					$.each(array_galleries, function(index, val) {
 						if (val.id == id) {
 							$('.single-product-img').html('<img src="'+val.public_image_url+'">');
 						}
 					});
 				});

 			} else {
 				$('.single-product-menu').html('');
 			}

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

 		$('.show-gallery').click(function(event) {
 			var id = this.id;
 			var array_galleries = [];
 			$.each(products_gallery, function(index, color) {
 				if (color.resources.galleries.length > 0) {
 					$.each(color.resources.galleries, function(index, gallery) {
 						array_galleries.push(gallery);
 					});
 				}
 			});
 			$.each(array_galleries, function(index, val) {
 				if (val.id == id) {
 					$('.single-product-img').html('<img src="'+val.public_image_url+'">');
 				}
 			});
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

 function getTranslations(){
 	languageObject = {
 		es : {
 			showing: 'Mostrando',
 			products: 'productos'
 		},
 		en : {
 			showing: 'Showing',
 			products: 'products'
 		}
 	}
 }
 function getCategory(){
 	$.get('get_category', function(data) {

 		var li = "";
 		$.each(data, function(index, val) {
 			li += '<li class="has-sub"><a class="link_category" name="'+val.base_categories_id+'">'+val.category+'</a></li>';
 		});

 		$(".category").html(li);
 		$(".link_category").click(function(event) {
 			id = this.name;
 			inputs = '<input type="hidden" name="id" value="' + id + '" />';
 			$("body").append('<form action="category" method="get"  class="categories">' +inputs+'</form>');
 			$(".categories").submit();
 		});
 	});
 }
 function getGender() {
 	$.get('get_gender', function(data) {
 		var input ="";
 		$.each(data, function(index, val) {
 			input += '<li><label><input type="radio" name="product-genre" value="'+val.product_genres_id+'"> '+val.genre+'</label></li>';
 		});
 		$(".gender").html(input);

 		$('input[name="product-genre"]').click(function(){

 			showProductsArray = [];
 			var product_genres_id = $(this).val();
 			productsGenreArray = [];
 			$.each(products, function(index, item){
 				if ( parseInt(product_genres_id) === parseInt(item.product_genres_id) ) {
 					productsGenreArray.push(item.id);
 				}
 			});


 			if ( productsStyleArray.length > 0 ) {
 				$.each(productsGenreArray, function(index, item){
 					$.each(productsStyleArray, function(index2, item2){
 						if ( item === item2 ) {
 							showProductsArray.push(item);
 						}
 					});
 				});
 			} else {
 				showProductsArray = productsGenreArray;
 			}

 			console.log("SHOW PRODUCTS ARRAY");
 			console.log(showProductsArray);

 			$("#paging-text").html(languageObject[lang].showing + " " +  showProductsArray.length + " " + languageObject[lang].products);

 			showProductsGrid(false);
 			showProductsList(false);

 		});
 	});
 }
