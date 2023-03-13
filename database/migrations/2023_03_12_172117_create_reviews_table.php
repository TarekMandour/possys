<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reviews', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('rate')->default(0);
			$table->string('name', 191);
			$table->string('email', 191);
			$table->string('phone', 191);
			$table->text('comment');
			$table->bigInteger('post_id')->unsigned()->nullable()->index('reviews_post_id_foreign');
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
		Schema::drop('reviews');
	}

}
