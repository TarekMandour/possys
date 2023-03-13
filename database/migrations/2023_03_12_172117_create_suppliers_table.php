<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('suppliers', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('title', 191);
			$table->text('address')->nullable();
			$table->integer('phone');
			$table->string('sales_name', 191)->nullable();
			$table->integer('phone2')->nullable();
			$table->string('email', 191)->nullable();
			$table->text('num')->nullable();
			$table->boolean('is_active')->default(1);
			$table->timestamps();
			$table->string('tax_number', 191)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('suppliers');
	}

}
