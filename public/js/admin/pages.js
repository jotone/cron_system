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

	getTemplateData();
	$('select[name=templateType]').change(function(){
		getTemplateData();
	});
});