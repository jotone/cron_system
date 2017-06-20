@extends('layout.default')
@section('content')
<div class="global-wrapper">
		<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->
	<div class="main">
		<!-- add partials here -->
		<section class="equipment">
			<div class="breadcrumbs-box">
				<div class="mbox2">
					<ul>
						<li><a href="{{ route('home') }}">Главная</a></li>
						<li>Оборудование</li>
					</ul>
				</div>
			</div>

			<div class="title-box">
				<h2 style="font-size: 36px;font-weight: 700;">Оборудование</h2>
			</div>

			<div class="text-box-right">
				{!! $content['text']->value !!}
			</div>

			@if( (isset($seo)) && ($seo['need_seo'] > 0) )
				<div class="catalog-seo">
					<h2>{{ $seo['title'] }}</h2>
					<div class="catalog-text">{!! $seo['text'] !!}</div>
					<a href="#ask_popup" class="button-round js_popup">Задать вопрос</a>
				</div>
			@endif
		</section>

	</div>
	<!-- FOOTER -->
	@include('layout.footer')
	<!-- /FOOTER -->
</div>
@stop