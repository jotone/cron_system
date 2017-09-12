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

function sliderDataFill(obj, name){
	var sliderData = {
		type: obj.attr('data-type'),
		name: name,
		value: []
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
		sliderData.value.push(temp);
	});
	return sliderData;
}

function resortSliderWrap(_this){
	_this.closest('.slider-wrap').find('.slider-content-element').each(function(){
		$(this).attr('data-position', $(this).index());
	});
	_this.closest('.slider-wrap').find('.slider-images-wrap').find('.image-wrap').each(function(){
		$(this).attr('data-position', $(this).index());
	});
}

function sliderSortable(){
	$(document).find('.slider-wrap').find('.slider-list-wrap').sortable({
		update: function(event, ui){
			var oldPos = $(ui.item).attr('data-position');
			var newPos = $(ui.item).index();
			var element = $(ui.item).closest('.slider-wrap').find('.slider-images-wrap .image-wrap[data-position='+oldPos+']');
			$(ui.item).closest('.slider-wrap').find('.slider-images-wrap .image-wrap[data-position='+oldPos+']').remove();
			if(newPos > oldPos){
				$(ui.item).closest('.slider-wrap').find('.slider-images-wrap').find('.image-wrap[data-position='+newPos+']').after(element);
			}else{
				$(ui.item).closest('.slider-wrap').find('.slider-images-wrap').find('.image-wrap[data-position='+newPos+']').before(element);
			}
			resortSliderWrap($(this));
		}
	});
}

function resortCustomSliderWrap(_this){
	_this.closest('.custom-slider-wrap').find('.custom-slider-preview-wrap:gt(0)').each(function(){
		$(this).attr('data-position', $(this).index() -1);
	});
	_this.closest('.custom-slider-wrap').find('.custom-slide-container').each(function(){
		$(this).attr('data-position', $(this).index());
	});
}


