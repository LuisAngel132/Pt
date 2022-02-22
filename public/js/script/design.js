$(document).ready(function() {

	BASE_URL =  $('meta[name="base_url"]').attr('content');
	DESIGNS_GET = '/designs/';
	lang = $('meta[name="language"]').attr('content');

	$(".radio-design").click(function(){
		getDesigns( $(this).val() );
	});

	getTranslations();
	designs = JSON.parse( $("#designs-variable-container").val() )['data'];
	designsTotal = $("#designs-total").val();

	$("#paging-text").html(languageObject[lang].showing + " " +  designsTotal + " " + languageObject[lang].designs);

	// getDesigns();

	$('.image-popup-no-margins').on('click', function(){
		let design = $(this).data('design').designs;
		
		facebook.events.arDesignViewed({
			name: design.nombre,
		});
	})
});

function getTranslations(){
	languageObject = {
		es : {
			showing: 'Mostrando',
			designs: 'diseños'
		},
		en : {
			showing: 'Showing',
			designs: 'designs'
		}
	}
}

/*
function getDesigns(id){
	console.log("GETTING DESIGNS...");
	$.ajaxSetup({
		headers:{
			'Authorization': 'Bearer ',
			'Content-Type': 'application/json',
			'Accept-Language': lang
		},
		dataType: 'json',
	});
	$.ajax({
		url: BASE_URL + DESIGNS_GET + id,
		type: 'GET'
	})
	.done(function(response) {
		console.log("DESIGNS RESPONSE : " + JSON.stringify(response) );
	}).fail(function(error) {
		console.log("designs response error " + JSON.stringify(error) );
	}).always(function() {
		console.log("designs response complete");
	});
}
*/
function getDesigns(id){
	$.get('get_designs', function(data) {
		console.log("DESIGNS: ");
		console.log(data);
	});
}


