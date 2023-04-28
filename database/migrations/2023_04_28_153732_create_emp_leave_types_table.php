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
        Schema::create('emp_leave_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_type_id');
            $table->longText('payload');

            $table->foreign('emp_type_id')->references('id')->on('emp_types')->cascadeOnDelete();
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
        $table->dropForeign(['emp_type_id']);
        $table->dropColumn('emp_type_id');
        Schema::dropIfExists('emp_leave_types');
    }
};
