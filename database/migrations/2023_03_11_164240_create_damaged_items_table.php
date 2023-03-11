<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamagedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damaged_items', function (Blueprint $table) {
            $table->increments('id');
            $table->text('product');
            $table->integer('qty')->default(0);
            $table->date('date')->nullable();
            $table->integer('branch_id');
            $table->string('branch_name');
            $table->text('admin');
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
        Schema::dropIfExists('damaged_items');
    }
}
