@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/services.js') }}"></script>
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
							<input name="enabled" type="checkbox" class="chbox-input" @if(isset($content)) @if($content->enabled == 1) checked="checked" @endif @else checked="checked" @endif>
							<span>Опубликовать немедленно</span>
						</label>
					</div>
				</fieldset>

				<fieldset>
					<legend>Превью</legend>
					<div class="row-wrap cfix">
						<div class="fl col_1_8">
							<input style="display: none" name="imageLoader" placeholder="Обзор&hellip;" type="file">
							<div class="row-wrap">
								<input class="control-button" name="fakeLoad" type="button" value="Обзор&hellip;">
							</div>
							<div class="row-wrap">
								<input class="control-button" name="clear" type="button" value="Очистить&hellip;">
							</div>
							<div class="row-wrap">
								<input class="control-button" name="viewGallery" type="button" value="Галлерея&hellip;">
							</div>
						</div>
						<?php
						if(isset($content)){
							$image = json_decode($content->img_url);
						}
						?>
						<div class="upload-image-preview tac fl col_3_4">
							@if(isset($content))
								@if(!empty($image->img))
									<img src="{{ $image->img }}" alt="{{ $image->alt }}" data-type="file">
									<input name="imageAlt" type="text" class="text-input col_1" placeholder="alt&hellip;" value="{{ $image->alt }}">
								@endif
							@endif
						</div>
					</div>
				</fieldset>

				<fieldset>
					<legend>Текст</legend>
					<div class="row-wrap">
						<textarea class="needCKE" name="text">@if(isset($content)){{ $content->text }}@endif</textarea>
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