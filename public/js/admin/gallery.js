$(document).ready(function(){
	$('#addImage').click(function(){
		$('.image-add-wrap').toggleClass('active');
	});

	$('input[name=galleryLoad]').click(function(){
		$('input[name=galleryImageLoader]').trigger('click');
	});

	var point = 0;
	$(document).on('change','input[name=galleryImageLoader]',function(){
		point = 0;
		var _this = $(this);
		var count = $(this).prop('files').length;
		for(var i = 0; i<count; i++){
			var reader = new FileReader();
			reader.onload = function(e){
				_this.closest('fieldset').find('.upload-image-preview').append('' +
				'<div class="fl">' +
					'<img src="'+e.target.result+'" alt="">' +
					'<p>'+_this.prop('files')[point]['name']+'</p>' +
				'</div>');
				formData.append('image_'+point, _this.prop('files')[point]);
				point++;
			}
			reader.readAsDataURL($(this).prop('files')[i]);
			$('input[name=addThisImage]').show();
		}
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