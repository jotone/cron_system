<div class="footer_placeholder"></div>
<footer class="footer">
	<div class="mbox3">
		<div class="footer-row">
			<div class="logo"><a href="{{ route('home') }}"><img src="{{ URL::asset('images/logo-bk.png') }}" alt=""></a></div>
			<div class="socials">
				@foreach($defaults['social'] as $social)
					<a href="{{ $social['link'] }}">
						@if(!empty($social['img_url']))
							<img src="{{ $social['img_url'] }}" alt="{{$social['title']}}">
						@else
							{{$social['title']}}
						@endif
					</a>
				@endforeach
			</div>
		</div>
		<div class="footer-row">
			<div class="footer-menu">
				<ul>
				@foreach($defaults['footer_menu'] as $item)
					<li><a href="@if($item->is_outer == 0){{ URL::asset($item->slug) }}@else{{$item->slug}}@endif">{{ $item->title }}</a></li>
				@endforeach
				</ul>
			</div>
			<div class="footer-col">
				<h6>Адрес:</h6>
				<p>{{ strip_tags($defaults['info']['address']) }}</p>
			</div>
			<div class="footer-col">
				<h6>Время работы:</h6>
				{!!$defaults['info']['work_time'] !!}
			</div>
			<div class="footer-sheep-fish">
				<a href="http://sheep.fish/">
					<img src="{{ URL::asset('images/sheep_fish.png') }}" alt="">
					<p>Разработка и поддержка сайта</p>
				</a>
			</div>
		</div>
	</div>
	<div class="copyright">
		<p>Cron 2016-2017 © Все права защищены</p>
	</div>
</footer>