<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table)
		{
			$table->bigInteger('id')->unsigned()->primary();
			$table->string('title', 191);
			$table->string('title_en', 191)->nullable();
			$table->text('meta_keywords');
			$table->text('meta_description');
			$table->text('meta_description_en')->nullable();
			$table->text('logo1')->nullable();
			$table->text('logo2')->nullable();
			$table->text('fav')->nullable();
			$table->text('breadcrumb')->nullable();
			$table->string('site_lang', 191)->nullable();
			$table->string('phone1', 191);
			$table->string('phone2', 191)->nullable();
			$table->string('email1', 191);
			$table->string('email2', 191)->nullable();
			$table->string('address', 191);
			$table->text('address_en')->nullable();
			$table->text('tax_num');
			$table->string('currency', 191)->nullable();
			$table->string('printing', 191)->nullable();
			$table->string('facebook', 191)->nullable();
			$table->string('twitter', 191)->nullable();
			$table->string('youtube', 191)->nullable();
			$table->string('linkedin', 191)->nullable();
			$table->string('instagram', 191)->nullable();
			$table->string('snapchat', 191)->nullable();
			$table->timestamps();
			$table->enum('website_type', array('sell','show'))->default('sell');
			$table->float('tax', 10, 0)->default(0);
			$table->text('background')->nullable();
			$table->integer('delivery_cost')->nullable()->default(0);
			$table->enum('opt', array('email','sms'))->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings');
	}

}
