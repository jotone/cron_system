'use strict';

function normalWordForm(val, word){
	val = val+'';
	var valLastChar = parseInt(val[val.length -1]);
	val = parseInt(val);
	if(val <= 20){
		switch(true){
			case val == 1: return word; break;
			case (val >= 2 && val <= 4): return word+'а'; break;
			default: return word+'ов';
		}
	}else{
		switch(true){
			case valLastChar == 1: return word; break;
			case (valLastChar >= 2 && valLastChar <= 4): return word+'а'; break;
			default: return word+'ов';
		}
	}
}

function brandSlider(selector) {
	var prev = $(selector).prev('.prev');
	var next = $(selector).next('.next');
	$(selector).slick({
		dots: false,
		infinite: true,
		// autoplay: true,
		// autoplaySpeed: 5000,
		prevArrow: prev,
		nextArrow: next,
		slidesToShow: 5,
		slidesToScroll: 1,
		responsive: [{
			breakpoint: 1367,
			settings: {
				slidesToShow: 4
			}
		},{
			breakpoint: 1024,
			settings: {
				slidesToShow: 3
			}
		},{
			breakpoint: 667,
			settings: {
				slidesToShow: 2
			}
		},{
			breakpoint: 440,
			settings: {
				slidesToShow: 2,
				autoplay: true,
				arrows: false
			}
		}]
	});
}

function recalculateBasket(){
	var total = 0;
	$(document).find('.busket-table .table-row').each(function(){
		if($(this).find('.js-number').length){
			var i = $(this).find('.product-summ span').text().replace(/\s+/g, '');
			total += parseInt(i);
		}
	});
	return total;
}

function busketCount(selector){
	var count = 1;
	var price = 0;

	$(selector).find('input').on('change', function(){
		if($(this).val() < 2){
			$(this).val(1);
		}else if ($(this).val() > 1000){
			$(this).val(1000);
		}
		price = $(this).closest('.table-row').find('.price span').text().replace(/\s+/g, '');
		count = $(this).val();
		$(this).closest('.table-row').find('.product-summ span').text(price * count);
		var total = recalculateBasket();

		$(this).closest('.busket-table').find('.table-footer .summ').text(total + " руб");
	});
}

