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
        //
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropForeign(['approval_id']);
            $table->dropColumn('approval_id');
        });

        Schema::table('leaves', function (Blueprint $table) {
            $table->bigInteger('approval_id')->unsigned()->nullable()->after('status');
            $table->foreign('approval_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
