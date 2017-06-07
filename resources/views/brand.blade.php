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

						<form action="ajax.php" name="brandFilters" class="brand-filters">
							{{ csrf_field() }}
							<div class="select-big">
								@if(!$brand_is_last)
								<select class="js-select" name="brands" data-placeholder="Выберите продукт">
									<option label="empty"></option>
									@foreach($products_list as $item)
										<option value="{{ $item['slug'] }}">{{ $item['title'] }}</option>
									@endforeach
								</select>
								@endif
							</div>
							<div class="select-small">
								<label for="number-select">Показать:</label>
								<select id="number-select" name="brandsNumber" class="js-select" >
									<option>8</option>
									<option>16</option>
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
							<div class="pic">
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

							<div class="price">
								@if(!empty($product['price']))
									<div class="prod-price">
										<span class="old">@if(!empty($product['old_price'])) $ {{ $product['old_price'] }}@endif</span>
										<span class="new">$ {{ $product['price'] }}</span>
									</div>
									<a href="#" class="button-invers">В корзину</a>
								@else
									<a href="#" class="button-invers">Уточнить цену</a>
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

				<div class="brand-info">
					<h2>СЕО текст</h2>
					<div class="info-content">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>

						<p>Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. </p>
					</div>
					<a href="#ask_popup" class="button-round js_popup">Задать вопрос</a>
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