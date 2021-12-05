<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPastStatusToRejoinCareers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rejoin_careers', function (Blueprint $table) {
            //
            $table->integer('past_status')->nullable()->after('applicant_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rejoin_careers', function (Blueprint $table) {
            //
            $table->dropColumn('past_status');
        });
    }
}
