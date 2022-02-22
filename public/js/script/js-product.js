$(document).ready(function() {
	//getSize();
  getIdClic();
  changeColorActive();
  changePictureActive();
  showDesign();
  showDesignNews();
  removeGift();

  $('#open-modal').on('hidden.bs.modal', function() {
    $("#myTabContent").html("");
    $(".field-data").html("");

  })

});

/**
 * Removes a gift.
 */
function removeGift() {
  $('img.design-gift').click(function(event) {
    var id = this.id;
    $('#'+id).attr('style',  'display: none; margin-top: -285px;');
    $('#'+id).removeClass('visible');
  });
}

/**
 * Shows the design.
 */
function showDesign() {
  $('.show-design').click(function(event) {
    let id = this.name;
		
		let design = $(this).data('design');

		facebook.events.arDesignViewed({
			name: design.nombre,
    });
    
    if ($('#design-product-'+id).hasClass( "visible" )) {
      $('#design-product-'+id).attr('style',  'display: none; margin-top: -285px;');
      $('#design-product-'+id).removeClass('visible');
    } else {
      $('#design-product-'+id).attr('style',  'margin-top: -285px;');
      $('#design-product-'+id).addClass('visible');
    }
  });
}

/**
 * Shows the design news.
 */
function showDesignNews() {
  $('.show-design-news').click(function(event) {
    let id = this.name;
		
		let design = $(this).data('design');

		facebook.events.arDesignViewed({
			name: design.nombre,
    });
    
    if ($('#design-product-news-'+id).hasClass( "visible" )) {
        $('#design-product-news-'+id).attr('style',  'display: none; margin-top: -285px;');
        $('#design-product-news-'+id).removeClass('visible');
    } else {
        $('#design-product-news-'+id).attr('style',  'margin-top: -285px;');
        $('#design-product-news-'+id).addClass('visible');
    }
  });
}

/**
 * Gets the identifier clic.
 */
function getIdClic() {
  $(".search-detail-product-id").click(function() {
    id =this.name;
    var inputs;
    inputs += '<input type="hidden" name="id" value="' + id + '" />';
    $("body").append('<form action="product-detail" method="get"  class="formul">' +inputs+'</form>');
    $(".formul").submit();
  });
}

/**
 * Change color active.
 */
function changeColorActive() {
  $(".change_colors_active").click(function() {
    id = this.name;
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.post('change_color_active', {
      id: id
    }, function(data, textStatus, xhr) {
      console.log(data);
      img ="";
      img = '<img src="'+data.resources.public_image_url+'">'
      $('.change-picture').html(img)
      $('#product-color-id').val(data.id)
    });
  });
}

/**
 * Change picture active.
 */
function changePictureActive() {
  $(".change-shirt").click(function(event) {
    id = this.name;
    colors = "";
    $.get('product/'+id, function(data) {
      $(".single-product-name").html(data.product_translations[0].name);
      $(".price").html(data.product_translations[0].langs.currency_code+" "+data.product_translations[0].price);
      description = '<p>'+data.product_translations[0].description+'</p>';
      $(".product-info").html(description);
      $.each(data.products_colors, function(index, val) {
        colors += '<li><a class="change_colors_active" name="'+ val.id+'"><span class="color" style="background-color:'+val.colors.hex +'"></span></a></li>';
      });
      $(".procuct-color").html(colors);
      changeColorActive();
    });
    colors ="";
  });
}
