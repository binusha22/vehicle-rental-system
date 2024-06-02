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
        Schema::create('vehicle_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->foreign('vehicle_id')->references('id')->on('vehicleregisters')->onDelete('cascade');
            $table->String('vehicle_name');
            $table->String('vehicle_number');
            $table->String('out_mileage')->default('0');
            $table->String('in_mileage')->default('0');
            $table->String('trip_mileage')->default('0');
            $table->String('out_date')->default('0');
            $table->String('in_date')->default('0');
            $table->String('reason');
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
        Schema::dropIfExists('vehicle_statuses');
    }
};
