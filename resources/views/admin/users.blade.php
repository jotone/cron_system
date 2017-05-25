@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/users.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">{{ $page_title }}</div>
		<div class="button-wrap"></div>
		@if(1 < $pagination['last_page'])
			<div class="row-wrap">
				<ul class="pagination">
					@if($pagination['current_page'] > 1)
						<li><a href="{{ URL::asset('/admin/users/?page=1&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&laquo;</a></li>
						<li><a href="{{ URL::asset('/admin/users/?page='.($pagination['current_page'] -1).'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&lsaquo;</a></li>
					@endif
					@for($i=1; $i<=$pagination['last_page']; $i++)
						<li><a href="{{ URL::asset('/admin/users/?page='.$i.'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}" @if($pagination['current_page'] == $i) class="active" @endif>{{$i}}</a></li>
					@endfor
					@if($pagination['current_page'] < $pagination['last_page'])
						<li><a href="{{ URL::asset('/admin/users/?page='.($pagination['current_page'] +1).'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&rsaquo;</a></li>
						<li><a href="{{ URL::asset('/admin/users/?page='.$pagination['last_page'].'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&raquo;</a></li>
					@endif
				</ul>
			</div>
		@endif
		<table class="item-list col_1">
			<thead>
			<tr>
				<th></th>
				<th></th>
				<th>e-mail
					<div class="direction" id="email">
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=email&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=email&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Имя
					<div class="direction" id="name">
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=name&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=name&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Телефон
					<div class="direction" id="phone">
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=phone&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=phone&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Роль
					<div class="direction" id="role">
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=role&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=role&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Активирован
					<div class="direction" id="activated">
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=activated&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=activated&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Создан
					<div class="direction" id="created">
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=created&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=created&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Изменен
					<div class="direction" id="updated">
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=updated&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/users/?page='.$pagination['current_page'].'&sort_by=updated&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
			</tr>
			</thead>
			<tbody>
			@foreach($content as $item)
				<tr data-id="{{ $item['id'] }}">
					<td>
						<a class="block-button edit" href="{{ route('admin-users-edit-page', $item['id']) }}" title="Редактировать">
							<img src="{{ URL::asset('images/edit.png') }}" alt="Редактировать">
						</a>
					</td>
					<td>
						<a class="block-button drop" href="#" data-title="{{ $item['email'] }}" title="Удалить">
							<img src="{{ URL::asset('images/drop.png') }}" alt="Удалить">
						</a>
					</td>
					<td>{!! $item['email'] !!}</td>
					<td>{!! $item['name'] !!}</td>
					<td>{!! $item['phone'] !!}</td>
					<td>{!! $item['role'] !!}</td>
					<td>{!! $item['activated'] !!}</td>
					<td>{!! $item['created'] !!}</td>
					<td>{!! $item['updated'] !!}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop