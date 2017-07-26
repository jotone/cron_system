function sendPositions(){
	var positions = [];
	$('.categories-list-wrap li').each(function(){
		positions.push({
			id: $(this).attr('data-id'),
			pos: $(this).index()
		});
	});
	$.ajax({
		url:	'/admin/change_postions',
		type:	'PATCH',
		headers:{'X-CSRF-TOKEN':$('header').attr('data-token')},
		data:	{positions:positions, type:'delivery'},
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
	});
}

$(document).ready(function(){
	$('button[name=save]').click(function(){
		formData.append('id', $('input[name=id]').val());
		formData.append('title', $('input[name=title]').val());
		formData.append('price', $('input[name=price]').val());
		formData.append('terms', $('input[name=terms]').val());
		$.ajax({
			url:		'/admin/delivery_type/add',
			type:		'POST',
			headers:	{'X-CSRF-TOKEN': $('header').attr('data-token')},
			processData:false,
			contentType:false,
			data:		formData,
			error:		function (jqXHR, textStatus, errorThrown) {
				showErrors(jqXHR.responseText, '/admin/delivery_type/add')
			},
			success:function(data){
				try{
					data = JSON.parse(data);
					if (data.message == 'success') {
						location = '/admin/delivery_type';
					}
				}catch(e){
					showErrors(e + data, '/admin/delivery_type/add')
				}
			}
		});
	});

	$('.categories-list-wrap a.drop').click(function(e){
		e.preventDefault();
		var result = confirm('Вы действительно хотите удалить '+$(this).attr('data-title')+'?');
		if(result){
			var id = $(this).closest('li').attr('data-id');
			var _this = $(this);
			$.ajax({
				url:	'/admin/delivery_type/drop',
				type:	'DELETE',
				headers:{'X-CSRF-TOKEN': $('header').attr('data-token')},
				data:	{id:id},
				error:	function (jqXHR, textStatus, errorThrown) {
					showErrors(jqXHR.responseText, '/admin/delivery_type/drop')
				},
				success:function(data){
					try{
						data = JSON.parse(data);
						if (data.message == 'success') {
							_this.closest('li').remove();
						}
					}catch(e){
						showErrors(e + data, '/admin/delivery_type/drop')
					}
				}
			});
		}
	});

	$('.categories-list-wrap ul').sortable({
		update: function(e, ui){
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
});