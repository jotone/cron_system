<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class EmailResets extends Model{
	protected $table = 'email_resets';
	protected $fillable = [
		'old_email','new_email','password','user_id','finished'
	];
}