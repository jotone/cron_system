@extends('layout.default')
@section('content')
<div class="global-wrapper">
		<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->
	<!-- MAIN -->
	<div class="main">
		<!-- add partials here -->
		<section class="contacts">
			<div class="text-box">
				<div class="breadcrumbs-box">
					<div class="mbox2">
						<ul>
							<li><a href="{{ route('home') }}">Главная</a></li>
							<li>Контакты</li>
						</ul>
					</div>
				</div>

				<div class="title-box">
					<h2>Контакты</h2>
				</div>
			</div>

			<div class="map-box">
				<div id='myMap'></div>
				<div class="contact-box">
					<ul>
						<li>
							<a href="tel:+{{str_replace([' ','(',')','-'],'',$defaults['info']['phone'])}}">+{{ $defaults['info']['phone'] }}</a>
						</li>
						<li>
							<a href="mailto:{{$defaults['info']['email']}}">{{$defaults['info']['email']}}</a>
						</li>
						<li>
							<h5>Время работы:</h5>
							{!!$defaults['info']['work_time'] !!}
						</li>
						<li>
							<h5>Адрес: </h5>
							{!! $defaults['info']['address'] !!}
						</li>
					</ul>
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