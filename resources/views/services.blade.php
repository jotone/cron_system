@extends('layout.default')
@section('content')
<div class="global-wrapper">
		<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->

	<!-- MAIN -->
	<div class="main">
		<!-- add partials here -->
		<section class="services">
			<div class="action">
				<div class="mbox2">
					<div class="title-box">
						<h1 style="color: dimgrey;font-size: 48px;font-weight: 700;">Акции</h1>
						<h2 style="font-size: 36px;">Финальная разпродажа весны</h2>
						<p style="font-size: 24px;">Срок акции истекает 28 мая</p>
					</div>

					<div class="timer-box">
						<div class="timear aos-init aos-animate" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
							<div id="close-timer1">
								<div class="convert-timer cfix">
									<div class="timer-item item-days">
										<span class="days"></span>
										<p>дней</p>
									</div>

									<div class="timer-item item-hours">
										<span class="hours"></span>
										<p>часов</p>
									</div>

									<div class="timer-item item-minutes">
										<span class="minutes"></span>
										<p>минуты</p>
									</div>

									<div class="timer-item item-seconds">
										<span class="seconds"></span>
										<p>секунд</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="text-box">
				<div class="text-block-wrap">
					<div class="mbox4">
						<div class="text-block text-left">
							<img src="{{ URL::asset('images/services-info1.png') }}" alt="image">
							<h2 style="font-size: 36px;font-weight: 600;">Услуга и решение</h2>
							<p style="font-size: 24px">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. </p>
							<a href="#call_back_popup" class="js_popup">Заказать звонок</a>
						</div>
					</div>
				</div>

				<div class="text-block-wrap">
					<div class="mbox4">
						<div class="text-block text-right">
							<img src="{{ URL::asset('images/services-info2.png') }}" alt="image">
							<h2 style="font-size: 36px;font-weight: 600;">Услуга и решение</h2>
							<p style="font-size: 24px">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. </p>
							<a href="#call_back_popup" class="js_popup">Заказать звонок</a>
						</div>
					</div>
				</div>

				<div class="text-block-wrap">
					<div class="mbox4">
						<div class="text-block text-left">
							<img src="{{ URL::asset('images/services-info3.png') }}" alt="image">
							<h2 style="font-size: 36px;font-weight: 600;">Услуга и решение</h2>
							<p style="font-size: 24px">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. </p>
							<a href="#call_back_popup" class="js_popup">Заказать звонок</a>
						</div>
					</div>
				</div>
			</div>

			<div class="text-box-SEO">
				<div class="title-box">
					<h2 style="font-size: 36px;font-weight: 600;">СЕО Блок</h2>
				</div>
				<p style="font-size: 25px">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.</p>
				<a href="#ask_popup" class="js_popup">Задать вопрос</a>
			</div>
		</section>
	</div>
	<!-- /MAIN -->

	<!-- FOOTER -->
	@include('layout.footer')
	<!-- /FOOTER -->
</div>
@stop