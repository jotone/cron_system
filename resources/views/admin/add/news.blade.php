@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/news.js') }}"></script>
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
							<input name="title" type="text" class="text-input col_1_2" placeholder="Название&hellip;" @if(isset($content['title'])) value="{{ $content['title'] }}" @endif>
							<span>Название</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="slug" type="text" class="text-input col_1_2" placeholder="Ссылка&hellip;" @if(isset($content['slug'])) value="{{ $content['slug'] }}" @endif>
							<span>Ссылка</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="enabled" type="checkbox" class="chbox-input" @if(isset($content)) @if($content['enabled'] == 1) checked="checked" @endif @else checked="checked" @endif>
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
						<div class="upload-image-preview tac fl col_3_4"></div>
					</div>
				</fieldset>

				<fieldset>
					<legend>Текст</legend>
					<div class="row-wrap">
						<textarea class="needCKE" name="text">@if(isset($content)){{ $content['text'] }}@endif</textarea>
					</div>
				</fieldset>

				<fieldset>
					<legend>Мета-данные</legend>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="metaTitle" class="text-input col_1_2" type="text" placeholder="Meta Title&hellip;" @if(isset($content['meta_title'])) value="{{ $content['meta_title'] }}" @endif>
							<span>Meta Title</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<span>Meta Description</span>
							<textarea name="metaDescription" class="simple-text" placeholder="Meta Description&hellip;">@if(isset($content['meta_description'])){{$content['meta_description']}}@endif</textarea>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<span>Meta Keywords</span>
							<textarea name="metaKeywords" class="simple-text" placeholder="Meta Keywords&hellip;">@if(isset($content['meta_keywords'])){{$content['meta_keywords']}}@endif</textarea>
						</label>
					</div>
				</fieldset>

				<fieldset>
					<legend>Так же читают</legend>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="also_reads" type="checkbox" class="chbox-input" @if((isset($content)) && ($content['also_reads'] == 1)) checked="checked" @endif>
							<span>Так же читают</span>
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