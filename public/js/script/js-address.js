$(document).ready(function() {
  deleteAddress();
  $('[data-toggle="tooltip"]').tooltip();
  $('#v-pills-tab a').on('click', function (e) {
    e.preventDefault()
    $(this).tab('show')
  })

});

/**
 * Gets the address type.
 */


/**
 * Gets the address.
 */




/**
 * Gets the form.
 *
 * @param    val     The value
 */


/**
 * delete Address
 */
function deleteAddress() {
  $("#delete-address").click(function() {
    swal({
      title: "Delete?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Delete!",
      cancelButtonText: "Cancel!",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
      if (isConfirm) {
        id = $("#addres_id").val();
        inputs = '<input type="hidden" name="id" value="' + id + '" />';
        $("body").append('<form action="address/delete" method="get"  class="address-delete">' +inputs+'</form>');
        $(".address-delete").submit();
      } else {
        swal("Cancel", "", "error");
      }
    });

  });
}