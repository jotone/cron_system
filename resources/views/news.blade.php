@extends('layout.default')
@section('content')
<div class="global-wrapper">
		<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->

    <!-- MAIN -->
	<div class="main">
		<!-- add partials here -->
		<div class="breadcrumbs">
			<div class="mbox2">
				<ul class="breadcrumbs-list">
					<li><a href="{{ route('home') }}">Главная</a></li>
					<li><a href="#">This Page</a></li>
				</ul>
			</div>
		</div>
		<section class="news">
			<div class="news-wrap">
				<div class="title">
					<h1>Новости</h1>
				</div>
				<ul>
					<li>
						<div class="news-pic">
							<img src="{{ URL::asset('images/news1.jpg') }}" alt="">
						</div>
						<div class="item-content">
							<div class="news-icon">
								<img src="{{ URL::asset('images/news-icon.png') }}" alt="">
							</div>
							<h6>Новость 1</h6>
							<div class="news-info">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum.</p>
							</div>
							<a href="#" class="button-round">Подробнее</a>
						</div>
					</li>
					<li>
						<div class="news-pic">
							<img src="{{ URL::asset('images/news2.jpg') }}" alt="">
						</div>
						<div class="item-content">
							<div class="news-icon">
								<img src="{{ URL::asset('images/news-icon.png') }}" alt="">
							</div>
							<h6>Новость 2</h6>
							<div class="news-info">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum.</p>
							</div>
							<a href="#" class="button-round">Подробнее</a>
						</div>
					</li>
					<li>
						<div class="news-pic">
							<img src="{{ URL::asset('images/news3.jpg') }}" alt="">
						</div>
						<div class="item-content">
							<div class="news-icon">
								<img src="{{ URL::asset('images/news-icon.png') }}" alt="">
							</div>
							<h6>Новость 3</h6>
							<div class="news-info">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum.</p>
							</div>
							<a href="#" class="button-round">Подробнее</a>
						</div>
					</li>
					<li>
						<div class="news-pic">
							<img src="{{ URL::asset('images/news4.jpg') }}" alt="">
						</div>
						<div class="item-content">
							<div class="news-icon">
								<img src="{{ URL::asset('images/news-icon.png') }}" alt="">
							</div>
							<h6>Новость 4</h6>
							<div class="news-info">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum.</p>
							</div>
							<a href="#" class="button-round">Подробнее</a>
						</div>
					</li>
				</ul>
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
		</section>
	</div>
	<!-- /MAIN -->

	<!-- FOOTER -->
	@include('layout.footer')
	<!-- /FOOTER -->
</div>
@stop
