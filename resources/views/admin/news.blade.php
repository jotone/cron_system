@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/news.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">{{ $page_title }}</div>
		<div class="button-wrap">
			<a class="control-button" href="{{ route('admin-news-add') }}">Добавить</a>
		</div>
		@if(1 < $pagination['last_page'])
			<div class="row-wrap">
				<ul class="pagination">
					@if($pagination['current_page'] > 1)
						<li><a href="{{ URL::asset('/admin/news/?page=1&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&laquo;</a></li>
						<li><a href="{{ URL::asset('/admin/news/?page='.($pagination['current_page'] -1).'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&lsaquo;</a></li>
					@endif
					@for($i=1; $i<=$pagination['last_page']; $i++)
						<li><a href="{{ URL::asset('/admin/news/?page='.$i.'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}" @if($pagination['current_page'] == $i) class="active" @endif>{{$i}}</a></li>
					@endfor
					@if($pagination['current_page'] < $pagination['last_page'])
						<li><a href="{{ URL::asset('/admin/news/?page='.($pagination['current_page'] +1).'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&rsaquo;</a></li>
						<li><a href="{{ URL::asset('/admin/news/?page='.$pagination['last_page'].'&sort_by='.$pagination['sort_by'].'&dir='.$pagination['dir']) }}">&raquo;</a></li>
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
						<a href="{{ URL::asset('/admin/news/?page='.$pagination['current_page'].'&sort_by=title&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/news/?page='.$pagination['current_page'].'&sort_by=title&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Превью</th>
				<th>Количество просмотров
					<div class="direction" id="views">
						<a href="{{ URL::asset('/admin/news/?page='.$pagination['current_page'].'&sort_by=views&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/news/?page='.$pagination['current_page'].'&sort_by=views&dir=desc') }}" class="desc">&#9660;</a>
					</div>
				</th>
				<th>Опубликован
					<div class="direction" id="published">
						<a href="{{ URL::asset('/admin/news/?page='.$pagination['current_page'].'&sort_by=published&dir=asc') }}" class="asc">&#9650;</a>
						<a href="{{ URL::asset('/admin/news/?page='.$pagination['current_page'].'&sort_by=published&dir=desc') }}" class="desc">&#9660;</a>
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

			</tbody>
		</table>
	</div>
</div>
@stop