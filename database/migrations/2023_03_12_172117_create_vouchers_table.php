<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vouchers', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('user_id')->nullable();
			$table->enum('user_type', array('client','supplier','external'))->default('client');
			$table->string('external_name', 191)->nullable();
			$table->date('trans_date');
			$table->enum('pay_type', array('cash','network'))->default('cash');
			$table->enum('type', array('receipt','exchange'))->default('receipt');
			$table->float('amount', 10, 0);
			$table->text('notes')->nullable();
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
		Schema::drop('vouchers');
	}

}
