<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Questions extends Model{
	protected $table = 'questions';
	protected $fillable = [
		'user_name','organisation','city','phone','callback_type','email','question','status'
	];
}