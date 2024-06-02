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
        Schema::create('customer_deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cus_id');
            $table->string('invoice');
            $table->foreign('cus_id')->references('id')->on('customer_regs')->onDelete('cascade');
            $table->string('name');
            $table->string('deposit');
            $table->string('current_deposit');
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
        Schema::dropIfExists('customer_deposits');
    }
};
