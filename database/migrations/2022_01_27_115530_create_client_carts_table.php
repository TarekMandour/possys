<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_carts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('branch_id');
            $table->bigInteger('client_id');
            $table->bigInteger('itm_code');
            $table->text('title_en');
            $table->timestamp('expiry_date')->nullable();
            $table->integer('qty');
            $table->bigInteger('unit_id');
            $table->text('unit_title');
            $table->integer('is_tax');
            $table->integer('price_selling');
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
        Schema::dropIfExists('client_carts');
    }
}
