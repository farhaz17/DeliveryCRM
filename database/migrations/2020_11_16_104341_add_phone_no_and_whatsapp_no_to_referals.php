<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneNoAndWhatsappNoToReferals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referals', function (Blueprint $table) {
            //

            $table->string('phone_no')->nullable();
            $table->string('whatsapp_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referals', function (Blueprint $table) {
            //
        });
    }
}
