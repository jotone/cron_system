$(document).ready(function(){
	buildFixedNavMenu();

	$('button[name=moreSocial]').click(function(){
		var title = $(this).closest('fieldset').find('ul.pseudo-selector li.active span').text();
		var type = $(this).closest('fieldset').find('ul.pseudo-selector li.active').attr('data-soc');
		$('#socList').append('<div class="row-wrap col_1_2" style="display: flex; align-items: center">' +
			'<span style="width: 110px; padding-right: 10px;" class="tar">'+title+':</span>'+
			'<input name="socLink" type="text" class="text-input col_4_5" placeholder="Ссылка&hellip;" data-soc="'+type+'">'+
			'<span class="drop-add-field">×</span>'+
		'</div>');
	});

	$(document).find('.pseudo-selector').on('click','li',function(e){
		e.stopPropagation();
		if($(this).hasClass('active')){
			$(this).closest('ul').find('li').css({'display':'flex'})
		}else{
			$(this).closest('ul').find('li').removeClass('active').css({'display':'none'});
			$(this).addClass('active').css({'display':'flex'});
		}
		$(document).click(function(){
			$(document).find('.pseudo-selector li:not(.active)').css({'display':'none'});
		});
	});

	$(document).find('#socList').on('click', '.drop-add-field', function(){
		$(this).closest('.row-wrap').remove();
	});

	$('input[name=galleryLoad]').click(function(){
		$('input[name=galleryImageLoader]').trigger('click');
	});

	$(document).on('change','input[name=galleryImageLoader]',function(){
		var reader = new FileReader();
		var _this = $(this);
		reader.onload = function(e){
			_this.closest('fieldset').find('.upload-image-preview').empty().append('<img src="'+e.target.result+'" alt="">');
			formData.append('image', _this.prop('files')[0]);
		};
		reader.readAsDataURL(_this.prop('files')[0]);
	});

	$('button[name=save]').click(function(){
	    formData.append('phone', $('input[name=phone]').val());
    })
});