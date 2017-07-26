$(document).ready(function(){
	$('#addImage').click(function(){
		$('.image-add-wrap').toggleClass('active');
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
		$('input[name=addThisImage]').show();
	});

	$('input[name=addThisImage]').click(function(){
		$.ajax({
			url:		'/admin/gallery/add',
			type:		'POST',
			headers:	{'X-CSRF-TOKEN': $('header').attr('data-token')},
			processData:false,
			contentType:false,
			data:		formData,
			error:		function (jqXHR, textStatus, errorThrown) {
				showErrors(jqXHR.responseText, '/admin/gallery/add')
			},
			success:function(data){
				try{
					data = JSON.parse(data);
					if (data.message == 'success') {
						location = '/admin/gallery';
					}
				}catch(e){
					showErrors(e + data, '/admin/gallery/add')
				}
			}
		});
	})

	$('.photos-main-wrap .drop').click(function(e){
		e.preventDefault();
		var file = $(this).closest('.photo-wrap').find('.image-src span').text()
		var res = confirm('Вы действительно хотите удалить файл '+file+'?');
		var _this = $(this);
		if(res){
			$.ajax({
				url:	'/admin/gallery/drop',
				type:	'DELETE',
				headers:{'X-CSRF-TOKEN': $('header').attr('data-token')},
				data:	{file:file},
				error:	function (jqXHR, textStatus, errorThrown) {
					showErrors(jqXHR.responseText, '/admin/gallery/drop')
				},
				success:function(data){
					try{
						data = JSON.parse(data);
						if (data.message == 'success') {
							_this.closest('.photo-wrap').remove();
						}
					}catch(e){
						showErrors(e + data, '/admin/gallery/add')
					}
				}
			});
		}
	})
});