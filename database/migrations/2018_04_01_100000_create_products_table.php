<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku')->unique();
            $table->string('spu')->index();
            $table->unsignedInteger('category_id')->default(0)->index();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('quantity')->default(0);
            $table->unsignedInteger('viewed')->default(0);
            $table->unsignedInteger('sales')->default(0);
            $table->boolean('hidden')->default(0);
            $table->string('seo_url')->unique();
            $table->string('keywords')->nullable();
            $table->string('meta_desc', 500)->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
