$(document).ready(function(){
	if($('.center-wrap>.item-list').length > 0){
		var getParams = getRequest();
		if(typeof getParams.sort_by == 'undefined'){
			var getParams = {
				sort_by: 'email',
				dir: 'asc'
			}
		}
		$('.center-wrap>.item-list #' + getParams.sort_by + ' .' + getParams.dir).addClass('active');
	}

	buildFixedNavMenu();

	$('button[name=save]').click(function(){
		formData.append('id', $('input[name=id]').val());
		formData.append('email', $('input[name=email]').val());
		formData.append('name', $('input[name=name]').val());
		formData.append('phone', $('input[name=phone]').val());
		formData.append('org_caption', $('input[name=org_caption]').val());
		formData.append('org_tid', $('input[name=org_tid]').val());
		formData.append('address', $('input[name=address]').val());
		formData.append('correspondence', $('input[name=correspondence]').val());
		if($('input[name=activated]').length > 0){
			formData.append('activated', ($('input[name=activated]').prop('checked') == true)? 1: 0);
		}
		formData.append('role', $('select[name=role]').val());
		formData.append('password', $('input[name=password]').val());
		formData.append('confirm_password', $('input[name=confirm_password]').val());
		$.ajax({
			url:		'/admin/users/edit',
			type:		'POST',
			headers:	{'X-CSRF-TOKEN': $('header').attr('data-token')},
			processData:false,
			contentType:false,
			data:		formData,
			error:		function (jqXHR, textStatus, errorThrown) {
				showErrors(jqXHR.responseText, '/admin/users/edit')
			},
			success:	function(data){
				try{
					data = JSON.parse(data);
					if (data['message'] == 'success') {
						location = '/admin/users';
					}else if(data['message'] == 'error'){
						alert(data['text']);
					}
				}catch(e){
					showErrors(e + data, '/admin/users/edit')
				}
			}
		});
	});

	$('.item-list a.drop').click(function(e){
		e.preventDefault();
		var result = confirm('Вы действительно хотите удалить пользователя '+$(this).attr('data-title')+'?');
		if(result){
			var id = $(this).closest('tr').attr('data-id');
			var _this = $(this);
			$.ajax({
				url:	'/admin/users/drop',
				type:	'DELETE',
				headers:{'X-CSRF-TOKEN': $('header').attr('data-token')},
				data:	{id:id},
				error:		function (jqXHR, textStatus, errorThrown) {
					showErrors(jqXHR.responseText, '/admin/users/drop')
				},
				success:function(data){
					try{
						data = JSON.parse(data);
						if (data['message'] == 'success') {
							_this.closest('tr').remove();
						}
					}catch(e){
						showErrors(e + data, '/admin/users/drop')
					}
				}
			});
		}
	});
});