@extends('layout.default')
@section('content')
<?php
$user = Auth::user();
?>
<div class="global-wrapper">
	<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->

	<!-- MAIN -->
	@if($user)
	<div class="main">
		<!-- add partials here -->
		<section class="private-office">
			<div class="mbox2">
				<div class="breadcrumbs-box">
					<ul>
						<li><a href="index.html">Главная</a></li>
						<li><a href="private_office.html">Личный кабинет</a></li>
					</ul>
				</div>

				<div class="office-box">
					<div class="nav-bar">
						<div id="office-title" class="title-box">
							<h2 style="font-size:36px">Личный кабинет</h2>
						</div>

						<ul class="office-tab-links">
							<li>
								<a href="#">Личная информация</a>
							</li>
							<li>
								<a href="#">История покупок</a>
							</li>
							<li>
								<a href="#">Статус заказов</a>
							</li>
							<li>
								<a href="#">Сменить почту</a>
							</li>
							<li>
								<a href="#">Сменить пароль</a>
							</li>
							<li>
								<a href="#" class="escape">Выход</a>
							</li>
						</ul>
					</div>

					<div class="office-content-box">
						<div class="office-tab">
							<a href="#" class="office-link">
								<span class="pic"><img src="{{ URL::asset('images/privat-info.png') }}" alt=""></span>
								<p>Личная информация</p>
							</a>
							<a href="#" class="office-link">
								<span class="pic"><img src="{{ URL::asset('images/history-buy.png') }}" alt=""></span>
								<p>История покупок</p>
							</a>
							<a href="#" class="office-link">
								<span class="pic"><img src="{{ URL::asset('images/status-buy.png') }}" alt=""></span>
								<p>Статус заказов</p>
							</a>
							<a href="#" class="office-link">
								<span class="pic"><img src="{{ URL::asset('images/change-mail.png') }}" alt=""></span>
								<p>Сменить почту</p>
							</a>
							<a href="#" class="office-link">
								<span class="pic"><img src="{{ URL::asset('images/change-password.png') }}" alt=""></span>
								<p>Сменить пароль</p>
							</a>
							<a href="#" class="office-link escape">
								<span class="pic"><img src="{{ URL::asset('images/office-exit.png') }}" alt=""></span>
								<p>Выход</p>
							</a>
						</div>

						<div class="office-tab">
							<div class="change-privat-info-form">
								<div class="title-box">
									<h3 style="font-size: 36px">Личная информация</h3>
								</div>

								<div class="forms-box">
									<div class="forms-box-row">
										<form>
											<input name="userName" type="text" class="element-input" disabled placeholder="Имя" @if(isset($data)) value="{{ $data['name'] }}" @endif>
											<button class="change-button-form" type="button">сменить</button>
										</form>

										<form>
											<input name="userPhone" type="text" class="element-input" disabled placeholder="Телефон" @if(isset($data)) value="{{ $data['phone'] }}" @endif>
											<button class="change-button-form" type="button">сменить</button>
										</form>
									</div>

									<div class="forms-box-row">
										<form class="fix-name-organisation">
											<input name="userOrg" type="text" class="element-input" disabled placeholder="Название организации" @if(isset($data)) value="{{ $data['org_caption'] }}" @endif>
											<button class="change-button-form" type="button">сменить</button>
										</form>

										<form class="fix-inn-organisation">
											<input name="userOrgTID" type="text" class="element-input" disabled placeholder="ИНН организации" @if(isset($data)) value="{{ $data['org_tid'] }}" @endif>
											<button class="change-button-form" type="button">сменить</button>
										</form>
									</div>

									<div class="forms-box-row">
										<form class="fix-adres-delivery">
											<input name="userAddr" type="text" class="element-input" disabled placeholder="Адрес доставки товара" @if(isset($data)) value="{{ $data['address'] }}" @endif>
											<button class="change-button-form" type="button">сменить</button>
										</form>

										<form class="fix-adres-correspondence">
											<input name="userCorresp" type="text" class="element-input" disabled placeholder="Адрес доставки корреспонденции" @if(isset($data)) value="{{ $data['correspondence'] }}" @endif>
											<button class="change-button-form" type="button">сменить</button>
										</form>
									</div>
								</div>
							</div>
						</div>

						<div class="office-tab">
							<div class="history">
								<div class="title-box">
									<h3 style="font-size: 36px">История покупок</h3>
								</div>

								<div class="history-table">
									<div class="history-row history-header">
										<div class="history-col">Название</div>
										<div class="history-col">Артикуль</div>
										<div class="history-col">Сумма</div>
										<div class="history-col">Статус</div>
									</div>

									<div class="history-row">
										<div class="history-col">Panel content</div>
										<div class="history-col">012642</div>
										<div class="history-col"><div class="summ">25 000 руб</div></div>
										<div class="history-col">В процессе</div>
									</div>

									<div class="history-row">
										<div class="history-col">Panel content</div>
										<div class="history-col">012642</div>
										<div class="history-col"><div class="summ">200 руб</div></div>
										<div class="history-col">Отменён</div>
									</div>

									<div class="history-row">
										<div class="history-col">Panel content</div>
										<div class="history-col">012642</div>
										<div class="history-col"><div class="summ">8 000 руб</div></div>
										<div class="history-col">Выполнен</div>
									</div>

									<div class="history-row">
										<div class="history-col">Panel content</div>
										<div class="history-col">012642</div>
										<div class="history-col"><div class="summ">25 000 руб</div></div>
										<div class="history-col">В процессе</div>
									</div>

									<div class="history-row">
										<div class="history-col">Panel content</div>
										<div class="history-col">012642</div>
										<div class="history-col"><div class="summ">200 руб</div></div>
										<div class="history-col">Отменён</div>
									</div>

									<div class="history-row">
										<div class="history-col">Panel content</div>
										<div class="history-col">012642</div>
										<div class="history-col"><div class="summ">8 000 руб</div></div>
										<div class="history-col">Выполнен</div>
									</div>

									<div class="history-row">
										<div class="history-col">Panel content</div>
										<div class="history-col">012642</div>
										<div class="history-col"><div class="summ">8 000 руб</div></div>
										<div class="history-col">Выполнен</div>
									</div>
								</div>
							</div>
						</div>

						<div class="office-tab"></div>
						<div class="office-tab">
							<div class="change-privat-info-form">
								<div class="title-box">
									<h3 style="font-size: 36px">Сменить почту</h3>
								</div>
								<div class="user-panel-form">
									<form action="{{ route('email-change') }}" class="action-form" method="POST" target="_self">
										<input name="_method" type="hidden" value="PATCH">
										{{ csrf_field() }}
										<div class="form-field">
											<label for="loginEmail">Ваша почта</label>
											<input type="text" id="loginEmail" name="email" value="{{ $user['email'] }}">
										</div>
										<div class="form-field">
											<label for="loginPass">Чтобы сменить почту, введите ваш пароль</label>
											<input type="password" id="loginPass" name="password">
										</div>
										<input type="submit" class="button-round" value="Сменить">
									</form>
								</div>
							</div>
						</div>

						<div class="office-tab">
							<div class="change-privat-info-form">
								<div class="title-box">
									<h3 style="font-size: 36px">Сменить пароль</h3>
								</div>
								<div class="user-panel-form">
									<form action="{{ route('password-change') }}" class="action-form change-pass-form" method="POST" target="_self">
										<input name="_method" type="hidden" value="PATCH">
										{{ csrf_field() }}
										<div class="form-field">
											<label for="loginEmail">Старый пароль</label>
											<input type="password" name="old_password" required="required">
										</div>
										<div class="form-field">
											<label for="loginPass">Новый пароль</label>
											<input type="password" name="new_password" required="required">
										</div>
										<div class="form-field">
											<label for="loginPass">Подтвердите новый пароль</label>
											<input type="password" name="conf_new_password" required="required">
										</div>
										<input type="submit" class="button-round" value="Сменить">
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	@endif
	<!-- /MAIN -->

	<!-- FOOTER -->
	@include('layout.footer')
	<!-- /FOOTER -->
</div>
@stop