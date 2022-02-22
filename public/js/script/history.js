$(document).ready(function() {
	filter();
});

/**
 * filter
 */
function filter() {
	$("#search-products").click(function() {
		status = $('input:radio[name=status]:checked').val();
		if (!status) {
    	status = 0;
    }
    if (status == 0) {
    	alert("selecciona almenos un filtro")
    }else{
    	postFilter(status);
    }
	});
}

function postFilter(status){
	console.log(status)
	inputs ="";
	inputs = '<input type="hidden" name="status" value="' + status + '" />'+
	$("body").append('<form action="shopping-history" method="get"  class="filter-status">' +inputs+'</form>');
	$(".filter-status").submit();
}