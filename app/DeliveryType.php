<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class DeliveryType extends Model{
	protected $table = 'delivery_type';
	protected $fillable = [
		'title','slug','price','position','terms'
	];
}