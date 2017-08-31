@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/brands.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">{{ $page_title }}</div>
		<div class="button-wrap">
			<a class="control-button" href="{{ route('admin-brands-add') }}">Добавить</a>
			<a class="control-button" href="{{ route('admin-brands-import') }}">Import</a>
		</div>
		<div class="categories-list-wrap">
			{!! $brands !!}
		</div>
	</div>
</div>
@stop