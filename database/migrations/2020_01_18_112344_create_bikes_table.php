<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bikes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model'); //varchar(255)
            $table->string('chasis_no');
            $table->string('plate_no');
            $table->string('make_year');
            $table->string('company');
            $table->string('registration_valid');
            $table->string('no_of_fines');
            $table->string('fines_amount');
            $table->string('issue_date');
            $table->string('expiry_date');
            $table->string('insurance_co');
            $table->string('mortaged_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bikes');
    }
}
