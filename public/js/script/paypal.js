




/**
 * Posts a summary.
 * @param    data    The data
 * @param    total   The total
 * @param    envio   The envio
 */
 function postSummary(data, total, envio) {
  address = $('select[name=address-user] option:selected').val();
   // console.log(address);
   if( $('#is_billable').is(':checked') ) {
    is_billable = true;
  }else{
    is_billable = false;
  }
  payment_method_id = 4;
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.post('summary_paypal', {
    address, is_billable, data, payment_method_id, total, envio
  }, function(data, textStatus, xhr) {
    console.log("RESPONSE ORDER WITH PAYPAL" + data);
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
  });
}

/**
 * number With Commas
 *
 * @param      {string}    number  The number
 * @return     {string[]}  { description_of_the_return_value }
 */
 function numberWithCommas(number) {
  var parts = number.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  return parts.join(".");
}