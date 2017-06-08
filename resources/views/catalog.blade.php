@extends('layout.default')
@section('content')
<div class="global-wrapper">
		<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->

	<!-- MAIN -->
	<div class="main">
		<!-- add partials here -->
		<div class="catalog">
			<div class="breadcrumbs">
				<div class="mbox2">
					<div class="breadcrumbs-inner">
						<ul class="breadcrumbs-list">
							<li><a href="{{ route('home') }}">Главная</a></li>
							<li>Каталог</li>
						</ul>
						<form name="brandFilters" class="brand-filters">
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
			<div class="mbox2">
				<div class="catalog-wrap">
					<aside class="catalog-filter-wrap">
						<div class="filter-item">
							<a href="#" class="filter-title js-title">
								<h3>Категория</h3>
								<span class="filter-arrow"></span>
							</a>
							<div class="link-list-wrap">
								<ul class="link-list js-scrollpane">
								@foreach($categories as $category)
									<li><a href="#{{ $category->slug }}">{{ $category->title }}</a></li>
								@endforeach
								</ul>
							</div>
						</div>
						<form action="ajax.php" name="catalog-filter">
							<div class="filter-item">
								<a href="#" class="filter-title js-title">
									<h3>Бренд</h3>
									<span class="filter-arrow"></span>
								</a>
								<div class="filter-checkbox-inner">
									<div class="filter-search">
										<input type="text" class="search-input" placeholder="Поиск...">
										<button type="submit"><img src="{{ URL::asset('images/search.png') }}" alt=""></button>
									</div>
									<div class="checkbox-list-wrap">
										<ul class="checkbox-list js-scrollpane">
										@foreach($brands as $brand)
											<li>
												<label>
													<input type="radio" id="{{ $brand->slug }}" name="brand_radio">
													<span></span>
													{{ $brand->title }}
												</label>
											</li>
										@endforeach
										</ul>
									</div>
								</div>
							</div>
							<div class="filter-item">
								<a href="#" class="filter-title js-title">
									<h3>Цена</h3>
									<span class="filter-arrow"></span>
								</a>
								<div class="filter-price-wrap">
									<div class="filter-price-inner">
										<div class="form-field">
											<label for="min">От</label>
											<input type="text" id="min" name="min">
										</div>
										<div class="form-field">
											<label for="max">До</label>
											<input type="text" id="max" name="max">
										</div>
									</div>
									<button type="submit" class="button-invers">ПРИМЕНИТЬ</button>
								</div>
							</div>
							<div class="filter-item filter-rating">
								<a href="#" class="filter-title js-title">
									<h3>Рейтинг</h3>
									<span class="filter-arrow"></span>
								</a>
								<div class="filter-stars">
									<input name="eval" type="radio" id="five-star" value="1">
									<label for="five-star" class="stars-label"></label>
									<input name="eval" type="radio" id="four-star" value="2">
									<label for="four-star" class="stars-label"></label>
									<input name="eval" type="radio" id="three-star" value="3">
									<label for="three-star" class="stars-label"></label>
									<input name="eval" type="radio" id="two-star" value="4">
									<label for="two-star" class="stars-label"></label>
									<input name="eval" type="radio" id="one-star" value="5">
									<label for="one-star" class="stars-label"></label>
								</div>
							</div>
						</form>
					</aside>
					<section class="catalog-right">
						<h1>Каталог</h1>
						<div class="burger">
							<div class="burger-brick"></div>
							<div class="burger-brick middle"></div>
							<div class="burger-brick"></div>
						</div>
						<div class="products">
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

								<div class="price cfix">
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
									<a href="{{ route('catalog') }}/page/{{ $paginate_options['prev'] }}" class="prev">&lt;</a>
								@endif

								<ul>
									@for($i = 1; $i<=$paginate_options['total']; $i++)
										<li @if($i == $paginate_options['current']) class="active" @endif>
											@if($i == $paginate_options['current'])
												{{ $i }}
											@else
												<a href="{{ route('catalog') }}/page/{{ $i }}">{{$i}}</a>
											@endif
										</li>
									@endfor
								</ul>

								@if($paginate_options['next'] <= $paginate_options['total'])
									<a href="{{ route('catalog') }}/page/{{ $paginate_options['next'] }}" class="next">&gt;</a>
								@endif
							</div>
						@endif

						<div class="catalog-seo">
							<h2>СЕО текст</h2>
							<div class="catalog-text">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>

								<p>Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. </p>
							</div>
							<a href="#ask_popup" class="button-round js_popup">Задать вопрос</a>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
	<!-- /MAIN -->

	<!-- FOOTER -->
	@include('layout.footer')
	<!-- /FOOTER -->
</div>
@stop