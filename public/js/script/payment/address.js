$(document).ready(function() {
	$(".nice-select").hide();
	$("#country").show();
	$("#countrys").show();
	$("#address-select").show();
	$("#address-type").show();
	$("#type_payment").show();
	//getAddressType();
	// getAddress();
	newAddress();
});

/**
 * Gets the address type.
 */
 function getAddressType() {
 	$.get('checkout_address_type', function(data) {
 		var select = '';
 		$.each(data, function(index, val) {
 			select += '<option value="'+val.address_types_id+'" >' + val.type+ '</option>';
 			$("#address-select").html(select);
 		});
 	});
 }

/**
 * Gets the address.
 */
 function getAddress() {
 	var select = '';
 	$.get('checkout_address', function(data) {
 		console.log( "checkout address " + JSON.stringify(data) );
 		if (data.length >0) {
 			$.each(data, function(index, val) {
 				select += '<option value="'+val.id+'" >' + val.address_types.address_type_translations[0].type+ '</option>';
 				if (index==0) {
 					formAddressShow(val);
 				}
 			});
 			$("#address-type").html(select);
 			$(".show-address").show();
 			$(".not-address").hide();
 		} else{
 			$(".show-address").hide();
 			$(".not-address").show();
 			setTimeout(function(){
 			 	 $(".not-address").hide(2000);
 			}, 3000);
 		}
 		$("#address-type").change(function() {
 			id = $(this).val();
 			$.each(data, function(index, val) {
 				if (val.addresses_id == id) {
 					formAddressShow(val);
 				}
 			});
 		});
	});//end get
 }

/**
 * form Address Show
 *
 * @param   val     The value
 */


 function newAddress() {
 	/*
 	$("#save-address").click(function(event) {
 		var formData = new FormData($("#form-new-address")[0]);
 		postOrderNewAddress(formData);
 	});
 	*/
 }


/**
 * Posts an order new address.
 *
 * @param      object formData  The form data
 */
 function postOrderNewAddress(formData) {
 	$.ajaxSetup({
 		headers: {
 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 		}
 	});
 	$.ajax({
 		url: 'new_address_order',
 		type: 'POST',
 		data:formData,
 		cache: false,
 		contentType: false,
 		processData: false,
 		beforeSend: function(){
 		},
 		success: function(data){
	   	//console.log(data);
	   	if (data.status == "success") {
	   		swal("", data.message, data.status);
	   		Location.reload();
	   	}else{
	   		swal("", data.message, data.status);
	   	}
	   },
	   error: function(data){
	   	sweetAlert("Oops... ", "", "error");
	   }
	});
 }