@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/templates.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="aside-wrap">
		<div class="fixed-navigation-menu">
			<ul></ul>
		</div>
	</div>

	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">Шаблон страницы</div>
		<div class="work-place-wrap">
			<div>
				<fieldset data-link="osnovnye_dannye">
					<input name="id" type="hidden" @if(isset($content)) value="{{ $content->id }}" @endif>
					<legend>Основные данные</legend>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="title" class="text-input col_1_2" placeholder="Название&hellip;" type="text" @if(isset($content)) value="{{ $content->title }}" @endif>
							<span>Название</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="slug" class="text-input col_1_2" placeholder="Ссылка меню&hellip;" type="text" @if(isset($content)) value="{{ $content->slug }}" @endif>
							<span>Ссылка</span>
						</label>
					</div>
				</fieldset>

				<fieldset>
					<legend>Код</legend>
					<label class="fieldset-label-wrap">
						<textarea name="content" style="min-height: 600px; width: 100%; resize: vertical;">@if(isset($content)){{ $content->content }}@endif</textarea>
					</label>
				</fieldset>

				<div class="button-wrap tac">
					<button name="saveMenu" class="control-button" type="button">Применить</button>
				</div>
			</div>
		</div>
	</div>
</div>
@stop