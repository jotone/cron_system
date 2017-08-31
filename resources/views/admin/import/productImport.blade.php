@extends('admin.layout.default')
@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/admin/import_products.js') }}"></script>
@stop
@section('content')
<div class="main-block">
	<div class="center-wrap col_1">
		<div class="work-place-wrap">
			<div>
				<form method="post" action="{{ route('admin-products-import-ajax-csv') }}" data-arr-import="" enctype="multipart/form-data" class="-form_import">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="action" value="to_json">
					<fieldset>
						<legend>Импорт товаров CSV:</legend>
						<div class="row-wrap">
								<label class="fieldset-label-wrap">
									<input id="fileSelect" name="file_products" type="file" accept=".csv" required="" />
								</label>
						</div>
						<div class="row-wrap">
								<label class="fieldset-label-wrap">
									<input type="submit" value="Импорт" />
								</label>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="progress_import">
				<ul class="-progress_import">
				</ul>
			</div>
		</div>

	</div>
</div>
@stop