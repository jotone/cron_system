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
	</div>
</div>
@stop