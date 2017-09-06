<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecifyPrice extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('specify_price_request', function (Blueprint $table) {
			$table->increments('id');
			$table->string('user_name');
			$table->string('phone',32);
			$table->integer('product')->unsigned();
			$table->tinyInteger('status')->unsigned();
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
		Schema::drop('specify_price_request');
	}
}
