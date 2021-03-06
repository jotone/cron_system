@extends('layout.default')
@section('content')
<div class="global-wrapper">
	<!-- HEADER -->
@include('layout.header')
<!-- /HEADER -->

	<!-- MAIN -->
	<div class="main">
		<!-- add partials here -->
		<section class="brand">
			<div class="breadcrumbs">
				<div class="mbox2">
					<div class="breadcrumbs-inner">
						<ul class="breadcrumbs-list">
							<li><a href="{{ route('home') }}">Главная</a></li>
							<li>{{ $page_title }}</li>
						</ul>

						<form name="brandFilters" class="brand-filters">
							{{ csrf_field() }}
							<div class="select-small">
								<label for="number-select">Показать:</label>
								<select id="number-select" name="brandsNumber" class="js-select" >
									<option @if($limit == 8) selected="selected" @endif>8</option>
									<option @if($limit == 16) selected="selected" @endif>16</option>
								</select>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="mbox">
				<h1>{{ $page_title }}</h1>

				<div class="brand-items">
					@foreach($products as $product)
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
								<div class="prod-name">{{ $product['title'] }}</div>
								{!! $product['text'] !!}
							</div>

							<div class="price" data-product="{{ $product['id'] }}">
								@if(!empty($product['price']))
									<div class="prod-price">
										<span class="old">@if(!empty($product['old_price'])) $ {{ $product['old_price'] }}@endif</span>
										<span class="new">$ {{ $product['price'] }}</span>
									</div>
									<a href="#" class="button-invers to_busket">В корзину</a>
								@else
									<a href="#" class="button-invers ask_price">Уточнить цену</a>
								@endif
							</div>
						</div>
					@endforeach
				</div>

				@if($paginate_options['total'] > 1)
					<div class="pagination">
						@if($paginate_options['prev'] > 0)
							<a href="{{ route('brand', $link) }}/page/{{ $paginate_options['prev'] }}" class="prev">&lt;</a>
						@endif

						<ul>
							@for($i = 1; $i<=$paginate_options['total']; $i++)
								<li @if($i == $paginate_options['current']) class="active" @endif>
									@if($i == $paginate_options['current'])
										{{ $i }}
									@else
										<a href="{{ route('brand', $link) }}/page/{{ $i }}">{{$i}}</a>
									@endif
								</li>
							@endfor
						</ul>

						@if($paginate_options['next'] <= $paginate_options['total'])
							<a href="{{ route('brand', $link) }}/page/{{ $paginate_options['next'] }}" class="next">&gt;</a>
						@endif
					</div>
				@endif

				@if( (isset($seo)) && ($seo['need_seo'] > 0) )
					<div class="brand-info">
						<h2>{{ $seo['title'] }}</h2>
						<div class="info-content">{!! $seo['text'] !!}</div>
						<a href="#ask_popup" class="button-round js_popup">Задать вопрос</a>
					</div>
				@endif
			</div>
		</section>
	</div>
	<!-- /MAIN -->

	<!-- FOOTER -->
@include('layout.footer')
<!-- /FOOTER -->
</div>
@stop