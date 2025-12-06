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
        Schema::create('organisations', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->string('phone_number', 255)->nullable();
            $table->string('full_name', 255);
            $table->string('organisation', 255);
            $table->string('address', 255);
            $table->string('city', 255);
            $table->string('zipcode', 255);
            $table->string('state', 255)->nullable();
            $table->string('e_mail', 255);
            $table->string('country', 255);
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
        Schema::dropIfExists('organisations');
    }
};
