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
			switch($(this).closest('.order-inner').attr('id')){
				case 'calls':		var type = 'call'; break;
				case 'questions':	var type = 'question'; break;
				case 'vacancy':		var type = 'vacancy'; break;
				default:			var type = 'order'
			}
			$.ajax({
				url:	'/admin/orders/change_status',
				type:	'PATCH',
				headers:{'X-CSRF-TOKEN': $('header').attr('data-token')},
				data:	{id:id, status:status, type:type},
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

	$('.orders-wrap a.drop').click(function(e){
		e.preventDefault();
		var res = confirm('Потвердите действие');
		if(res){
			var id = $(this).attr('data-id');
			var _this = $(this);
			switch($(this).closest('.order-inner').attr('id')){
				case 'calls':		var type = 'call'; break;
				case 'questions':	var type = 'question'; break;
				case 'vacancy':		var type = 'vacancy'; break;
				default:			var type = 'order'
			}
			$.ajax({
				url:	'/admin/orders/drop',
				type:	'DELETE',
				headers:{'X-CSRF-TOKEN': $('header').attr('data-token')},
				data:	{id:id, type:type},
				error:	function (jqXHR, textStatus, errorThrown) {
					showErrors(jqXHR.responseText, '/admin/orders/drop')
				},
				success:function(data){
					try{
						data = JSON.parse(data);
						if (data.message == 'success') {
							_this.closest('tr').remove();
						}
					}catch(e){
						showErrors(e + data, '/admin/orders/drop')
					}
				}
			});
		}
	});
});