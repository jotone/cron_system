@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/templates.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">{{ $page_title }}</div>
		<div class="button-wrap">
			<a class="control-button" href="{{ route('admin-templates-add') }}">Добавить</a>
		</div>
		<table class="item-list col_1">
			<thead>
			<tr>
				<th></th>
				<th></th>
				<th>Название</th>
				<th>Тип</th>
			</tr>
			</thead>
			<tbody>
			@foreach($content as $item)
				<tr>
					<td style="width: 10%;">
						<a class="block-button edit" href="{{ route('admin-templates-edit', $item['id']) }}" title="Редактировать">
							<img src="{{ URL::asset('/images/edit.png') }}" alt="Редактировать">
						</a>
					</td>
					<td style="width: 10%;">
						<a class="block-button drop" href="#" data-title="{{ $item['title'] }}" data-id="{{ $item->id}}" title="Удалить">
							<img src="{{ URL::asset('/images/drop.png') }}" alt="Удалить">
						</a>
					</td>
					<td>{{ $item['title'] }}</td>
					<td>{{ $item['slug'] }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop