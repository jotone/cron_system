<?php
$user = Auth::user();
?>
<header class="header">
	<div class="top-header">
		<div class="mbox2">
			<div class="wrapper">
				<a href="#ask_popup" class="ask js_popup">Задать вопрос</a>
				<a href="tel:+74957450480" class="tel">
					<span><img src="{{ URL::asset('images/tel.png') }}" alt=""></span>+7 (495)745-04-80
				</a>
				<a href="mailto:hello@gmail.com" class="tel">
					<span><img src="{{ URL::asset('images/mail.png') }}" alt=""></span>hello@gmail.com
				</a>
				@if(!$user)
				<a href="{{ route('login-page') }}" class="regist">
					<span><img src="{{ URL::asset('images/lock.png') }}" alt=""></span>Вход\Регистрация
				</a>
				@else
				<a href="{{ route('user-panel') }}" class="regist">Личный кабинет</a>
				<a href="{{ route('logout') }}" class="regist">Выйти</a>
				@endif
			</div>
		</div>
	</div>
	<div class="bottom-header">
		<div class="mbox2">
			<div class="wrapper">
				<div class="logo">
					<a href="index.html"><img src="{{ URL::asset('images/logo-wh.png') }}" alt=""></a>
				</div>
				<div class="right-header">
					<a href="#" class="header-burger"><span></span></a>
					<div class="header-menu">
						<ul>
							<li><a href="#" class="catalogue">Каталог ПО</a></li>
							<li><a href="about_us.html">О компании</a></li>
							<li><a href="services.html">Услуги</a></li>
							<li><a href="services.html">Специальные прелложения</a></li>
							<li><a href="equipment.html">Оборудование</a></li>
						</ul>
						<a href="#" class="close"></a>
					</div>
					<div class="search">
						<form action="\">
							<input type="text" name="search" class="search-input" placeholder="Поиск...">
							<button type="submit" class="submit">
								<img src="{{ URL::asset('images/search.png') }}" alt="">
							</button>
						</form>
					</div>
					<div class="busket">
						<a href="#">
							<img src="{{ URL::asset('images/busket.png') }}" alt="">
							<span class="busket-count">1</span>
						</a>
					</div>
					<div class="busket-popup">
						<div class="busket-title">
							<div class="txt">
								<h5>В корзине 2 товар</h5>
								<p>на сумму 996 руб</p>
							</div>
							<a href="#" class="close"></a>
						</div>
						<div class="busket-item">
							<div class="pic"><img src="images/indesign.png" alt=""></div>
							<div class="item-name">
								<a href="#">Our Legacy Splash Jacquard</a>
								<span>498 руб</span>
							</div>
							<div class="delete"></div>
						</div>
						<div class="busket-item">
							<div class="pic"><img src="images/indesign.png" alt=""></div>
							<div class="item-name">
								<a href="#">Our Legacy Splash Jacquard</a>
								<span>498 руб</span>
							</div>
							<div class="delete"></div>
						</div>
						<a href="#" class="button-invers">ОФОРМИТЬ ЗАКАЗ</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="header-huge-menu">
		<div class="mbox2">
			<div class="top-menu">
				<div class="search">
					<form action="ajax.php">
						<input type="text" name="search" class="search-input" placeholder="Поиск...">
						<button type="submit" class="submit">go</button>
					</form>
				</div>
				<a href="#" class="close">Назад<span></span></a>
			</div>
			<div class="bottom-menu">
				<ul class="menu-list">
					<li><a href="#">Adobe</a>
						<ul>
							<li><a href="#">Adobe Creative Suite</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe Stock Photos</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe Version Cue</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe Document Server</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe Document Policy Server</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe eBook Reader</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe Flash Player</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe Flex програма </a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe Fonts програма </a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe Form Manager</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe LiveCycle Barcoded Forms</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe LiveCycle Designer</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe LiveCycle Document Security</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe LiveCycle Reader Extensions </a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe LiveCycle Forms </a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe LiveCycle Form Manager</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe LiveCycle Policy Server</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe LiveCycle Workflow</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe Output Designer</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe PageMaker </a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe PDF JobReady</a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe Photoshop Album </a>
								<ul>
									<li><a href="#">Adobe Acrobat</a></li>
									<li><a href="#">Adobe Bridge</a></li>
									<li><a href="#">Adobe GoLive</a></li>
									<li><a href="#">Adobe Illustrator</a></li>
									<li><a href="#">Adobe InDesign</a></li>
									<li><a href="#">Adobe Photoshop</a>
										<ul>
											<li><a href="#">Photoshop CS</a></li>
											<li><a href="#">Photoshop CC</a></li>
											<li><a href="#">Photoshop CC5</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#">Adobe Photoshop Album Starter Edition </a></li>
							<li><a href="#">Adobe Photoshop Elements </a></li>
							<li><a href="#">Adobe Premiere Elements</a></li>
							<li><a href="#">Adobe Reader </a></li>
							<li><a href="#">Adobe Source Libraries (Open Source)</a></li>
							<li><a href="#">Adobe SVG Viewer</a></li>
							<li><a href="#">Adobe Production Studio</a></li>
						</ul>
					</li>
					<li><a href="#">Kaspersky</a>
						<ul>
							<li><a href="#">Продукты для дома</a>
								<ul>
									<li><a href="#">Kaspersky Free Anti-Virus</a></li>
									<li><a href="#">Kaspersky Anti-Virus</a></li>
									<li><a href="#">Kaspersky Internet Security</a></li>
									<li><a href="#">Kaspersky Total Security</a></li>
									<li><a href="#">Kaspersky Internet Security для Android</a></li>
									<li><a href="#">Kaspersky Internet Security для Mac</a></li>
									<li><a href="#">Kaspersky Security Scan</a></li>
									<li><a href="#">Kaspersky Password Manager</a></li>
									<li><a href="#">Kaspersky KryptoStorage</a></li>
									<li><a href="#">Kaspersky Fake ID Scanner</a></li>
									<li><a href="#">Kaspersky Safe Kids</a></li>
								</ul>
							</li>
							<li><a href="#">Продукты для офиса</a>
								<ul>
									<li><a href="#">Kaspersky Free Anti-Virus</a></li>
									<li><a href="#">Kaspersky Anti-Virus</a></li>
									<li><a href="#">Kaspersky Internet Security</a></li>
									<li><a href="#">Kaspersky Total Security</a></li>
								</ul>
							</li>
							<li><a href="#">Комплексные продукты</a></li>
							<li><a href="#">Операционная система и компоненты</a>
								<ul>
									<li><a href="#">Kaspersky KryptoStorage</a></li>
									<li><a href="#">Kaspersky Fake ID Scanner</a></li>
									<li><a href="#">Kaspersky Safe Kids</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li><a href="#">ESET</a>
						<ul>
							<li><a href="#">NOD32 Antivirus и Smart Security 4.0.</a></li>
							<li><a href="#">NOD32 Antivirus и Smart Security 4.2.</a></li>
							<li><a href="#">NOD32 Antivirus и Smart Security 5.0.</a></li>
							<li><a href="#">NOD32 Antivirus и Smart Security 6.0.</a></li>
							<li><a href="#">NOD32 Antivirus и Smart Security 7.0.</a></li>
							<li><a href="#">NOD32 Antivirus и Smart Security 8.0.</a></li>
							<li><a href="#">NOD32 Antivirus и Smart Security 9.0.</a></li>
							<li><a href="#">NOD32 Antivirus и Smart Security 10.0.</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>