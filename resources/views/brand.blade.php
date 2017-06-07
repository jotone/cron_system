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
							<li>This Page</li>
						</ul>
						<form action="ajax.php" name="brandFilters" class="brand-filters">
							<div class="select-big">
								<select class="js-select" name="brands" data-placeholder="Выберите продукт">
									<option></option>
									<option>Пункт 1</option>
									<option>Пункт 2</option>
									<option>Пункт 3</option>
								</select>
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
				<h1>Microsoft</h1>
				<div class="brand-items">
					<div class="product-item">
						<div class="pic">
							<img src="{{ URL::asset('images/Office365.jpg') }}" alt="">
						</div>
						<div class="name">
							<div class="prod-name">Microsoft CSP Office 365 Cloud</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Cum sociis natoque penatibus et magnis dis parturient
								montes, nascetur ridiculus mus.</p>
						</div>
						<div class="price">
							<a href="#" class="button-invers">КАТАЛОГ</a>
						</div>
					</div>
					<div class="product-item">
						<div class="pic">
							<img src="{{ URL::asset('images/OfficePro2013.jpg') }}" alt="">
						</div>
						<div class="name">
							<div class="prod-name">Microsoft CSP Office 365 Cloud</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Cum sociis natoque penatibus et magnis dis parturient
								montes, nascetur ridiculus mus.</p>
						</div>
						<div class="price">
							<a href="#" class="button-invers">КАТАЛОГ</a>
						</div>
					</div>
					<div class="product-item">
						<div class="pic">
							<img src="{{ URL::asset('images/OfficeHome2016.jpg') }}" alt="">
						</div>
						<div class="name">
							<div class="prod-name">Microsoft CSP Office 365 Cloud</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Cum sociis natoque penatibus et magnis dis parturient
								montes, nascetur ridiculus mus.</p>
						</div>
						<div class="price">
							<a href="#" class="button-invers">КАТАЛОГ</a>
						</div>
					</div>
					<div class="product-item">
						<div class="pic">
							<img src="{{ URL::asset('images/OfficeBussines2016.jpg') }}" alt="">
						</div>
						<div class="name">
							<div class="prod-name">Microsoft CSP Office 365 Cloud</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Cum sociis natoque penatibus et magnis dis parturient
								montes, nascetur ridiculus mus.</p>
						</div>
						<div class="price">
							<a href="#" class="button-invers">КАТАЛОГ</a>
						</div>
					</div>
					<div class="product-item">
						<div class="pic">
							<img src="{{ URL::asset('images/Office2016.jpg') }}" alt="">
						</div>
						<div class="name">
							<div class="prod-name">Microsoft CSP Office 365 Cloud</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Cum sociis natoque penatibus et magnis dis parturient
								montes, nascetur ridiculus mus.</p>
						</div>
						<div class="price">
							<a href="#" class="button-invers">КАТАЛОГ</a>
						</div>
					</div>
					<div class="product-item">
						<div class="pic">
							<img src="{{ URL::asset('images/WinServer2012.jpg') }}" alt="">
						</div>
						<div class="name">
							<div class="prod-name">Microsoft CSP Office 365 Cloud</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Cum sociis natoque penatibus et magnis dis parturient
								montes, nascetur ridiculus mus.</p>
						</div>
						<div class="price">
							<a href="#" class="button-invers">КАТАЛОГ</a>
						</div>
					</div>
					<div class="product-item">
						<div class="pic">
							<img src="{{ URL::asset('images/Office2007.jpg') }}" alt="">
						</div>
						<div class="name">
							<div class="prod-name">Microsoft CSP Office 365 Cloud</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Cum sociis natoque penatibus et magnis dis parturient
								montes, nascetur ridiculus mus.</p>
						</div>
						<div class="price">
							<a href="#" class="button-invers">КАТАЛОГ</a>
						</div>
					</div>
					<div class="product-item">
						<div class="pic">
							<img src="{{ URL::asset('images/WinXP.jpg') }}" alt="">
						</div>
						<div class="name">
							<div class="prod-name">Microsoft CSP Office 365 Cloud</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Cum sociis natoque penatibus et magnis dis parturient
								montes, nascetur ridiculus mus.</p>
						</div>
						<div class="price">
							<a href="#" class="button-invers">КАТАЛОГ</a>
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