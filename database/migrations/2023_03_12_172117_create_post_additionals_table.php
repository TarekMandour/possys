<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostAdditionalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_additionals', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('addname', 191)->nullable();
			$table->float('addprice', 10, 0)->default(0);
			$table->bigInteger('itm_code');
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
		Schema::drop('post_additionals');
	}

}
