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
        Schema::create('svalues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staks_id');
            $table->foreign('staks_id')->references('id')->on('staks')->onDelete('cascade');
            $table->string('type');
            $table->string('checked_value');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('svalues');
    }
};
