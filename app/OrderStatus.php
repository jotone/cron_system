<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class OrderStatus extends Model{
	protected $table = 'orders_status';
	protected $fillable = [
		'user_id','user_firstname','user_lastname','phone','email','address','delivery_type','history','status'
	];
}