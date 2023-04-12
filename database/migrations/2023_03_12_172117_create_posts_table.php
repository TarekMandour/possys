<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('title', 191);
			$table->string('title_en', 191)->nullable();
			$table->text('content')->nullable();
			$table->integer('cat_id');
			$table->integer('is_show')->default(1);
			$table->integer('is_tax')->nullable()->default(0);
			$table->bigInteger('itm_code')->unique('itm_code');
			$table->integer('itm_unit1');
			$table->integer('itm_unit2');
			$table->integer('itm_unit3');
			$table->integer('mid')->default(1);
			$table->integer('sm')->default(1);
			$table->integer('status')->default(1);
			$table->integer('stock_limit')->default(2);
			$table->text('photo')->nullable();
			$table->timestamps();
			$table->bigInteger('branch_id')->unsigned()->nullable()->index('posts_branch_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
