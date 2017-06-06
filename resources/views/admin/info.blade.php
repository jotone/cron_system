@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/info.js') }}"></script>
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
			<div>
				<fieldset>
					<legend>{{ $content['phone']['title'] }}</legend>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="phone" type="text" class="text-input col_1_2 needPhoneMask" placeholder="{{ $content['phone']['title'] }}&hellip;" value="{{ $content['phone']['val'] }}">
						</label>
					</div>
				</fieldset>

				<fieldset>
					<legend>{{ $content['email']['title'] }}</legend>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<input name="email" type="email" class="text-input col_1_2" placeholder="{{ $content['email']['title'] }}&hellip;" value="{{ $content['email']['val'] }}">
						</label>
					</div>
				</fieldset>

				<fieldset>
					<legend>{{ $content['address']['title'] }}</legend>
					<div class="row-wrap">
						<textarea class="needCKE" name="address">{{ $content['address']['val'] }}</textarea>
					</div>
				</fieldset>

				<fieldset>
					<legend>{{ $content['work_time']['title'] }}</legend>
					<div class="row-wrap">
						<textarea class="needCKE" name="work_time">{{ $content['work_time']['val'] }}</textarea>
					</div>
				</fieldset>

				<fieldset>
					<legend>{{ $content['social']['title'] }}</legend>
					<div id="socList">
						@if(!empty($content['social']['val']))
							@foreach($content['social']['val'] as $social)
								<?php
								switch($social->slug){
									case 'facebook':	$title = 'FaceBook'; break;
									case 'google_plus':	$title = 'Google+'; break;
									case 'instagram':	$title = 'Instagram'; break;
									case 'linkedin':	$title = 'LinkedIn'; break;
									case 'livejournal':	$title = 'LiveJournal'; break;
									case 'mailru':		$title = 'MailRu'; break;
									case 'pinterest':	$title = 'Pinterest'; break;
									case 'twitter':		$title = 'Twitter'; break;
									case 'viber':		$title = 'Viber'; break;
									case 'whatsapp':	$title = 'WhatsApp'; break;
									case 'vkontakte':	$title = 'Вконтакте'; break;
									case 'odnoklassniki':$title= 'Одноклассники'; break;
									default: $title = '';
								}
								?>
								<div class="row-wrap col_1_2" style="display: flex; align-items: center">
									<span style="width: 110px; padding-right: 10px;" class="tar">{{ $title }}:</span>
									<input name="socLink" type="text" class="text-input col_4_5" placeholder="Ссылка&hellip;" data-soc="{{$social->slug}}" value="{{$social->link}}">
									<span class="drop-add-field">×</span>
								</div>
							@endforeach
						@endif
					</div>
					<div class="row-wrap">
						<ul class="pseudo-selector col_1_4">
							<li class="active" data-soc="facebook"><img src="{{ URL::asset('/images/social/fb-icon.png') }}"><span>FaceBook</span></li>
							<li data-soc="google_plus"><img src="{{ URL::asset('/images/social/gp-icon.png') }}"><span>Google+</span></li>
							<li data-soc="instagram"><img src="{{ URL::asset('/images/social/insta-icon.png') }}"><span>Instagram</span></li>
							<li data-soc="linkedin"><img src="{{ URL::asset('/images/social/li-icon.png') }}"><span>LinkedIn</span></li>
							<li data-soc="livejournal"><img src="{{ URL::asset('/images/social/lj-icon.png') }}"><span>LiveJournal</span></li>
							<li data-soc="mailru"><img src="{{ URL::asset('/images/social/mailru-icon.png') }}"><span>MailRu</span></li>
							<li data-soc="pinterest"><img src="{{ URL::asset('/images/social/pinterest-icon.png') }}"><span>Pinterest</span></li>
							<li data-soc="twitter"><img src="{{ URL::asset('/images/social/tw-icon.png') }}"><span>Twitter</span></li>
							<li data-soc="viber"><img src="{{ URL::asset('/images/social/viber-icon.png') }}"><span>Viber</span></li>
							<li data-soc="whatsapp"><img src="{{ URL::asset('/images/social/wa-icon.png') }}"><span>WhatsApp</span></li>
							<li data-soc="vkontakte"><img src="{{ URL::asset('/images/social/vk-icon.png') }}"><span>Вконтакте</span></li>
							<li data-soc="odnoklassniki"><img src="{{ URL::asset('/images/social/ok-icon.png') }}"><span>Одноклассники</span></li>
						</ul>
					</div>
					<div class="row-wrap">
						<button name="moreSocial" class="control-button">Добавить&hellip;</button>
					</div>
				</fieldset>

				<fieldset>
					<legend>{{ $content['map_marker']['title'] }}</legend>
					<div class="row-wrap">
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
							<div class="upload-image-preview tac fl col_3_4">
								<img src="{{ $content['map_marker']['val'] }}" alt="" data-type="file">
							</div>
						</div>
					</div>
				</fieldset>

				<fieldset>
					<legend>{{ $content['marker_coordinates']['title'] }}</legend>
					<div class="row-wrap">
						<label class="fieldset-label-wrap">
							<span>X&#8431;</span>
							<input name="x" type="text" class="text-input col_1_4" value="{{ $content['marker_coordinates']['val']->x }}">
						</label>
						<label class="fieldset-label-wrap" style="padding-left: 30px;">
							<span>Y &uarr;</span>
							<input name="y" type="text" class="text-input col_1_4" value="{{ $content['marker_coordinates']['val']->y }}">
						</label>
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