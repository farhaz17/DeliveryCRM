<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisaProcessIdToBetweenVisaCancels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('between_visa_cancels', function (Blueprint $table) {
            //
            $table->integer('visa_process_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('between_visa_cancels', function (Blueprint $table) {
            //
        });
    }
}
