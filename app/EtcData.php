<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class EtcData extends Model{
	protected $table = 'etc_data';
	protected $fillable = [
		'title','key','label','value'
	];
}