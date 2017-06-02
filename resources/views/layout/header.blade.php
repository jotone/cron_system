<?php
$user = Auth::user();
?>
<header class="header" id="header">
	<div class="top-header">
		<div class="mbox2">
			<div class="wrapper">
				<a href="#ask_popup" class="ask js_popup">Задать вопрос</a>
				<a href="tel:+74957450480" class="tel">
					<span><img src="{{ URL::asset('images/tel.png') }}" alt=""></span>+7 (495)745-04-80
				</a>
				<a href="mailto:hello@gmail.com" class="tel">
					<span><img src="{{ URL::asset('images/mail.png') }}" alt=""></span>hello@gmail.com
				</a>
				@if(!$user)
				<a href="{{ route('login-page') }}" class="regist">
					<span><img src="{{ URL::asset('images/lock.png') }}" alt=""></span>Вход\Регистрация
				</a>
				@else
				<a href="{{ route('user-panel') }}" class="regist">Личный кабинет</a>
				<a href="{{ route('logout') }}" class="regist">Выйти</a>
				@endif
			</div>
		</div>
	</div>
	<div class="bottom-header">
		<div class="mbox2">
			<div class="wrapper">
				<div class="logo">
					<a href="{{ route('home') }}"><img src="{{ URL::asset('images/logo-wh.png') }}" alt=""></a>
				</div>
				<div class="right-header">
					<a href="#" class="header-burger"><span></span></a>
					<div class="header-menu">
						<ul>
						@foreach($defaults['top_menu'] as $item)
							<li><a href="{{ URL::asset($item->slug) }}">{{ $item->title }}</a></li>
						@endforeach
						</ul>
						<a href="#" class="close"></a>
					</div>
					<div class="search">
						<form>
							<input type="text" name="search" class="search-input" placeholder="Поиск...">
							<button type="submit" class="submit">
								<img src="{{ URL::asset('images/search.png') }}" alt="">
							</button>
						</form>
					</div>
					<div class="busket">
						<a href="#">
							<img src="{{ URL::asset('images/busket.png') }}" alt="">
							<span class="busket-count">1</span>
						</a>
					</div>
					<div class="busket-popup">
						<div class="busket-title">
							<div class="txt">
								<h5>В корзине 2 товар</h5>
								<p>на сумму 996 руб</p>
							</div>
							<a href="#" class="close"></a>
						</div>
						<div class="busket-item">
							<div class="pic"><img src="images/indesign.png" alt=""></div>
							<div class="item-name">
								<a href="#">Our Legacy Splash Jacquard</a>
								<span>498 руб</span>
							</div>
							<div class="delete"></div>
						</div>
						<div class="busket-item">
							<div class="pic"><img src="images/indesign.png" alt=""></div>
							<div class="item-name">
								<a href="#">Our Legacy Splash Jacquard</a>
								<span>498 руб</span>
							</div>
							<div class="delete"></div>
						</div>
						<a href="#" class="button-invers">ОФОРМИТЬ ЗАКАЗ</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="header-huge-menu">
		<div class="mbox2">
			<div class="top-menu">
				<div class="search">
					<form action="ajax.php">
						<input type="text" name="search" class="search-input" placeholder="Поиск...">
						<button type="submit" class="submit">go</button>
					</form>
				</div>
				<a href="#" class="close">Назад<span></span></a>
			</div>
			<div class="bottom-menu">
				{!! $defaults['brands'] !!}
			</div>
		</div>
	</div>
</header>