@extends('admin.layout.default')
@section('content')
<div class="main-block">
	<div class="center-wrap col_1">
		<div class="page-caption row-wrap">{{ $page_title }}</div>
		<table class="item-list col_1">
			<thead>
			<tr>
				<th></th>
				<th></th>
				<th>e-mail</th>
				<th>Имя</th>
				<th>Телефон</th>
				<th>Роль</th>
				<th>Создан</th>
				<th>Изменен</th>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
@stop