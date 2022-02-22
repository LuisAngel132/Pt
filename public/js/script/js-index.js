$(document).ready(function() {
	console.log( $('meta[name="base_url"]').attr('content') );
//	getCart();

});

/**
 * Gets the cartesian.
 */
 function getCart() {
 	$.get('get_cart', function(data) {
 		$(".item-total").html(data)
 	});
 }

