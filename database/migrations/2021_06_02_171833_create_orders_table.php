<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('order_type');
            $table->double('tax_setting')->default(0)->nullable();
            $table->bigInteger('order_id');
            $table->float('total_sub');
            $table->float('total_tax');
            $table->integer('qty')->default(0);
            $table->float('discount')->default(0)->nullable();
            $table->string('discount_title')->nullable();
            $table->float('discount_price')->nullable()->default(0);
            $table->integer('is_discount')->nullable()->default(0);
            $table->integer('unit_id');
            $table->string('unit_title');
            $table->float('price_selling');
            $table->integer('is_tax')->nullable()->default(0);
            $table->timestamp('expiry_date')->nullable();
            $table->bigInteger('itm_code');
            $table->integer('branch_id');
            $table->integer('client_id');
            $table->text('branch');
            $table->text('product');
            $table->integer('attributes')->nullable()->default(0);
            $table->text('additionals')->nullable();
            $table->text('client');
            $table->timestamp('sdate')->nullable()->default("current_timestamp()");
            $table->float('cash')->nullable()->default(0);
            $table->float('online')->nullable()->default(0);
            $table->float('installment')->nullable()->default(0);
            $table->integer('order_return')->nullable();
            $table->tinyInteger('add_by_id')->nullable();
            $table->string('add_by_name')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
