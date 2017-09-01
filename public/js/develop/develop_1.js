function getOS(){
	var userAgent = window.navigator.userAgent,
		platform = window.navigator.platform,
		macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
		windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
		iosPlatforms = ['iPhone', 'iPad', 'iPod'],
		os = null;

	if(macosPlatforms.indexOf(platform) !== -1){
		os = 'MacOS';
	}else if(iosPlatforms.indexOf(platform) !== -1){
		os = 'iOS';
	}else if(windowsPlatforms.indexOf(platform) !== -1){
		os = 'Windows';
	}else if(/Android/.test(userAgent)){
		os = 'Android';
	}else if(!os && /Linux/.test(platform)){
		os = 'Linux';
	}

	$('html').addClass(os);
}

function builProductView(product){
	var hotClass = (product['is_hot'].length > 0)? ' hot-item': '';
	var hotTag = (product['is_hot'].length > 0)? '<div class="'+product['is_hot']+'">'+product['is_hot']+'</div>': '';

	var itemImage = (product['img_url']['img'].length > 0)? '<img src="'+product['img_url']['img']+'" alt="'+product['img_url']['alt']+'">': '';

	var item = '' +
	'<div class="product-item'+hotClass+'">'+
		'<div class="pic">'+itemImage+hotTag+'</div>'+
		'<div class="name">'+
			'<div class="prod-name">'+product['title']+'</div>'+product['text']+
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

function sendFilterData(type, data){
	var pageIsset = window.location.pathname.split('/').indexOf('page');
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
                                                if(parseInt(data.pagination.prev)>0){
                                                    if($('.pagination a.prev').length<1){
                                                        //alert('tyt');
                                                        $('.pagination').prepend('<a href="#" class="prev"><</a>');
                                                    }
                                                    $('.pagination a.prev').attr('href','/catalog/page/'+data.pagination.prev);
                                                }else{
                                                    $('.pagination a.prev').remove();
                                                }
                                                if(parseInt(data.pagination.next)<=parseInt(data.pagination.total)){
                                                    if($('.pagination a.next').length<1){
                                                        $('.pagination').append('<a href="#" class="next">></a>');
                                                    }
                                                    $('.pagination a.next').attr('href','/catalog/page/'+data.pagination.next);
                                                }else{
                                                    $('.pagination a.next').remove();
                                                }
						
					}else{
						$('.pagination').hide();
					}

					$('.catalog-right .products').empty();
					for(var i in data.products){
						var product = data.products[i];
						var item = builProductView(product);
						$('.catalog-right .products').append(item);
					}
                                        history.pushState({},'CronSystem','/catalog');
				}
			}catch(e){}
		}
	});
}

$(document).ready(function(){
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

	function showItemPopup(_this){
		var picture = _this.closest('.product-item').find('.pic').html();
		var title = _this.closest('.product-item').find('.name .prod-name').text();
		var price = _this.closest('.product-item').find('.price .prod-price .new').text();
		var product = _this.closest('.price').attr('data-product');

		$('.busket_popup .pic').html(picture);
		$('.busket_popup .title').html(title);
		$('.busket_popup .product-desc .price').html(price);
		$('.busket_popup .product-desc .price').attr('data-price',price);
		$('.busket_popup').attr('data-product',product);

		$.fancybox.open({
			src: '#busket_popup',
		});
	}

	//to shopping cart
	$(document).on('click','.to_busket', function(e) {
		e.preventDefault();
		showItemPopup($(this));
	});
	$(document).find('.product-item .to-busket').on('click', function(){
		showItemPopup($(this));
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

	//drop
	$('.busket .table-row .delete').click(function(e){
		e.preventDefault();
		var item = $(this).attr('data-gii');
		var _this = $(this);
		$.ajax({
			url:	'/drop_from_cart',
			type:	'DELETE',
			data:	{gii: item},
			success:function(data){
				try{
					data = JSON.parse(data);
					if(data.message == 'success'){
						_this.closest('.table-row').remove();
						var total = recalculateBasket();
						$('.busket-table').find('.table-footer .summ').text(total + " руб");
					}
				}catch(e){
					console.log(data)
				}
			}
		});
	});
	//change quantity

	function sendGoodsQuantities(){
		var values = [];
		$('.busket-table .delete').each(function(){
			values.push({
				gii:$(this).attr('data-gii'),
				q:	$(this).closest('.table-row').find('.jq-number__field input[name=count]').val()
			});
		});
		$.ajax({
			url:	'/update_cart',
			type:	'PUT',
			data:	{values:values},
			success:function(data){
				try{
					data = JSON.parse(data);
					if(data.message != 'success'){console.log(data)}
				}catch(e){console.log(data)}
			}
		});
		$('#step2').show();
	}

	//shopping cart controls
	$('.main #step2, .main #step3').hide();
	$('.busket-steps .mbox li').click(function(){
		var step = $(this).find('a').attr('data-index');
		$('.busket-steps .mbox li a').removeClass('active');
		$(this).find('a').addClass('active');
		$('.main section').hide();
		$('.main section#'+step).show();
		sendGoodsQuantities();
	});
	$('#step1 form.busket button.submit').click(function(){
		$('.busket-steps .mbox li a').removeClass('active');
		$('.busket-steps .mbox li:eq(1) a').addClass('active');
		$('.main section').hide();
		sendGoodsQuantities()
	});

	$('#step2 .buttons .continue').click(function(e){
		e.preventDefault();
		$('.busket-steps .mbox li a').removeClass('active');
		$('.busket-steps .mbox li:eq(0) a').addClass('active');
		$('.main section').hide();
		$('#step1').show();
	});
	// /shopping cart controls

	// /to shopping cart

	$(document).click(function(event){
		if ($(event.target).closest('.advertising-sidebar').length) return;
		$(".autocomplite-dropdown").slideUp('active');
		event.stopPropagation();
	});

	//catalog filter
	//category
	$('.link-list-wrap li').on('click','a',function(e){
		e.preventDefault();
		$('.link-list-wrap li').removeClass('active');
		$(this).closest('li').addClass('active');

		var type = 'category';
		var data = $(this).attr('href').replace(/#{1,}/g,'').trim();
		sendFilterData(type, data);
	});
	// /category

	//brand
	$('.filter-item').on('click','.checkbox-list-wrap li label',function(){
		var type = 'brand';
		var data = $(this).find('input').attr('id');
		sendFilterData(type, data);

		if ( $('.filter-search .search-input').val().length>0 ){
			$('.filter-search .search-input').val('');
		}
	});

	$(document).find('ul.autocomplete-dropdown').on('click','a',function(e){
		e.preventDefault();
		var type = 'brand';
		var data = $(this).attr('href').replace(/#{1,}/g,'').trim();

		var linkText = $(this).text();
		var mainInput = $(this).closest('.filter-search').find('.search-input');
		mainInput.val(linkText);

		$('.checkbox-list-wrap li input[name="brand_radio"]').prop('checked',false);
		$('.checkbox-list-wrap li input[name="brand_radio"]#'+data).prop( "checked", true );
		console.log($('.checkbox-list-wrap li input[name="brand_radio"]#'+data));
		console.log('.checkbox-list-wrap li input[name="brand_radio"]#'+data);
		//remove dropDown menu
		$('.autocomplete-dropdown').slideUp();

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

	//services
	$('.main .text-block a.js_popup').click(function(){
		$('#call_back_popup input[name=service]').val($(this).attr('data-service'));
	});
	// /services

	getOS();
});