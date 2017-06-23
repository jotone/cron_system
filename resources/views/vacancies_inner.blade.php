@extends('layout.default')
@section('content')
<?php $user = Auth::user(); ?>
<div class="global-wrapper">
	<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->

	<!-- MAIN -->
	<div class="main">
		<!-- add partials here -->
		<div class="breadcrumbs">
			<div class="mbox2">
				<ul class="breadcrumbs-list">
					<li><a href="{{ route('home') }}">Главная</a></li>
					<li><a href="{{ route('vacancies') }}">Вакансии</a></li>
					<li>{{ $content['title'] }}</li>
				</ul>
			</div>
		</div>
		<section class="vacancies-inner">
			<div class="title">
				<h1>Вакансия</h1>
			</div>
			@if(isset($content['img_url']->img))
			<div class="vacancy-pic">
				<img src="{{ URL::asset($content['img_url']->img) }}" alt="{{ $content['img_url']->alt }}">
			</div>
			@endif
			<div class="vacancy-content">
				<div class="vacancy-wrap">
					<div class="vacancy-left">
						{!! $content['text'] !!}
					</div>
					<div class="vacancy-right">
						<form action="{{ route('vacancies-send-resume') }}" name="vacancy" class="vacancy-form" method="POST">
							{{ csrf_field() }}
							<input name="vacancy" type="hidden" value="{{ $content['id'] }}">
							<h6>Оставить резюме</h6>
							<div class="fields-wrap">
								<div class="form-field">
									<input type="text" name="name" placeholder="Имя" required="required" @if($user) value="{{ $user['name'] }}" @endif/>
								</div>
								<div class="form-field">
									<input type="text" name="tel" placeholder="Телефон" required="required" @if($user) value="{{ $user['phone'] }}" @endif/>
								</div>
								<div class="form-field">
									<input type="text" name="email" placeholder="Почта" required="required" @if($user) value="{{ $user['email'] }}" @endif/>
								</div>
							</div>
							<div class="file-field">
								<input type="file" name="file" class="js-file" data-placeholder="Загрузить резюме" data-browse="" required="required">
								<a href="#" class="button-round js-remove">Удалить</a>
							</div>
							<button type="submit" class="button-round">Отправить</button>
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
	<!-- /MAIN -->

	<!-- FOOTER -->
	@include('layout.footer')
	<!-- /FOOTER -->
</div>
@stop