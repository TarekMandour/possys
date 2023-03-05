<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id(); 
            $table->string('title');
            $table->text('meta_keywords');
            $table->text('meta_description');
            $table->text('logo1')->nullable();
            $table->text('logo2')->nullable();
            $table->text('fav')->nullable();
            $table->text('breadcrumb')->nullable();
            $table->string('site_lang')->nullable();
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->string('email1');
            $table->string('email2')->nullable();
            $table->string('address');
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('snapchat')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
