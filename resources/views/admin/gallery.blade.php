@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/gallery.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">{{ $page_title }}</div>

		<div class="button-wrap">
			<a class="control-button" href="#" id="addImage">Добавить</a>
		</div>

		<div class="image-add-wrap col_1_2">
			<fieldset>
				<div class="row-wrap cfix">
					<div class="fl col_1_8">
						<input style="display: none" name="galleryImageLoader" placeholder="Обзор&hellip;" type="file">
						<div class="row-wrap">
							<input class="control-button" name="galleryLoad" type="button" value="Обзор&hellip;">
						</div>
						<div class="row-wrap">
							<input style="display: none;" class="control-button" name="addThisImage" type="button" value="Загрузить&hellip;">
						</div>
					</div>
					<div class="upload-image-preview tac fl col_3_4"></div>
				</div>
			</fieldset>
		</div>

		<div class="photos-main-wrap">
			@foreach($photos as $photo)
				<div class="photo-wrap @if(empty($photo['used_in'])) disactive @endif">
					<div class="image-wrap">
						<img src="{{ URL::asset($photo['img']) }}" alt="">
					</div>
					<div class="desc-wrap">
						@if(!empty($photo['used_in']))
							@foreach($photo['used_in'] as $type => $items)
								<?php
								$descript = '<p>Используется в ';
								switch($type){
									case 'brand':		$descript .= 'Брэнды:</p>'; break;
									case 'news':		$descript .= 'Новости:</p>'; break;
									case 'products':	$descript .= 'Товары:</p>'; break;
									case 'social':		$descript .= 'Соц.Сети:</p>'; break;
									case 'vacancies':	$descript .= 'Вакансии:</p>'; break;
								}
								?>
								{!! $descript !!}
								<ul>
								@foreach($items as $title)
									<li>{{ $title }}</li>
								@endforeach
								</ul>
							@endforeach
						@else
							<p>Не используется</p>
						@endif
					</div>
					<div class="image-src">URL: <span>{{ $photo['img'] }}</span></div>
					<div class="image-drop">
						<a class="button drop" href="#" title="Удалить">
							<img src="{{ URL::asset('images/drop.png') }}" alt="Удалить">
						</a>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
@stop