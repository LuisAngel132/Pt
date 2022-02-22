$(document).ready(function() {
	modalCancel();
	modalDevolution();
	viweReference();
	viewDetail();
	shipping();
	changeProduct();
	ratingCustomers();
	changeRadiobutton();
	changeRadiobuttonEdit();
	$(".text-radio").hide();
	saveRating();
	editRating();

	orders = $("#orders-container").val();
	console.log("ORDERS " + orders );

});

/**
 * Cancel
 */
 function modalCancel() {
 	$('.cancel').click(function(event) {
 		var id = this.name;
 		var order_id = $(this).attr('order_id');
 		$('input[name=id]').val(id);
 		$('input[name=id_order]').val(order_id);
 	});

 }

/**
 * Devolution
 */
 function modalDevolution() {
 	$('.devolution').click(function(event) {
 		var id = this.name;
 		$.ajaxSetup({
 			headers: {
 				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 			}
 		});
 		$.post('getProducts', {id: id}, function(data, textStatus, xhr) {
 			console.log(data);
 			var array_products = [];
 			$.each(data.data.products[0].products.colors, function(index, val) {
 				array_products.push(val.products_id);
 			});
 			$('input[name=id]').val(id);
 			$('input[name=products]').val(array_products);
 			$('input[name=id_order]').val(data.data.order_id);
 		});
 	});
 }

/**
 * Reference
 */
 function viweReference() {
 	$('.reference').click(function(event) {
 		var id = this.name;
 		var inputs;
 		inputs += '<input type="hidden" name="id" value="' + id + '" />';
 		$("body").append('<form action="getReference" method="get"  class="formul">' +inputs+'</form>');
 		$(".formul").submit();
 	});
 }

/**
 * Detail of the order
 */
 function viewDetail() {
 	$('.detail').click(function(event) {
 		var id = this.name;
 		var inputs;
 		inputs += '<input type="hidden" name="reference" value="' + id + '" />';
 		$("body").append('<form action="getDetail" method="get"  class="formul">' +inputs+'</form>');
 		$(".formul").submit();
 	});
 }

/**
 * shipping
 */
 function shipping() {
 	$('.shipping').click(function(event) {
 		var id = this.name;
 		var inputs;
 		inputs += '<input type="hidden" name="reference" value="' + id + '" />';
 		$("body").append('<form action="getTraking" method="get"  class="formul">' +inputs+'</form>');
 		$(".formul").submit();
 	});
 }

/**
 * change Product
 */
 function changeProduct() {
 	$('.change-product').click(function(event) {
 		var product_id = this.name;
 		var order_id = $(this).attr('order_id');
 		$.ajaxSetup({
 			headers: {
 				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 			}
 		});
 		$.post('getResource', {product_id: product_id, order_id: order_id}, function(data, textStatus, xhr) {
 			console.log(data);
 			var id = data.products.id;
 			var name = data.products.translations[0].name;
 			var description = data.products.translations[0].description;
 			var price = data.products.translations[0].price;
 			var size = data.sizes.size;
 			var qty = data.qty;
 			$.each(data.products.colors, function(index, val) {
 				if (val.colors_id == data.colors_id) {
 					var url_image = val.resources.galleries[0].public_image_url;
 					$("#img-product").attr("src", url_image);
 				}
 			});
 			$('#products_id').val(id);
 			$('.name-product').text(name);
 			$('.price-product').text("$ "+price);
 			$('.description-product').text(description);
 			$('.size-product').text(size);
 			$('.qty-product').text(qty);
 			$('input[name=product_id]').val(id);
 			$('input[name=id_product]').val(id);

 			ratingCustomers();
 		});
 	});
 }

