<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sliders', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('title1', 191);
			$table->string('title2', 191)->nullable();
			$table->string('title1_en', 191)->nullable();
			$table->string('title2_en', 191)->nullable();
			$table->text('content')->nullable();
			$table->boolean('sort')->default(0);
			$table->text('photo')->nullable();
			$table->text('logo')->nullable();
			$table->timestamps();
			$table->bigInteger('product_id')->unsigned()->nullable()->index('sliders_product_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sliders');
	}

}
