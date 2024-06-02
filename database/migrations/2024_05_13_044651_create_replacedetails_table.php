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
        Schema::create('replacedetails', function (Blueprint $table) {
            $table->id();
            $table->string('new_inv');
            $table->string('old_inv');
            $table->string('cus_name');
            $table->string('cus_id');
            $table->string('passport');
            $table->string('reg_date');
            $table->string('s_date');
            $table->string('e_date');
            $table->string('old_v_number');
            $table->string('new_v_number');
            $table->string('trip_amount');
            $table->string('additional_cost_km');
            $table->string('rest_of_deposit');
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
        Schema::dropIfExists('replacedetails');
    }
};
