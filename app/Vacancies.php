<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Vacancies extends Model{
	protected $table = 'vacancies';
	protected $fillable = [
		'title','slug','text','img_url','views','enabled','published_at'
	];
}