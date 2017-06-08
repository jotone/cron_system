@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/pages.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="aside-wrap">
		<div class="fixed-navigation-menu">
			<ul></ul>
		</div>
	</div>

	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">{{ $page_title }}</div>
		<div class="work-place-wrap">
			<input name="id" type="hidden" @if(isset($content->id)) value="{{ $content->id }}" @endif>
			<div>
				<fieldset>
					<legend>Основные данные</legend>
				</fieldset>
			</div>
			<div class="button-wrap tac">
				<button name="save" class="control-button" type="button">Применить</button>
			</div>
		</div>
	</div>
</div>
@stop