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
			@if(!$interval->invert)
			<div class="action">
				<div class="mbox2">
					<div class="title-box">
						<h1 style="color: dimgrey;font-size: 48px;font-weight: 700;">Акции</h1>
						<h2 style="font-size: 36px;">{{ $promo_title }}</h2>
						<p style="font-size: 24px;">Срок акции истекает {{ $expire_date }}</p>
					</div>

					<div class="timer-box">
						<div class="timear aos-init aos-animate" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
							<div id="close-timer1">
								<div class="convert-timer cfix">
									<div class="timer-item item-days">
										<span class="days">{{ $interval->d }}</span>
										<p>дней</p>
									</div>

									<div class="timer-item item-hours">
										<span class="hours">{{ $interval->h }}</span>
										<p>часов</p>
									</div>

									<div class="timer-item item-minutes">
										<span class="minutes">{{ $interval->i }}</span>
										<p>минуты</p>
									</div>

									<div class="timer-item item-seconds">
										<span class="seconds">{{ $interval->s }}</span>
										<p>секунд</p>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			@endif

			<div class="text-box">
				@for($i=0; $i<count($services); $i++)
				<div class="text-block-wrap">
					<div class="mbox4">
						<div class="text-block @if($i%2 == 0) text-left @else text-right @endif">
							@if(!empty($services[$i]['img_url']->img))
							<img src="{{ URL::asset($services[$i]['img_url']->img) }}" alt="{{ $services[$i]['img_url']->alt }}">
							@endif
							<h2 style="font-size: 36px;font-weight: 600;">{{ $services[$i]['title'] }}</h2>
							{!! $services[$i]['text'] !!}
							<a href="#call_back_popup" data-service="{{ $services[$i]['id'] }}" class="js_popup">Заказать звонок</a>
						</div>
					</div>
				</div>
				@endfor
			</div>

			@if( (isset($seo)) && ($seo['need_seo'] > 0) )
			<div class="text-box-SEO">
				<div class="title-box">
					<h2 style="font-size: 36px;font-weight: 600;">{{ $seo['title'] }}</h2>
				</div>
				{!! $seo['text'] !!}
				<a href="#ask_popup" class="js_popup">Задать вопрос</a>
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