<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->enum('user_type', ['client', 'supplier', 'external'])->default('client');
            $table->string('external_name')->nullable();
            $table->date('trans_date');
            $table->enum('pay_type', ['cash', 'network'])->default('cash');
            $table->enum('type', ['receipt', 'exchange'])->default('receipt');
            $table->double('amount');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('vouchers');
    }
}
