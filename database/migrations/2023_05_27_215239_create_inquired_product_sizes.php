<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquired_product_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquired_product_id')->references('id')->on('inquired_products');
            $table->foreignId('size_id')->references('id')->on('sizes');
            $table->unsignedInteger('number_of_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inquired_product_sizes');
    }
};
