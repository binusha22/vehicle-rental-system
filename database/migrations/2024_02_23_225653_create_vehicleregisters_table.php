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
        Schema::create('vehicleregisters', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->string('year');
            $table->string('vehicle_number');
            $table->string('mielage');
            $table->string('lice_start');
            $table->string('lice_end');
            $table->string('insu_start');
            $table->string('insu_end');
            $table->string('owner_type');
            $table->string('owner_fname');
            $table->string('owner_id');
            $table->string('owner_phone_number');
            $table->string('registerdate');

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
        Schema::dropIfExists('vehicleregisters');
    }
};
