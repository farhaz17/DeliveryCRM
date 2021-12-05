<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemakrsOtherToCareers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->string('medical_type')->nullable()->comment('1=company, 2= own'); //1= compay 2= own
            $table->bigInteger('care_of')->nullable()->comment('rider passport_id'); //1= compay 2= own
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->dropColumn('medical_type');
            $table->dropColumn('care_of');
        });
    }
}
