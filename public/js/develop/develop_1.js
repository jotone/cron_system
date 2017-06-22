function builProductView(product){
	var hotClass = (product['is_hot'].length > 0)? ' hot-item': '';
	var hotTag = (product['is_hot'].length > 0)? '<div class="'+product['is_hot']+'">'+product['is_hot']+'</div>': '';

	var itemImage = (product['img_url']['img'].length > 0)? '<img src="'+product['img_url']['img']+'" alt="'+product['img_url']['alt']+'">': '';

	var item = '' +
	'<div class="product-item'+hotClass+'">'+
		'<div class="pic">'+itemImage+hotTag+'</div>'+
		'<div class="name">'+
			'<span class="prod-name">'+product['title']+'</span>'+product['text']+
		'</div>'+
		'<div class="price" data-product="'+product['id']+'">';

	if(product['price'] > 0){
		var oldPrice = (product['old_price'] > 0)? '$ '+ product['old_price']: '';
		item += '' +
			'<div class="prod-price">'+
				'<span class="old">'+oldPrice+'</span>'+
				'<span class="new">$ '+product['price']+'</span>'+
			'</div>'+
			'<a href="#busket_popup" class="button-invers to_busket">В корзину</a>';
	}else{
		item += '<a href="#" class="button ask_price">Уточнить цену</a>';
	}
	item +=''+
		'</div>'+
	'</div>';
	return item;
}

$(document).ready(function () {
	if($('#number-select').length > 0){
		$('#number-select').change(function(){
			$.ajax({
				url:	'/change_per_page',
				type:	'PATCH',
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
							$('.autocomplete-dropdown').empty();
							for(var i in data.items){
								$('.autocomplete-dropdown').append('<li><a href="#'+data.items[i]['slug']+'">'+data.items[i]['title']+'</a></li>').slideDown();
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

	$(document).click(function(event){
		if ($(event.target).closest('.advertising-sidebar').length) return;
		$(".autocomplite-dropdown").slideUp('active');
		event.stopPropagation();
	});

	//catalog filter
	//category
	$('.link-list-wrap li').on('click','a',function(e){
		e.preventDefault();
		var type = 'category';
		var data = $(this).attr('href').replace(/#{1,}/g,'').trim();
		sendFilterData(type, data);
	});
	// /category

	//brand
	$('.filter-item').on('change','input[name=brand_radio]',function(){
		var type = 'brand';
		var data = $(this).attr('id');
		sendFilterData(type, data);
	});

	$(document).find('ul.autocomplete-dropdown').on('click','a',function(e){
		e.preventDefault();
		var type = 'brand';
		var data = $(this).attr('href').replace(/#{1,}/g,'').trim();
		sendFilterData(type, data);
	});
	// /brand

	//price
	$('.filter-item').on('click','button[name=acceptPrice]',function(){
		var type = 'price';
		var data = {
			min: $(this).closest('.filter-price-wrap').find('input[name=min]').val().replace(/[^0-9.]/g,''),
			max: $(this).closest('.filter-price-wrap').find('input[name=max]').val().replace(/[^0-9.]/g,'')
		}
		sendFilterData(type, JSON.stringify(data));
	});
	// /price

	//rating
	$('.filter-item').on('change','input[name=eval]',function(){
		var type = 'rating';
		var data = $('.filter-item input[name=eval]:checked:last').val();
		sendFilterData(type, JSON.stringify(data));
	});
	// /rating

	$('.catalog-filter-wrap .filter-reset').on('click','a',function(e){
		e.preventDefault();
		$.ajax({
			url:	'/change_filter',
			type:	'PATCH',
			data:	{reset:0},
			success:function(data){
				try{
					data = JSON.parse(data);
					if(data.message == 'reset'){
						location.reload(true)
					}
				}catch(e){}
			}
		});
	});
	// /catalog filter
});

function sendFilterData(type, data){
	var pageIsset = window.location.pathname.split('/').indexOf('page')
	var page = (pageIsset > 0)? window.location.pathname.split('/')[pageIsset+1]: 1;
	$.ajax({
		url:	'/change_filter',
		type:	'PATCH',
		data:	{filter: [type,data], page:page},
		success:function(data){
			try{
				data = JSON.parse(data);
				if(data.message == 'success'){

					if(data.pagination.total > 1){
						$('.pagination').show();
						$('.pagination ul').empty();
						for(var i = 1; i<= data.pagination.total; i++){
							var currentClass = (i == parseInt(data.pagination.current))? ' class="active"': '';

							var paginationTag = '<li'+currentClass+'>';
							paginationTag += (i == parseInt(data.pagination.current))? i: '<a href="/catalog/page/'+i+'">'+i+'</a>';
							paginationTag += '</li>';
							$('.pagination ul').append(paginationTag)
						}
						$('.pagination a.prev').remove();
						$('.pagination a.next').attr('href','/catalog/page/2');
					}else{
						$('.pagination').hide();
					}

					$('.catalog-right .products').empty();
					for(var i in data.products){
						var product = data.products[i];
						var item = builProductView(product);
						$('.catalog-right .products').append(item);
					}
				}
			}catch(e){}
		}
	});
}