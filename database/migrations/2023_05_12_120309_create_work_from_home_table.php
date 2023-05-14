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
        Schema::create('work_from_home', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('reason');
            $table->boolean('status');
            $table->bigInteger('approved_by')->unsigned()->nullable();
            $table->longText('attach_file')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onCascadeDelete();
            $table->foreign('approved_by')->references('id')->on('users')->onCascadeDelete();
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
        Schema::dropIfExists('work_from_home');
    }
};
