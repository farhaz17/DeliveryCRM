<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHrSentToVisaCanelRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visa_cancel_requests', function (Blueprint $table) {
            //
            $table->integer('hr_reqest')->default('0')->comment('0 = no hr request, 1 = hr request');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visa_canel_requests', function (Blueprint $table) {
            //
        });
    }
}
