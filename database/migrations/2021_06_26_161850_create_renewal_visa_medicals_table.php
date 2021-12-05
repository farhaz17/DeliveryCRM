<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenewalVisaMedicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewal_visa_medicals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('medical_type')->comment('1= Normal, 2= 48, 3= 24, 4=VIP');
            $table->bigInteger('passport_id')->nullable();
            $table->string('medical_tans_no')->nullable();
            $table->string('medical_date_time')->nullable();
            $table->string('payment_amount')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('transaction_no')->nullable();
            $table->string('transaction_date_time')->nullable();
            $table->double('vat')->nullable();
            $table->text('other_attachment')->nullable();
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
        Schema::dropIfExists('renewal_visa_medicals');
    }
}
