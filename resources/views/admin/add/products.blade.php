@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/products.js') }}"></script>
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
					</div>show_on_main
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="enabled" type="checkbox" class="chbox-input" @if(isset($content)) @if($content->enabled == 1) checked="checked" @endif @else checked="checked" @endif>
							<span>Опубликовать немедленно</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="show_on_main" type="checkbox" class="chbox-input" @if( (isset($content)) && ($content->show_on_main == 1)) checked="checked" @endif>
							<span>Показать на главной</span>
						</label>
					</div>
				</fieldset>

				<fieldset>
					<legend>Брэнд</legend>
					<div class="row-wrap">
						<select name="brand" class="select-input">
						@foreach($brands as $brand)
							<option value="{{ $brand->id }}" @if(isset($content)) @if($brand->id == $content->refer_to_brand) selected="selected" @endif @endif>{{ $brand->title }}</option>
						@endforeach
						</select>
					</div>
				</fieldset>

				<fieldset>
					<legend>Категория</legend>
					<div class="row-wrap">
						<select name="category" class="select-input">
						@foreach($categories as $category)
							<option value="{{ $category->id }}" @if(isset($content)) @if($category->id == $content->refer_to_category) selected="selected" @endif @endif>{{ $category->title }}</option>
						@endforeach
						</select>
					</div>
				</fieldset>

				<fieldset>
					<legend>Цены</legend>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="old_price" type="text" class="text-input col_1_2" placeholder="Старая цена&hellip;" @if(isset($content->old_price)) value="{{ $content->old_price }}" @endif>
							<span>Старая цена</span>
						</label>
					</div>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="price" type="text" class="text-input col_1_2" placeholder="Цена&hellip;" @if(isset($content->price)) value="{{ $content->price }}" @endif>
							<span>Цена</span>
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

				<fieldset>
					<legend>Рейтинг</legend>
					<div class="row-wrap rating-wrap">
					@for($i=1; $i<=5; $i++)
						<label>
							<input name="rating" type="radio" style="display: none" value="{{ $i }}" @if( (isset($content)) && ($content->rating == $i)) checked="checked" @endif>
							<img src="/images/star.png" alt="{{ $i }}" @if( (isset($content)) && ($content->rating >= $i)) class="active" @endif>
						</label>
					@endfor
					</div>
				</fieldset>

				<fieldset>
					<legend>Тип Специального Предложения</legend>
					<div class="row-wrap">
						<select name="is_hot" class="select-input">
							<option value="0" @if( (isset($content)) && ($content->is_hot == 0)) selected="selected" @endif>Не назначать</option>
							<option value="1" @if( (isset($content)) && ($content->is_hot == 1)) selected="selected" @endif>Горячая (HOT)</option>
							<option value="2" @if( (isset($content)) && ($content->is_hot == 2)) selected="selected" @endif>Распродажа (SALE)</option>
						</select>
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