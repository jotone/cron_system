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
							<a href="tel:+74957450480">+7 (495)745-04-80</a>
						</li>
						<li>
							<a href="mailto:hello@gmail.com">hello@gmail.com</a>
						</li>
						<li>
							<h5>Время работы:</h5>
							<p>Понедельник-четверг:  с 09:30 до 19:00</p>
							<p>Пятница: с 9:30 до 18:00</p>
							<p>Суббота, воскресенье - выходные дни</p>
						</li>
						<li>
							<h5>Адрес: </h5>
							<p>Санкт-Петербург, </p>
							<p>Набережная канала Грибоедова, дом 17</p>
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