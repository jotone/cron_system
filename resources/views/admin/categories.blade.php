@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/categories.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">{{ $page_title }}</div>
		<div class="button-wrap">
			<a class="control-button" href="{{ route('admin-categories-add') }}">Добавить</a>
		</div>
		<div class="categories-list-wrap">
			{!! $categories !!}
		</div>
	</div>
</div>
@stop