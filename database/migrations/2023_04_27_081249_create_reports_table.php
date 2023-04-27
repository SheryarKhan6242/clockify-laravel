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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('office_in');
            $table->string('office_out')->nullable();
            $table->boolean('is_late')->default(0);
            $table->string('late_reason')->nullable();
            $table->unsignedBigInteger('checkin_id');
            $table->longText('wfh_reason')->nullable();
            $table->string('total_work_hours')->nullable();
            $table->string('login_date');
            $table->unsignedBigInteger('shift_id');
            $table->string('clockin_location');
            $table->string('login_user_ip');

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('shift_id')->references('id')->on('shifts')->cascadeOnDelete();
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
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
        $table->dropForeign(['shift_id']);
        $table->dropColumn('shift_id');
        $table->dropForeign(['checkin_id']);
        $table->dropColumn('checkin_id');
        Schema::dropIfExists('reports');
    }
};
