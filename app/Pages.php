<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Pages extends Model{
	protected $table = 'pages';
	protected $fillable = [
		'title','link','content',
		'meta_title','meta_keywords','meta_description',
		'need_seo','seo_title','seo_text'
	];
}