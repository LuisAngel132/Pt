$(document).ready(function() {
	clickSaveAddress();
});

function clickSaveAddress() {
	$("#save-address").click(function() {
		var formData = new FormData($("#form-new-address")[0]);
		    postOrderNewAddress(formData);
	});
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

	  		swal("", "success", data.status);
	  		  location.reload();
			}else{
				swal("", data.message, data.status);
			}
    },
    error: function(data){
			sweetAlert("Oops... ", "", "error");
    }
 	});
}

