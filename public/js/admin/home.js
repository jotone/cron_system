$(document).ready(function(){
	$('.tab-list li').click(function(){
		var type = $(this).attr('data-type');
		$('.orders-wrap .order-inner').hide();
		$('.orders-wrap .order-inner#'+type).show();
	});

	$('.orders-wrap input[name=done], .orders-wrap input[name=cancel]').click(function(){
		var res = confirm('Потвердите действие');
		if(res){
			var id = $(this).closest('tr').find('a.drop').attr('data-id');
			var status = ($(this).attr('name') == 'done')? '1': '2';
			$.ajax({
				url:	'/admin/orders/change_status',
				type:	'PATCH',
				headers:{'X-CSRF-TOKEN': $('header').attr('data-token')},
				data:	{id:id, status:status},
				error:	function (jqXHR, textStatus, errorThrown) {
					showErrors(jqXHR.responseText, '/admin/orders/change_status')
				},
				success:function(data){
					try{
						data = JSON.parse(data);
						if(data.message == 'success'){
							location.reload(true);
						}
					}catch(e){
						showErrors(e + data, '/admin/orders/change_status')
					}
				}
			})
		}
	});
});