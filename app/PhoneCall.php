<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class PhoneCall extends Model{
	protected $table = 'phone_call';
	protected $fillable = [
		'user_name','phone','info'
	];
}