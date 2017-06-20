@extends('layout.default')
@section('content')
<div class="global-wrapper">
	<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->
	<!-- MAIN -->
	<div class="main">
		<!-- add partials here -->
		<section class="about-us">
			<div class="text-box">
				<div class="breadcrumbs-box">
					<div class="mbox2">
						<ul>
							<li><a href="{{ route('home') }}">Главная</a></li>
							<li>О Компании</li>
						</ul>
					</div>
				</div>

				<div class="wrap-text">
					<img src="{{ URL::asset($content['page']->value->img) }}" alt="image">
					<h2 style="font-size: 36px;font-weight: 700;">О Компании</h2>
					{!! $content['text']->value !!}
				</div>
			</div>

			<div class="map-box">
				<div id='myMap'></div>
				<div class="contact-box">
					<ul>
						<li>
							<div class="contact-icon">
								<img src="{{ URL::asset('images/icon-tel-map.png') }}" alt="images">
							</div>
							<div class="contact-text">
								<a href="tel:+{{str_replace([' ','(',')','-'],'',$defaults['info']['phone'])}}">+{{ $defaults['info']['phone'] }}</a>
							</div>
						</li>
						<li>
							<div class="contact-icon">
								<img src="{{ URL::asset('images/icon-mail-map.png') }}" alt="images">
							</div>
							<div class="contact-text">
								<a href="mailto:{{$defaults['info']['email']}}">{{$defaults['info']['email']}}</a>
							</div>
						</li>
						<li>
							<div class="contact-icon">
								<img src="{{ URL::asset('images/icon-time-map.png') }}" alt="images">
							</div>
							<div class="contact-text">
								<h5>Время работы:</h5>
								{!!$defaults['info']['work_time'] !!}
							</div>
						</li>
						<li>
							<div class="contact-icon">
								<img src="{{ URL::asset('images/icon-adres-map.png') }}" alt="images">
							</div>
							<div class="contact-text">
								<h5>Адрес: </h5>
								{!! $defaults['info']['address'] !!}
							</div>
						</li>
					</ul>
				</div>
			</div>

			@if( (isset($seo)) && ($seo['need_seo'] > 0) )
			<div class="catalog-seo">
				<h2>{{ $seo['title'] }}</h2>
				<div class="catalog-text">
					{!! $seo['text'] !!}
				</div>
				<a href="#ask_popup" class="button-round js_popup">Задать вопрос</a>
			</div>
			@endif
		</section>
	</div>
	<!-- /MAIN -->

	<!-- FOOTER -->
	@include('layout.footer')
	<!-- /FOOTER -->
</div>
@stop