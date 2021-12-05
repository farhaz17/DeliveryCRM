<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEidRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eid_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_number');
            $table->string('name');
            $table->string('nationality');
            $table->string('date_of_birth');
            $table->string('card_number');
            $table->string('expiry_date');
            $table->string('receipt_no');
            $table->string('app_no');
            $table->string('registered_mob_no');
            $table->string('emirates_id');
            $table->string('residency_no');
            $table->string('uid_no');

            $table->string('deleted_at')->nullable();
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
        Schema::dropIfExists('eid_registrations');
    }
}
