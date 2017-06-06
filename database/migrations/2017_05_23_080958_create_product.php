<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduct extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('slug');
			$table->text('text');
			$table->text('img_url');
			$table->float('old_price');
			$table->float('price');
			$table->integer('refer_to_category')->unsigned();
			$table->integer('refer_to_brand')->unsigned();
			$table->tinyInteger('rating')->unsigned();
			$table->tinyInteger('is_hot')->unsigned();
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
		Schema::drop('products');
	}
}
