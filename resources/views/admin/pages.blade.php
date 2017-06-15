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
					<th>Название</th>
					<th>Ссылка</th>
					<th>Изображение</th>
					<th>Шаблон</th>
					<th>Создан</th>
					<th>Изменен</th>
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