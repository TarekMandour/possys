<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admins', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->string('email', 191)->unique();
			$table->string('phone', 191)->unique();
			$table->string('password', 191);
			$table->text('photo')->nullable();
			$table->boolean('is_active');
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->boolean('type')->default(0);
			$table->bigInteger('branch_id')->unsigned()->nullable()->index('admins_branch_id_foreign');
			$table->string('api_token', 191)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('admins');
	}

}
