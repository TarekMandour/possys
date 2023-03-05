<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_permissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('branch_from_id')->unsigned()->nullable();
            $table->foreign('branch_from_id')->references('id')->on('branches')->onDelete('set null');
            $table->bigInteger('branch_to_id')->unsigned()->nullable();
            $table->foreign('branch_to_id')->references('id')->on('branches')->onDelete('set null');
            $table->bigInteger('qty');
            $table->bigInteger('itm_code');
            $table->timestamp('expiry_date')->nullable();
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
        Schema::dropIfExists('transfer_permissions');
    }
}
