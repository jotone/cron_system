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
									<option @if($limit == 7) selected="selected" @endif>7</option>
									<option @if($limit == 14) selected="selected" @endif>14</option>
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
									<li @if(isset($filter['category']) && $filter['category']==$category->slug) class="active" @endif><a href="#{{ $category->slug }}">{{ $category->title }}</a></li>
								@endforeach
								</ul>
							</div>
						</div>
						<form name="catalog-filter">
							<div class="filter-item">
								<a href="#" class="filter-title js-title">
									<h3>Бренд</h3>
									<span class="filter-arrow"></span>
								</a>
								<div class="filter-checkbox-inner">
									<div class="filter-search">
										<input type="text" class="search-input" placeholder="Поиск...">
										<button type="submit"><img src="{{ URL::asset('images/search.png') }}" alt=""></button>
										<ul class="autocomplete-dropdown"></ul>
									</div>
									<div class="checkbox-list-wrap">
										<ul class="checkbox-list js-scrollpane">
										@foreach($brands as $brand)
											<li>
												<label>
													<input @if(isset($filter['brand']) && $filter['brand']==$brand->slug) checked="checked" @endif type="radio" id="{{ $brand->slug }}" name="brand_radio">
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
										<?php $price_array=[];?>
										@if(isset($filter['price']))
											<?php $price_array=json_decode($filter['price']);?>
										@endif
										<div class="form-field">
											<label for="min">От</label>
											<input type="text" id="min" class="price-filter-input" data-min-price='{{$price_range['min']}}' name="min" value="{{$price_array->min or $price_range['min']}}">
										</div>
										<div class="form-field">
											<label for="max">До</label>
											<input type="text" id="max" class="price-filter-input" data-max-price='{{$price_range['max']}}' name="max" value="{{$price_array->max or $price_range['max']}}">
										</div>
									</div>
									<button type="button" name="acceptPrice" class="button-invers">ПРИМЕНИТЬ</button>
								</div>
							</div>
							<div class="filter-item filter-rating">
								<a href="#" class="filter-title js-title">
									<h3>Рейтинг</h3>
									<span class="filter-arrow"></span>
								</a>
								<div class="filter-stars">
									<input @if(isset($filter['rating']) && str_replace(['"'],'',$filter['rating'])==5) checked="checked" @endif name="eval" type="radio" id="five-star" value="5">
									<label for="five-star" class="stars-label"></label>
									<input @if(isset($filter['rating']) && str_replace(['"'],'',$filter['rating'])==4) checked="checked" @endif name="eval" type="radio" id="four-star" value="4">
									<label for="four-star" class="stars-label"></label>
									<input @if(isset($filter['rating']) && str_replace(['"'],'',$filter['rating'])==3) checked="checked" @endif name="eval" type="radio" id="three-star" value="3">
									<label for="three-star" class="stars-label"></label>
									<input @if(isset($filter['rating']) && str_replace(['"'],'',$filter['rating'])==2) checked="checked" @endif name="eval" type="radio" id="two-star" value="2">
									<label for="two-star" class="stars-label"></label>
									<input @if(isset($filter['rating']) && str_replace(['"'],'',$filter['rating'])==1) checked="checked" @endif name="eval" type="radio" id="one-star" value="1">
									<label for="one-star" class="stars-label"></label>
								</div>
							</div>
						</form>
						<div class="filter-reset">
							<a href="#" class="button-invers">СБРОСИТЬ ФИЛЬТР</a>
						</div>
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

								<div class="price cfix"  data-product="{{ $product['id'] }}">
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
						<div class="pagination" @if($paginate_options['total'] < 2) style="display: none" @endif>
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

						@if( (isset($seo)) && ($seo['need_seo'] > 0) )
						<div class="catalog-seo">
							<h2>{{ $seo['title'] }}</h2>
							<div class="catalog-text">{!! $seo['text'] !!}</div>
							<a href="#ask_popup" class="button-round js_popup">Задать вопрос</a>
						</div>
						@endif
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