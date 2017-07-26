<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersStatus extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('orders_status', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('user_firstname');
			$table->string('user_lastname');
			$table->string('phone', 31);
			$table->string('email');
			$table->text('address');
			$table->integer('delivery_type')->unsigned();
			$table->text('history');
			$table->tinyInteger('status')->unsigned();//0 - in progress, 1 - done, 2 - canceled
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
		Schema::drop('orders_status');
	}
}
