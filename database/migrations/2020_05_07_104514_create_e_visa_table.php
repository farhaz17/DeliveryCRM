<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEVisaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_visas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employment');
            $table->string('entry_permit_number');
            $table->string('date_of_issue');
            $table->string('place_of_issue');
            $table->string('valid_until');
            $table->string('uid_no');
            $table->string('full_name');
            $table->string('nationality');
            $table->string('place_of_birth');
            $table->string('passport_number');
            $table->string('profession');
            $table->string('sponser_name');
            $table->string('entry_date');



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
        Schema::dropIfExists('e_visas');
    }
}
