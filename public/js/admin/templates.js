$(document).ready(function(){
	$('button[name=saveMenu]').click(function(){
		formData.append('id', $('input[name=id]').val());
		formData.append('title', $('input[name=title]').val());
		formData.append('slug', $('input[name=slug]').val());
		formData.append('content', $('textarea[name=content]').val());

		$.ajax({
			url:		'/admin/templates/add',
			type:		'POST',
			headers:	{'X-CSRF-TOKEN': $('header').attr('data-token')},
			processData:false,
			contentType:false,
			data:		formData,
			error:		function (jqXHR, textStatus, errorThrown) {
				showErrors(jqXHR.responseText, '/admin/templates/add')
			},
			success:function(data){
				try{
					data = JSON.parse(data);
					if(data.message == 'success'){
						location = '/admin/templates';
					}
				}catch(e){
					showErrors(e + data, '/admin/templates/add')
				}
			}
		});
	});

	$('.item-list a.drop').click(function(e){
		e.preventDefault();
		var result = confirm('Вы действительно хотите удалить шаблон '+$(this).attr('data-title')+'?');
		if(result){
			var id = $(this).attr('data-id');
			var _this = $(this);
			$.ajax({
				url:	'/admin/templates/drop',
				type:	'DELETE',
				headers:{'X-CSRF-TOKEN': $('header').attr('data-token')},
				data:	{id:id},
				error:	function (jqXHR, textStatus, errorThrown) {
					showErrors(jqXHR.responseText, '/admin/templates/drop')
				},
				success:function(data){
					try{
						data = JSON.parse(data);
						if (data.message == 'success') {
							_this.closest('tr').remove();
						}
					}catch(e){
						showErrors(e + data, '/admin/templates/drop')
					}
				}
			});
		}
	});
});