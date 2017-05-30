@extends('layout.default')
@section('content')
<div class="global-wrapper">
	<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->

	<!-- MAIN -->
	<div class="main">
		<!-- add partials here -->
		<div class="breadcrumbs">
			<div class="mbox2">
				<ul class="breadcrumbs-list">
					<li><a href="{{ route('home') }}">Главная</a></li>
					<li><a href="#">This Page</a></li>
				</ul>
			</div>
		</div>
		<section class="vacancies-inner">
			<div class="title">
				<h1>Вакансия</h1>
			</div>
			<div class="vacancy-pic">
				<img src="{{ URL::asset('images/vacancy-pic.jpg') }}" alt="">
			</div>
			<div class="vacancy-content">
				<div class="vacancy-wrap">
					<div class="vacancy-left">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.</p>
					</div>
					<div class="vacancy-right">
						<form action="ajax.php" name="vacancy" class="vacancy-form">
							<h6>Оставить резюме</h6>
							<div class="fields-wrap">
								<div class="form-field">
									<input type="text" name="name" placeholder="Имя" required />
								</div>
								<div class="form-field">
									<input type="text" name="tel" placeholder="Телефон" required />
								</div>
								<div class="form-field">
									<input type="text" name="email" placeholder="Почта" required />
								</div>
							</div>
							<div class="file-field">
								<input type="file" class="js-file" data-placeholder="Загрузить резюме" data-browse="">
								<a href="#" class="button-round js-remove">Удалить</a>
							</div>
							<button type="submit" class="button-round">Отправить</button>
						</form>
					</div>
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