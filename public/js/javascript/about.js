$(document).ready(function() {
	company();
	faqs();
	clearModalDetail();
});

/**
 * Get Company
 */
function company() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.get('getCompany', function(data) {
		$('.name-company').text(data.data[0].companies[0].company);
		$('.description-company').text(data.data[0].companies[0].description);
		$('.link-terms').html(data.data[0].term_conditions[0].terms_and_conditions);
		$('.link-privacy').html(data.data[0].privacy_policies[0].privacy_policy);
	});
}

/**
 * Get Faqs
 */
function faqs() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.get('getFaqs', function(data) {
		console.log(data);
		var item = "";
		$.each(data.data, function(index, val) {
			console.log(val);
			var id = val.translations[0].pivot.faq_categories_id;
			var category = val.translations[0].pivot.category;
			item = item+'<div class="card">'+
				'<div class="card-header" id="heading'+id+'">'+
					'<h5 class="mb-0">'+
						'<a class="" data-toggle="collapse" data-target="#collapse'+id+'" aria-expanded="true" aria-controls="collapseOne">'+category+'</a>'+
					'</h5>'+
				'</div>'+
				'<div id="collapse'+id+'" class="collapse" aria-labelledby="heading'+id+'" data-parent="#accordion">'+
					'<div class="card-body">';

					$.each(val.faqs, function(a, b) {
						var question = b.translations[0].pivot.question;
						var answer = b.translations[0].pivot.answer;
						item =item+'<h4><b>'+question+'</b></h4>'+
						'<p style="text-align: justify;">'+answer+'</p>';
					});

					item = item+'</div>'+
				'</div>'+
			'</div>';
		});
		$('#accordion').html(item);

	});
}

/**
 * Clean modal when closing
 */
function clearModalDetail() {
	$(".Detail").on('hidden.bs.modal', function () {
		$('.list-faqs').html('');
	});
}