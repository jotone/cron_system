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
		if($(this).val().length > 1){
			$.ajax({
				url:	'/filter_brand',
				type:	'GET',
				data:	{word: $(this).val()},
				success:function(data){
					try{
						data = JSON.parse(data);
						if( (data.message == 'success') && (data.items.length > 0) ){
							for(var i in data.items){
								$('.autocomplete-dropdown').append('<li><a href="'+data.items[i]['slug']+'">'+data.items[i]['title']+'</a></li>').slideDown();
							}
							return false;
						}
					}catch(e){}
				}
			})
		}
	});

	// to basket
	$(document).on('click','.to_busket', function(e) {
		e.preventDefault();
		var picture = $(this).closest('.product-item').find('.pic').html();
		var title = $(this).closest('.product-item').find('.name .prod-name').text();
		var price = $(this).closest('.product-item').find('.price .prod-price .new').text();
		var product = $(this).closest('.price').attr('data-product');
		$(this).fancybox({
			openEffect  : 'fade',
			closeEffect : 'fade',
			autoSize:true,
			maxWidth : '100%',
			wrapCSS:'busket-wrap',
			'closeBtn' : true,
			fitToView:false,
			padding:'0',
			'afterLoad': function() {
				$('.fancybox-slide .busket_popup .pic').html(picture);
				$('.fancybox-slide .busket_popup .title').html(title);
				$('.fancybox-slide .busket_popup .product-desc .price').html(price);
				$('.fancybox-slide .busket_popup .product-desc .price').attr('data-price',price);
				$('.fancybox-slide .busket_popup').attr('data-product',product);
			}
		});
	});

	$(document).find('.busket_popup').on('click','.minus, .plus', function(){
		var quantity = parseInt($(this).closest('.js-number').find('input[name=count]').val());
		var price = parseInt($(this).closest('.product-desc').find('.price').attr('data-price').replace(/[^0-9.]/g,''));
		var total = price * quantity;
		$(this).closest('.product-desc').find('.price').text('$ '+total);
	});

	$('.busket_popup .buttons .continue').click(function(e){
		e.preventDefault();
		var product = $(this).closest('.busket_popup').attr('data-product');
		var quantity = $(this).closest('.busket_popup').find('.product-desc input[name=count]').val().replace(/[^0-9.]/g,'');
		$.ajax({
			url:	'/add_to_card',
			type:	'POST',
			data:	{gii: product, quantity:quantity},
			success:function(data){
				$.fancybox.close();
			}
		});
	});

	$('.busket_popup .buttons .submit').click(function(e){
		e.preventDefault();
		var product = $(this).closest('.busket_popup').attr('data-product');
		var quantity = $(this).closest('.busket_popup').find('.product-desc input[name=count]').val().replace(/[^0-9.]/g,'');
		$.ajax({
			url:	'/add_to_card',
			type:	'POST',
			data:	{gii: product, quantity:quantity},
			success:function(data){
				location = '/shopping_cart';
			}
		});
	});
	// /to basket

	$(document).find('.brand-items').on('click','a.button-invers',function(e){
		e.preventDefault();
		if(typeof $(this).attr('data-giib') != 'undefined'){
			alert($(this).attr('data-giib'));
		}
	});

	$(document).click(function(event){
		if ($(event.target).closest('.advertising-sidebar').length) return;
		$(".autocomplite-dropdown").slideUp('active');
		event.stopPropagation();
	});
});