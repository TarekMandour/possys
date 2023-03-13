<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferPermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transfer_permissions', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('branch_from_id')->unsigned()->nullable()->index('transfer_permissions_branch_from_id_foreign');
			$table->bigInteger('branch_to_id')->unsigned()->nullable()->index('transfer_permissions_branch_to_id_foreign');
			$table->bigInteger('qty');
			$table->bigInteger('itm_code');
			$table->dateTime('expiry_date')->nullable();
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
		Schema::drop('transfer_permissions');
	}

}
