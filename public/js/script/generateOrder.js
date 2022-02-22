$(document).ready(function() {
  /*
  $("#generate-order").click(function() {
    address = $('select[name=address-user] option:selected').val();
    summary(address);
  });
  */
});



/**
 * summary
 *
 * @param      string address The address
 */
 function summary(address) {
	// -- Obtener variables -- //
	alert = $("input[name=alert_select_type_payment]").val();
	alertDescription = $("input[name=alert_description]").val();
	detail = $("textarea[name=descriptions]").val();
	payment_method = $('select[id=type_payment] option:selected').val();
	//-------------------------//
	// -- Habilitar o desabilitar la facturacion -- //
	if( $('#is_billable').is(':checked') ) {
		is_billable = true;
	}else{
		is_billable = false;
	}
	//----------------------------------------------//

	if (payment_method != 2 && payment_method != 1 &&  payment_method != 3 )  {
        //-- Alerta cuando no se ha seleccionado ningun método de pago --//
        swal("", alert, "warning");
      } else if (detail.trim() === '') {
       //-- Alerta cuando no se a agregado la referencia de la dirección --//
       swal("", alertDescription, "warning");
       $("textarea[name=descriptions]").addClass('has-error');
     } else {
        //-- Se ejecuta este if si selecciono tienda como método de pago --//
        if (payment_method == 3) {

          createStoreOrder( address, payment_method, detail, is_billable );
        //	postSummaryStore(address, payment_method, detail, is_billable);
        //-- Se ejecuta este if else si el metodo de pago selecionado es tarjeta  --//
      } else if (payment_method == 2 || payment_method == 1) {
       if( $("input[name=card]:radio").is(':checked')) {
        card = $('input:radio[name=card]:checked').val();
        deviceSessionId = $('input[name=device_session_id]').val();
        console.log(deviceSessionId);
        postSummaryCard(address, payment_method, detail, is_billable, card, deviceSessionId);
      } else{
        swal("", "Selecciona una tarjeta", "warning");
      }
    }
  }
}








/**
 * Posts a summary.
 *
 * @param      {string}   address         The address
 * @param      {string}   payment_method  The payment method
 * @param      {string}   detail          The detail
 * @param      {boolean}  is_billable     Indicates if billable
 */
 function postSummaryStore(address, payment_method, detail, is_billable) {
 	$.ajaxSetup({
 		headers: {
 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 		}
 	});
 	$.post(
 		'summary', 
 		{ address, payment_method, detail, is_billable}
 		, function(data, textStatus, xhr) {
 			console.log( JSON.stringify(data) );
 			if (data.status == "success") {
 				var id = data.order;
 				var inputs;
 				inputs += '<input type="hidden" name="id" value="' + id + '" />';
 				$("body").append('<form action="getDetail" method="get"  class="formul">' +inputs+'</form>');
 				$(".formul").submit();
 				swal("", data.message, data.status);
 			} else {
 				swal("", data.message, data.status);
 			}
 		});
 }

 function postSummaryCard(address, payment_method, detail, is_billable, card, deviceSessionId){
 	$.ajaxSetup({
 		headers: {
 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 		}
 	});
 	$.post(
 		'summary_card', 
 		{address, payment_method, detail, is_billable, card, deviceSessionId
 		}, function(data, textStatus, xhr) {
 			console.log( JSON.stringify(data) );
 			if (textStatus== "success") {
 				console.log(data);
 				if (data.status == "success") {
 					var id = data.order;
 					var inputs;
 					inputs += '<input type="hidden" name="id" value="' + id + '" />';
 					$("body").append('<form action="getDetail" method="get"  class="formul">' +inputs+'</form>');
 					$(".formul").submit();
 					swal("", data.message, data.status);
 				}else{
 					swal("", data.message, data.status);
 				}
 			}else{
 				swal("", "Error", "error");
 			}
 		});
 }