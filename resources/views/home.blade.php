@extends('layout.default')
@section('content')
<div class="global-wrapper">
	<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->

	<!-- MAIN -->
	<div class="main">
		<!-- add partials here -->
		<section class="top-slider">
			<div class="index-slider">
				@foreach($content['top_article'] as $i => $slide)
					<div class="slide" style="background: url({{ URL::asset($slide->top_article->value->img) }}) no-repeat center/cover;">
						<div class="text">
							<?php $text_field = 'article_text_'.$i; ?>
							<h4>{{ $slide->article_title->value }}</h4>
							{!! $slide->$text_field->value !!}
							<a href="{{ $slide->article_link->value }}" class="button-round">Детальнее</a>
						</div>
					</div>
				@endforeach
			</div>
		</section>

		<section class="wrap-brands">
			<div class="mbox3 brands">
				<a href="javascript:void(0)" class="prev"><img src="{{ URL::asset('images/prev.png') }}" alt=""></a>
				<div class="brand-slider">
					@foreach($content['slider']->value as $slide)
						<a href="{{ $slide->alt }}" class="slide">
							<img src="{{ URL::asset($slide->img) }}" alt="">
						</a>
					@endforeach
				</div>
				<a href="javascript:void(0)" class="next"><img src="{{ URL::asset('images/prev.png') }}" alt=""></a>
			</div>
		</section>

		<section class="wrap-index-desc">
			<div class="desc-content">
				<div class="pic"><img src="{{ URL::asset('images/desc_pic.png') }}" alt=""></div>
				<div class="desc">
					<h2>{{ $content['about_block']->about_title->value }}</h2>
					{!! $content['about_block']->about_text->value !!}
					<a href="{{ $content['about_block']->about_link->value }}" class="button-round">Читать полностью</a>
				</div>
			</div>
		</section>

		<section class="wrap-popular">
			<div class="mbox">
				<div class="title-line">
					<h3>Популярные товары</h3>
				</div>
				<div class="products" data-start="0">
					@foreach($content['products'] as $product)
						<div class="product-item @if(!empty($product['is_hot'])) hot-item @endif">
							<div class="pic @if(!empty($product['price'])) to-busket @else ask-price @endif">
								@if(!empty($product['img_url']->img))
									<img src="{{ URL::asset($product['img_url']->img) }}" alt="{{ $product['img_url']->alt }}">
								@endif
								@if(!empty($product['is_hot']))
									<div class="{{ $product['is_hot'] }}">{{ $product['is_hot'] }}</div>
								@endif
							</div>
							<div class="name">
								<span class="prod-name">{{ $product['title'] }}</span>
								{!! $product['text'] !!}
							</div>
							<div class="price" data-product="{{ $product['id'] }}">
								@if(!empty($product['price']))
									<div class="prod-price">
										<span class="old">@if(!empty($product['old_price'])) $ {{ $product['old_price'] }}@endif</span>
										<span class="new">$ {{ $product['price'] }}</span>
									</div>
									<a href="#busket_popup" class="button-invers to_busket">В корзину</a>
								@else
									<a href="#" class="button ask_price">Уточнить цену</a>
								@endif
							</div>
						</div>
					@endforeach
				</div>
				<a href="#" class="more"><span><img src="{{ URL::asset('images/arr.png') }}" alt=""></span>Показать еще</a>
			</div>
		</section>
		<section class="wrap-news">
			<div class="mbox">
				<div class="title-line">
					<h3>Последние новости</h3>
				</div>
				<div class="all-news">
					<ul class="news-popular-list">
						@foreach($content['news'] as $news)
						<li>
							<div class="popular-pic">
								<a href="{{ route('news-inner', $news['slug']) }}">
									<img src="{{ URL::asset($news['img_url']->img) }}" alt="{{ $news['img_url']->alt }}">
								</a>
							</div>
							<div class="popular-content">
								<a href="{{ route('news-inner', $news['slug']) }}" class="button-invers">Подробнее</a>
								<a href="{{ route('news-inner', $news['slug']) }}"><h6>{{ $news['title'] }}</h6></a>
								<div class="popular-info">
									<p>{{ $news['text'] }}</p>
								</div>
							</div>
						</li>
						@endforeach
					</ul>
				</div>
				<a href="{{ route('news') }}" class="all">Все новости<span></span></a>
			</div>
		</section>
	</div>
	<!-- /MAIN -->

	<!-- FOOTER -->
	@include('layout.footer')
	<!-- /FOOTER -->
</div>
@stop