<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class SocialMenu extends Model{
	protected $table = 'social_menu';
	protected $fillable = [
		'title','slug','img_url','position','enabled'
	];
}