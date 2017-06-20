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
					<li>Вакансии</li>
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

			@if($paginate_options['total'] > 1)
				<div class="pagination">
					@if($paginate_options['prev'] > 0)
						<a href="{{ route('vacancies') }}/page/{{ $paginate_options['prev'] }}" class="prev">&lt;</a>
					@endif

					<ul>
					@for($i = 1; $i<=$paginate_options['total']; $i++)
						<li @if($i == $paginate_options['current']) class="active" @endif>
							@if($i == $paginate_options['current'])
								{{ $i }}
							@else
								<a href="{{ route('vacancies') }}/page/{{ $i }}">{{$i}}</a>
							@endif
						</li>
					@endfor
					</ul>

					@if($paginate_options['next'] <= $paginate_options['total'])
						<a href="{{ route('vacancies') }}/page/{{ $paginate_options['next'] }}" class="next">&gt;</a>
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