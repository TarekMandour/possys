<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wallets', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('walletable_type', 191);
			$table->bigInteger('walletable_id')->unsigned();
			$table->float('in', 10, 0)->default(0)->comment('داين');
			$table->float('out', 10, 0)->default(0)->comment('مدين');
			$table->date('trans_date');
			$table->text('notes');
			$table->enum('type', array('client','supplier'))->default('client');
			$table->timestamps();
			$table->index(['walletable_type','walletable_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wallets');
	}

}
