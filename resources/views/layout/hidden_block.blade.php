<div class="hidden-block">
	<div id="call-message" @if(isset($err->message)) data-active="1" @endif>
		<div class="call-success-wrap">
			<!--<div class="call-success-title"></div>-->
			<div class="call-success-subtitle">
				@if(isset($err->message)) {{ $err->message }} @endif
			</div>
		</div>
	</div>

	<div id="call_success">
		<div class="call-success-wrap">
			<div class="call-success-title">Спасибо за заявку</div>
			<div class="call-success-subtitle">Мы свяжемся с Вами в ближайшее время</div>
		</div>
	</div>

	<div id="specify_price" class="specify_price">
		<div class="specify_price_wrap ask_popup">
			<form action="ajax.php" class="specify_price_form" method="POST">
				<div class="popup-title">Уточнить цену</div>
				<div class="form-field">
					<span class="field-name">Имя</span>
					<input type="text" class="el-input" name="name" required="required">
				</div>
				<div class="form-field">
					<span class="field-name">Телефон</span>
					<input type="text" class="el-input" name="tel" required="required">
				</div>
				<input type="hidden" class="product-id"  name="product_id" value="">
				<input type="submit" class="submit" value="Отправить">
			</form>
		</div>
	</div>

	<div id="call-popup">
		<form action="ajax.php" class="contact-form">
			<div class="contact-form-title">
				<!-- Title -->
			</div>
			<div class="contact-form-row cfix">
				<div class="contact-form-item">
					<div class="contact-form-item-input form_row">
						<div class="form_input">
							<input type="text" name="contact_name" required="required" value="" placeholder="Ваше Имя">
						</div>
					</div>
				</div>
				<div class="contact-form-item">
					<div class="contact-form-item-input form_row">
						<div class="form_input">
							<input type="text" name="contact_tel" value="" required="required" placeholder="Ваш номер" class="tel-mask">
						</div>
					</div>
				</div>
			</div>
			<div class="contact-form-row cfix">
				<div class="contact-form-item">
					<button type="submit" class="contact-submit">
						<span><!-- Отправить заявку  --></span>
					</button>
				</div>
			</div>
		</form>
	</div>

	<div id="ask_popup" class="ask_popup">
		<form action="{{ route('ask-question') }}" class="ask-form" method="POST">
			<div class="popup-title">Задать вопрос</div>
			<div class="form-field">
				<span class="field-name">ФИО<sup style="color: #1abbb5;">*</sup></span>
				<input type="text" class="el-input" name="name" required="required">
			</div>
			<div class="form-field">
				<span class="field-name">Организация</span>
				<input type="text" class="el-input" name="organisation">
			</div>
			<div class="form-field">
				<span class="field-name">Город<sup style="color: #1abbb5;">*</sup></span>
				<input type="text" class="el-input" name="city" required="required">
			</div>
			<div class="form-field">
				<span class="field-name">Телефон<sup style="color: #1abbb5;">*</sup></span>
				<input type="text" class="el-input" name="tel" required="required">
			</div>
			<div class="form-field radio">
				<input type="radio" class="el-radio" id="email" name="callbackType" value="Хочу, чтобы менеджер ответил мне по E-mail">
				<label for="email">Хочу, чтобы менеджер ответил мне по E-mail</label>
			</div>
			<div class="form-field radio">
				<input type="radio" class="el-radio" id="call" name="callbackType" value="Хочу, чтобы менеджер мне перезвонил">
				<label for="call">Хочу, чтобы менеджер мне перезвонил</label>
			</div>
			<div class="form-field radio">
				<input type="radio" class="el-radio" id="meet" name="callbackType" value="Хочу, чтобы менеджер приехал на встречу">
				<label for="meet">Хочу, чтобы менеджер приехал на встречу</label>
			</div>
			<div class="form-field">
				<span class="field-name">E-mail<sup style="color: #1abbb5;">*</sup></span>
				<input type="text" class="el-input" name="email" required="required">
			</div>
			<div class="form-field">
				<span class="field-name">Вопрос<sup style="color: #1abbb5;">*</sup></span>
				<textarea name="question" class="el-textarea" rows="10"></textarea>
			</div>
			<input type="submit" class="submit" value="Отправить">
		</form>
	</div>

	<div id="call_back_popup" class="ask_popup">
		<form action="{{ route('order-phone-call') }}" class="call-back-form" method="POST">
			<input name="service" type="hidden" value="">
			<div class="popup-title">Заказать звонок</div>
			<div class="form-field">
				<span class="field-name">Имя<sup style="color: #1abbb5;">*</sup></span>
				<input type="text" class="el-input" name="name" required="required">
			</div>
			<div class="form-field">
				<span class="field-name">Телефон<sup style="color: #1abbb5;">*</sup></span>
				<input type="text" class="el-input" name="tel" required="required">
			</div>
			<input type="submit" class="submit" value="Отправить">
		</form>
	</div>

	<div id="busket_popup" class="busket_popup">
		<div class="pic"></div>
		<div class="title"></div>
		<div class="product-desc">
			<div class="price"></div>
			<div class="table-col">
				<input type="number" name="count" class="js-number" value="1">
			</div>
		</div>
		<div class="buttons">
			<a href="#" class="continue">Продолжить покупки</a>
			<a href="#" class="submit">Оформить заказ</a>
		</div>
	</div>
	{{ csrf_field() }}
</div>