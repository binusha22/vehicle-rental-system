<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.

*vehicle pickup location
*sellect employee(e dwase IN dapu ewn witrai methnt ennee)
*start date
*end date
*advanced amount(not required)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->string('vehicle_number');
            $table->string('vehicle_name');
            $table->string('customer_name');
            $table->string('cus_id');
            $table->string('cus_passport');
            $table->string('mobile');
            $table->string('vehicle_pickup_location')->default('no-place');
            $table->string('select_employee');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('status');
            $table->float('advanced')->default('0000');
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
        Schema::dropIfExists('bookings');
    }
};
