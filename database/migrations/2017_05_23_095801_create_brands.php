<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrands extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('brands', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('slug');
			$table->tinyInteger('position')->unsigned();
			$table->integer('refer_to')->unsigned();
			$table->boolean('enabled')->unsigned();
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
		Schema::drop('brands');
	}
}
