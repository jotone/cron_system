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
				<div class="slide">
					<div class="photo"><img src="images/laptop.jpg" alt=""></div>
					<div class="text">
						<h4>НОВАЯ КОЛЕКЦИЯ</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut aliquam leo. Quisque ac justo ut eros aliquet vulputate.</p>
						<a href="#" class="button-round">Детальнее</a>
					</div>
					<div class="overlay"><img src="images/wave.png" alt=""></div>
				</div>
				<div class="slide">
					<div class="photo"><img src="images/laptop.jpg" alt=""></div>
					<div class="text">
						<h4>НОВАЯ КОЛЕКЦИЯ</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut aliquam leo. Quisque ac justo ut eros aliquet vulputate.</p>
						<a href="#" class="button-round">Детальнее</a>
					</div>
					<div class="overlay"><img src="images/wave.png" alt=""></div>
				</div>
				<div class="slide">
					<div class="photo"><img src="images/laptop.jpg" alt=""></div>
					<div class="text">
						<h4>НОВАЯ КОЛЕКЦИЯ</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut aliquam leo. Quisque ac justo ut eros aliquet vulputate.</p>
						<a href="#" class="button-round">Детальнее</a>
					</div>
					<div class="overlay"><img src="images/wave.png" alt=""></div>
				</div>
			</div>
		</section>
		<section class="wrap-brands">
			<div class="mbox3 brands">
				<a href="javascript:void(0)" class="prev"><img src="images/prev.png" alt=""></a>
				<div class="brand-slider">
					<a href="#" class="slide">
						<img src="images/toshiba.png" alt="">
					</a>
					<a href="#" class="slide">
						<img src="images/asus.png" alt="">
					</a>
					<a href="#" class="slide">
						<img src="images/iconbit.png" alt="">
					</a>
					<a href="#" class="slide">
						<img src="images/micro.png" alt="">
					</a>
					<a href="#" class="slide">
						<img src="images/lenovo.png" alt="">
					</a>
					<a href="#" class="slide">
						<img src="images/toshiba.png" alt="">
					</a>
					<a href="#" class="slide">
						<img src="images/asus.png" alt="">
					</a>
					<a href="#" class="slide">
						<img src="images/iconbit.png" alt="">
					</a>
					<a href="#" class="slide">
						<img src="images/micro.png" alt="">
					</a>
					<a href="#" class="slide">
						<img src="images/lenovo.png" alt="">
					</a>
				</div>
				<a href="javascript:void(0)" class="next"><img src="images/prev.png" alt=""></a>
			</div>
		</section>
		<section class="wrap-index-desc">
			<div class="pic"><img src="images/desc_pic.png" alt=""></div>
			<div class="desc">
				<h2>Lorem ipsum</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.</p>
				<a href="about_us.html" class="button-round">Читать полностью</a>
			</div>
		</section>
		<section class="wrap-popular">
			<div class="mbox">
				<div class="title-line">
					<h3>Популярные товары</h3>
				</div>
				<div class="products">
					<div class="product-item hot-item">
						<div class="pic">
							<img src="images/windows.png" alt="">
							<div class="hot">hot</div>
						</div>
						<div class="name">
							<span class="prod-name">Furniture for Home</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
						</div>
						<div class="price">
							<div class="prod-price">
								<span class="old">$ 200</span>
								<span class="new">$ 100</span>
							</div>
							<a href="#" class="button">В КОРЗИНУ</a>
						</div>
					</div>
					<div class="product-item hot-item">
						<div class="pic">
							<img src="images/photoshop.png" alt="">
							<div class="hot">hot</div>
						</div>
						<div class="name">
							<span class="prod-name">Furniture for Home</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
						</div>
						<div class="price">
							<div class="prod-price">
								<span class="old">$ 200</span>
								<span class="new">$ 100</span>
							</div>
							<a href="#" class="button">В КОРЗИНУ</a>
						</div>
					</div>
					<div class="product-item hot-item">
						<div class="pic">
							<img src="images/drweb.png" alt="">
							<div class="hot">hot</div>
						</div>
						<div class="name">
							<span class="prod-name">Furniture for Home</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
						</div>
						<div class="price">
							<div class="prod-price">
								<span class="old">$ 200</span>
								<span class="new">$ 100</span>
							</div>
							<a href="#" class="button">В КОРЗИНУ</a>
						</div>
					</div>
					<div class="product-item hot-item">
						<div class="pic">
							<img src="images/adobe.png" alt="">
							<div class="hot">hot</div>
						</div>
						<div class="name">
							<span class="prod-name">Furniture for Home</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
						</div>
						<div class="price">
							<div class="prod-price">
								<span class="old">$ 200</span>
								<span class="new">$ 100</span>
							</div>
							<a href="#" class="button">В КОРЗИНУ</a>
						</div>
					</div>
					<div class="product-item hot-item">
						<div class="pic">
							<img src="images/illustrator.png" alt="">
							<div class="hot">hot</div>
						</div>
						<div class="name">
							<span class="prod-name">Furniture for Home</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
						</div>
						<div class="price">
							<div class="prod-price">
								<span class="old"></span>
								<span class="new"></span>
							</div>
							<a href="#" class="button">уточнить цену</a>
						</div>
					</div>
					<div class="product-item hot-item">
						<div class="pic">
							<img src="images/indesign.png" alt="">
							<div class="hot">hot</div>
						</div>
						<div class="name">
							<span class="prod-name">Furniture for Home</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
						</div>
						<div class="price">
							<div class="prod-price">
								<span class="old">$ 200</span>
								<span class="new">$ 100</span>
							</div>
							<a href="#" class="button">В КОРЗИНУ</a>
						</div>
					</div>
					<div class="product-item hot-item">
						<div class="pic">
							<img src="images/microsoft.png" alt="">
							<div class="hot">hot</div>
						</div>
						<div class="name">
							<span class="prod-name">Furniture for Home</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
						</div>
						<div class="price">
							<div class="prod-price">
								<span class="old">$ 200</span>
								<span class="new">$ 100</span>
							</div>
							<a href="#" class="button">В КОРЗИНУ</a>
						</div>
					</div>
					<div class="product-item hot-item">
						<div class="pic">
							<img src="images/kaspersky.png" alt="">
							<div class="hot">hot</div>
						</div>
						<div class="name">
							<span class="prod-name">Furniture for Home</span>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
						</div>
						<div class="price">
							<div class="prod-price">
								<span class="old">$ 200</span>
								<span class="new">$ 100</span>
							</div>
							<a href="#" class="button">В КОРЗИНУ</a>
						</div>
					</div>
				</div>
				<a href="#" class="more"><span><img src="images/arr.png" alt=""></span>Показать еще</a>
			</div>
		</section>
		<section class="wrap-news">
			<div class="mbox">
				<div class="title-line">
					<h3>Последние новости</h3>
				</div>
				<div class="all-news">
					<ul class="news-popular-list">
						<li>
							<div class="popular-pic">
								<img src="images/popular1.jpg" alt="">
							</div>
							<div class="popular-content">
								<a href="news-inner.html" class="button-invers">Подробнее</a>
								<h6>Новость 1</h6>
								<div class="popular-info">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut aliquam leo. Quisque ac justo ut eros aliquet vulputate.</p>
								</div>
							</div>
						</li>
						<li>
							<div class="popular-pic">
								<img src="images/popular2.jpg" alt="">
							</div>
							<div class="popular-content">
								<a href="news-inner.html" class="button-invers">Подробнее</a>
								<h6>Новость 2</h6>
								<div class="popular-info">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut aliquam leo. Quisque ac justo ut eros aliquet vulputate.</p>
								</div>
							</div>
						</li>
						<li>
							<div class="popular-pic">
								<img src="images/popular3.jpg" alt="">
							</div>
							<div class="popular-content">
								<a href="news-inner.html" class="button-invers">Подробнее</a>
								<h6>Новость 3</h6>
								<div class="popular-info">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut aliquam leo. Quisque ac justo ut eros aliquet vulputate.</p>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<a href="news.html" class="all">Все новости<span></span></a>
			</div>
		</section>
	</div>
	<!-- /MAIN -->

	<!-- FOOTER -->
	@include('layout.footer')
	<!-- /FOOTER -->
</div>
@stop