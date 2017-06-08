<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class PageContent extends Model{
	protected $table = 'pages_content';
	protected $fillable = [
		'type','meta_key','meta_value'
	];
}