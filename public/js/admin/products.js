$(document).ready(function(){
	autoSlug();
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

	$('.rating-wrap img').click(function(){
		var pos = parseInt($(this).attr('alt'));
		$('.rating-wrap img').removeClass('active');
		$('.rating-wrap img').each(function(){
			if($(this).closest('label').index() < pos){
				$(this).addClass('active');
			}
		})
	});

	$('button[name=save]').click(function(){
		formData.append('id', $('input[name=id]').val());
		formData.append('title', $('input[name=title]').val());
		formData.append('slug', $('input[name=slug]').val());
		formData.append('enabled', ($('input[name=enabled]').prop('checked') == true)? 1: 0);
		formData.append('brand', $('select[name=brand]').val());
		formData.append('category', $('select[name=category]').val());
		formData.append('old_price', $('input[name=old_price]').val());
		formData.append('price', $('input[name=price]').val());
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
		formData.append('rating', $('input[name=rating]:checked').val());
		formData.append('is_hot', $('select[name=is_hot]').val());
		formData.append('show_on_main', ($('input[name=show_on_main]').prop('checked') == true)? 1: 0);
		$.ajax({
			url:		'/admin/products/add',
			type:		'POST',
			headers:	{'X-CSRF-TOKEN': $('header').attr('data-token')},
			processData:false,
			contentType:false,
			data:		formData,
			error:		function (jqXHR, textStatus, errorThrown) {
				showErrors(jqXHR.responseText, '/admin/products/add')
			},
			success:function(data){
				try{
					data = JSON.parse(data);
					if(data.message == 'success'){
						location = '/admin/products';
					}
				}catch(e){
					showErrors(e + data, '/admin/products/add')
				}
			}
		});
	});

	$('.item-list a.drop').click(function(e){
		e.preventDefault();
		var result = confirm('Вы действительно хотите удалить товар '+$(this).attr('data-title')+'?');
		if(result){
			var id = $(this).attr('data-id');
			var _this = $(this);
			$.ajax({
				url:	'/admin/products/drop',
				type:	'DELETE',
				headers:{'X-CSRF-TOKEN': $('header').attr('data-token')},
				data:	{id:id},
				error:	function (jqXHR, textStatus, errorThrown) {
					showErrors(jqXHR.responseText, '/admin/products/drop')
				},
				success:function(data){
					try{
						data = JSON.parse(data);
						if (data.message == 'success') {
							_this.closest('tr').remove();
						}
					}catch(e){
						showErrors(e + data, '/admin/products/drop')
					}
				}
			});
		}
	});

	$('.item-list input[name=enabled]').change(function(){
		var id = $(this).attr('data-id');
		var enabled = ($(this).prop('checked') == true)? 1: 0;
		var type = 'products';
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