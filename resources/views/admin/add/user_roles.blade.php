@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/user_roles.js') }}"></script>
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
			<input name="id" type="hidden" @if(isset($content['id'])) value="{{ $content['id'] }}" @endif>
			<div>
				<fieldset>
					<legend>Основные данные</legend>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="title" type="text" maxlength="32" class="text-input col_1_2" placeholder="Название&hellip;" @if(isset($content['title'])) value="{{ $content['title'] }}" @endif>
							<span>Название</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="pseudonim" type="text" maxlength="127" class="text-input col_1_2" placeholder="Псевдоним&hellip;" @if(isset($content['pseudonim'])) value="{{ $content['pseudonim'] }}" @endif>
							<span>Псевдоним</span>
						</label>
					</div>
				</fieldset>

				<fieldset>
					<legend>Запретить доступ к страницам</legend>
					<div class="chbox-selector-wrap">
						<?php if(isset($content)) $forbidden = json_decode($content->access_pages); ?>
						@foreach($pages as $page)
						<div class="checkbox-item-wrap">
							<label class="fieldset-label-wrap">
								<input name="page" type="checkbox" class="chbox-input" value="{{$page->id}}" @if((isset($content)) && (in_array($page->id, $forbidden))) checked="checked" @endif>
								<span>{{$page->title}}</span>
							</label>
						</div>
						@endforeach
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