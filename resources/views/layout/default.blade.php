@include('layout.head_styles')
@yield('content')
@include('layout.hidden_block')
<?php $temp = (isset($allow_map))? true: false; ?>
@include('layout.scripts', ['allow_map'=>$temp])