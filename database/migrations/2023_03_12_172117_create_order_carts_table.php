<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderCartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_carts', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('emp_id');
			$table->bigInteger('itm_code');
			$table->string('title_en', 191);
			$table->dateTime('expiry_date')->nullable();
			$table->integer('qty');
			$table->integer('unit_id');
			$table->string('unit_title', 191);
			$table->integer('is_tax');
			$table->float('price_selling', 10, 0);
			$table->float('discount', 10, 0)->nullable()->default(0);
			$table->string('discount_title', 191)->nullable();
			$table->float('discount_price', 10, 0)->nullable()->default(0);
			$table->integer('is_discount')->nullable()->default(0);
			$table->integer('attributes')->nullable()->default(0);
			$table->text('additionals')->nullable();
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
		Schema::drop('order_carts');
	}

}
