@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/users.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="aside-wrap">
		<div class="fixed-navigation-menu">
			<ul></ul>
		</div>
	</div>

	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">{{ $page_title }}</div>
		<div class="work-place-wrap">
			<input name="id" type="hidden" @if(isset($content['id'])) value="{{ $content['id'] }}" @endif>
			<div>
				<fieldset>
					<legend>Основные данные</legend>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="email" type="text" class="text-input col_1_2" placeholder="Email&hellip;" @if(isset($content['email'])) value="{{ $content['email'] }}" @endif>
							<span>Email</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="name" type="text" class="text-input col_1_2" placeholder="Имя&hellip;" @if(isset($content['name'])) value="{{ $content['name'] }}" @endif>
							<span>Имя</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="phone" type="text" class="text-input col_1_2" placeholder="Телефон&hellip;" @if(isset($content['phone'])) value="{{ $content['phone'] }}" @endif>
							<span>Телефон</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="org_caption" type="text" class="text-input col_1_2" placeholder="Название организации&hellip;" @if(isset($content['org_caption'])) value="{{ $content['org_caption'] }}" @endif>
							<span>Название организации</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="org_tid" type="text" class="text-input col_1_2" placeholder="ИНН организации&hellip;" @if(isset($content['org_tid'])) value="{{ $content['org_tid'] }}" @endif>
							<span>ИНН организации</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="address" type="text" class="text-input col_1_2" placeholder="Адрес доставки товара&hellip;" @if(isset($content['address'])) value="{{ $content['address'] }}" @endif>
							<span>Адрес доставки товара</span>
						</label>
					</div><div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="correspondence" type="text" class="text-input col_1_2" placeholder="Адрес доставки корреспонденции&hellip;" @if(isset($content['correspondence'])) value="{{ $content['correspondence'] }}" @endif>
							<span>Адрес доставки корреспонденции</span>
						</label>
					</div>
					@if((isset($content['activated'])) && ($content['activated'] == 0))
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="activated" type="checkbox" class="chbox-input">
							<span>Активировать пользователя</span>
						</label>
					</div>
					@endif
				</fieldset>

				<fieldset>
					<legend>Текущая роль</legend>
					<div class="row-wrap">
						<select name="role" class="select-input">
							<option value="0">Не назначена</option>
							@foreach($roles as $role)
								<option value="{{ $role->pseudonim }}" @if((isset($content['role'])) && ($content['role'] == $role->pseudonim)) selected="selected" @endif>{{ $role->title }}</option>
							@endforeach
						</select>
					</div>
				</fieldset>

				<fieldset>
					<legend>Задать новый пароль</legend>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="password" type="password" class="text-input col_1_4" placeholder="Новый пароль&hellip;">
							<span>Новый пароль</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="confirm_password" type="password" class="text-input col_1_4" placeholder="Подтвердите пароль&hellip;">
							<span>Подтвердите пароль</span>
						</label>
					</div>
				</fieldset>

				<fieldset>
					<legend>История покупок</legend>
				</fieldset>
			</div>
			<div class="button-wrap tac">
				<button name="save" class="control-button" type="button">Применить</button>
			</div>
		</div>
	</div>
</div>
@stop