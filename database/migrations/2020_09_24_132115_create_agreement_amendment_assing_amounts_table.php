<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgreementAmendmentAssingAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_amendment_assing_amounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('amount');
            $table->bigInteger('master_step_id');
            $table->bigInteger('passport_id');
            $table->bigInteger('amendmentagreement_id');
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
        Schema::dropIfExists('agreement_amendment_assing_amounts');
    }
}
