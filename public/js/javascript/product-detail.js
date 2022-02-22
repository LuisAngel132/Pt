$(document).ready(function() {
	BASE_URL =  $('meta[name="base_url"]').attr('content');
	TOP_GET = '/v1/products/top';
	lang = $('meta[name="language"]').attr('content');
	token = $('meta[name="token"]').attr('content');
	searchProductDetail();
});
/**
 * Search product detail.
 *
 * @return {[type]} [description]
 */
 function searchProductDetail() {
 	$(".search-product-detail-top").click(function(event) {
 		$('.single-product-menu').html('');
 		$(".product-details-large").html('<i style="font-size: 100px;margin-top: 100px;margin-left: 110px;" class="fa fa-spinner fa-spin"></i>');
 		var id = this.id;
 		$('input[name=id]').val(id);
 		$.get('search-product/'+id, function(data) {
			console.log(data);

			facebook.events.viewContent({
				product_design: data.nombre,
				product_name: data.products[0].translations[0].name,
				product_description: data.products[0].translations[0].description,
				product_currency: data.products[0].translations[0].formatted_price.split(' ')[1],
				product_value: data.products[0].translations[0].price,
			});

 			products_gallery = data.products[0].colors;
 			/*Sizes guide*/
 			$('input[name=styles_id]').val(data.products[0].styles.id);
 			$('input[name=types_id]').val(data.products[0].types.id);
 			$('input[name=genres_id]').val(data.products[0].genres.id);
 			getSizesGuide();
 			/*End sizes guide*/
 			/*Info cart*/
 			var productCart = {
 				products_id: data.id,
 			}
 			$("#product-cart-info").val( JSON.stringify( productCart ) );
 			/*end info cart*/
 			var product_name = '<h1 class="single-product-name">'+data.products[0].translations[0].name+'</h1>';
 			var product_description = '<p>'+data.products[0].translations[0].description+'</p>';
 			var product_price = '<span class="price text-uppercase">'+" $ "+data.products[0].translations[0].price +' '+ getCurrency() +'</span>';
 			var product_resource = '<div class="tab-pane fade show active" id="single-slide'+data.products[0].colors[0].resources.id+'" role="tabpanel" aria-labelledby="single-slide-tab-'+data.products[0].colors[0].resources.id+'" >'+
 			'<div class="single-product-img img-full image-main">'+
 			'<img src="'+data.products[0].colors[0].resources.galleries[0].public_image_url+'" alt="">'+
 			'</div>'+
 			'</div>';

 			/*Rating*/
 			var rating = '';
 			if ( data.products[0].average_rating > 0 ) {
 				for ( var i = 0; i < 5; i++ ) {
 					if ( i < data.products[0].average_rating ) {
 						rating += '<i class="fa fa-star text-warning"></i>';
 					} else {
 						rating += '<i class="fa fa-star-o text-muted"></i>';
 					}
 				}
 			} else {
 				for ( var i = 0; i < 5; i++ ) {
 					rating += '<i class="fa fa-star-o text-muted"></i>';
 				}
 			}

 			/*Favorites*/
 			var favorite = '';
 			if ( data.products[0].liked_by_me != "Unauthorized" ) {
 				if ( data.products[0].liked_by_me == true ) {
 					favorite = '<a class="remove like" style="font-size: 20px;" name="'+data.products[0].id+'"> <i class="zmdi zmdi-favorite zmdi-hc-fw text-danger"></i></a>';
 				} else {
 					favorite = '<a class="remove like" style="font-size: 20px;" name="'+data.products[0].id+'"> <i class="zmdi zmdi-favorite-outline zmdi-hc-fw"></i></a>';
 				}
 			} else {
 				favorite = '';
 			}

 			/*Colors*/
 			var array_colors = [];
 			var products_colors = data.products[0].colors;
 			$.each(products_colors, function(key, color) {
 				if (color.is_active == 1) {
 					array_colors.push(color.colors);
 				}
 			});
 			function deleteColorsDuplicates(arr, prop) {
 				var nuevoArray = [];
 				var lookup  = {};
 				for (var i in arr) {
 					lookup[arr[i][prop]] = arr[i];
 				}
 				for (i in lookup) {
 					nuevoArray.push(lookup[i]);
 				}
 				return nuevoArray;
 			}
 			var colors_uniques = deleteColorsDuplicates(array_colors, 'hex');
 			var colors = '';
 			$.each(colors_uniques, function(index, val) {
 				colors += '<li><a class="change_active" name="'+val.id+'"><span class="color select-color" name="'+val.id+'" style="background-color:'+val.hex+'"></span></a></li>';
 			});

 			/*Sizes*/
 			var array_sizes = [];
 			$.each(products_colors, function(key, color) {
 				if (color.is_active == 1) {
 					array_sizes.push(color.sizes);
 				}
 			});
 			function deleteSizesDuplicates(arr, prop) {
 				var nuevoArray = [];
 				var lookup  = {};
 				for (var i in arr) {
 					lookup[arr[i][prop]] = arr[i];
 				}
 				for (i in lookup) {
 					nuevoArray.push(lookup[i]);
 				}
 				return nuevoArray;
 			}
 			var sizes_uniques = deleteSizesDuplicates(array_sizes, 'size');
 			/*Order by id*/
 			sizes_uniques.sort(function (a, b) {
 				if (a.id > b.id) { return 1; }
 				if (a.id < b.id) { return -1; }
 			  // a must be equal to b
 			  return 0;
 			});
 			$(".nice-select").hide();
 			var select_sizes = '<option value="" ></option>';
 			$.each(sizes_uniques, function(key, val) {
 				select_sizes += '<option value="'+val.id+'" >' + val.size+ '</option>';
 				$("#sizes").html(select_sizes);
 			});
 			$("#sizes").show();
 			$(".product-details-large").html(product_resource);
 			$(".product-name-div").html(product_name);
 			$(".product-info").html(product_description);
 			$(".product-discount").html(product_price);
 			$('.single-product-reviews').html(rating);
 			//$('.favorite').html(favorite);
 			$(".procuct-color").html(colors);

 			if (data.products[0].colors[0].resources.galleries.length > 1) {
 				var galleries_image = '';
 				var li_image_indicator = '';
 				$.each(data.products[0].colors[0].resources.galleries, function(index, gallery) {
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

 			/*Select color*/
 			$(".select-color").click(function(){
 				$.each($(".procuct-color li a span"), function(index, item){
 					$($(item).parent()).css('border','2px solid white');
 					$(item).removeClass('selected');
 				});
 				$($(this).parent()).css('border','2px solid tan');
 				$(this).addClass('selected');

 				var colors_id = "";
 				var sizes_id = $('#sizes').val();
 				$.each( $(".select-color"), function( index, item ) {
 					if ( $(item).hasClass('selected') ) {
 						colors_id = $($(item).parent()).attr('name');
 					}
 				});
 				var image_url = '';
 				var filter_color = products_colors.filter(function (item) {
 					return item.colors_id == colors_id;
 				});
 				img_url = filter_color[0].resources.galleries[0].public_image_url;
 				$('.image-main').html('<img src="'+img_url+'">');

 				if (filter_color[0].resources.galleries.length > 1) {
 					var galleries_image = '';
 					var li_image_indicator = '';
 					$.each(filter_color[0].resources.galleries, function(index, gallery) {
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
 								$('.image-main').html('<img src="'+val.public_image_url+'">');
 							}
 						});
 					});

 				} else {
 					$('.single-product-menu').html('');
 				}

 				if (sizes_id != '' && colors_id != '') {
 					var filter_color_size = products_colors.filter(function (item) {
 						return item.colors_id == colors_id && item.sizes_id == sizes_id;
 					});
 					if (filter_color_size.length == 0) {
 						$('.add-to-cart').hide();
 						$('.stock-label').hide();
 					} else {
 						var qty = filter_color_size[0].quantity;
 						$('.add-to-cart').show();
 						$('.stock-label').show();
 						$('#qty-stock').text(qty);
 					}
 				} else {
 					$('.add-to-cart').hide();
 					$('.stock-label').hide();
 				}

 			}); /*end select-color*/

 			$('#sizes').change(function(event) {
 				var sizes_id = $(this).val();
 				var colors_id = "";
 				$.each( $(".select-color"), function( index, item ) {
 					if ( $(item).hasClass('selected') ) {
 						colors_id = $($(item).parent()).attr('name');
 					}
 				});
 				if (sizes_id != '' && colors_id != '') {
 					var filter_color_size = products_colors.filter(function (item) {
 						return item.colors_id == colors_id && item.sizes_id == sizes_id;
 					});
 					if (filter_color_size.length == 0) {
 						$('.add-to-cart').hide();
 						$('.stock-label').hide();
 					} else {
 						var qty = filter_color_size[0].quantity;
 						$('.add-to-cart').show();
 						$('.stock-label').show();
 						$('#qty-stock').text(qty);
 					}
 				} else {
 					$('.add-to-cart').hide();
 					$('.stock-label').hide();
 				}
 			});/*end change size*/

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
 						$('.image-main').html('<img src="'+val.public_image_url+'">');
 					}
 				});
 			});
 		});
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
 		// console.log(response);
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