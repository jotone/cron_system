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
				if($('#newsContainer').length() > 0){
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
								$('#newsContainer').empty().append(containerContent);
							}catch(e){
								showErrors(e + data, '/admin/get_latest_news')
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
$(document).ready(function(){
	buildFixedNavMenu();
	seoToggle();
	$('input[name=need_seo]').change(function(){
		seoToggle();
	});

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

	$(document).find('button[name=moreNews]').click(function(){
		var title = $(this).closest('fieldset').find('ul.pseudo-selector li.active span').text();
		$('#newsContainer').append('<div class="row-wrap col_1_2" style="display: flex; align-items: center">' +
			'<span style="width: 110px; padding-right: 10px;" class="tar">'+title+'</span>'+
			'<span class="drop-add-field">×</span>'+
		'</div>');
	});

	$(document).find('#newsContainer').on('click', '.drop-add-field', function(){
		$(this).closest('.row-wrap').remove();
	});
	if($('select[name=templateType]').length > 0){
		getTemplateData();
		$('select[name=templateType]').change(function () {
			getTemplateData();
		});
	}
});