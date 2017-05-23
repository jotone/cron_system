@extends('layout.default')
@section('content')
<div class="global-wrapper">
		<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->

	<!-- MAIN -->
	<div class="main bread-light">
		<!-- add partials here -->
		<div class="breadcrumbs">
			<div class="mbox2">
				<ul class="breadcrumbs-list">
					<li><a href="{{ route('home') }}">Главная</a></li>
					<li><a href="{{ route('registration-page') }}">Регистрация</a></li>
					<li><a href="#">Регистрация провалена</a></li>
				</ul>
			</div>
		</div>
		<section class="wrap-thanks">
			<div class="mbox">
				<div class="thanks">
					<h2>Увы, НО!!</h2>
					<p style="font-size: 30px; line-height: 36px;">Срок ключа регистрации истек.</p>
					<p style="font-size: 30px; line-height: 36px;">Попробуйте пройти регистрацию</p>
					<p style="font-size: 30px; line-height: 36px;">заново.</p>
					<a href="{{ route('registration-page') }}" class="to-main">Регистрация<span></span></a>
				</div>
			</div>
		</section>
	</div>
</div>
<!-- /MAIN -->
<!-- FOOTER -->
@include('layout.footer')
<!-- /FOOTER -->
@stop