<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stocks', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('qty')->default(0);
			$table->integer('qty_mid')->nullable()->default(0);
			$table->integer('qty_sm')->nullable()->default(0);
			$table->float('price_purchasing', 10, 0)->nullable();
			$table->float('price_selling', 10, 0);
			$table->float('price_minimum_sale', 10, 0)->nullable()->default(1);
			$table->dateTime('production_date')->nullable();
			$table->dateTime('expiry_date')->nullable();
			$table->bigInteger('itm_code');
			$table->integer('branch_id');
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
		Schema::drop('stocks');
	}

}
