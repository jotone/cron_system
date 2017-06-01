function sendPositions(){
	var positions = [];
	$('.categories-list-wrap li').each(function(){
		positions.push({
			id: $(this).attr('data-id'),
			pos: $(this).index()
		});
	});
	/*$.ajax({
		url:	'/admin/change_postions',
		type:	'PATCH',
		headers:{'X-CSRF-TOKEN':$('header').attr('data-token')},
		data:	{positions:positions, type:'brands'},
		error:	function(jqXHR, textStatus, errorThrown){
			showErrors(jqXHR.responseText, '/admin/change_postions');
		},
		success:function(data){
			try{
				data = JSON.parse(data);
				if(data.message != 'success'){
					showErrors(data, '/admin/change_postions');
				}
			}catch(e){
				showErrors(e+data, '/admin/change_postions');
			}
		}
	});*/
}

$(document).ready(function(){
	autoSlug();
	buildFixedNavMenu();

	$('button[name=save]').click(function(){
		formData.append('id', $('input[name=id]').val());
		formData.append('title', $('input[name=title]').val());
		formData.append('slug', $('input[name=slug]').val());
		formData.append('enabled', ($('input[name=enabled]').prop('checked') == true)? 1: 0);
		formData.append('refer_to', $('select[name=refer_to]').val());
		if($('.upload-image-preview img').length > 0){
			if($('.upload-image-preview img').attr('data-type') == 'upload'){
				formData.append('image_alt', $('input[name=imageAlt]').val());
				formData.append('image_type', 'upload');
			}else{
				formData.append('image', $('.upload-image-preview img').attr('src'));
				formData.append('image_alt', $('input[name=imageAlt]').val());
				formData.append('image_type', 'file');
			}
		}else{
			formData.append('image', '');
			formData.append('image_alt', '');
			formData.append('image_type', 'file');
		}
		$.ajax({
			url:		'/admin/brands/add',
			type:		'POST',
			headers:	{'X-CSRF-TOKEN': $('header').attr('data-token')},
			processData:false,
			contentType:false,
			data:	formData,
			error:	function (jqXHR, textStatus, errorThrown) {
				showErrors(jqXHR.responseText, '/admin/brands/add')
			},
			success:function(data){
				try{
					data = JSON.parse(data);
					if (data.message == 'success') {
						location = '/admin/brands';
					}
				}catch(e){
					showErrors(e + data, '/admin/brands/add')
				}
			}
		});
	});

	$('.categories-list-wrap a.drop').click(function(e){
		e.preventDefault();
		var result = confirm('Вы действительно хотите удалить брэнд '+$(this).attr('data-title')+'?');
		if(result){
			var id = $(this).closest('li').attr('data-id');
			$.ajax({
				url:	'/admin/brands/drop',
				type:	'DELETE',
				headers:{'X-CSRF-TOKEN': $('header').attr('data-token')},
				data:	{id:id},
				error:		function (jqXHR, textStatus, errorThrown) {
					showErrors(jqXHR.responseText, '/admin/brands/drop')
				},
				success:function(data){
					try{
						data = JSON.parse(data);
						if (data.message == 'success') {
							location.reload(true);
						}
					}catch(e){
						showErrors(e + data, '/admin/brands/drop')
					}
				}
			});
		}
	});

	$('.categories-list-wrap ul').sortable({
		connectWith: ['.categories-list-wrap .empty'],
		over: function(e, ui){
			$(this).find('ul.empty').show();
		},
		stop: function(e, ui){
			$('.categories-list-wrap ul.empty').hide();
		},
		update: function(e, ui){
			$(this).closest('ul.empty').removeClass('empty');
			sendPositions();
		}
	});

	$('.categories-list-wrap ul .sort-controls').on('click', 'p', function(){
		var direction = $(this).attr('data-direction');
		if(direction == 'up'){
			if($(this).closest('li').prev().length > 0){
				var el = $(this).closest('li').prev();
				$(this).closest('li').after(el);
			}
		}else{
			if($(this).closest('li').next().length > 0){
				var el = $(this).closest('li').next();
				$(this).closest('li').before(el);
			}
		}
		sendPositions();
	});

	$('.category-controls .trigger_off, .category-controls .trigger_on').on('click', function(e){
		e.preventDefault();
		var _this = $(this);
		var enabled = ($(this).hasClass('trigger_on'))? 0: 1;
		var type = 'brands';
		var id = $(this).closest('li').attr('data-id');
		$.ajax({
			url:	'/admin/change_enabled',
			type:	'PATCH',
			headers:{'X-CSRF-TOKEN':$('header').attr('data-token')},
			data:	{type: type, val:enabled, id:id},
			error:	function(jqXHR, textStatus, errorThrown){
				showErrors(jqXHR.responseText, '/admin/change_enabled');
			},
			success:function(data){
				try{
					data = JSON.parse(data);
					if(data.message == 'success'){
						if(enabled == 0){
							_this.removeClass('trigger_on').addClass('trigger_off').text('off');
						}else{
							_this.removeClass('trigger_off').addClass('trigger_on').text('on');
						}
					}
				}catch(e){
					showErrors(e+data, '/admin/change_enabled');
				}
			}
		});
	});
});