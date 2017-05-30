<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class News extends Model{
	protected $table = 'news';
	protected $fillable = [
		'title','slug','text','img_url',
		'meta_title','meta_description','meta_keywords',
		'also_reads','views','enabled','published_at'
	];
}