<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasCartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchas_carts', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('emp_id');
			$table->bigInteger('itm_code');
			$table->string('title_en', 191);
			$table->float('price_purchasing', 10, 0);
			$table->integer('qty');
			$table->integer('is_tax');
			$table->float('price_selling', 10, 0);
			$table->float('price_minimum_sale', 10, 0);
			$table->dateTime('production_date')->nullable();
			$table->dateTime('expiry_date')->nullable();
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
		Schema::drop('purchas_carts');
	}

}
