'use strict';

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
		}, {
			breakpoint: 1024,
			settings: {
				slidesToShow: 3
			}
		}, {
			breakpoint: 667,
			settings: {
				slidesToShow: 2
			}
		}, {
			breakpoint: 440,
			settings: {
				slidesToShow: 2,
				autoplay: true,
				arrows: false
			}
		}]
	});
}

function busketCount(selector) {
	$(selector).val(1);
	var count = 1;
	var price = 0;

	$(selector).find('input').on('change', function () {
		if ($(this).val() <= 0) {
			$(this).val(1);
		} else if ($(this).val() > 1000) {
			$(this).val(1000);
		}
		price = $(this).closest('.table-row').find('.price span').text().replace(/\s+/g, '');
		count = $(this).val();
		$(this).closest('.table-row').find('.product-summ span').text(price * count);

		var total = 0;
		$(this).closest('.busket-table').find('.table-row').each(function () {
			if ($(this).find('.js-number').length) {
				var i = $(this).find('.product-summ span').text().replace(/\s+/g, '');
				total += parseInt(i);
			}
		});
		$(this).closest('.busket-table').find('.table-footer .summ').text(total + " руб");
	});
}

$(document).ready(function () {
	brandSlider('.brand-slider');

	$('.js_popup').fancybox();

	$('.el-radio').styler();
	$('.js-number').styler();

	busketCount('.js-number');

	if ($('.product-item').length) {
		var test = 0;
		$('.product-item').each(function() {
			if ($(this).find('.name').outerHeight() > test) {
				test = $(this).find('.name').outerHeight();
			}
		});
		$('.product-item .name').css('height', test);
	}

	$('.header .busket').click(function (e) {
		e.preventDefault();
		$(this).next('.busket-popup').slideToggle();
		return false;
	});

	$('.busket-popup .close').click(function (e) {
		e.preventDefault();
		$(this).closest('.busket-popup').slideUp();
		return false;
	});

	$('<a href="javascript:void(0)" class="slide-up"><span></span></a>').insertAfter('.menu-list li:has("ul") > a');

	$('.menu-list > li ul li .slide-up').click(function () {
		var parent_ul = $(this).parents('ul');
		$(this).closest('.menu-list').find('ul li ul').not(parent_ul).slideUp();

		if ($(this).next('ul').css('display') == "none") {
			$(this).next('ul').slideDown();
		} else {
			$(this).next('ul').slideUp();
		}
	});

	$('.menu-list > li > .slide-up').click(function () {
		if ($(this).next('ul').css('display') == "none") {
			$(this).next('ul').slideDown();
		} else {
			$(this).next('ul').slideUp();
		}
	});

	$('.header a[href="#catalog"], .footer-menu a[href="#catalog"]').click(function (e) {
		e.preventDefault();
		$('body,html').animate({ scrollTop: 0}, 500);
		$('.header-huge-menu').addClass('active');
	});

	$('.header .header-huge-menu .close').click(function (e) {
		e.preventDefault();
		$('.header-huge-menu').removeClass('active');
	});

	// removing product from busket

	if ($('.first-busket').length) {
		$('.busket-table .delete').click(function (e) {
			e.preventDefault();
			var id = $(this).attr('data-id');
			var product = $(this).closest('.table-row');
			$.ajax({
				url: removing_from_busket,
				data: { 'remove_id': id },
				method: 'POST',
				success: function success(data) {
					if (data) {
						product.remove();
					}
				}
			});
		});
	};

	// /removing product from busket

	// show more button
	$('.more').on("click", function (e) {
		e.preventDefault();
		var start = $('.products').attr('data-start');
		$.ajax({
			url:	'/get_more_products',
			type:	'GET',
			data:	{start:start},
			success: function(data){
				try{
					data = JSON.parse(data);
					if(data.message == 'success'){
						if(data.has_more < 1) $('.mbox a.more').hide();
						$('.products').attr('data-start',data.start);
						for(var i in data.items){
							var product = data.items[i];

							var classHot = (product['is_hot'].length > 0)? ' hot-item': '';
							var itemTag = '<div class="product-item'+classHot+'"><div class="pic">';
							if(product['img_url']['img'].length > 0){
								itemTag += '<img src="'+product['img_url']['img']+'" alt="'+product['img_url']['alt']+'">';
							}
							if(product['is_hot'].length > 0){
								itemTag += '<div class="'+product['is_hot']+'">'+product['is_hot']+'</div>';
							}
							itemTag += '</div><div class="name" style="height: 159px;"><span class="prod-name">'+product['title']+'</span>'+product['text']+'</div><div class="price">';

							if(product['price'] > 0){
								itemTag += '<div class="prod-price"><span class="old">';
								if(product['old_price'] > 0) itemTag += '$ '+product['formated_old_price'];
								itemTag += '</span><span class="new">$ '+product['formated_price']+'</span></div><a href="#" class="button-invers" data-gii="'+product['id']+'">В корзину</a>';
							}else{
								itemTag += '<a href="#" class="button" data-gii="'+product['id']+'">Уточнить цену</a>';
							}
							itemTag += '</div></div>';
							$('.products').append(itemTag);
						}
					}
				}catch(e){}
			}
		});
	});
	// /show more button

	// burger
	$('.header-burger').click(function (e) {
		e.preventDefault();
		$(this).next('.header-menu').toggleClass('active');
	});

	$('.header-menu .close').click(function (e) {
		e.preventDefault();
		$(this).closest('.header-menu').toggleClass('active');
	});
	// /burger
});

jQuery(document).click(function (event) {
	if ($(event.target).closest(".busket-popup").length) return;
	jQuery(".busket-popup").slideUp();

	event.stopPropagation();
});

$(window).load(function () {});

$(window).resize(function () {});
//# sourceMappingURL=develop_2.js.map
