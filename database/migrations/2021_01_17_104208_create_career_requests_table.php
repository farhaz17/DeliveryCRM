<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareerRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('career_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("country_name");
            $table->string("city_name");
            $table->string("name");
            $table->string("mobile_no");
            $table->string('whatsapp_no');
            $table->string("email_address")->nullable();
            $table->boolean("passport_status")->comment('0 = yes, 1 = no');
            $table->string("passport_no")->nullable()->comment("if passport_status is 0");
            $table->string("pak_license_status")->comment('1 = yes, 2 = no');
            $table->boolean("uae_license_status")->comment('0 = yes, 1 = no');
            $table->string("license_no")->nullable();
            $table->softdeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('career_requests');
    }
}
