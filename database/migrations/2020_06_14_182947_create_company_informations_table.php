<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id');
            $table->string('trade_license_no')->nullable();
            $table->string('establishment_card')->nullable();
            $table->string('labour_card')->nullable();
            $table->string('salik_acc')->nullable();
            $table->string('traffic_fle_no')->nullable();
            $table->string('etisalat_party_id')->nullable();
            $table->string('du_acc')->nullable();
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
        Schema::dropIfExists('company_informations');
    }
}
