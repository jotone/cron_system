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
		var social = [];
		$('#socList input[name=socLink]').each(function(){
			social.push({
				type: $(this).attr('data-soc'),
				val: $(this).val(),
				pos: $(this).closest('.row-wrap').index()
			});
		});
		formData.append('phone', $('input[name=phone]').val());
		formData.append('email', $('input[name=email]').val());
		formData.append('address', CKEDITOR.instances.address.getData());
		formData.append('work_time', CKEDITOR.instances.work_time.getData());
		formData.append('social', JSON.stringify(social));
		if($('.upload-image-preview img').length > 0){
			if($('.upload-image-preview img').attr('data-type') == 'upload'){
				formData.append('image_type', 'upload');
			}else{
				formData.append('image', $('.upload-image-preview img').attr('src'));
				formData.append('image_type', 'file');
			}
		}else{
			formData.append('image', '');
			formData.append('image_type', 'file');
		}
		formData.append('marker_coordinates', JSON.stringify({
			x:	$('input[name=x]').val(),
			y:	$('input[name=y]').val()
		}));
		$.ajax({
			url:		'/admin/info',
			type:		'POST',
			headers:	{'X-CSRF-TOKEN': $('header').attr('data-token')},
			processData:false,
			contentType:false,
			data:		formData,
			error:		function (jqXHR, textStatus, errorThrown) {
				showErrors(jqXHR.responseText, '/admin/info')
			},
			success:	function(data) {
				try{
					data = JSON.parse(data);
					if(data.message == 'success'){
						alert('Данные успешно изменены.');
					}
				}catch(e){
					showErrors(e + data, '/admin/info')
				}
			}
		});
	})
});