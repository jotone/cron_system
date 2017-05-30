jQuery.browser = {};
jQuery.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
jQuery.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());

var scroller=jQuery.browser.webkit ? "body": "html";

formData = new FormData();

function goTo(href){
	var target = $(href).offset().top-65;
	$(scroller).animate({scrollTop:target},500);
}

function rus2translit(str){
	str = str.trim();
	var converter = {
		'а':'a',	'б':'b',	'в':'v',	'г':'g',	'д':'d',	'е':'e',
		'ё':'e',	'ж':'zh',	'з':'z',	'и':'i',	'й':'j',	'к':'k',
		'л':'l',	'м':'m',	'н':'n',	'о':'o',	'п':'p',	'р':'r',
		'с':'s',	'т':'t',	'у':'u',	'ф':'f',	'х':'h',	'ц':'ts',
		'ч':'ch',	'ш':'sh',	'щ':'shch',	'ь':'',		'ы':'y',	'ъ':'',
		'э':'e',	'ю':'yu',	'я':'ya',	'і':'i',	'ї':'i',	'є':'ie',
		'А':'A',	'Б':'B',	'В':'V',	'Г':'G',	'Д':'D',	'Е':'E',
		'Ё':'E',	'Ж':'Zh',	'З':'Z',	'И':'I',	'Й':'J',	'К':'K',
		'Л':'L',	'М':'M',	'Н':'N',	'О':'O',	'П':'P',	'Р':'R',
		'С':'S',	'Т':'T',	'У':'U',	'Ф':'F',	'Х':'H',	'Ц':'Ts',
		'Ч':'Ch',	'Ш':'Sh',	'Щ':'Shch',	'Ь':'',		'Ы':'Y',	'Ъ':'',
		'Э':'E',	'Ю':'Yu',	'Я':'Ya',	'І':'I',	'Ї':'I',	'Є':'Ie'
	};
	str = str.split('');
	var result = '';
	for(var char in str){
		if(converter[str[char]] != undefined){
			result += converter[str[char]];
		}else{
			result += str[char];
		}
	}
	return result;
}

