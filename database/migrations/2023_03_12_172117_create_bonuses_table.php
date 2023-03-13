<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bonuses', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('admin_id');
			$table->bigInteger('pro_id');
			$table->float('percent', 10, 0);
			$table->text('product')->nullable();
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
		Schema::drop('bonuses');
	}

}
