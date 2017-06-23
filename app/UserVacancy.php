<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class UserVacancy extends Model{
	protected $table = 'user_vacancy';
	protected $fillable = [
		'name','phone','email','file','refer_to_vacancy','status'
	];
}