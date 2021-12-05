<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisaFieldsToPassports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passports', function (Blueprint $table) {
            //
            $table->integer('visa_status')->nullable();
            $table->integer('visa_status_visit')->nullable();
            $table->integer('visa_status_cancel')->nullable();
            $table->integer('visa_status_own')->nullable();
            $table->date('exit_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('passports', function (Blueprint $table) {
            //
            $table->dropColumn('visa_status');
            $table->dropColumn('visa_status_visit');
            $table->dropColumn('visa_status_cancel');
            $table->dropColumn('visa_status_own');
            $table->dropColumn('exit_date');
        });
    }
}
