<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class   CreatePassportAddtionalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passport_additional_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->string('full_name')->nullable();
            $table->string('nat_name')->nullable();
            $table->string('nat_relation')->nullable();
            $table->string('nat_address')->nullable();
            $table->string('nat_phone')->nullable();
            $table->string('nat_whatsapp_no')->nullable();
            $table->string('nat_email')->nullable();
            $table->string('inter_name')->nullable();
            $table->string('inter_relation')->nullable();
            $table->string('inter_address')->nullable();
            $table->string('inter_phone')->nullable();
            $table->string('inter_whatsapp_no')->nullable();
            $table->string('inter_email')->nullable();
            $table->string('personal_mob')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('personal_image')->nullable();
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
        Schema::dropIfExists('passport_additional_info');
    }
}
