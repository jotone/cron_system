<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Brand extends Model{
	protected $table = 'brands';
	protected $fillable = [
		'title','slug','seo_title','seo_text','position','refer_to','is_last','enabled'
	];
}