@extends('layout.default')
@section('content')
<?php
$err = [];
if(!empty($errors->all())){
	$err = $errors->all();
	$err = json_decode($err[0]);
}
?>
<div class="global-wrapper">
<!-- MAIN -->
	<div class="main">
		<!-- add partials here -->
		<section class="enter">
			<div class="enter-top">
				<a href="{{ route('home') }}" class="enter-logo">
					<img src="{{ URL::asset('images/logo-big.png') }}" alt="">
				</a>
			</div>
			<div class="enter-content">
				<div class="enter-center">
					<h1>Регистрация</h1>
					<form action="{{ route('registration') }}" name="reg-form" class="reg-form" method="POST" target="_self">
						{{ csrf_field() }}
						<div class="form-field">
							<label for="regEmail">Ваша почта</label>
							<input id="regEmail" type="text" name="email" @if(isset($err->email)) class="error" @endif/>
						</div>
						<div class="form-field">
							<label for="regPass">Пароль</label>
							<input id="regPass" type="password" name="pass" @if(isset($err->pass)) class="error" @endif/>
						</div>
						<div class="form-field">
							<label for="regConfirmPass">Повторите пароль</label>
							<input id="regConfirmPass" type="password" name="confimPass" @if(isset($err->confimPass)) class="error" @endif/>
						</div>
						<button type="submit" class="button-round">Зарегестрироваться</button>
					</form>
					<div class="enter-links">
						<p>Уже есть аккаунт? <a href="{{ route('login-page') }}">Войти</a></p>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
<!-- /MAIN -->
@stop