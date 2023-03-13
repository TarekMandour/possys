<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('title', 191);
			$table->text('content');
			$table->string('title_en', 250)->nullable();
			$table->text('content_en')->nullable();
			$table->text('meta_keywords')->nullable();
			$table->text('meta_description')->nullable();
			$table->text('photo')->nullable();
			$table->text('lat')->nullable();
			$table->text('lng')->nullable();
			$table->text('whywedo')->nullable();
			$table->text('mission')->nullable();
			$table->text('vision')->nullable();
			$table->timestamps();
			$table->string('photo2', 191)->nullable();
			$table->string('photo3', 191)->nullable();
			$table->string('photo4', 191)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pages');
	}

}
