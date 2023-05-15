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
        Schema::table('work_from_home', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('work_from_home', function (Blueprint $table) {
            $table->string('status')->after('reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_change_status', function (Blueprint $table) {
            //
        });
    }
};
