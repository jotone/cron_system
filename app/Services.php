<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Services extends Model{
	protected $table = 'services';
	protected $fillable = [
		'title','slug','text','img_url',
		'enabled','published_at'
	];
}