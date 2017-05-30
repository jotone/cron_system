<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class News extends Model{
	protected $table = 'news';
	protected $fillable = [
		'title','slug','text','img_url','also_reads','views','enabled','published_at'
	];
}