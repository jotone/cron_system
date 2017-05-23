<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNews extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('slug');
			$table->text('text');
			$table->text('img_url'); //preview
			$table->boolean('also_reads')->unsigned();
			$table->integer('views')->unsigned();
			$table->boolean('enabled')->unsigned();
			$table->timestamp('published_at');
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
		Schema::drop('news');
	}
}
