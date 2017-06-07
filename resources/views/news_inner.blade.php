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
					<li><a href="{{ route('news') }}">Новости</a></li>
					<li>{{ $content->title }}</li>
				</ul>
			</div>
		</div>
		<section class="news-inner">
			<div class="title">
				<h1>{{ $content->title }}</h1>
			</div>
			<div class="news-content">
				{!! $content->text !!}
			</div>
			@if(count($also_reading) > 0)
			<div class="news-popular">
				<div class="mbox">
					<div class="title-line line-white">
						<h2>Так же читают</h2>
					</div>
					<ul class="news-popular-list">
						@foreach($also_reading as $item)
						<li>
							<div class="popular-pic">
								<img src="{{ URL::asset($item['img_url']->img) }}" alt="{{ $item['img_url']->alt }}">
							</div>
							<div class="popular-content">
								<a href="{{ route('news-inner', $item['slug']) }}" class="button-invers">Подробнее</a>
								<h6>{{ $item['title'] }}</h6>
								<div class="popular-info">
									<p>{{ $item['text'] }}</p>
								</div>
							</div>
						</li>
						@endforeach
					</ul>
				</div>
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