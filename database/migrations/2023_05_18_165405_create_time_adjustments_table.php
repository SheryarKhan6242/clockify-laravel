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
        Schema::create('time_adjustments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->date('adj_date');
            $table->time('office_in');
            $table->time('office_out');
            $table->bigInteger('report_id')->unsigned()->nullable();
            $table->bigInteger('checkin_id')->unsigned();
            $table->string('adj_reason');
            $table->string('wfh_reason')->nullable();
            $table->string('status');

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('report_id')->references('id')->on('reports')->cascadeOnDelete();
            $table->foreign('checkin_id')->references('id')->on('checkin_types')->cascadeOnDelete();
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
        Schema::dropIfExists('time_adjustments');
    }
};
