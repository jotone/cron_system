@extends('layout.default')
<div class="global-wrapper">
	<!-- HEADER -->
	@include('layout.header')
	<!-- /HEADER -->
	<!-- MAIN -->
    	<div class="main">
    	    <div class="error-404">
                <div class="error-404-wrap">
                    <div class="error-404-left">
                        <div class="error-404-image">
                            <div class="error-404-image-wrap">
                                <img src="{{ URL::asset('images/error-404-img.gif') }}" alt="images">
                            </div>
                        </div>
                        <div class="error-404-loope">
                            <img src="{{ URL::asset('images/error-404-loope.png') }}" alt="images">
                        </div>
                        <div class="error-404-smallImg">
                            <img src="{{ URL::asset('images/error-404-smallImg.png') }}" alt="images">
                        </div>
                    </div>
                    <div class="error-404-right">
                        <div class="error-404-title">Ошибка 404</div>
                        <div class="error-404-text">Извините, мы не смогли найти то, что Вы искали :( </div>
                        <a href="{{ route('home') }}" class="to-main button-round">На главную<span></span></a>
                    </div>
                </div>
            </div>
    	</div>
    <!-- /MAIN -->
        <!-- FOOTER -->
	@include('layout.footer')
	<!-- /FOOTER -->
</div>
