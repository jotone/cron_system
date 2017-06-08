<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('link');
			$table->text('content');
			$table->string('meta_title');
			$table->string('meta_keywords');
			$table->string('meta_description');
			$table->boolean('need_seo')->unsigned();
			$table->string('seo_title');
			$table->text('seo_text');
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
		Schema::drop('pages');
	}
}
