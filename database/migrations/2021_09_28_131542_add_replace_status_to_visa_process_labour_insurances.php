<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReplaceStatusToVisaProcessLabourInsurances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visa_process_labour_insurances', function (Blueprint $table) {
            //
            $table->bigInteger('replace_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visa_process_labour_insurances', function (Blueprint $table) {
            //
        });
    }
}
