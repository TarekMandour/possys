<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeficienciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('deficiencies', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->text('product');
			$table->integer('branch_id');
			$table->string('branch_name', 191);
			$table->text('admin');
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
		Schema::drop('deficiencies');
	}

}
