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
        Schema::create('allowances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->date('allowance_date');
            $table->bigInteger('approver_id')->unsigned()->nullable();
            $table->bigInteger('allowance_id')->unsigned();
            $table->longText('description');
            $table->string('receipt_id')->nullable();
            //Medical & General Allowance
            $table->float('amount')->nullable();
            //Medical & General Allowance
            //Sunday Allowance
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->string('attachment')->nullable();
            //Sunday Allowance
            //Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('approver_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('allowance_id')->references('id')->on('allowance_types')->cascadeOnDelete();
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
        Schema::dropIfExists('allowances');
    }
};
