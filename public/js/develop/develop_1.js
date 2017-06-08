$(document).ready(function () {
	if($('#number-select').length > 0){
		$('#number-select').change(function(){
			$.ajax({
				url:	'/change_per_page',
				type:	'PATCH',
				headers:{'X-CSRF-TOKEN': $('input[name=_token]').val()},
				data:	{per_page: $(this).val()},
				success: function(response){
					if(response == 'success'){
						location.reload(true);
					}
				}
			});
		})
	}

	$('form[name=brandFilters] select[name=brands]').change(function(){
		location = '/brand/'+$(this).attr('data-parent')+'/'+$(this).val();
	});

	$('.filter-item .filter-search').on('keyup', 'input', function(){
		if($(this).val().length > 2){
			$.ajax({
				url:	'/filter_brand',
				type:	'GET',
				data:	{word: $(this).val()},
				success:function(data){
					console.log(data);
				}
			})
		}
	})
});