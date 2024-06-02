<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *         
              
              
          
              
              
              <th>Previous Payment Date</th>
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vid');
            $table->foreign('vid')->references('id')->on('vehicleregisters')->onDelete('cascade');
            $table->string('vnumber');
            $table->string('vname');
            $table->string('owner_name');
            $table->string('phone_number');
            $table->string('agreed_miledge');
            $table->string('agreed_payment');
            $table->string('liesence_renew_cost');
            $table->string('liesence_renew_date');
            $table->string('previous_mile');
            $table->string('additional_mile');
            $table->string('previous_pay_date');
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
        Schema::dropIfExists('owner_payments');
    }
};
