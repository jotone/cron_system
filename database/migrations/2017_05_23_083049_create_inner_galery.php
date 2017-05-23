<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInnerGalery extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inner_galery', function (Blueprint $table) {
			$table->increments('id');
			$table->text('img_url');
			$table->text('alt');
			$table->text('refer_to');//array ['type','id']
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('inner_galery');
	}
}
