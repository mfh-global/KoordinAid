<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const SCHEMA_NAME = 'boxes';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::SCHEMA_NAME, function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->integer('boxtribute_id')->index();
            $table->foreignId('product_id')->references('id')->on('products');
            $table->foreignId('size_id')->references('id')->on('sizes');
            $table->foreignId('location_id')->references('id')->on('locations');
            $table->integer('number_of_items')->default(0);
            $table->integer('label_identifier')->index();
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
        Schema::dropIfExists(self::SCHEMA_NAME);
    }
};
