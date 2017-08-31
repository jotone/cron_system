<?php
$user = Auth::user();
?>
<header class="header" id="header">
	<div class="top-header">
		<div class="mbox2">
			<div class="wrapper">
				<a href="#ask_popup" class="ask js_popup">Задать вопрос</a>
				<a href="tel:+{{str_replace([' ','(',')','-'],'',$defaults['info']['phone'])}}" class="tel">
					<span><img src="{{ URL::asset('images/tel.png') }}" alt=""></span>+{{$defaults['info']['phone']}}
				</a>
				<a href="mailto:{{$defaults['info']['email']}}" class="tel">
					<span><img src="{{ URL::asset('images/mail.png') }}" alt=""></span>{{$defaults['info']['email']}}
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
						<form action="{{ route('search') }}">
							<input type="text" name="search" value="@if(isset($_GET['search'])){{ $_GET['search']}}@endif" class="search-input" placeholder="Поиск...">
							<button type="submit" class="submit">
								<img src="{{ URL::asset('images/search.png') }}" alt="">
							</button>
						</form>
					</div>
					@if(!isset($deny_basket))
					<div class="busket">
						<a href="#">
							<img src="{{ URL::asset('images/busket.png') }}" alt="">
							<img src="{{ URL::asset('images/busket-hover.png') }}" class="busket-img-hover" alt="">
							<span class="busket-count" style="display: none"></span>
						</a>
					</div>
					<div class="busket-popup">
						<div class="busket-title">
							<div class="txt">
								<h5>В корзине <span></span></h5>
								<p>на сумму <span></span> руб</p>
							</div>
							<a href="#" class="close"></a>
						</div>
						<div class="cart-wrap"></div>
						<a href="{{ route('shopping_cart') }}" class="button-invers">ОФОРМИТЬ ЗАКАЗ</a>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
	<div class="header-huge-menu">
		<div class="mbox2">
			<div class="top-menu">
				<div class="search">
					<form action="{{ route('search') }}">
						<input type="text" name="search" class="search-input" value="@if(isset($_GET['search'])){{ $_GET['search']}}@endif" placeholder="Поиск...">
						<button type="submit" class="submit"><img src="{{ URL::asset('images/search.png') }}" alt=""></button>
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