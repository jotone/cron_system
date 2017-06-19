function seoToggle() {
	if($('input[name=need_seo]').prop('checked') == true){
		$('fieldset #seo').show();
	}else{
		$('fieldset #seo').hide();
	}
}

function getTemplateData(){
	$.ajax({
		url:'/admin/get_template',
		type:'GET',
		data:{id:$('select[name=templateType]').val()},
		error:	function (jqXHR, textStatus, errorThrown) {
			showErrors(jqXHR.responseText, '/admin/get_template')
		},
		success:function(data){
			try{
				data = JSON.parse(data);
				if(data.message == 'success'){
					$('#contentData').empty().append(data.content);
					$('#contentData').find('.needCKE').each(function(){
						CKEDITOR.replace($(this).attr('name'));
					});
				}
				if($(document).find('#newsContainer').length > 0){
					$.ajax({
						url:	'/admin/get_latest_news',
						type:	'GET',
						error:	function (jqXHR, textStatus, errorThrown) {
							showErrors(jqXHR.responseText, '/admin/get_latest_news')
						},
						success:function(data){
							try{
								data = JSON.parse(data);
								var containerContent = '';
								for(var i in data){
									containerContent += '<li ';
									if(i == 0){
										containerContent += 'class="active" ';
									}
									containerContent += 'data-id="'+data[i]['id']+'">';
									if(data[i]['img_url']['img'].length > 0){
										containerContent += '<img src="'+data[i]['img_url']['img']+'" alt="">';
									}
									containerContent += '<span>'+data[i]['title']+'</span></li>';
								}
								$(document).find('.pseudo-selector').empty().append(containerContent);
								pseudoSelectorControls();
							}catch(e){
								showErrors(e + data, '/admin/get_latest_news')
							}
						}
					});
				}

				if($('input[name=id]').val().length > 0){
					$.ajax({
						url:	'/admin/get_page_content',
						type:	'GET',
						data:	{id:$('input[name=id]').val()},
						error:	function (jqXHR, textStatus, errorThrown) {
							showErrors(jqXHR.responseText, '/admin/get_page_content')
						},
						success:function(data){
							try {
								data = JSON.parse(data);
								for(var fieldsetName in data){
									var _thisValue = data[fieldsetName].value;
									switch(data[fieldsetName].type){
										case 'block':
											for(var elemName in _thisValue){
												switch(_thisValue[elemName].type){
													case 'single-image':
														$(document).find('fieldset[data-name='+fieldsetName+']').find('.upload-image-preview').append('' +
															'<img src="'+_thisValue[elemName].value.img+'" alt="'+_thisValue[elemName].value.alt+'" data-type="file">'+
															'<input name="imageAlt" type="text" class="text-input col_1" placeholder="alt&hellip;" value="'+_thisValue[elemName].value.alt+'">');
													break;

													case 'string':
														$(document).find('fieldset[data-name='+fieldsetName+']').find('input[name='+elemName+']').val(_thisValue[elemName].value);
													break;

													case 'text':
														CKEDITOR.instances[elemName].setData(_thisValue[elemName].value);
													break;
												}
											}
										break;

										case 'drop_down':
											$(document).find('fieldset[data-name='+fieldsetName+'] #newsContainer').empty();
											for(var id in _thisValue.value){
												var caption = $(document).find('fieldset[data-name='+fieldsetName+']').find('li[data-id='+_thisValue.value[id]+'] span').text();
												$(document).find('fieldset[data-name='+fieldsetName+'] #newsContainer').append('<div class="row-wrap col_1_2" style="display: flex; align-items: center" data-id="'+_thisValue.value[id]+'">' +
													'<span style="width: 110px; padding-right: 10px;" class="tar">'+caption+'</span>' +
													'<span class="drop-add-field">×</span>' +
												'</div>');
											}
										break;

										case 'single-image':
											$(document).find('fieldset[data-name='+fieldsetName+']').find('.upload-image-preview').append('' +
												'<img src="'+_thisValue.value.img+'" alt="'+_thisValue.value.alt+'" data-type="file">'+
												'<input name="imageAlt" type="text" class="text-input col_1" placeholder="alt&hellip;" value="'+_thisValue.value.alt+'">');
										break;

										case 'slider':
											$(document).find('fieldset[data-name='+fieldsetName+'] .slider-images-wrap').empty();
											$(document).find('fieldset[data-name='+fieldsetName+'] .slider-list-wrap').empty();
											for(var image in _thisValue.value){
												$(document).find('fieldset[data-name='+fieldsetName+'] .slider-images-wrap').append('' +
													'<div class="image-wrap" data-position="'+image+'">' +
														'<img src="'+_thisValue.value[image]['img']+'" alt="">' +
														'<div class="attributes-wrap">' +
															'<input name="altText" type="text" class="text-input" placeholder="Альтернативный текст&hellip;" style="width: 90%;" value="'+_thisValue.value[image]['alt']+'">' +
															'<a href="#" class="drop-image button" title="Удалить">' +
																'<img src="/images/drop.png" alt="">' +
															'</a>' +
														'</div>' +
													'</div>');

												$(document).find('fieldset[data-name='+fieldsetName+'] .slider-list-wrap').append('' +
													'<div class="slider-content-element" data-position="'+image+'">' +
														'<div class="element-title">'+_thisValue.value[image]['img']+'</div>' +
														'<div class="element-size"></div>' +
														'<div class="element-image">' +
															'<img src="'+_thisValue.value[image]['img']+'" alt="">' +
														'</div>' +
														'<div class="element-alt">'+_thisValue.value[image]['alt']+'</div>' +
														'<div class="element-drop">' +
															'<img src="/images/drop.png" alt="Удалить" title="Удалить">' +
														'</div>' +
													'</div>');
											}
											$(document).find('fieldset[data-name='+fieldsetName+'] .slider-images-wrap .image-wrap:first').addClass('active');
										break;

										case 'text':
											CKEDITOR.instances[fieldsetName].setData(_thisValue.value);
										break;
									}

								}
							}catch(e){
								showErrors(e + data, '/admin/get_page_content')
							}
						}
					});
				}
			}catch(e){
				showErrors(e + data, '/admin/get_template')
			}
		}
	});
}
function pseudoSelectorControls(){
	$(document).find('.pseudo-selector').off('click','li');
	$(document).off('click','button[name=moreNews]');
	$(document).find('#newsContainer').off('click', '.drop-add-field');

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

	$(document).on('click','button[name=moreNews]',function(){
		var title = $(this).closest('fieldset').find('ul.pseudo-selector li.active span').text();
		var id = $(this).closest('fieldset').find('ul.pseudo-selector li.active').attr('data-id');
		if($('#newsContainer .row-wrap').length <= 2){
			$('#newsContainer').append('<div class="row-wrap col_1_2" style="display: flex; align-items: center" data-id="'+id+'">' +
				'<span style="width: 110px; padding-right: 10px;" class="tar">'+title+'</span>'+
				'<span class="drop-add-field">×</span>'+
			'</div>');
		}
	});

	$(document).find('#newsContainer').on('click', '.drop-add-field', function(){
		$(this).closest('.row-wrap').remove();
	});
}
$(document).ready(function(){
	buildFixedNavMenu();
	seoToggle();
	$('input[name=need_seo]').change(function(){
		seoToggle();
	});

	if($('select[name=templateType]').length > 0){
		getTemplateData();
		$('select[name=templateType]').change(function () {
			getTemplateData();
		});
	}
	pseudoSelectorControls();

	$('button[name=save]').click(function(){
		formData.append('id', $('input[name=id]').val());
		formData.append('title', $('input[name=title]').val());
		formData.append('link', $('input[name=link]').val());
		formData.append('meta_title', $('input[name=metaTitle]').val());
		formData.append('meta_keywords', $('textarea[name=metaKeywords]').val());
		formData.append('meta_description', $('textarea[name=metaDescription]').val());
		formData.append('need_seo', ($('input[name=need_seo]').prop('checked') == true)? 1: 0);
		formData.append('seo_title', $('input[name=seo_title]').val());
		formData.append('seo_text', CKEDITOR.instances.seo_text.getData());
		formData.append('used_template', $('select[name=templateType]').val());

		var temp = [];
		$(document).find('#contentData fieldset').each(function(){
			switch($(this).attr('data-type')){
				case 'block':
					var inner_temp = [];
					$(this).children('.row-wrap').each(function(){
						switch($(this).attr('data-type')){
							case 'string':
								inner_temp.push({
									type:	$(this).attr('data-type'),
									field:	$(this).find('input[type=text]').attr('name'),
									value:	$(this).find('input[type=text]').val()
								});
							break;
							case 'single-image':
								inner_temp.push({
									type:	$(this).attr('data-type'),
									name:	$(this).closest('fieldset').attr('data-name')
								});
								if($(this).find('.upload-image-preview img').length > 0){
									if($(this).find('.upload-image-preview img').attr('data-type') == 'upload'){
										formData.append('image_alt'+$(this).closest('fieldset').attr('data-name'), $(this).find('input[name=imageAlt]').val());
										formData.append('image_type'+$(this).closest('fieldset').attr('data-name'), 'upload');
									}else{
										formData.append('image'+$(this).closest('fieldset').attr('data-name'), $(this).find('.upload-image-preview img').attr('src'));
										formData.append('image_alt'+$(this).closest('fieldset').attr('data-name'), $(this).find('input[name=imageAlt]').val());
										formData.append('image_type'+$(this).closest('fieldset').attr('data-name'), 'file');
									}
								}else{
									formData.append('image'+$(this).closest('fieldset').attr('data-name'), '');
									formData.append('image_alt'+$(this).closest('fieldset').attr('data-name'), '');
									formData.append('image_type'+$(this).closest('fieldset').attr('data-name'), 'file');
								}
							break;
							case 'text':
								inner_temp.push({
									type:	$(this).attr('data-type'),
									field:	$(this).find('textarea') .attr('name'),
									value:	CKEDITOR.instances[$(this).find('textarea') .attr('name')].getData()
								});
							break;
						}
					});
					temp.push({
						type: $(this).attr('data-type'),
						name: $(this).attr('data-name'),
						value: inner_temp
					});
				break;

				case 'drop_down':
					inner_temp = [];
					$(this).find('#newsContainer .row-wrap').each(function(){
						inner_temp.push($(this).attr('data-id'));
					});
					temp.push({
						type:	$(this).attr('data-type'),
						name:	$(this).attr('data-name'),
						value:	inner_temp
					});
				break;

				case 'single-image':
					temp.push({
						type:	$(this).attr('data-type'),
						name:	$(this).attr('data-name')
					});
					if($(this).find('.upload-image-preview img').length > 0){
						if($(this).find('.upload-image-preview img').attr('data-type') == 'upload'){
							formData.append('image_alt'+$(this).attr('data-name'), $(this).find('input[name=imageAlt]').val());
							formData.append('image_type'+$(this).attr('data-name'), 'upload');
						}else{
							formData.append('image'+$(this).attr('data-name'), $(this).find('.upload-image-preview img').attr('src'));
							formData.append('image_alt'+$(this).attr('data-name'), $(this).find('input[name=imageAlt]').val());
							formData.append('image_type'+$(this).attr('data-name'), 'file');
						}
					}else{
						formData.append('image'+$(this).attr('data-name'), '');
						formData.append('image_alt'+$(this).attr('data-name'), '');
						formData.append('image_type'+$(this).attr('data-name'), 'file');
					}
				break;

				case 'slider':
					temp.push(sliderDataFill($(this), $(this).attr('data-name')));
				break;

				case 'text':
					temp.push({
						type:	$(this).attr('data-type'),
						name:	$(this).attr('data-name'),
						field:	$(this).find('textarea') .attr('name'),
						value:	CKEDITOR.instances[$(this).find('textarea') .attr('name')].getData()
					});
				break;
			}
		});

		formData.append('content', JSON.stringify(temp));

		$.ajax({
			url:	'/admin/pages/add',
			type:	'POST',
			headers:	{'X-CSRF-TOKEN': $('header').attr('data-token')},
			processData:false,
			contentType:false,
			data:	formData,
			error:	function (jqXHR, textStatus, errorThrown) {
				showErrors(jqXHR.responseText, '/admin/pages/add')
			},
			success:function(data){
				try{
					data = JSON.parse(data);
					if(data.message == 'success'){
						location = '/admin/pages';
					}
				}catch(e){
					showErrors(e + data, '/admin/pages/add')
				}
			}
		})
	});

	$('.item-list a.drop').click(function(e){
		e.preventDefault();
		var result = prompt('Для того чтобы удалить страницу введите её название в поле ниже.');
		if($(this).attr('data-title') == result){
			var id = $(this).attr('data-id');
			var _this = $(this);
			$.ajax({
				url:	'/admin/pages/drop',
				type:	'DELETE',
				headers:{'X-CSRF-TOKEN': $('header').attr('data-token')},
				data:	{id:id},
				error:		function (jqXHR, textStatus, errorThrown) {
					showErrors(jqXHR.responseText, '/admin/pages/drop')
				},
				success:function(data){
					try{
						data = JSON.parse(data);
						if (data.message == 'success') {
							_this.closest('tr').remove();
						}
					}catch(e){
						showErrors(e + data, '/admin/pages/drop')
					}
				}
			});
		}
	});
});