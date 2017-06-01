<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Brand extends Model{
	protected $table = 'brands';
	protected $fillable = [
		'title','slug','img_url','position','refer_to','is_last','enabled'
	];
}