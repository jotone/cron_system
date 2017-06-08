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
													<input type="checkbox" id="{{ $brand->slug }}" name="{{ $brand->slug }}">
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
							<div class="product-item hot-item">
								<div class="pic">
									<img src="{{ URL::asset('images/windows.png') }}" alt="">
									<div class="hot">hot</div>
								</div>
								<div class="name">
									<div class="prod-name">Furniture for Home</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
								<div class="price">
									<div class="prod-price">
										<span class="old">$ 200</span>
										<span class="new">$ 100</span>
									</div>
									<a href="#" class="button-invers">В КОРЗИНУ</a>
								</div>
							</div>
							<div class="product-item hot-item">
								<div class="pic">
									<img src="{{ URL::asset('images/photoshop.png') }}" alt="">
									<div class="hot">hot</div>
								</div>
								<div class="name">
									<div class="prod-name">Furniture for Home</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
								<div class="price">
									<div class="prod-price">
										<span class="old">$ 200</span>
										<span class="new">$ 100</span>
									</div>
									<a href="#" class="button-invers">В КОРЗИНУ</a>
								</div>
							</div>
							<div class="product-item hot-item">
								<div class="pic">
									<img src="{{ URL::asset('images/drweb.png') }}" alt="">
									<div class="hot">hot</div>
								</div>
								<div class="name">
									<div class="prod-name">Furniture for Home</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
								<div class="price">
									<div class="prod-price">
										<span class="old">$ 200</span>
										<span class="new">$ 100</span>
									</div>
									<a href="#" class="button-invers">В КОРЗИНУ</a>
								</div>
							</div>
							<div class="product-item hot-item">
								<div class="pic">
									<img src="{{ URL::asset('images/adobe.png') }}" alt="">
									<div class="hot">hot</div>
								</div>
								<div class="name">
									<div class="prod-name">Furniture for Home</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
								<div class="price">
									<div class="prod-price">
										<span class="old">$ 200</span>
										<span class="new">$ 100</span>
									</div>
									<a href="#" class="button-invers">В КОРЗИНУ</a>
								</div>
							</div>
							<div class="product-item hot-item">
								<div class="pic">
									<img src="{{ URL::asset('images/illustrator.png') }}" alt="">
									<div class="hot">hot</div>
								</div>
								<div class="name">
									<div class="prod-name">Furniture for Home</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
								<div class="price">
									<div class="prod-price">
										<span class="old"></span>
										<span class="new"></span>
									</div>
									<a href="request.html" class="button-invers">уточнить цену</a>
								</div>
							</div>
							<div class="product-item hot-item">
								<div class="pic">
									<img src="{{ URL::asset('images/indesign.png') }}" alt="">
									<div class="hot">hot</div>
								</div>
								<div class="name">
									<div class="prod-name">Furniture for Home</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
								<div class="price">
									<div class="prod-price">
										<span class="old">$ 200</span>
										<span class="new">$ 100</span>
									</div>
									<a href="#" class="button-invers">В КОРЗИНУ</a>
								</div>
							</div>
							<div class="product-item hot-item">
								<div class="pic">
									<img src="{{ URL::asset('images/microsoft.png') }}" alt="">
									<div class="hot">hot</div>
								</div>
								<div class="name">
									<div class="prod-name">Furniture for Home</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
								<div class="price">
									<div class="prod-price">
										<span class="old">$ 200</span>
										<span class="new">$ 100</span>
									</div>
									<a href="#" class="button-invers">В КОРЗИНУ</a>
								</div>
							</div>
							<div class="product-item hot-item">
								<div class="pic">
									<img src="{{ URL::asset('images/kaspersky.png') }}" alt="">
									<div class="hot">hot</div>
								</div>
								<div class="name">
									<div class="prod-name">Furniture for Home</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</div>
								<div class="price">
									<div class="prod-price">
										<span class="old">$ 200</span>
										<span class="new">$ 100</span>
									</div>
									<a href="#" class="button-invers">В КОРЗИНУ</a>
								</div>
							</div>
						</div>
						<div class="pagination">
							<a href="#" class="prev">&lt;</a>
							<ul>
								<li><a href="#">1</a></li>
								<li class="active">2</li>
								<li><a href="#">3</a></li>
								<li><a href="#">4</a></li>
								<li><a href="#">5</a></li>
							</ul>
							<a href="#" class="next">&gt;</a>
						</div>
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