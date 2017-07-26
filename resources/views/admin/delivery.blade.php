@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/delivery.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">{{ $page_title }}</div>
		<div class="button-wrap">
			<a class="control-button" href="{{ route('admin-delivery-add') }}">Добавить</a>
		</div>
		<div class="categories-list-wrap">
			<ul>
			@foreach($delivery as $item)
				<li data-id="{{ $item->id }}">
					<div class="category-wrap">
						<div class="category-title">
							<div class="sort-controls">
								<p data-direction="up">▲</p>
								<p data-direction="down">▼</p></div>
							<div>{{ $item->title }}</div>
						</div>
						<div class="category-slug">{{ $item->price }} руб</div>
						<div class="timestamps">
							<p>Создан: {{ \App\Http\Controllers\Supply\Functions::convertDate($item->created_at) }}</p>
							<p>Изменен: {{ \App\Http\Controllers\Supply\Functions::convertDate($item->updated_at) }}</p>
						</div>
						<div class="category-controls">
							<a class="button edit" href="{{ route('admin-delivery-edit', $item->id) }}" title="Редактировать"><img src="{{ URL::asset('images/edit.png') }}" alt="Редактировать"></a>
							<a class="button drop" href="#" title="Удалить" data-title="{{ $item->title }}"><img src="{{ URL::asset('images/drop.png') }}" alt="Удалить"></a>
						</div>
					</div>
				</li>
			@endforeach
			</ul>
		</div>
	</div>
</div>
@stop