/**
 * rating Customers
 */
 function ratingCustomers() {
 	rating = "";
 	ratingUser = "";
 	ratingTitle = "";
 	ratingDescription = "";
 	ratingOption = "";
 	id = $('input[name=product_id]').val();
 	$.ajaxSetup({
 		headers: {
 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 		}
 	});
 	$.post('get_rating', {
 		product_id: id
 	}, function(data, textStatus, xhr) {
 		console.log(data);
 		if (data.rating == true) {
 			ratingOption = '<a class="rating-edit btn" name="'+data.ratingCustomerID+'" data-toggle="modal" data-product="'+id+'" href="#rating_edit"> <i class="zmdi zmdi-edit"></i> </a>'+
 			'<a class="rating-delete btn" name="'+data.ratingCustomerID+'"> <i class="zmdi zmdi-delete"></i> </a>';
 			ratingTitle += '<h4>'+data.ratingTitle+'</h4>';
 			ratingDescription += '<p>'+data.ratingDescription+'</p>'
 			for (var i = 0; i < 5; i++) {
 				if (i < data.ratingCustomer) {
 					ratingUser += '<i class="fa fa-star text-warning"></i>';
 				}else{
 					ratingUser += '<i class="fa fa-star-o text-warning"></i>';
 				}
 			}
 			$('.product-reviews-user').html(ratingUser);
 			$(".rating-title").html(ratingTitle);
 			$(".rating-description").html(ratingDescription);
 			$(".option-rating").html(ratingOption);

 			$(".rating-user").show();
 			$(".rating-user-btn").hide();
 		} else{
 			$(".rating-user").hide();
 			$(".rating-user-btn").show();
 		}
 		if (data.ratingTotal > 0) {
 			for (var i = 0; i < 5; i++) {
 				if (i < data.ratingTotal) {
 					rating += '<i class="fa fa-star fa-lg text-warning"></i>';
 				}else{
 					rating += '<i class="fa fa-star-o fa-lg text-muted"></i>';
 				}
 			}
 		}else{
 			for (var i = 0; i < 5; i++) {
 				rating += '<i class="fa fa-star-o fa-lg text-muted"></i>';
 			}
 		}
 		$('.rating-text').html(data.ratingTotal)
 		$('.product-reviews').html(rating)
 		$('.total-customer-rating').html(data.ratingCustomerTotal)
 		rating = "";
 		ratingUser = "";
 		ratingTitle = "";
 		ratingDescription = "";
 		ratingOption = "";

 		$(".rating-edit").click(function(event) {
 			id = this.name;
 			product = $(this).data('product');
 			$('input[name=id_product]').val(product);
 			$('input[name=id_customer_rating]').val(id);
 		});
 		$(".rating-delete").click(function(event) {
 			id = this.name;
 			deleteRating(id);
 		});
 	});
 }

/**
 * change Radiobutton
 */
 function changeRadiobutton() {
 	title ="";
 	$("input[name=rating]").click(function () {
 		option = $(this).val();
 		switch(option){
 			case '1':
 			title = $("input[name=rating_title_1]").val();
 			break;
 			case '2':
 			title = $("input[name=rating_title_2]").val();
 			break;
 			case '3':
 			title = $("input[name=rating_title_3]").val();
 			break;
 			case '4':
 			title = $("input[name=rating_title_4]").val();
 			break;
 			case '5':
 			title = $("input[name=rating_title_5]").val();
 			break;
 			default:
 			break;
 		}
 		$("input[name=title]").val(title);
 		$(".text-rating-select").html(title);
 	});
 }

/**
 * change Radiobutton
 */
 function changeRadiobuttonEdit() {
 	title ="";
 	$("input[name=rating_edit]").click(function () {
 		option = $(this).val();
 		switch(option){
 			case '1':
 			title = $("input[name=rating_title_1_edit]").val();
 			break;
 			case '2':
 			title = $("input[name=rating_title_2_edit]").val();
 			break;
 			case '3':
 			title = $("input[name=rating_title_3_edit]").val();
 			break;
 			case '4':
 			title = $("input[name=rating_title_4_edit]").val();
 			break;
 			case '5':
 			title = $("input[name=rating_title_5_edit]").val();
 			break;
 			default:
 			break;
 		}
 		$("input[name=title_edit]").val(title);
 		$(".text-rating-select-edit").html(title);
 	});
 }

