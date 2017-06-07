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
				@foreach($vacancies as $vacancy)
					<li>
						<div class="vacancy-title">
							<h2>{{ $vacancy['title'] }}</h2>
						</div>
						<div class="vacancy-pic">
							@if(!empty($vacancy['img_url']->img))
							<img src="{{ URL::asset($vacancy['img_url']->img) }}" alt="{{ $vacancy['img_url']->alt }}">
							@endif
						</div>
						<div class="vacancy-content">
							<p>{{ $vacancy['text'] }}</p>
						</div>
						<a href="{{ route('vacancies-inner', $vacancy['slug']) }}" class="button-round">Подробнее</a>
					</li>
				@endforeach
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