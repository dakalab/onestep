<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaypalSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_settings', function (Blueprint $table) {
            $table->enum('env', ['sandbox', 'production'])->default('sandbox');
            $table->string('account');
            $table->string('client_id');
            $table->string('secret');
            $table->timestamps();
            $table->primary('env');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paypal_settings');
    }
}
