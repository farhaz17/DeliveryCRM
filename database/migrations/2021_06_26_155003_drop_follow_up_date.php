<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropFollowUpDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('career_status_histories', function (Blueprint $table) {
            $table->dropColumn('follow_up_date');
        });

        Schema::table('career_status_histories', function (Blueprint $table) {
            $table->date('follow_up_date');
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
}
