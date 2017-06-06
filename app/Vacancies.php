<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Vacancies extends Model{
	protected $table = 'vacancies';
	protected $fillable = [
		'title','slug','text','img_url',
		'meta_title','meta_description','meta_keywords',
		'views','enabled','published_at'
	];
}