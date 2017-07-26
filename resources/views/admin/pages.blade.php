@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/pages.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">{{ $page_title }}</div>
		<div class="button-wrap">
			<a class="control-button" href="{{ route('admin-pages-add') }}">Добавить</a>
		</div>
		<table class="item-list col_1">
			<thead>
				<tr>
					<th></th>
					<th></th>
					<th>Название
						<div class="direction" id="title">
							<a href="{{ URL::asset('/admin/pages/?page='.$pagination['current_page'].'&sort_by=title&dir=asc') }}" class="asc">&#9650;</a>
							<a href="{{ URL::asset('/admin/pages/?page='.$pagination['current_page'].'&sort_by=title&dir=desc') }}" class="desc">&#9660;</a>
						</div>
					</th>
					<th>Ссылка
						<div class="direction" id="link">
							<a href="{{ URL::asset('/admin/pages/?page='.$pagination['current_page'].'&sort_by=link&dir=asc') }}" class="asc">&#9650;</a>
							<a href="{{ URL::asset('/admin/pages/?page='.$pagination['current_page'].'&sort_by=link&dir=desc') }}" class="desc">&#9660;</a>
						</div>
					</th>
					<th>Изображение</th>
					<th>Шаблон
						<div class="direction" id="template">
							<a href="{{ URL::asset('/admin/pages/?page='.$pagination['current_page'].'&sort_by=template&dir=asc') }}" class="asc">&#9650;</a>
							<a href="{{ URL::asset('/admin/pages/?page='.$pagination['current_page'].'&sort_by=template&dir=desc') }}" class="desc">&#9660;</a>
						</div>
					</th>
					<th>Создан
						<div class="direction" id="created">
							<a href="{{ URL::asset('/admin/pages/?page='.$pagination['current_page'].'&sort_by=created&dir=asc') }}" class="asc">&#9650;</a>
							<a href="{{ URL::asset('/admin/pages/?page='.$pagination['current_page'].'&sort_by=created&dir=desc') }}" class="desc">&#9660;</a>
						</div>
					</th>
					<th>Изменен
						<div class="direction" id="updated">
							<a href="{{ URL::asset('/admin/pages/?page='.$pagination['current_page'].'&sort_by=updated&dir=asc') }}" class="asc">&#9650;</a>
							<a href="{{ URL::asset('/admin/pages/?page='.$pagination['current_page'].'&sort_by=updated&dir=desc') }}" class="desc">&#9660;</a>
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
			@foreach($pages as $item)
				<tr>
					<td>
						<a class="block-button edit" href="{{ route('admin-pages-edit', $item['id']) }}" title="Редактировать">
							<img src="{{ URL::asset('images/edit.png') }}" alt="Редактировать">
						</a>
					</td>
					<td>
						<a class="block-button drop" data-id="{{ $item['id'] }}" href="#" data-title="{{ $item['title'] }}" title="Удалить">
							<img src="{{ URL::asset('images/drop.png') }}" alt="Удалить">
						</a>
					</td>
					<td>{{ $item['title'] }}</td>
					<td>{{ $item['link'] }}</td>
					<td>
						@if(!empty($item['img_url']))
							<img class="preview" src="{{ $item['img_url'] }}" alt="">
						@else
							Изображение отсутствует
						@endif
					</td>
					<td>{{ $item['template'] }}</td>
					<td>{{ $item['created_at'] }}</td>
					<td>{{ $item['updated_at'] }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop