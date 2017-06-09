<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Brand extends Model{
	protected $table = 'brands';
	protected $fillable = [
		'title','slug','position','refer_to','is_last','enabled'
	];
}