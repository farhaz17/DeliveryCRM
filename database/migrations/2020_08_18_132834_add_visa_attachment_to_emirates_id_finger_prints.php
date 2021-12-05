<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisaAttachmentToEmiratesIdFingerPrints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emirates_id_finger_prints', function (Blueprint $table) {
            //
            $table->string('visa_attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emirates_id_finger_prints', function (Blueprint $table) {
            //
        });
    }
}
