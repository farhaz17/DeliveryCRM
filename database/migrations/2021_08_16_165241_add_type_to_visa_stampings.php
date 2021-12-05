<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToVisaStampings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visa_stampings', function (Blueprint $table) {
            //
            $table->integer('types')->nullable()->comment('0 for normal, 1 for urgent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visa_stampings', function (Blueprint $table) {
            //
        });
    }
}
