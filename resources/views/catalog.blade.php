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
							<li>This Page</li>
						</ul>
						<form action="ajax.php" name="brandFilters" class="brand-filters">
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
									<li><a href="#">Антивирусы и Безопасность</a></li>
									<li><a href="#">Продукты 1С Предприятие</a></li>
									<li><a href="#">Офисные программы</a></li>
									<li><a href="#">Средства обработки графики</a></li>
									<li><a href="#">3D-моделирование САПР, СПДС</a></li>
									<li><a href="#">Администрирование сетей</a></li>
									<li><a href="#">Почтовые серверы и клиенты</a></li>
									<li><a href="#">Средства обработки видео</a></li>
									<li><a href="#">Средства обработки аудио</a></li>
									<li><a href="#">Средства виртуализации</a></li>
									<li><a href="#">Запись CD DVD HD Blu-Ray</a></li>
									<li><a href="#">Антивирусы и Безопасность</a></li>
									<li><a href="#">Продукты 1С</a></li>
									<li><a href="#">Офисные программы</a></li>
									<li><a href="#">Средства обработки аудио</a></li>
									<li><a href="#">Средства виртуализации</a></li>
									<li><a href="#">Запись CD DVD HD Blu-Ray</a></li>
									<li><a href="#">Антивирусы и Безопасность</a></li>
									<li><a href="#">Продукты 1С</a></li>
									<li><a href="#">Офисные программы</a></li>
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
											<li>
												<input type="checkbox" id="adobe" name="adobe">
												<label for="adobe"><span></span>Adobe</label>
											</li>
											<li>
												<input type="checkbox" id="kasper" name="kasper">
												<label for="kasper"><span></span>Kasperskiy</label>
											</li>
											<li>
												<input type="checkbox" id="eset" name="eset">
												<label for="eset"><span></span>Eset</label>
											</li>
											<li>
												<input type="checkbox" id="ms" name="ms">
												<label for="ms"><span></span>Microsoft</label>
											</li>
											<li>
												<input type="checkbox"  id="apple" name="apple">
												<label for="apple"><span></span>Apple</label>
											</li>
											<li>
												<input type="checkbox" id="test1" name="test1">
												<label for="test1"><span></span>test1</label>
											</li>
											<li>
												<input type="checkbox" id="test2" name="test2">
												<label for="test2"><span></span>test2</label>
											</li>
											<li>
												<input type="checkbox"  id="test3" name="test3">
												<label for="test3"><span></span>test3</label>
											</li>
											<li>
												<input type="checkbox" id="test4" name="test4">
												<label for="test4"><span></span>test4</label>
											</li>
											<li>
												<input type="checkbox" id="test5" name="test5">
												<label for="test5"><span></span>test5</label>
											</li>
											<li>
												<input type="checkbox"  id="test6" name="test6">
												<label for="test6"><span></span>test6</label>
											</li>
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