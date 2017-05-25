$(document).ready(function(){
	if($('.center-wrap>.item-list').length > 0){
		var getParams = getRequest();
		if(typeof getParams.sort_by == 'undefined'){
			var getParams = {
				sort_by: 'title',
				dir: 'asc'
			}
		}
		$('.center-wrap>.item-list #'+getParams.sort_by + ' .'+getParams.dir).addClass('active');
	}

	buildFixedNavMenu();

	$('button[name=save]').click(function(){
		var pages =[];
		$('.chbox-selector-wrap input[name=page]:checked').each(function(){
			pages.push($(this).val());
		});
		formData.append('id', $('input[name=id]').val());
		formData.append('title', $('input[name=title]').val());
		formData.append('pseudonim', $('input[name=pseudonim]').val());
		formData.append('pages', JSON.stringify(pages));
		$.ajax({
			url:		'/admin/users/roles/add',
			type:		'POST',
			headers:	{'X-CSRF-TOKEN': $('header').attr('data-token')},
			processData:false,
			contentType:false,
			data: formData,
			error:		function (jqXHR, textStatus, errorThrown) {
				showErrors(jqXHR.responseText, '/admin/users/roles/add')
			},
			success:	function(data){
				try{
					data = JSON.parse(data);
					if (data['message'] == 'success') {
						location = '/admin/users/roles';
					}
				}catch(e){
					showErrors(e + data, '/admin/users/roles/add')
				}
			}
		})
	});

	$('.item-list a.drop').click(function(e){
		e.preventDefault();
		var users = $(this).closest('tr').find('td[data-name=users]').text();
		if(users.length > 0){
			users += ' Права пользователей '+users+' будут удалены.';
		}
		var result = confirm('Вы действительно хотите удалить роль '+$(this).attr('data-title')+'?'+users);
		if(result){
			var id = $(this).closest('tr').attr('data-id');
			var _this = $(this);
			$.ajax({
				url:	'/admin/users/roles/drop',
				type:	'DELETE',
				headers:{'X-CSRF-TOKEN': $('header').attr('data-token')},
				data:	{id:id},
                error:		function (jqXHR, textStatus, errorThrown) {
                    showErrors(jqXHR.responseText, '/admin/users/roles/drop')
                },
				success:function(data){
					try{
						data = JSON.parse(data);
						if (data['message'] == 'success') {
							_this.closest('tr').remove();
						}
					}catch(e){
						showErrors(e + data, '/admin/users/roles/drop')
					}
				}
			});
		}
	});
});