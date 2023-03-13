<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->boolean('order_type');
			$table->float('tax_setting', 10, 0)->nullable()->default(0);
			$table->bigInteger('order_id');
			$table->float('total_sub', 10, 0);
			$table->float('total_tax', 10, 0);
			$table->integer('qty')->default(0);
			$table->float('discount', 10, 0)->nullable()->default(0);
			$table->string('discount_title', 191)->nullable();
			$table->float('discount_price', 10, 0)->nullable()->default(0);
			$table->integer('is_discount')->nullable()->default(0);
			$table->integer('unit_id');
			$table->string('unit_title', 191);
			$table->float('price_selling', 10, 0);
			$table->integer('is_tax')->nullable()->default(0);
			$table->dateTime('expiry_date')->nullable();
			$table->bigInteger('itm_code');
			$table->integer('branch_id');
			$table->integer('client_id');
			$table->text('branch');
			$table->text('product');
			$table->integer('attributes')->nullable()->default(0);
			$table->text('additionals')->nullable();
			$table->text('client');
			$table->timestamp('sdate')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->float('cash', 10, 0)->nullable()->default(0);
			$table->float('online', 10, 0)->nullable()->default(0);
			$table->float('installment', 10, 0)->nullable()->default(0);
			$table->integer('order_return')->nullable();
			$table->boolean('add_by_id')->nullable();
			$table->string('add_by_name', 191)->nullable();
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
		Schema::drop('orders');
	}

}
