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

function str2urlUpperCase(str){
	str = rus2translit(str);
	str = str.toUpperCase();
	str = str.replace(/[^-A-Z0-9_\.\#]/g, '_');
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

function caseImageInOverviewPopup(_this){
	$('.overview-popup .image-container').click(function(){
		$(this).toggleClass('active');
	});
	$('.overview-popup').off('click','button[name=addImageFromSaved]');
	$('.overview-popup').on('click','button[name=addImageFromSaved]', function(){
		var point = 0;
		$('.overview-popup .popup-images .active').each(function(){
			var imageSrc	= $(this).find('img').attr('alt');
			var imageCaption= imageSrc.split('/');

			imageCaption = imageCaption[imageCaption.length -1];
			imageSrc = (imageSrc.substr(0,1) != '/')? '/'+imageSrc: imageSrc;

			_this.closest('.slider-wrap').find('.slider-images-wrap').append('' +
				'<div class="image-wrap" data-position="'+point+'">' +
				'<img src="'+imageSrc+'" alt="">' +
				'<div class="attributes-wrap">' +
				'<input name="altText" type="text" class="text-input" placeholder="Альтернативный текст&hellip;" style="width: 90%;">' +
				'<a href="#" class="drop-image button" title="Удалить">' +
				'<img src="/img/drop.png" alt="">' +
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
				'<img src="/img/drop.png" alt="Удалить" title="Удалить">' +
				'	</div>' +
				'</div>');
			point++
		});
		_this.closest('.slider-wrap').find('.slider-images-wrap .image-wrap').removeClass('active');
		_this.closest('.slider-wrap').find('.slider-images-wrap .image-wrap:first').addClass('active');
		resortSliderWrap(_this);
		$('.overview-popup').hide();
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

	//Autoslug
	$(document).on('keyup', 'input[name=title], input[name=slug]', function(){
		var str = str2url($(this).val());
		$(document).find('input[name=slug]').val(str);
	});
	// /Autoslug

	//Custom fields table
	$(document).on('click','input[name=addRowToTable]', function(){
		var colCount = $(this).closest('fieldset').find('.item-list').find('tr th').length;
		var tag = '<tr>';
		for(var i=0; i<colCount; i++){
			if(i==0){
				tag += '<td><a href="#" class="drop-row block-button" title="Удалить"><img src="/img/drop.png" alt=""></a></td>';
			}else{
				tag += '<td><input name="tableBody" type="text" class="text-input" placeholder="Содержимое ячейки&hellip;"></td>';
			}
		}
		tag += '</tr>';
		$(this).closest('fieldset').find('.item-list').find('tbody').append(tag);
	});

	$(document).on('click', 'a.drop-row', function(e){
		e.preventDefault();
		$(this).closest('tr').remove();
	});
	// /Custom fields table

	$(document).on('click','input[name=fakeLoad]',function(){
		$(this).closest('fieldset').find('input[name=imageLoader]').trigger('click');
	});
	$(document).on('change','input[name=imageLoader]',function(){
		var addName = (typeof $(this).closest('fieldset').attr('data-name') != 'undefined')? '_'+$(this).closest('fieldset').attr('data-name'): '';

		var reader = new FileReader();
		var _this = $(this);
		reader.onload = function(e){
			_this.closest('fieldset').find('.upload-image-preview').empty().append('<img src="'+e.target.result+'" alt="">').attr('data-cleared','0');
			formData.append('image'+addName, _this.prop('files')[0]);
		}
		reader.readAsDataURL(_this.prop('files')[0]);
	});
	$(document).on('click','input[name=clear]',function(){
		var addName = (typeof $(this).closest('fieldset').attr('data-name') != 'undefined')? '_'+$(this).closest('fieldset').attr('data-name'): '';
		$(this).closest('fieldset').find('.upload-image-preview').empty().attr('data-cleared','1');
		formData.delete('image'+addName);
	});

	// Slider
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
					'<img src="/img/drop.png" alt="">' +
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
					'<img src="/img/drop.png" alt="Удалить" title="Удалить">' +
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
	$(document).on('click','input[name=getImgToSlider]', function(){
		var _this = $(this);
		var token = $('.central-block').attr('data-token');
		$.ajax({
			url:	'/admin/get_server_images',
			type:	'GET',
			headers:{'X-CSRF-TOKEN': token},
			error:	function(xhr){
				showErrors(xhr.responseText, '/admin/get_server_images');
			},
			success:function(data){
				try{
					data = JSON.parse(data);
					if(data['message'] == 'success') {
						$('.overview-popup .popup-images').empty();
						for(var img in data['folders']){
							$('.overview-popup .popup-images').append('<div class="image-container"><img src="/'+data['folders'][img]+'" alt="'+data['folders'][img]+'"></div>');
						}
						$('.overview-popup').show();
						caseImageInOverviewPopup(_this);
					}else{
						showErrors(data, '/admin/get_server_images');
					}
				}catch(e){
					showErrors(e+data, '/admin/get_server_images');
				}
			}
		});
	});
	// /Slider

    //Custom fields custom slider
    //add slide
    $(document).on('click', 'input[name=customSliderAddSlide]', function(){
        var clone = $(this).closest('fieldset').find('.custom-slider-content-wrap').find('.custom-slide-container:first').clone(false);
        clone.find('.row-wrap').each(function(){
            $(this).find('input:not([type=button])').val('');
            $(this).find('input').prop('checked',false);
            $(this).find('textarea').text('');
            $(this).find('textarea').val('');
            $(this).find('.upload-image-preview').empty();
        });
        $(this).closest('fieldset').find('.custom-slider-content-wrap').append(clone);
        $(this).closest('fieldset').find('.custom-slider-content-wrap').find('.custom-slide-container').removeClass('active');
        $(this).closest('fieldset').find('.custom-slider-content-wrap').find('.custom-slide-container:last').addClass('active');
    });

    //drop current slide
    $(document).on('click', 'input[name=customSliderDropCurrentSlide]', function(){
        if($(this).closest('fieldset').find('.custom-slider-content-wrap .custom-slide-container').length > 1){
            $(this).closest('fieldset').find('.custom-slider-content-wrap').find('.active').remove();
            $(this).closest('fieldset').find('.custom-slider-content-wrap .custom-slide-container').removeClass('active');
            $(this).closest('fieldset').find('.custom-slider-content-wrap .custom-slide-container:first').addClass('active');
        }else{
            $(this).closest('fieldset').find('.custom-slider-content-wrap').find('.custom-slide-container').find('.row-wrap').each(function(){                $(this).find('input').val('');
                $(this).find('textarea').text('');
                $(this).find('textarea').val('');
            });
        }
    });

    //slider controls
    $(document).on('click', '.slider-controls-bg', function(){
        var sliderLength = $(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .custom-slide-container').length -1;
        var activeEl = $(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap').find('.active').index();
        if($(this).hasClass('left')){
            var showEl = (activeEl == 0)? sliderLength: activeEl -1;
        }else{
            var showEl = (activeEl == sliderLength)? 0: activeEl+1;
        }
        $(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .custom-slide-container').removeClass('active');
        $(this).closest('.custom-slider-wrap').find('.custom-slider-content-wrap .custom-slide-container:eq('+showEl+')').addClass('active');
    });
    // /Custom fields custom slider
});