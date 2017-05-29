<div class="footer_placeholder"></div>
<footer class="footer">
	<div class="mbox3">
		<div class="footer-row">
			<div class="logo"><a href="index.html"><img src="images/logo-bk.png" alt=""></a></div>
			<div class="socials">
				<a href="#"><img src="images/vk.png" alt=""></a>
				<a href="#"><img src="images/fb.png" alt=""></a>
				<a href="#"><img src="images/gg.png" alt=""></a>
			</div>
		</div>
		<div class="footer-row">
			<div class="footer-menu">
				<ul>
				@foreach($footer_menu as $item)
					<li><a href="@if($item->is_outer == 0){{ URL::asset($item->slug) }}@else{{$item->slug}}@endif">{{ $item->title }}</a></li>
				@endforeach
				</ul>
			</div>
			<div class="footer-col">
				<h6>Адрес:</h6>
				<p>Санкт-Петербург,     Набережная канала Грибоедова, дом 17</p>
			</div>
			<div class="footer-col">
				<h6>Время работы:</h6>
				<p>Понедельник-четверг:  с 09:30 до 19:00</p>
			</div>
			<div class="footer-sheep-fish">
				<a href="http://sheep.fish/">
					<img src="images/sheep_fish.png" alt="">
					<p>Разработка и поддержка сайта</p>
				</a>
			</div>
		</div>
	</div>
	<div class="copyright">
		<p>Cron 2016-2017 © Все права защищены</p>
	</div>
</footer>