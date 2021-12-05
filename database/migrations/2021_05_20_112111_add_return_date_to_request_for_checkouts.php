<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReturnDateToRequestForCheckouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dc_request_for_checkouts', function (Blueprint $table) {
            //
            $table->date('return_date')->nullable()->after('request_status');
            $table->integer('shuffle_type')->nullable()->after('return_date');
            $table->integer('is_action_approve_status_id')->default(0)->after('return_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dc_request_for_checkouts', function (Blueprint $table) {
            $table->dropColumn('return_date');
            $table->dropColumn('shuffle_type');
            $table->dropColumn('is_action_approve_status_id');
        });
    }
}
