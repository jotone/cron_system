@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/home.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">Статус заказов</div>

		<div class="work-place-wrap">
			<ul class="tab-list col_1">
				<li data-type="progress" class="active">Поступившие Заказы</li>
				<li data-type="done">Оформленые Заказы</li>
				<li data-type="canceled">Отмененные Заказы</li>
				<li data-type="calls">Звонки</li>
				<li data-type="questions">Вопросы</li>
			</ul>
		</div>

		<div class="orders-wrap">
		@foreach($order_list as $type => $items)
			<div id="{{ $type }}" class="order-inner" @if($type != 'progress') style="display: none;" @endif>
				<table class="item-list orders col_1">
					<thead>
					<tr>
						<th></th>
						<th>№ заказа</th>
						<th>Контактные данные</th>
						<th>Заказаные товары</th>
						@if($type == 'progress')
						<th>Статус</th>
						@endif
						<th>Создан</th>
						<th>Изменен</th>
					</tr>
					</thead>
					<tbody>
					@foreach($items as $item)
						<tr>
							<td>
								<a class="block-button drop" data-id="{{ $item['id'] }}" href="#" title="Удалить">
									<img src="{{ URL::asset('images/drop.png') }}" alt="Удалить">
								</a>
							</td>
							<td style="width: 6%;">{{ str_pad($item['id'], 10, '0', STR_PAD_LEFT) }}</td>
							<td style="padding-left: 5%; text-align: left">
								<div class="row-wrap">
									<ins>Имя:</ins> @if(!empty($item['link'])) <a href="{{ $item['link'] }}"> @endif{{ $item['user_name'] }}@if(!empty($item['link'])) </a> @endif
								</div>
								<div class="row-wrap"><ins>Телефон:</ins> {{ $item['phone'] }}</div>
								<div class="row-wrap"><ins>Email:</ins> {{ $item['email'] }}</div>
								<div class="row-wrap">
									<ins>Адресс:</ins>
									<p style="padding-left: 15px;"><ins>Страна:</ins> {{ $item['address']->c }}</p>
									<p style="padding-left: 15px;"><ins>Область:</ins> {{ $item['address']->r }}</p>
									<p style="padding-left: 15px;"><ins>Город:</ins> {{ $item['address']->t }}</p>
									<p style="padding-left: 15px;"><ins>Улица:</ins> {{ $item['address']->a }}</p>
									<p style="padding-left: 15px;"><ins>Индекс:</ins> {{ $item['address']->i }}</p>
								</div>
							</td>
							<td>
								<div class="row-wrap" style="padding: 15px 0;"><ins>Доставка:</ins> {{ $item['delivery'] }}</div>
								<div class="row-wrap goods-list" style="font-size: 18px;">
									<div class="col_1_5">Бренд</div>
									<div class="col_1_5">Название</div>
									<div class="col_1_5">Цена</div>
									<div class="col_1_5">Количество</div>
									<div class="col_1_5">Сумма</div>
								</div>
								<?php
								$total = 0;
								?>
								@foreach($item['products'] as $product)
									<?php $total += $product['price'] * $product['quant']; ?>
									<div class="row-wrap goods-list">
										<div class="col_1_5">{{ $product['brand'] }}</div>
										<div class="col_1_5">
											<a href="{{ URL::asset('/admin/products/edit/'.$product['id']) }}">{{ $product['title'] }}</a>
										</div>
										<div class="col_1_5">{{ number_format($product['price'],2, '.', ' ') }} руб.</div>
										<div class="col_1_5"> x {{ $product['quant'] }}</div>
										<div class="col_1_5">{{ number_format($product['price'] * $product['quant'], 2, '.', ' ') }} руб.</div>
									</div>
								@endforeach
								<div class="row-wrap goods-etc">
									<div class="col_1_5" style="font-size: 18px;">Итого:</div>
									<div class="col_1_5">{{ number_format($total, 2, '.', ' ') }} руб.</div>
								</div>
								<div class="row-wrap goods-etc">
									<div class="col_1_5" style="font-size: 18px;">Доставка:</div>
									<div class="col_1_5">{{ number_format($item['delivery_price'], 2, '.', ' ') }} руб.</div>
								</div>
								<div class="row-wrap goods-etc">
									<div class="col_1_5" style="font-size: 18px;">К оплате:</div>
									<div class="col_1_5">{{ number_format($item['delivery_price'] + $total, 2, '.', ' ') }} руб.</div>
								</div>
							</td>
							@if($type == 'progress')
							<td style="width: 10%;">
								<div class="row-wrap">
									<input name="done" type="button" class="control-button" value="Оформлено">
								</div>
								<div class="row-wrap">
									<input name="cancel" type="button" class="control-button" value="Отклонить">
								</div>
							</td>
							@endif
							<td style="width: 10%;">{{ $item['created'] }}</td>
							<td style="width: 10%;">{{ $item['updated'] }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		@endforeach
			<div id="calls" class="order-inner" style="display: none;">
				<table class="item-list calls col_1">
					<thead>
					<tr>
						<th></th>
						<th>Имя</th>
						<th>Телефон</th>
						<th>Услуга</th>
						<th>Статус</th>
						<th>Создан</th>
						<th>Изменен</th>
					</tr>
					</thead>
					<tbody>
					@foreach($call_list as $item)
						<tr @if(!empty($item['class'])) class="{{ $item['class'] }}" @endif>
							<td>
								<a class="block-button drop" data-id="{{ $item['id'] }}" href="#" title="Удалить">
									<img src="{{ URL::asset('images/drop.png') }}" alt="Удалить">
								</a>
							</td>
							<td>{{ $item['user_name'] }}</td>
							<td>{{ $item['phone'] }}</td>
							<td><a href="{{ URL::asset('/admin/services/edit/'.$item['service']['id']) }}">{{ $item['service']['title'] }}</a></td>
							<td style="width: 10%;">
								<div class="row-wrap">
									<input name="done" type="button" class="control-button" value="Обработано">
								</div>
								<div class="row-wrap">
									<input name="cancel" type="button" class="control-button" value="Отклонить">
								</div>
							</td>
							<td style="width: 10%;">{{ $item['created'] }}</td>
							<td style="width: 10%;">{{ $item['updated'] }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>

			<div id="questions" class="order-inner" style="display: none;">
				<table class="item-list questions col_1">
					<thead>
					<tr>
						<th></th>
						<th>Контактная информация</th>
						<th>Ожидаемый тип ответа</th>
						<th>Вопрос</th>
						<th>Статус</th>
						<th>Создан</th>
						<th>Изменен</th>
					</tr>
					</thead>
					<tbody>
					@foreach($question_list as $item)
						<tr @if(!empty($item['class'])) class="{{ $item['class'] }}" @endif>
							<td>
								<a class="block-button drop" data-id="{{ $item['id'] }}" href="#" title="Удалить">
									<img src="{{ URL::asset('images/drop.png') }}" alt="Удалить">
								</a>
							</td>
							<td style="padding-left: 5%; text-align: left">
								<div class="row-wrap"><ins>Имя:</ins> {{ $item['name'] }}</div>
								<div class="row-wrap"><ins>Организация:</ins> {{ $item['organisation'] }}</div>
								<div class="row-wrap"><ins>Город:</ins> {{ $item['city'] }}</div>
								<div class="row-wrap"><ins>Телефон:</ins> {{ $item['phone'] }}</div>
								<div class="row-wrap"><ins>Email:</ins> {{ $item['email'] }}</div>
							</td>
							<td>{{ $item['type'] }}</td>
							<td>{{ $item['question'] }}</td>
							<td style="width: 10%;">
								<div class="row-wrap">
									<input name="done" type="button" class="control-button" value="Обработано">
								</div>
								<div class="row-wrap">
									<input name="cancel" type="button" class="control-button" value="Отклонить">
								</div>
							</td>
							<td style="width: 10%;">{{ $item['created'] }}</td>
							<td style="width: 10%;">{{ $item['updated'] }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop