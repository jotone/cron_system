<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Products extends Model{
	protected $table = 'products';
	protected $fillable = [
		'title','slug','text','img_url','old_price','price',
		'refer_to_category','refer_to_brand',
		'rating','is_hot','show_on_main','views',
		'enabled','published_at','import_id'
	];
}