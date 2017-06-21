@extends('layout.default')
@section('content')
<div class="global-wrapper">
		<!-- HEADER -->
	@include('layout.header', ['deny_basket'=>'1'])
	<!-- /HEADER -->

	<!-- MAIN -->
	<div class="main bread-light">
		<!-- add partials here -->
		<div class="breadcrumbs">
			<div class="mbox2">
				<ul class="breadcrumbs-list">
					<li><a href="{{ route('home') }}">Главная</a></li>
					<li>This Page</li>
				</ul>
			</div>
		</div>
		<div class="busket-steps">
			<div class="mbox">
				<ul>
					<li><a href="#" class="active"><span>1</span>КОРЗИНА</a></li>
					<li><a href="#"><span>2</span>ДОСТАВКА</a></li>
					<li><a href="#"><span>3</span>ОПЛАТА</a></li>
				</ul>
			</div>
		</div>
		<section class="first-busket">
			<div class="busket-content">
				<form class="busket">
					<div class="busket-table">
						<div class="table-row table-header">
							<div class="table-col">НАЗВАНИЕ</div>
							<div class="table-col">ЦЕНА</div>
							<div class="table-col">КОЛИЧЕСТВО</div>
							<div class="table-col">ВСЕГО</div>
						</div>
						<?php $total = 0; ?>
						@foreach($items as $item)
							<?php
							$total += $item['price'] * $item['quantity'];
							?>
							<div class="table-row">
								<div class="table-col">
									<a href="#" class="delete" data-gii="{{ \Crypt::encrypt($item['id']) }}"></a>
									<a href="#" class="product">
										<span class="pic">
										@if(!empty($item['img_url']->img))
											<img src="{{ URL::asset($item['img_url']->img) }}" alt="">
										@endif
										</span>
										<span class="prod-name">{{ $item['title'] }}</span>
									</a>
								</div>
								<div class="table-col price" data-price="{{ $item['price'] }}">
									<span>{{ number_format($item['price'],0, '',' ') }}</span> руб
								</div>
								<div class="table-col">
									<input type="number" name="count" class="js-number" value="{{ $item['quantity'] }}">
								</div>
								<div class="table-col product-summ">
									<span>{{ number_format(($item['price'] * $item['quantity']),0, '',' ') }}</span> руб
								</div>
							</div>
						@endforeach
						<div class="table-row table-footer">
							<div class="table-col">ИТОГ</div>
							<div class="table-col summ">{{ number_format($total,0, '',' ') }} руб</div>
						</div>
					</div>

					<div class="buttons">
						<a href="{{ route('catalog') }}" class="continue"><span></span>Продолжить покупки</a>
						@if(!empty($items))
						<button type="submit" class="submit">Доставка<span></span></button>
						@endif
					</div>

				</form>
			</div>
		</section>
<hr/>
		<section class="second-busket">
			<form action="ajax.php" class="busket2">
				<div class="form-table">
					<div class="form-col">
						<div class="form-header"><h4>АДРЕС ДОСТАВКИ</h4></div>
						<div class="form-content">
							<div class="form-field">
								<p>Страна<sup style="color:#00b3ad;">*</sup></p>
								<input type="text" class="el-input" name="country" required="required">
							</div>
							<div class="form-field">
								<p>Область<sup style="color:#00b3ad;">*</sup></p>
								<input type="text" class="el-input" name="region" required="required">
							</div>
							<div class="form-field">
								<p>Город<sup style="color:#00b3ad;">*</sup></p>
								<input type="text" class="el-input" name="city" required="required">
							</div>
							<div class="form-field">
								<p>Адрес<sup style="color:#00b3ad;">*</sup></p>
								<input type="text" class="el-input" name="address" required="required">
							</div>
							<div class="form-field">
								<p>Индекс<sup style="color:#00b3ad;">*</sup></p>
								<input type="text" class="el-input" name="index" required="required">
							</div>
						</div>
					</div>
					<div class="form-col">
						<div class="form-header"><h4>КОНТАКТНАЯ ИНФОРМАЦИЯ</h4></div>
						<div class="form-content">
							<div class="form-field">
								<p>Ваше имя<sup style="color:#00b3ad;">*</sup></p>
								<input type="text" class="el-input" name="country" required="required">
							</div>
							<div class="form-field">
								<p>Телефон<sup style="color:#00b3ad;">*</sup></p>
								<input type="text" class="el-input" name="region" required="required">
							</div>
							<div class="form-field">
								<p>Ваша фамилия<sup style="color:#00b3ad;">*</sup></p>
								<input type="text" class="el-input" name="city" required="required">
							</div>
							<div class="form-field">
								<p>E-mail</p>
								<input type="text" class="el-input" name="address">
							</div>
						</div>
					</div>
					<div class="form-col delivery">
						<div class="form-header">
							<h4>способ доставки</h4>
							<div class="form-field">
								<input type="radio" class="el-radio" name="delivery" id="standart">
								<label for="standart">90.00 руб Стандарт <span>1-2 Недели</span></label>
							</div>
							<div class="form-field">
								<input type="radio" class="el-radio" name="delivery" id="ultra-speed">
								<label for="ultra-speed"> 200.00 руб Ultra Speed <span>1 День</span></label>
							</div>
						</div>
					</div>
				</div>
				<div class="buttons">
					<a href="#" class="continue"><span></span>Корзина</a>
					<button type="submit" class="submit">Оплата<span></span></button>
				</div>
			</form>
		</section>
<hr/>
		<section class="second-busket third-busket">
			<form action="ajax.php" class="busket3">
				<div class="card-busket">
					<div class="back">
					</div>
					<div class="front">
						<div class="card-type">
							<p>Тип карты</p>
							<input type="text" class="el-input" name="card-type">
						</div>
						<div class="cvv-field">
							<p>CVV</p>
							<input type="text" class="el-input cvv" name="cvv">
						</div>
						<div class="card-number">
							<input type="text" class="el-input number" name="card-number1">
							<input type="text" class="el-input number" name="card-number2">
							<input type="text" class="el-input number" name="card-number3">
							<input type="text" class="el-input number" name="card-number4">
						</div>
						<div class="price">
							<div class="card-time">
								<input type="text" class="el-input time1" name="card-time1">
								<p>\</p>
								<input type="text" class="el-input time2" name="card-time2">
							</div>
							<p>ИТОГОВАЯ ЦЕНА <b style="color: #00b3ad;">30 000 руб</b></p>
						</div>
					</div>
				</div>
				<div class="buttons">
					<a href="#" class="continue"><span></span>Покупка</a>
					<button type="submit" class="submit">Подтвердить<span></span></button>
				</div>
			</form>
		</section>
	</div>
	<!-- /MAIN -->

	<!-- FOOTER -->
	@include('layout.footer')
	<!-- /FOOTER -->
</div>
@stop