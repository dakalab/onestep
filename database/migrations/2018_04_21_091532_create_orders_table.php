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
            $table->string('order_no')->unique();
            $table->unsignedInteger('user_id')->default(0)->index();
            $table->string('email')->nullable();
            $table->enum('status', [
                'pending', 'paid', 'shipped', 'complete', 'canceled', 'refunded', 'expired',
            ])->default('pending');
            $table->decimal('total', 10, 2)->default(0);
            $table->decimal('product_amount', 10, 2)->default(0);
            $table->decimal('shipping_fee', 8, 2)->default(0);
            $table->decimal('tax', 8, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->string('currency')->default('USD');
            $table->decimal('exchange_rate', 10, 4)->default(1);
            $table->string('shipping_method')->default('free');
            $table->string('payment_method')->default('paypal');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('address');
            $table->string('city');
            $table->string('province')->nullable();
            $table->string('country');
            $table->string('postcode')->nullable();
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('comment')->nullable();
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('express')->nullable();
            $table->string('tracking_no')->default('')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
