@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/brands.js') }}"></script>
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
							<input name="slug" type="text" class="text-input col_1_2" placeholder="Ссылка&hellip;" @if(isset($content->slug)) value="{{ $content->slug }}" @endif>
							<span>Ссылка</span>
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
					<legend>Отнести к брэнду</legend>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<select name="refer_to" class="select-input">
								<option value="0">Не относится</option>
								{!! $brands_list !!}
							</select>
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
		</div>

		<div class="button-wrap tac">
			<button name="save" class="control-button" type="button">Применить</button>
		</div>
	</div>
</div>
@stop