function str2url(str){
	str = rus2translit(str);
	str = str.toLowerCase();
	str = str.replace(/[^-a-z0-9_\.\#]/g, '_');
	return str;
}

function showErrors(data, url){
	$('.error-popup .popup-caption span').html('&quot;'+url+'&quot;');
	$('.error-popup .error-wrap').html(data);
	$('footer .error-log').show();
}
//Fixed nav menu building
function buildFixedNavMenu(){
	$('.fixed-navigation-menu ul').empty();
	$(document).find('.work-place-wrap').children('div:visible').children('fieldset').each(function(){
		var slug = str2url($(this).children('legend').text());
		$(this).attr('data-link',slug);
		$('.fixed-navigation-menu ul').append('<li data-link="'+slug+'">'+$(this).children('legend').text()+'</li>');
	});
	$(document).find('.fixed-navigation-menu').on('click','li',function(){
		var link = $(this).attr('data-link');
		goTo('fieldset[data-link='+link+']');
	});
}

function addTelMask(){
	$(document).find('.needPhoneMask').mask('0 (000) 000-00-00', {
		placeholder: '_ (___) __-__-__',
		pattern: /[0-9*]/
	});
}

function resortSliderWrap(_this){
	_this.closest('.slider-wrap').find('.slider-content-element').each(function(){
		$(this).attr('data-position', $(this).index());
	});
	_this.closest('.slider-wrap').find('.slider-images-wrap').find('.image-wrap').each(function(){
		$(this).attr('data-position', $(this).index());
	});
}

function sliderDataFill(obj, name){
	var sliderData = {
		name: name,
		type: 'slider',
		items: []
	};
	obj.find('.slider-list-wrap').find('.slider-content-element').each(function(){
		var temp = {
			pos: $(this).index(),
			alt: $(this).find('.element-alt').text().trim()
		};
		temp.uploaded = ($(this).find('.element-size').text().trim().length > 0)
			? $(this).find('.element-title').text().trim()
			: '';
		temp.image = ($(this).find('.element-size').text().trim().length > 0)
			? ''
			: $(this).find('.element-image').find('img').attr('src');
		sliderData.items.push(temp);
	});
	return sliderData;
}

function sliderSortable(){
	$(document).find('.slider-wrap').find('.slider-list-wrap').sortable({
		update: function(event, ui){
			var oldPos = $(ui.item).attr('data-position');
			var newPos = $(ui.item).index();
			var element = $(ui.item).closest('.slider-wrap').find('.slider-images-wrap').find('.image-wrap[data-position='+oldPos+']');
			$(ui.item).closest('.slider-wrap').find('.slider-images-wrap').find('.image-wrap[data-position='+oldPos+']').remove();
			if(newPos > oldPos){
				$(ui.item).closest('.slider-wrap').find('.slider-images-wrap').find('.image-wrap[data-position='+newPos+']').after(element);
			}else{
				$(ui.item).closest('.slider-wrap').find('.slider-images-wrap').find('.image-wrap[data-position='+newPos+']').before(element);
			}
			resortSliderWrap($(this));
		}
	});
}

function getRequest(){
	var params = window.location.search.replace('?','').split('&').reduce(
		function(p,e){
			var a = e.split('=');
			p[decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
			return p;
		},{}
	);
	return params;
}

function autoSlug(){
	$(document).on('keyup', 'input[name=title], input[name=slug]', function(){
		var str = str2url($(this).val());
		$(document).find('input[name=slug]').val(str);
	});
}

$(document).ready(function(){
	$('footer .error-log').click(function(){
		$('.error-popup').show();
		$('footer .error-log').hide();
	});

	$(document).on('click','.close-popup',function(){
		$(this).parent().hide();
	});

	$(document).on('focus','.errorInp',function(){
		$(this).removeClass('errorInp');
	});

	CKEDITOR.replaceAll('needCKE');

	addTelMask();

	$.datepicker.regional['ru'] = {
		closeText: 'Закрыть',
		currentText: 'Сегодня',
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
		dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
		dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
		dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false
	};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
	$('.needDatePicker').datepicker();

	//Single Image Loader
	$(document).on('click','input[name=fakeLoad]',function(){
		$(this).closest('fieldset').find('input[name=imageLoader]').trigger('click');
	});

	$(document).on('change','input[name=imageLoader]',function(){
		var addName = (typeof $(this).closest('fieldset').attr('data-name') != 'undefined')? '_'+$(this).closest('fieldset').attr('data-name'): '';
		var reader = new FileReader();
		var _this = $(this);
		reader.onload = function(e){
			_this.closest('fieldset').find('.upload-image-preview').empty().append('' +
				'<img src="'+e.target.result+'" alt="" data-type="upload">' +
				'<input name="imageAlt" type="text" class="text-input col_1" placeholder="alt&hellip;">');
			formData.append('image'+addName, _this.prop('files')[0]);
		};
		reader.readAsDataURL(_this.prop('files')[0]);
	});
	$(document).on('click','input[name=clear]',function(){
		var addName = (typeof $(this).closest('fieldset').attr('data-name') != 'undefined')? '_'+$(this).closest('fieldset').attr('data-name'): '';
		$(this).closest('fieldset').find('.upload-image-preview').empty();
		formData.delete('image'+addName);
	});
	// /Single Image Loader

	//Call Gallery
	$(document).on('click','input[name=viewGallery]',function(){
		var _this = $(this);
		$.ajax({
			url:	'/admin/get_all_images',
			type:	'GET',
			error:	function(jqXHR, textStatus, errorThrown){
				showErrors(jqXHR.responseText, '/admin/get_all_images')
			},
			success:function(data){
				try{
					data = JSON.parse(data);
					if(data.message == 'success'){
						$('.overview-popup .popup-images').off('click','.image-container');
						$('.overview-popup .popup-images').empty();
						for(var i in data.images){
							if(data.images[i]['used_in'].length > 0){
								var descript = '';
							}else{
								var descript = '<p>Нигде не используется</p>';
							}

							$('.overview-popup .popup-images').append('<div class="image-container">' +
								'<img src='+data.images[i]['img']+' alt="">'+descript+
							'</div>');
						}
						$('.overview-popup').show();

						$('.overview-popup .popup-images').on('click','.image-container', function(){
							if(_this.closest('fieldset').find('input[name=fakeLoad]').length > 0){
								$('.overview-popup .popup-images .image-container').removeClass('active');
								$(this).addClass('active');
							}else{
								$('.overview-popup .popup-images').on('click','.image-container', function(){
									$('.overview-popup .popup-images .image-container').toggleClass('active');
								});
							}
						});

						$('.overview-popup').on('click','button[name=addImageFromSaved]',function(){
							if(_this.closest('fieldset').find('input[name=fakeLoad]').length > 0){
                                var image = $('.overview-popup .popup-images .active img').attr('src');
								_this.closest('fieldset').find('.upload-image-preview').empty().append('' +
									'<img src="'+image+'" alt="" data-type="file">' +
									'<input name="imageAlt" type="text" class="text-input col_1" placeholder="alt&hellip;">');
							}else{

							}
                            $('.overview-popup').hide();
						});
					}else{
						showErrors(data.message, '/admin/get_all_images')
					}
				}catch(e){
					showErrors(e + data, '/admin/get_all_images')
				}
			}
		});
	});
	// /Call Gallery
});