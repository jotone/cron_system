<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class SpecifyPrice extends Model{
	protected $table = 'specify_price_request';
	protected $fillable = [
		'user_name','phone','product','status'
	];
}