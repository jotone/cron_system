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
				<a href="index.html" class="enter-logo">
					<img src="{{ URL::asset('images/logo-big.png') }}" alt="">
				</a>
			</div>
			<div class="enter-content">
				<div class="enter-center">
					<h1>Вход</h1>
					<form action="{{ route('login') }}" name="recovery-form" method="POST" target="_self">
						{{ csrf_field() }}
						<div class="form-field">
							<label for="loginEmail">Ваша почта</label>
							<input type="text" id="loginEmail" name="email" @if(isset($err->email)) class="error" @endif/>
						</div>
						<div class="form-field">
							<label for="loginPass">Пароль</label>
							<input type="password" id="loginPass" name="pass" @if(isset($err->pass)) class="error" @endif/>
						</div>
						<button type="submit" class="button-round">Войти</button>
					</form>
					<div class="enter-links">
						<p>Нету аккаунта? <a href="{{ route('registration-page') }}">Регистрация</a></p>
						<p>Забыли пароль? <a href="#">Востановить</a></p>
					</div>
				</div>
			</div>
		</section>
	</div>
	<!-- /MAIN -->
</div>
@stop