@extends('layout.default')
@section('content')
<div class="global-wrapper">
	<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->

	<!-- MAIN -->
	<div class="main bread-light">
		<!-- add partials here -->
		<div class="breadcrumbs">
			<div class="mbox2">
				<ul class="breadcrumbs-list">
					<li><a href="index.html">Главная</a></li>
					<li><a href="#">This Page</a></li>
				</ul>
			</div>
		</div>
		<section class="wrap-thanks">
			<div class="mbox">
				<div class="thanks">
					<h2>Спасибо!</h2>
					<p>Ваш заказ оформлен.</p>
					<a href="index.html" class="to-main">На главную<span></span></a>
				</div>
			</div>
		</section>
	</div>
</div>
<!-- /MAIN -->
<!-- FOOTER -->
@include('layout.footer')
<!-- /FOOTER -->
@stop