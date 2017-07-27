'use strict';

/**
* Main validation form
* @param {form} jquery obj - Form
* @param {options} obj - object width params
*/
function validate(form, options) {
	var setings = {
		errorFunction: null,
		submitFunction: null,
		highlightFunction: null,
		unhighlightFunction: null
	};
	$.extend(setings, options);

	var $form;
	if(form == '$(this)'){
		$form = form;
	}else{
		$form = $(form);
	}

	if ($form.length && $form.attr('novalidate') === undefined) {
		$form.on('submit', function (e) {
			e.preventDefault();
		});

		$form.validate({
			errorClass: 'errorText',
			focusCleanup: true,
			focusInvalid: false,
			invalidHandler: function invalidHandler(event, validator) {
				if (typeof setings.errorFunction === 'function') {
					setings.errorFunction(form);
				}
			},
			errorPlacement: function errorPlacement(error, element) {
				error.appendTo(element.closest('.form_input'));
			},
			highlight: function highlight(element, errorClass, validClass) {
				$(element).addClass('error');
				$(element).closest('.form_row').addClass('error').removeClass('valid');
				if (typeof setings.highlightFunction === 'function') {
					setings.highlightFunction(form);
				}
			},
			unhighlight: function unhighlight(element, errorClass, validClass) {
				$(element).removeClass('error');
				if ($(element).closest('.form_row').is('.error')) {
					$(element).closest('.form_row').removeClass('error').addClass('valid');
				}
				if (typeof setings.unhighlightFunction === 'function') {
					setings.unhighlightFunction(form);
				}
			},
			submitHandler: function submitHandler(form) {
				if (typeof setings.submitFunction === 'function') {
					setings.submitFunction(form);
				} else {
					$form[0].submit();
				}
			}
		});

		$('[required]', $form).each(function () {
			$(this).rules("add", {
				required: true,
				messages: {
					required: "Вы пропустили"
				}
			});
		});

		if ($('[type="email"]', $form).length) {
			$('[type="email"]', $form).rules("add", {
				messages: {
					email: "Невалидный email"
				}
			});
		}

		if ($('.tel-mask[required]', $form).length) {
			$('.tel-mask[required]', $form).rules("add", {
				messages: {
					required: "Введите номер мобильного телефона."
				}
			});
		}

		$('[type="password"]', $form).each(function () {
			if ($(this).is("#re_password") == true) {
				$(this).rules("add", {
					minlength: 3,
					equalTo: "#password",
					messages: {
						equalTo: "Неверный пароль.",
						minlength: "Недостаточно символов."
					}
				});
			}
		});
	}
}

/**
* Sending form with a call popup
* @param {form} string - Form
*/
function validationCall(form) {
	var thisForm = $(form);
	var formSur = thisForm.serialize();

	$.ajax({
		url: thisForm.attr('action'),
		data: formSur,
		method: 'POST',
		success: function success(data) {
			try{
				data = JSON.parse(data);
				if(data.message == 'success'){
					if(data.request.length){
						switch(data.request){
							case 'ask_question':
							case 'order_phone_call':
								thisForm.trigger('reset');
								$.fancybox.close();
								popNext("#call_success");
							break;
						}
					}
				}
			}catch(e){
				if(data.trim() == 'true'){
					thisForm.trigger("reset");
					$.fancybox.close();
					popNext("#call_success", "call-popup");
				}else{
					thisForm.trigger('reset');
				}
			}
		}
	});
}

