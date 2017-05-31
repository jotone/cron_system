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
					<li><a href="{{ route('news') }}">Новости</a></li>
					<li><a href="#">{{ $content->title }}</a></li>
				</ul>
			</div>
		</div>
		<section class="news-inner">
			<div class="news-content">
				<div>
					<img src="{{ URL::asset('images/news-inner1.jpg') }}" width="900" height="800" alt="" style="float:right;margin:0 0 10px 20px;">
					<h1>{{ $content->title }}</h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum</p>
				</div>
				<br>
				<div>
					<img src="{{ URL::asset('images/news-inner2.jpg') }}" alt="" width="755" height="485" style="float:left;margin: 0 20px 10px 0;">
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio.</p>
				</div>
			</div>
			<div class="news-popular">
				<div class="mbox">
					<div class="title-line line-white">
						<h2>Так же читают</h2>
					</div>
					<ul class="news-popular-list">
						<li>
							<div class="popular-pic">
								<img src="{{ URL::asset('images/popular1.jpg') }}" alt="">
							</div>
							<div class="popular-content">
								<a href="#" class="button-invers">Подробнее</a>
								<h6>Новость 1</h6>
								<div class="popular-info">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut aliquam leo. Quisque ac justo ut eros aliquet vulputate.</p>
								</div>
							</div>
						</li>
						<li>
							<div class="popular-pic">
								<img src="{{ URL::asset('images/popular2.jpg') }}" alt="">
							</div>
							<div class="popular-content">
								<a href="#" class="button-invers">Подробнее</a>
								<h6>Новость 2</h6>
								<div class="popular-info">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut aliquam leo. Quisque ac justo ut eros aliquet vulputate.</p>
								</div>
							</div>
						</li>
						<li>
							<div class="popular-pic">
								<img src="{{ URL::asset('images/popular3.jpg') }}" alt="">
							</div>
							<div class="popular-content">
								<a href="#" class="button-invers">Подробнее</a>
								<h6>Новость 3</h6>
								<div class="popular-info">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut aliquam leo. Quisque ac justo ut eros aliquet vulputate.</p>
								</div>
							</div>
						</li>
					</ul>
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