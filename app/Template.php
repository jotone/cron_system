<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Template extends Model{
	protected $table = 'templates';
	protected $fillable = [
		'title','slug','content'
	];
}