<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFooterMenu extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('footer_menu', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
            $table->string('slug');
            $table->tinyInteger('position')->unsigned();
            $table->boolean('is_outer')->unsigned();
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
		Schema::drop('footer_menu');
	}
}
