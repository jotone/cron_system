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
							<li><a href="index.html">Главная</a></li>
							<li>О Компании</li>
						</ul>
					</div>
				</div>

				<div class="wrap-text">

					<img src="../images/about-us-image.png" alt="image">

					<h2 style="font-size: 36px;font-weight: 700;">О Компании</h2>
					<p style="font-size: 24px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus ac</p>
				</div>

			</div>

			<div class="map-box">

				<div id='myMap'></div>

				<div class="contact-box">

					<ul>
						<li>
							<div class="contact-icon">
								<img src="../images/icon-tel-map.png" alt="images">
							</div>
							<div class="contact-text">
								<a href="tel:+74957450480">+7 (495)745-04-80</a>
							</div>
						</li>
						<li>
							<div class="contact-icon">
								<img src="../images/icon-mail-map.png" alt="images">
							</div>
							<div class="contact-text">
								<a href="mailto:hello@gmail.com">hello@gmail.com</a>
							</div>							
						</li>
						<li>
							<div class="contact-icon">
								<img src="../images/icon-time-map.png" alt="images">
							</div>
							<div class="contact-text">
								<h5>Время работы:</h5>
								<p>Понедельник-четверг:  с 09:30 до 19:00</p>
								<p>Пятница: с 9:30 до 18:00</p>
								<p>Суббота, воскресенье - выходные дни</p>
							</div>							
						</li>
						<li>
							<div class="contact-icon">
								<img src="../images/icon-adres-map.png" alt="images">
							</div>
							<div class="contact-text">
								<h5>Адрес: </h5>
								<p>Санкт-Петербург, </p>
								<p>Набережная канала Грибоедова, дом 17</p>
							</div>							
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
@stop