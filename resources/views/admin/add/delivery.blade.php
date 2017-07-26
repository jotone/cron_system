@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/delivery.js') }}"></script>
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
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="title" type="text" class="text-input col_1_2" placeholder="Название&hellip;" @if(isset($content->title)) value="{{ $content->title }}" @endif>
							<span>Название</span>
						</label>
					</div>

					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="price" type="text" class="text-input col_1_2" placeholder="Цена&hellip;" @if(isset($content->price)) value="{{ $content->price }}" @endif>
							<span>Цена</span>
						</label>
					</div>

					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="terms" type="text" class="text-input col_1_2" placeholder="Термин доставки&hellip;" @if(isset($content->price)) value="{{ $content->terms }}" @endif>
							<span>Термин доставки</span>
						</label>
					</div>
				</fieldset>
			</div>
			<div class="button-wrap tac">
				<button name="save" class="control-button" type="button">Применить</button>
			</div>
		</div>
	</div>
</div>
@stop