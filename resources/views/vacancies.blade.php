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
		<section class="vacancies">
			<div class="vacancies-wrap">
				<div class="title">
					<h1>Вакансии</h1>
				</div>
				<ul>
					<li>
						<div class="vacancy-title">
							<h2>Вакансия 1</h2>
						</div>
						<div class="vacancy-pic">
							<img src="{{ URL::asset('images/vacancy1.jpg') }}" alt="">
						</div>
						<div class="vacancy-content">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum.</p>
						</div>
						<a href="#" class="button-round">Подробнее</a>
					</li>
					<li>
						<div class="vacancy-title">
							<h2>Вакансия 2</h2>
						</div>
						<div class="vacancy-pic">
							<img src="{{ URL::asset('images/vacancy2.jpg') }}" alt="">
						</div>
						<div class="vacancy-content">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum.</p>
						</div>
						<a href="#" class="button-round">Подробнее</a>
					</li>
					<li>
						<div class="vacancy-title">
							<h2>Вакансия 3</h2>
						</div>
						<div class="vacancy-pic">
							<img src="{{ URL::asset('images/vacancy3.jpg') }}" alt="">
						</div>
						<div class="vacancy-content">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum.</p>
						</div>
						<a href="#" class="button-round">Подробнее</a>
					</li>
				</ul>
			</div>
		</section>
	</div>
	<!-- /MAIN -->

	<!-- FOOTER -->
	@include('layout.footer')
	<!-- /FOOTER -->
</div>
@stop