$(document).ready(function(){
	//get shopping cart items count
	$.ajax({
		url:	'/get_cart_items',
		type:	'GET',
		success:function(data){
			try{
				data = JSON.parse(data);
				if(data.message == 'success'){
					if(data.items.length > 0){
						$('.bottom-header .busket .busket-count').show().text(data.items.length);
					}else{
						$('.bottom-header .busket .busket-count').hide();
					}
				}
			}catch(e){}
		}
	});
	// /get shopping cart items count

	brandSlider('.brand-slider');

	$('.js_popup').fancybox();

	$('.el-radio').styler();
	$('.js-number').styler();

	busketCount('.js-number');

	if($('.product-item').length){
		var test = 0;
		$('.product-item').each(function(){
			if($(this).find('.name').outerHeight() > test){
				test = $(this).find('.name').outerHeight();
			}
		});
		$('.product-item .name').css('height', test);
	}

	$('.header .busket').click(function(e){
		e.preventDefault();
		var _this = $(this);
		$.ajax({
			url:	'/get_cart_items',
			type:	'GET',
			success:function(data){
				try{
					data = JSON.parse(data);
					if(data.message == 'success'){
						var totalCount = data.items.length;
						totalCount = totalCount+' '+normalWordForm(totalCount, 'товар');
						var totalSum = 0;
						var itemsTag = '';

						for(var i in data.items){
							var item = data.items[i];
							itemsTag += '' +
							'<div class="busket-item">'+
								'<div class="pic"><img src="'+item['img_url']['img']+'" alt=""></div>'+
								'<div class="item-name">'+
									'<a href="#">'+item['title']+'</a>'+
									'<span>'+item['price']+' руб</span>'+
								'</div>'+
								'<div class="delete"></div>'+
							'</div>';
							totalSum += parseInt(item['price']);
						}

						$('.bottom-header .busket-popup .txt>h5>span').text(totalCount);
						$('.bottom-header .busket-popup .txt>p>span').text(totalSum);
						$('.bottom-header .busket-popup .cart-wrap').empty();
						$('.bottom-header .busket-popup .cart-wrap').append(itemsTag);

						_this.next('.busket-popup').slideDown();
					}
				}catch(e){}
			}
		});

		return false;
	});

	$('.busket-popup .close').click(function(e){
		e.preventDefault();
		$(this).closest('.busket-popup').slideUp();
		return false;
	});

	$('<a href="javascript:void(0)" class="slide-up"><span></span></a>').insertAfter('.menu-list li:has("ul") > a');

	$('.menu-list > li ul li .slide-up').click(function(){
		var parent_ul = $(this).parents('ul');
		$(this).closest('.menu-list').find('ul li ul').not(parent_ul).slideUp();

		if($(this).next('ul').css('display') == "none"){
			$(this).next('ul').slideDown();
			$(this).addClass('minimazed');
		}else{
			$(this).next('ul').slideUp();
			$(this).removeClass('minimazed');
		}
	});

	$('.menu-list > li > .slide-up').click(function () {
		var menuHolder = $(this).next();
		console.log($(this));
		if(menuHolder.css('display') == "none"){
			menuHolder.slideDown();
			$(this).removeClass('minimazed');
		}else{
			menuHolder.slideUp();
			$(this).addClass('minimazed');
		}
	});

	$('.header a[href="#catalog"], .footer-menu a[href="#catalog"]').click(function(e){
		e.preventDefault();
		$('body,html').animate({ scrollTop: 0}, 500);
		$('.header-huge-menu').addClass('active');
	});

	$('.header .header-huge-menu .close').click(function(e){
		e.preventDefault();
		$('.header-huge-menu').removeClass('active');
	});

	// show more button
	var showMoreClicked = false;
	$('.more').on("click", function(e){
		e.preventDefault();
		//var start = $(this).closest('.mbox').find('.products').attr('data-start');
		var dispatchData = null;
		productListStart = parseInt(productListStart);
		productLoadsCount = parseInt(productLoadsCount);

		if (showMoreClicked) {
			productListStart += productLoadsCount
		}

		dispatchData = {
			start:productListStart,
			loadCount:productLoadsCount
		}

		var _this = $(this);
		$.ajax({
			url:	'/get_more_products',
			data:	dispatchData,
			type:	'GET',
			success:function(data){
				try{
					data = JSON.parse(data);
					if(data.message == 'success'){
						for(var i in data.items){
							var product = data.items[i];
							var item = $( builProductView(product) );
							item.addClass('hide');
							_this.closest('.mbox').find('.products').append(item);
							showProductItemsAnimate(i);
						}

						if(data.has_more < 1){
							_this.hide();
						}
						_this.closest('.mbox').find('.products').attr('data-start',data.start);

						showMoreClicked = true;

					}

				}catch(e){}
			}
		});

	});
	function showProductItemsAnimate(i) {
		setTimeout(function(){
			$('.product-item.hide').first().removeClass('hide');
		},i*130)
	}

	// /show more button

	// burger
	$('.header-burger').click(function(e){
		e.preventDefault();
		$(this).next('.header-menu').toggleClass('active');
	});

	$('.header-menu .close').click(function(e){
		e.preventDefault();
		$(this).closest('.header-menu').toggleClass('active');
	});
	// /burger

});

$(document).click(function(event){
	if($(event.target).closest('.busket-popup').length)
		return;
	$('.busket-popup').slideUp();

	event.stopPropagation();
});

$(window).load(function(){});

$(window).resize(function(){});
//# sourceMappingURL=develop_2.js.map
