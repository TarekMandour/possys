<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->string('email', 191)->nullable()->unique('admins_email_unique');
			$table->string('phone', 191)->unique('admins_phone_unique');
			$table->string('password', 191);
			$table->text('photo')->nullable();
			$table->boolean('is_active');
			$table->integer('code')->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->string('city', 191)->nullable();
			$table->string('address', 191)->nullable();
			$table->string('location', 191)->nullable();
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
		Schema::drop('clients');
	}

}
