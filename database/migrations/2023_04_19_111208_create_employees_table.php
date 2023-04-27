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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name')->nullable();
            $table->string('permanent_address');
            $table->string('temporary_address')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->string('cnic_no')->nullable();
            $table->string('mobile_no');
            $table->string('emergency_no');
            $table->string('alternative_no')->nullable();
            $table->string('user_email');
            $table->string('personal_email')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('marital_status');
            $table->unsignedBigInteger('emp_type');
            $table->unsignedBigInteger('gen_id');
            $table->unsignedBigInteger('dep_id');
            $table->unsignedBigInteger('shift_id');
            $table->string('designation');
            $table->bigInteger('salary')->nullable();
            $table->longText('leaves_payload')->nullable();
            $table->longText('primary_bank_payload')->nullable();
            $table->longText('personal_bank_payload')->nullable();
            $table->longText('earnings_payload')->nullable();
            $table->longText('deductions_payload')->nullable();
            $table->boolean('is_lead')->default(0);
            $table->integer('lead_reporting_to')->default(0);
            $table->longText('socialite_payload')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('marital_status')->references('id')->on('marital_statuses');
            $table->foreign('emp_type')->references('id')->on('emp_types');
            $table->foreign('gen_id')->references('id')->on('genders');
            $table->foreign('dep_id')->references('id')->on('emp_departments');
            $table->foreign('shift_id')->references('id')->on('shifts');

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
        $table->dropForeign(['country_id']);
        $table->dropColumn('country_id');
        $table->dropForeign(['city_id']);
        $table->dropColumn('city_id');
        $table->dropForeign(['marital_status']);
        $table->dropColumn('marital_status');
        $table->dropForeign(['emp_type']);
        $table->dropColumn('emp_type');
        $table->dropForeign(['dep_id']);
        $table->dropColumn('dep_id');
        $table->dropForeign(['shift_id']);
        $table->dropColumn('shift_id');
        Schema::dropIfExists('employees');
    }
};