function validationCallPatchMethod(form){
	var thisForm = $(form);
	var formSur = thisForm.serialize();
	$.ajax({
		url:	thisForm.attr('action'),
		data:	formSur,
		headers:{'X-CSRF-TOKEN':$(form).find('input[name=_token]').val()},
		type:	'PATCH',
		success:function(data){
			data = JSON.parse(data);
			if(data.message.length > 0){
				if(data.message == 'success'){
					alert(data.text);
				}
			}else if(data.error.length > 0){
				switch(data.type){
					case 'old_password': $('.change-pass-form input[name=old_password]').addClass('error'); alert(data.error); break;
					case 'not_activated': alert(data.error); break;
					case 'new_password': $('.change-pass-form input[name=new_password]').addClass('error'); alert(data.error); break;
					case 'conf_password': $('.change-pass-form input[name=conf_new_password]').addClass('error'); alert(data.error); break;
				}
			}
		}
	});
}

/**
* Sending form with a call popup
* @param {popupId} string - Id form, that we show
* @param {popupWrap} string - Name of class, for wrapping popup width form
*/
function popNext(popupId, popupWrap) {
	$.fancybox.open({
		src: popupId,
		type: '',
		opts: {
			baseClass: popupWrap || '',
			afterClose: function afterClose() {
				$('form').trigger("reset");
				clearTimeout(timer);
			}
		}
	});

	var timer = null;

	timer = setTimeout(function () {
		$('form').trigger("reset");
		$.fancybox.close();
	}, 2000);
}

/**
* Submitting the form with the file
* @param {form} string - Form
* не использовать input[type="file"] в форме и не забыть дописать форме enctype="multipart/form-data"
*/
function validationCallDocument(form) {
	var thisForm = $(form);
	var formData = new FormData($(form)[0]);

	formData.append('file', thisForm.find('input[type=file]')[0].files[0]);

	$.ajax({
		url: thisForm.attr('action'),
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		cache: false,
		success: function success(response) {
			try{
				response = JSON.parse(response);
				if(response.message == 'success'){
					thisForm.trigger("reset");
					popNext("#call_success", "call-popup");
				}else if(response.message == 'error'){
					alert(response.text);
				}
			}catch(e){}
		}
	});
}

/**
* Submitting the form with the files
* @param {form} string - Form
* не использовать input[type="file"] в форме и не забыть дописать форме enctype="multipart/form-data"
*/
function validationCallDocuments(form) {
	var thisForm = $(form);
	var formData = new FormData($(form)[0]);

	$.each(thisForm.find('input[type="file"]')[0].files, function (index, file) {
		formData.append('file[' + index + ']', file);
	});

	$.ajax({
		url: thisForm.attr('action'),
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		cache: false,
		error:	function(err){
			$('.copyright').append(err);
		},
		success: function success(response){
			if(response != 'success'){
				$('.copyright').append(response);
			}
			thisForm.trigger("reset");
			popNext("#call_success", "call-popup");
		}
	});
}

/**
* Mask on input(russian telephone)
*/
function Maskedinput(){
	if($('.tel-mask')){
		$('.tel-mask').mask('+9 (999) 999-99-99 ');
	}
	if($('.time2')){
		$('.time2').mask('9 9');
	}
	if($('.time1')){
		$('.time1').mask('99');
	}
	if($('.number')){
		$('.number').mask('9 9 9 9');
	}
	if($('.cvv')){
		$('.cvv').mask('9 9 9');
	}
}

/**
* Fansybox on form
*/
function fancyboxForm() {
	$('.fancybox-form').fancybox({
		baseClass: 'fancybox-form'
	});
}

$(document).ready(function () {
	validate('#call-popup .contact-form', { submitFunction: validationCall });
	validate('.ask-form', { submitFunction: validationCall });
	validate('.call-back-form', { submitFunction: validationCall });
	validate('.vacancy-form', { submitFunction: validationCallDocuments });
	//validate('.reg-form', { submitFunction: validationCall });
	validate('.login-form', { submitFunction: validationCall });
	validate('.recovery-form', { submitFunction: validationCall });
	validate('.request-form', { submitFunction: validationCall });
	validate('.change-pass-form', { submitFunction: validationCallPatchMethod });
	Maskedinput();
	fancyboxForm();
});
//# sourceMappingURL=validate_script.js.map
