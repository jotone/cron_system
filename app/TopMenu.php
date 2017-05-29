<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class TopMenu extends Model{
	protected $table = 'top_menu';
	protected $fillable = [
		'title','slug','position','enabled'
	];
}