function customSliderSortable(){
	$(document).find('.custom-slider-wrap').find('.custom-slider-controls').sortable({
		items:	'.custom-slider-preview-wrap:not(:first)',
		update:	function(event, ui){
			var oldPos = $(ui.item).attr('data-position');
			var newPos = $(ui.item).index() -1;
			var element = $(ui.item).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .custom-slide-container[data-position='+oldPos+']');
			$(ui.item).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .custom-slide-container[data-position='+oldPos+']').remove();
			if(newPos > oldPos){
				$(ui.item).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .custom-slide-container[data-position='+newPos+']').after(element);
			}else{
				$(ui.item).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .custom-slide-container[data-position='+newPos+']').before(element);
			}
			resortCustomSliderWrap($(this));
			if(newPos > 0){
				if($(ui.item).find('.close').length == 0){
					$(ui.item).append('<div class="close">x</div>');
				}
			}
			$(ui.item).closest('.custom-slider-wrap').find('.custom-slider-preview-wrap[data-position=0] .close').remove();
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

function caseImageInOverviewPopup(_this){
	var point = 0;
	$('.overview-popup .popup-images .active').each(function(){
		var imageSrc	= $(this).find('img').attr('src');
		var imageCaption= imageSrc.split('/');

		imageCaption = imageCaption[imageCaption.length -1];
		imageSrc = (imageSrc.substr(0,1) != '/')? '/'+imageSrc: imageSrc;

		_this.closest('.slider-wrap').find('.slider-images-wrap').append('' +
			'<div class="image-wrap" data-position="'+point+'">' +
			'<img src="'+imageSrc+'" alt="">' +
			'<div class="attributes-wrap">' +
			'<input name="altText" type="text" class="text-input" placeholder="Альтернативный текст&hellip;" style="width: 90%;">' +
			'<a href="#" class="drop-image button" title="Удалить">' +
			'<img src="/images/drop.png" alt="">' +
			'</a>' +
			'</div>' +
			'</div>');
		_this.closest('.slider-wrap').find('.slider-list-wrap').append('' +
			'<div class="slider-content-element" data-position="'+point+'">' +
			'<div class="element-title">'+imageCaption+'</div>' +
			'<div class="element-size"></div>' +
			'<div class="element-image">' +
			'<img src="'+imageSrc+'" alt="">' +
			'</div>' +
			'<div class="element-alt"></div>' +
			'<div class="element-drop">' +
			'<img src="/images/drop.png" alt="Удалить" title="Удалить">' +
			'</div>' +
			'</div>');
		point++
	});
	_this.closest('.slider-wrap').find('.slider-images-wrap .image-wrap').removeClass('active');
	_this.closest('.slider-wrap').find('.slider-images-wrap .image-wrap:first').addClass('active');
	resortSliderWrap(_this);
	$('.overview-popup').hide();
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
		closeText:		'Закрыть',
		currentText:	'Сегодня',
		monthNames:		['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
		monthNamesShort:['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
		dayNames:		['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
		dayNamesShort:	['вск','пнд','втр','срд','чтв','птн','сбт'],
		dayNamesMin:	['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
		dateFormat:		'yy-mm-dd',
		firstDay:		1,
		isRTL:			false
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
	$(document).on('click','input[name=viewGallery], input[name=getImgToSlider]',function(){
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
							var descript = '<div>';
							if(typeof data.images[i]['used_in'].length == 'undefined'){
								for(var key in data.images[i]['used_in']){
									switch(key){
										case 'news':		descript += '<p>Новости:</p>'; break;
										case 'products':	descript += '<p>Товары:</p>'; break;
										case 'vacancies':	descript += '<p>Вакансии:</p>'; break;
									}
									for(var iter in data.images[i]['used_in'][key]){
										descript += '<p>'+data.images[i]['used_in'][key][iter]+'</p>';
									}
								}
							}else{
								descript += '<p>Нигде не используется</p>';
							}
							descript += '</div>';

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
								$(this).toggleClass('active');
							}
						});

						$('.overview-popup').off('click').on('click','button[name=addImageFromSaved]',function(){
							if(_this.closest('fieldset').find('input[name=fakeLoad]').length > 0){
								var image = $('.overview-popup .popup-images .active img').attr('src');
								_this.closest('fieldset').find('.upload-image-preview').empty().append('' +
									'<img src="'+image+'" alt="" data-type="file">' +
									'<input name="imageAlt" type="text" class="text-input col_1" placeholder="alt&hellip;">');

							}else if(_this.closest('fieldset').find('input[name=customFakeLoad]').length > 0){
								var image = $('.overview-popup .popup-images .active img').attr('src');
								var position = _this.closest('.custom-slide-container').index();
								_this.closest('.row-wrap[data-type=single-image]').find('.upload-image-preview').empty().append('' +
									'<img src="'+image+'" alt="" data-type="file">' +
									'<input name="imageAlt" type="text" class="text-input col_1" placeholder="alt&hellip;">');

								_this.closest('fieldset').find('.custom-slider-controls .custom-slider-preview-wrap:eq('+(position+1)+') .holder').empty().append(''+
									'<img src="'+image+'" alt="">');
							}else{
								caseImageInOverviewPopup(_this);
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

	//Slider
	$(document).on('click','input[name=loadFileToSlider]', function(){
		$(this).closest('.slider-manage-buttons').find('input[name=imageFileToUpload]').trigger('click');
	});

	var point = 0;
	$(document).on('change', 'input[name=imageFileToUpload]', function(){
		point = 0;
		var formdata_iter = point;
		var sliderName = $(this).closest('fieldset').attr('data-name');
		var _this = $(this);
		var count = $(this).prop('files').length;
		for(var i=0; i<count; i++){
			var reader = new FileReader();
			reader.onload = function(e){
				_this.closest('.slider-wrap').find('.slider-images-wrap').append('' +
					'<div class="image-wrap" data-position="'+point+'">' +
					'<img src="'+e.target.result+'" alt="">' +
					'<div class="attributes-wrap">' +
					'<input name="altText" type="text" class="text-input" placeholder="Альтернативный текст&hellip;" style="width: 90%;">' +
					'<a href="#" class="drop-image button" title="Удалить">' +
					'<img src="/images/drop.png" alt="">' +
					'</a>' +
					'</div>' +
					'</div>');

				_this.closest('.slider-wrap').find('.slider-list-wrap').append('' +
					'<div class="slider-content-element" data-position="'+point+'">' +
					'<div class="element-title">'+(_this.prop('files')[point]['name'])+'</div>' +
					'<div class="element-size">'+(_this.prop('files')[point]['size'] /1024).toFixed(2)+' Kb</div>' +
					'<div class="element-image">' +
					'<img src="'+e.target.result+'" alt="">' +
					'</div>' +
					'<div class="element-alt"></div>' +
					'<div class="element-drop">' +
					'<img src="/images/drop.png" alt="Удалить" title="Удалить">' +
					'</div>' +
					'</div>');
				for(var key of formData.keys()){
					if(key == sliderName+'_file_'+formdata_iter){
						formdata_iter++;
					}
				}
				formData.append(sliderName+'_file_'+formdata_iter , _this.prop('files')[point]);
				if(point == count-1){
					_this.closest('.slider-wrap').find('.slider-images-wrap .image-wrap').removeClass('active');
					_this.closest('.slider-wrap').find('.slider-images-wrap .image-wrap:first').addClass('active');
					resortSliderWrap(_this);
				}
				point++;
				formdata_iter++;
			};
			reader.readAsDataURL($(this).prop('files')[i]);
		}
	});

	// slider controls
	$(document).on('click', '.slider-controls', function(){
		var sliderLength = $(this).closest('.slider-preview').find('.slider-images-wrap .image-wrap').length -1;
		var activeEl = $(this).closest('.slider-preview').find('.slider-images-wrap').find('.active').index();
		if($(this).hasClass('left')){
			var showEl = (activeEl == 0)? sliderLength: activeEl -1;
		}else{
			var showEl = (activeEl == sliderLength)? 0: activeEl+1;
		}
		$(this).closest('.slider-preview').find('.slider-images-wrap .image-wrap').removeClass('active');
		$(this).closest('.slider-preview').find('.slider-images-wrap .image-wrap:eq('+showEl+')').addClass('active');
	});

	// slider sortable
	sliderSortable();


	/*Custom slider*/
	//Custom slider Image Loader
	$(document).on('click', 'input[name=customFakeLoad]', function(){
		$(this).closest('.button-container').find('input[name=customImageLoader]').trigger('click');
	});
	$(document).on('change','input[name=customImageLoader]',function(){
		var addName = (typeof $(this).closest('fieldset').attr('data-name') != 'undefined')? '_'+$(this).closest('fieldset').attr('data-name'): '';
		var reader = new FileReader();
		var _this = $(this);
		var position = $(this).closest('.custom-slide-container').index();
		reader.onload = function(e){
			_this.closest('.button-container').find('.upload-image-preview').empty().append('' +
				'<img src="'+e.target.result+'" alt="" data-type="upload">' +
				'<input name="imageAlt" type="text" class="text-input col_1" placeholder="alt&hellip;">');
			_this.closest('fieldset').find('.custom-slider-controls .custom-slider-preview-wrap:eq('+(position+1)+') .holder').empty().append('' +
				'<img src="'+e.target.result+'" alt="">');
			formData.append('image'+addName+'_'+position, _this.prop('files')[0]);
		};
		reader.readAsDataURL(_this.prop('files')[0]);
	});
	// /Custom slider Image Loader

	//Custom Slider Add Slide
	$(document).on('click','.custom-slider-controls .add-button',function(){
		var cloned = $(this).closest('.custom-slider-wrap').find('.custom-slide-container:last').clone();
		var ckeDrop = 'cke_'+cloned.find('textarea').attr('name');
		var textareaName = cloned.find('textarea').attr('name').split('_');
		var position = parseInt(cloned.attr('data-position')) +1;

		textareaName[textareaName.length -1] = position;
		textareaName = textareaName.join('_');
		cloned.find('.upload-image-preview').empty();
		cloned.find('input[type=text]').val('');
		cloned.find('textarea').val('').attr('name',textareaName);
		cloned.find('#'+ckeDrop).remove();
		cloned.attr('data-position',position);

		$(this).closest('.custom-slider-controls').find('.custom-slider-preview-wrap').removeClass('active');
		$(this).closest('.custom-slider-controls').append('<div class="custom-slider-preview-wrap active" data-position="'+position+'">'+
			'<div class="holder"></div><div class="close">x</div>'+
		'</div>');
		$(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap').append(cloned);
		if($.isEmptyObject(CKEDITOR.instances[textareaName])){
			CKEDITOR.replace(textareaName);
		}
		$(this).closest('.custom-slider-wrap').find('.custom-slide-container').removeClass('active');
		$(this).closest('.custom-slider-wrap').find('.custom-slide-container:last').addClass('active');
	});
	// /Custom Slider Add Slide

	//Custom slider left-right click
	$(document).on('click', '.slider-controls-bg', function(){
		var sliderLength = $(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .custom-slide-container').length -1;
		if(sliderLength){
			var activeEl = $(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap').find('.active').index();
		if($(this).hasClass('left')){
				var showEl = (activeEl == 0)? sliderLength: activeEl -1;
			}else{
				var showEl = (activeEl == sliderLength)? 0: activeEl+1;
			}
			$(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .custom-slide-container').removeClass('active');
			$(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .custom-slide-container:eq('+showEl+')').addClass('active');
			var position = $(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .active').index();

			$(this).closest('.custom-slider-wrap').find('.custom-slider-preview-wrap').removeClass('active');
			$(this).closest('.custom-slider-wrap').find('.custom-slider-preview-wrap:eq('+(parseInt(position)+1)+')').addClass('active');
		}
	});

	$(document).on('click', '.custom-slider-wrap .custom-slider-preview-wrap', function(){
		if($(this).index() > 0){
			var position = $(this).index() -1;
			$(this).closest('.custom-slider-controls').find('.custom-slider-preview-wrap').removeClass('active');
			$(this).addClass('active');

			$(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .custom-slide-container').removeClass('active');
			$(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .custom-slide-container:eq('+position+')').addClass('active');
		}
	});
	// /Custom slider left-right click

	//Custom Slider drop slide
	$(document).on('click','.custom-slider-controls .close', function(){
		var res = confirm('Вы действительно хотите удалить данный слайд?');
		if(res){
			var position = $(this).closest('.custom-slider-preview-wrap').index()-1;
			if($(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .active').index() == position){
				$(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .custom-slide-container:eq('+(position -1)+')').addClass('active');
				$(this).closest('.custom-slider-controls').find('.custom-slider-preview-wrap:eq('+position+')').addClass('active')
			}

			$(this).closest('.custom-slider-wrap').find('.custom-slide-container:eq('+position+')').remove();
			$(this).closest('.custom-slider-preview-wrap').remove();
		}
	});
	// /Custom Slider drop slide
	// / Custom slider

	$(document).on('keyup','input[name=altText]', function(){
		var position = $(this).closest('.image-wrap').index();
		$(this).closest('.slider-wrap').find('.slider-list-wrap').find('.slider-content-element[data-position='+position+']').find('.element-alt').text($(this).val());
	});
	//drop image
	$(document).on('click', '.drop-image', function(e){
		e.preventDefault();
		var sliderName = $(this).closest('fieldset').attr('data-name');
		var position = $(this).closest('.image-wrap').index();
		var _that = $(this).closest('.slider-images-wrap');
		$(this).closest('.slider-wrap').find('.slider-list-wrap').find('.slider-content-element[data-position='+position+']').remove();
		$(this).closest('.image-wrap').remove();
		resortSliderWrap(_that);
		formData.delete(sliderName+'_file_'+position);
	});
	$(document).on('click', '.element-drop', function(){
		var sliderName = $(this).closest('fieldset').attr('data-name');
		var position = $(this).closest('.slider-content-element').index();
		var _that = $(this).closest('.slider-list-wrap');
		$(this).closest('.slider-wrap').find('.slider-images-wrap').find('.image-wrap[data-position='+position+']').remove();
		$(this).closest('.slider-content-element').remove();
		resortSliderWrap(_that);
		formData.delete(sliderName+'_file_'+position);
	});
	//add images from uploaded

	//tab list
	$('.tab-list li').click(function(){
		$(this).closest('ul').find('li').removeClass('active');
		$(this).addClass('active');
	});
	// /tab list
});