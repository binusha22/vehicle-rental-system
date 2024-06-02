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
        Schema::create('carreplaces', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->string('customer_name');
            $table->string('id_number');
            $table->string('passport');
            $table->string('deposit');
            $table->string('vehicle_name');
            $table->string('vehicle_number');
            $table->string('status');
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
        Schema::dropIfExists('carreplaces');
    }
};
