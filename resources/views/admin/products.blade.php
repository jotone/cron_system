@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/products.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">{{ $page_title }}</div>
		<div class="button-wrap">
			<a class="control-button" href="{{ route('admin-products-add') }}">Добавить</a>
		</div>
		@if(1 < $pagination['last_page'])
			<div class="row-wrap">
				<ul class="pagination">
					@if($pagination['current_page'] > 1)
						<li><a href="{{ URL::asset('/admin/products/?page=1&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&laquo;</a></li>
						<li><a href="{{ URL::asset('/admin/products/?page='.($pagination['current_page'] -1).'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&lsaquo;</a></li>
					@endif
					@for($i=1; $i<=$pagination['last_page']; $i++)
						<li><a href="{{ URL::asset('/admin/products/?page='.$i.'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}" @if($pagination['current_page'] == $i) class="active" @endif>{{$i}}</a></li>
					@endfor
					@if($pagination['current_page'] < $pagination['last_page'])
						<li><a href="{{ URL::asset('/admin/products/?page='.($pagination['current_page'] +1).'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&rsaquo;</a></li>
						<li><a href="{{ URL::asset('/admin/products/?page='.$pagination['last_page'].'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&raquo;</a></li>
					@endif
				</ul>
			</div>
		@endif
		<table class="item-list col_1">
			<thead>
			<tr>
				<th></th>
				<th></th>
				<th>Название
					<div class="direction" id="title">
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=title&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=title&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Превью</th>
				<th>Цена
					<div class="direction" id="price">
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=price&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=price&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Брэнд
					<div class="direction" id="brand">
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=brand&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=brand&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Категория
					<div class="direction" id="category">
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=category&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=category&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Рейтинг
					<div class="direction" id="rating">
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=rating&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=rating&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Специальное предложение
					<div class="direction" id="is_hot">
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=is_hot&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=is_hot&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Опубликован
					<div class="direction" id="published">
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=published&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=published&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Создан
					<div class="direction" id="created">
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=created&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=created&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Изменен
					<div class="direction" id="updated">
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=updated&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/products/?page='.$pagination['current_page'].'&sort_by=updated&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
			</tr>
			</thead>
			<tbody>
			@foreach($content as $item)
				<td>
					<a class="block-button edit" href="{{ route('admin-products-edit',$item['id']) }}" title="Редактировать">
						<img src="{{ URL::asset('images/edit.png') }}" alt="Редактировать">
					</a>
				</td>
				<td>
					<a class="block-button drop" data-id="{{ $item['id'] }}" href="#" data-title="{{ $item['title'] }}" title="Удалить">
						<img src="{{ URL::asset('images/drop.png') }}" alt="Удалить">
					</a>
				</td>
				<td>{{ $item['title'] }}</td>
				<td>
				@if(!empty($item['img_url']->img))
					<img class="preview" src="{{ $item['img_url']->img }}" alt="{{ $item['img_url']->alt }}">
				@endif
				</td>
				<td>{{ $item['price'] }}</td>
				<td>{{ $item['brand'] }}</td>
				<td>{{ $item['category'] }}</td>
				<td>
					@for($i=0; $i<$item['rating']; $i++)
					<img src="{{ URL::asset('images/star.png') }}" alt="">
					@endfor
				</td>
				<td>{!! $item['is_hot'] !!}</td>
				<td>
					<div class="row-wrap">{{ $item['published_at'] }}</div>
					<label class="fieldset-label-wrap">
						<input name="enabled" class="chbox-input" type="checkbox" {{ $item['enabled'] }} data-id="{{ $item['id'] }}">
						<span>Опубликован</span>
					</label>
				</td>
				<td>{{ $item['created_at'] }}</td>
				<td>{{ $item['updated_at'] }}</td>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop