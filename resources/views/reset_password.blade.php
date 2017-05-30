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
					<h1>Востановить пароль</h1>
					<form action="ajax.php" name="reg-form" class="reg-form">
						<div class="form-field">
							<label for="RecEmail">Ваша почта</label>
							<input id="RecEmail" type="text" name="email" required />
						</div>
						<button type="submit" class="button-round">Отправить</button>
					</form>
				</div>
			</div>
		</section>
	</div>
	<!-- /MAIN -->
</div>
@stop