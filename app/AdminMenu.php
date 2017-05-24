<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class AdminMenu extends Model{
	protected $table = 'admin_table';
	protected $fillable = [
		'title','slug','position','refer_to'
	];
}