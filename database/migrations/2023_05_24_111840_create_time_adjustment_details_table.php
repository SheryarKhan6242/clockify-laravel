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
        Schema::create('time_adjustment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('time_adj_id');
            $table->time('office_in');
            $table->time('office_out');

            $table->foreign('time_adj_id')->references('id')->on('time_adjustments')->cascadeOnDelete();
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
        Schema::dropIfExists('time_adjustment_details');
    }
};
