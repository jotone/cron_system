@extends('layout.default')
@section('content')
<div class="global-wrapper">
	<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->

	<!-- MAIN -->
	<div class="main bread-light">
		<!-- add partials here -->
		<div class="breadcrumbs">
			<div class="mbox2">
				<ul class="breadcrumbs-list">
					<li><a href="{{ route('home') }}">Главная</a></li>
					<li><a href="{{ route('catalog') }}">Каталог</a></li>
					<li>This Page</li>
				</ul>
			</div>
		</div>
		<section class="request">
			<h1>Запросить цену</h1>
			<div class="request-inner">
				<div class="request-top">
					<div class="product-item hot-item">
						<div class="pic">
							<img src="{{ URL::asset('images/psCS6.jpg') }}" alt="">
							<div class="hot">hot</div>
						</div>
					</div>
					<div class="product-content">
						<h2>Furniture for Home</h2>
						<div class="product-info">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor.</p>
						</div>
					</div>
				</div>
				<form action="ajax-programer.php" name="request" class="request-form">
					<div class="fields-wrap">
						<div class="request-col">
							<div class="form-field">
								<label for="request-name">Ваше имя<span style="color:#00b3ad;font-weight:700;font-size: 18px;">*</span></label>
								<input id="request-name" class="el-input" type="text" name="name" required />
							</div>
							<div class="form-field">
								<label for="request-email">E-mail<span style="color:#00b3ad;font-weight:700;font-size: 18px;">*</span></label>
								<input id="request-email" class="el-input" type="text" name="email" required />
							</div>
						</div>
						<div class="request-col">
							<div class="form-field">
								<label for="request-tel">Телефон<span style="color:#00b3ad;font-weight:700;font-size: 18px;">*</span></label>
								<input id="request-tel" class="el-input" type="text" name="tel" required />
							</div>
							<div class="form-field">
								<label for="request-firm">Организация<span style="color:#00b3ad;font-weight:700;font-size: 18px;">*</span></label>
								<input id="request-firm" class="el-input" type="text" name="firm" required />
							</div>
						</div>
						<div class="request-col">
							<div class="form-field">
								<label for="request-text">Вопрос<span style="color:#00b3ad;font-weight:700;font-size: 18px;">*</span></label>
								<textarea id="request-text" class="el-textarea" name="text" required></textarea>
							</div>
						</div>
					</div>
					<button type="submit" class="button-round">Отправить</button>
				</form>
			</div>
		</section>
	</div>
	<!-- /MAIN -->

	<!-- FOOTER -->
	@include('layout.footer')
	<!-- /FOOTER -->
</div>
@stop