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
					<li>Новости</li>
				</ul>
			</div>
		</div>
		<section class="news">
			<div class="news-wrap">
				<div class="title">
					<h1>Новости</h1>
				</div>
				<ul>
				@foreach($news as $new)
					<li>
						<div class="news-pic">
						@if(!empty($new['img_url']->img))
							<img src="{{ URL::asset($new['img_url']->img) }}" alt="{{ $new['img_url']->alt }}">
						@endif
						</div>
						<div class="item-content">
							<div class="news-icon">
								<img src="{{ URL::asset('images/news-icon.png') }}" alt="">
							</div>
							<h6>{{ $new['title'] }}</h6>
							<div class="news-info">
								<p>{!! $new['text'] !!}</p>
							</div>
							<a href="{{ route('news-inner', $new['slug']) }}" class="button-round">Подробнее</a>
						</div>
					</li>
				@endforeach
				</ul>
			</div>

			@if($paginate_options['total'] > 1)
			<div class="pagination">
				@if($paginate_options['prev'] > 0)
					<a href="{{ route('news') }}/page/{{ $paginate_options['prev'] }}" class="prev">&lt;</a>
				@endif

				<ul>
				@for($i = 1; $i<=$paginate_options['total']; $i++)
					<li @if($i == $paginate_options['current']) class="active" @endif>
					@if($i == $paginate_options['current'])
						{{ $i }}
					@else
						<a href="{{ route('news') }}/page/{{ $i }}">{{$i}}</a>
					@endif
					</li>
				@endfor
				</ul>

				@if($paginate_options['next'] <= $paginate_options['total'])
					<a href="{{ route('news') }}/page/{{ $paginate_options['next'] }}" class="next">&gt;</a>
				@endif
			</div>
			@endif

			@if( (isset($seo)) && ($seo['need_seo'] > 0) )
				<div class="catalog-seo">
					<h2>{{ $seo['title'] }}</h2>
					<div class="catalog-text">{!! $seo['text'] !!}</div>
					<a href="#ask_popup" class="button-round js_popup">Задать вопрос</a>
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