/**
 * Saves a rating.
 */
 function saveRating() {
 	$("#save-rating").click(function() {
 		comentario = $("textarea[name=description]").val();
 		title = $("input[name=title]").val();
 		rating = $('input:radio[name=rating]:checked').val();
 		products = $("input[name=id_product]").val();
 		if (title == '') {
 			$('#alert-stars-edit').show();
 			setTimeout(function(){
 				$('#alert-stars-edit').hide(500);
 			}, 4000);
 		} else if ($.trim(comentario) == '') {
 			$('#alert-comment-edit').show();
 			setTimeout(function(){
 				$('#alert-comment-edit').hide(500);
 			}, 4000);
 		} else {
 			postRating(comentario, title, rating, products);
 		}
 	});
 }


/**
 * Posts a rating.
 * @param     comentario  The comentario
 * @param     title       The title
 * @param     rating      The rating
 * @param     products    The products
 */
 function postRating(comentario, title, rating, products) {
 	$.ajaxSetup({
 		headers: {
 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 		}
 	});
 	$.post('rating', {
 		comentario, title, rating, products
 	}, function(data, textStatus, xhr) {
		//console.log(data);
		if (data.status == 'success') {
			swal("", data.mensaje, data.status);
			ratingCustomers();
			$('#calificar').modal('toggle');
		}else{
			swal("", data.mensaje, data.status);
		}
	});
 }


/**
 * edit Rating
 */
 function editRating() {
 	$("#edit-rating").click(function() {
 		id = $("input[name=id_customer_rating]").val();
 		comentario_edit = $("textarea[name=description_edit]").val();
 		title_edit = $("input[name=title_edit]").val();
 		rating_edit = $('input:radio[name=rating_edit]:checked').val();
 		products_edit = $("input[name=id_product]").val();
 		if (title_edit == '') {
 			$('#alert-stars').show();
 			setTimeout(function(){
 				$('#alert-stars').hide(500);
 			}, 4000);
 		} else if ($.trim(comentario_edit) == '') {
 			$('#alert-comment').show();
 			setTimeout(function(){
 				$('#alert-comment').hide(500);
 			}, 4000);
 		} else {
 			putRating(id, comentario_edit, title_edit, rating_edit, products_edit);
 		}
 	});

 }

/**
 * Puts a rating.
 *
 * @param      {string}  id               The identifier
 * @param      {string>}  comentario_edit  The comentario edit
 * @param      {string>}  title_edit       The title edit
 * @param      {string>}  rating_edit      The rating edit
 * @param      {string>}  products_edit    The products edit
 */
 function putRating(id, comentario_edit, title_edit, rating_edit, products_edit) {
 	$.ajaxSetup({
 		headers: {
 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 		}
 	});
 	$.ajax({
 		url: 'rating/'+id,
 		type: 'PUT',
 		dataType: 'json',
 		data: {comentario_edit, title_edit, rating_edit, products_edit},
 		success: function (data) {
 			console.log(data);
 			if (data.status == 'success') {
 				swal("", data.mensaje, data.status);
 				ratingCustomers();
 				$('#rating_edit').modal('hide');
 			}else{
 				swal("", data.mensaje, data.status);
 			}
 		},
 		error: function (data) {
 			swal("", "Oops...!", "error");
 		}
 	});
 }

/**
 * delete Rating
 * @param      {string}  id      The identifier
 */
 function deleteRating(id) {
 	$.ajaxSetup({
 		headers: {
 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 		}
 	});
 	$.ajax({
 		url: 'rating/'+id,
 		type: 'DELETE',
 		dataType: 'json',
 		success: function (data) {
 			console.log(data);
 			if (data.status == 'success') {
 				swal("", data.mensaje, data.status);
 				ratingCustomers();
 			}else{
 				swal("", data.mensaje, data.status);
 			}
 		},
 		error: function (data) {
 			swal("", "Oops...!", "error");
 		}
 	});
 }