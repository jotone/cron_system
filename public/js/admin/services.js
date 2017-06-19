$(document).ready(function(){
	buildFixedNavMenu();

	if($('.center-wrap>.item-list').length > 0){
		var getParams = getRequest();
		if(typeof getParams.sort_by == 'undefined'){
			var getParams = {
				sort_by: 'title',
				dir: 'asc'
			}
		}
		$('.center-wrap>.item-list #' + getParams.sort_by + ' .' + getParams.dir).addClass('active');
	}

	$('button[name=save]').click(function(){
		formData.append('id', $('input[name=id]').val());
		formData.append('title', $('input[name=title]').val());
		formData.append('enabled', ($('input[name=enabled]').prop('checked') == true)? 1: 0);
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
		formData.append('text', CKEDITOR.instances.text.getData());
		$.ajax({
			url:		'/admin/services/add',
			type:		'POST',
			headers:	{'X-CSRF-TOKEN': $('header').attr('data-token')},
			processData:false,
			contentType:false,
			data:	formData,
			error:	function (jqXHR, textStatus, errorThrown) {
				showErrors(jqXHR.responseText, '/admin/services/add')
			},
			success:function(data){
				try{
					data = JSON.parse(data);
					if(data.message == 'success'){
						location = '/admin/services';
					}
				}catch(e){
					showErrors(e + data, '/admin/services/add')
				}
			}
		});
	});

	$('.item-list a.drop').click(function(e){
		e.preventDefault();
		var result = confirm('Вы действительно хотите удалить услугу '+$(this).attr('data-title')+'?');
		if(result){
			var id = $(this).attr('data-id');
			var _this = $(this);
			$.ajax({
				url:	'/admin/services/drop',
				type:	'DELETE',
				headers:{'X-CSRF-TOKEN': $('header').attr('data-token')},
				data:	{id:id},
				error:		function (jqXHR, textStatus, errorThrown) {
					showErrors(jqXHR.responseText, '/admin/services/drop')
				},
				success:function(data){
					try{
						data = JSON.parse(data);
						if (data.message == 'success') {
							_this.closest('tr').remove();
						}
					}catch(e){
						showErrors(e + data, '/admin/services/drop')
					}
				}
			});
		}
	});

	$('.item-list input[name=enabled]').change(function(){
		var id = $(this).attr('data-id');
		var enabled = ($(this).prop('checked') == true)? 1: 0;
		var type = 'services';
		var _this = $(this);
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
						_this.closest('td').find('.row-wrap').text(data.published);
					}
				}catch(e){
					showErrors(e+data, '/admin/change_enabled');
				}
			}
		});
	});
});