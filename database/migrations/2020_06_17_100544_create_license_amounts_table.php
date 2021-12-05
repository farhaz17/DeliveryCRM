<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenseAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_amounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee_type_id');
            $table->integer('company_id');
            $table->string('option_label');    // Bike, Car, Both
            $table->integer('option_value')->nullable();   // 1 = Automatic Car, 2= Manual Car, null = Bike
            $table->double('amount');
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
        Schema::dropIfExists('license_amounts');
    }
}
