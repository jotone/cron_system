@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/pages.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="aside-wrap">
		<div class="template-select-wrap">
			<label class="fieldset-label-wrap">
				<strong>Выберите тип шаблона:</strong>
				<select name="templateType" class="select-input">
					@foreach($templates as $template)
						<option value="{{ $template->id }}" @if((isset($content->used_template)) && ($content->used_template == $template->id)) selected="selected" @endif>{{ $template->title }}</option>
					@endforeach
				</select>
			</label>
		</div>
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
							<input name="link" type="text" class="text-input col_1_2" placeholder="Ссылка&hellip;" @if(isset($content->link)) value="{{ $content->link }}" @endif>
							<span>Ссылка</span>
						</label>
					</div>
				</fieldset>
			</div>

			<div id="contentData"></div>

			<div>
				<fieldset>
					<legend>Мета-данные</legend>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="metaTitle" class="text-input col_1_2" type="text" placeholder="Meta Title&hellip;" @if(isset($content->meta_title)) value="{{ $content->meta_title }}" @endif>
							<span>Meta Title</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<span>Meta Description</span>
							<textarea name="metaDescription" class="simple-text" placeholder="Meta Description&hellip;">@if(isset($content->meta_description)){{$content->meta_description}}@endif</textarea>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<span>Meta Keywords</span>
							<textarea name="metaKeywords" class="simple-text" placeholder="Meta Keywords&hellip;">@if(isset($content->meta_keywords)){{$content->meta_keywords}}@endif</textarea>
						</label>
					</div>
				</fieldset>

				<fieldset>
					<legend>SEO блок</legend>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="need_seo" type="checkbox" class="chbox-input" @if( (isset($content)) && ($content->need_seo == 1)) checked="checked" @endif>
							<span>Разрешить SEO</span>
						</label>
					</div>
					<div class="row-wrap" id="seo">
						<label class="fieldset-label-wrap">
							<input name="seo_title" class="text-input col_1_2" type="text" placeholder="SEO заглавие&hellip;" @if(isset($content->seo_title)) value="{{ $content->seo_title }}" @endif>
							<span>SEO заглавие</span>
						</label>
					</div>
					<div class="row-wrap" id="seo">
						<p>SEO текст</p>
						<textarea name="seo_text" class="needCKE">@if(isset($content->seo_text)){{ $content->seo_text }}@endif</textarea>
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