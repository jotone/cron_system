@extends('admin.layout.default')
@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/admin/user_roles.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">{{ $page_title }}</div>
		<div class="button-wrap">
			<a class="control-button" href="#">Добавить</a>
		</div>
		@if(1 < $pagination['last_page'])
			<div class="row-wrap">
				<ul class="pagination">
					@if($pagination['current_page'] > 1)
						<li><a href="{{ URL::asset('/admin/users/roles/?page=1&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&laquo;</a></li>
						<li><a href="{{ URL::asset('/admin/users/roles/?page='.($pagination['current_page'] -1).'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&lsaquo;</a></li>
					@endif
					@for($i=1; $i<=$pagination['last_page']; $i++)
						<li><a href="{{ URL::asset('/admin/users/roles/?page='.$i.'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}" @if($pagination['current_page'] == $i) class="active" @endif>{{$i}}</a></li>
					@endfor
					@if($pagination['current_page'] < $pagination['last_page'])
						<li><a href="{{ URL::asset('/admin/users/roles/?page='.($pagination['current_page'] +1).'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&rsaquo;</a></li>
						<li><a href="{{ URL::asset('/admin/users/roles/?page='.$pagination['last_page'].'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&raquo;</a></li>
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
						<a href="{{ URL::asset('/admin/users/roles/?page='.$pagination['current_page'].'&sort_by=title&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/users/roles/?page='.$pagination['current_page'].'&sort_by=title&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Псевдоним
					<div class="direction" id="pseudonim">
						<a href="{{ URL::asset('/admin/users/roles/?page='.$pagination['current_page'].'&sort_by=pseudonim&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/users/roles/?page='.$pagination['current_page'].'&sort_by=pseudonim&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Доступные страницы</th>
				<th>Создан
					<div class="direction" id="created">
						<a href="{{ URL::asset('/admin/users/roles/?page='.$pagination['current_page'].'&sort_by=created&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/users/roles/?page='.$pagination['current_page'].'&sort_by=created&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Изменен
					<div class="direction" id="updated">
						<a href="{{ URL::asset('/admin/users/roles/?page='.$pagination['current_page'].'&sort_by=updated&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/users/roles/?page='.$pagination['current_page'].'&sort_by=updated&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
			</tr>
			</thead>
			<tbody>
			@foreach($content as $item)
				<tr data-id="{{$item['id']}}">
					<td>
						@if($item['editable'] > 0)
						<a class="block-button edit" href="#" title="Редактировать">
							<img src="{{ URL::asset('images/edit.png') }}" alt="Редактировать">
						</a>
						@endif
					</td>
					<td>
						@if($item['editable'] > 0)
						<a class="block-button drop" data-id="#" href="#" data-title="{{ $item['title'] }}" title="Удалить">
							<img src="{{ URL::asset('images/drop.png') }}" alt="Удалить">
						</a>
						@endif
					</td>
					<td>{{ $item['title'] }}</td>
					<td>{{ $item['pseudonim'] }}</td>
					<td>{!! $item['pages'] !!}</td>
					<td>{!! $item['created'] !!}</td>
					<td>{!! $item['updated'] !!}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop