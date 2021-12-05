+<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('nation_id')->nullable();
            $table->string('pp_uid');
            $table->string('country_code')->nullable();
            $table->string('passport_no');
            $table->string('sur_name')->nullable();
            $table->string('given_names')->nullable();
            $table->string('sex')->nullable();
            $table->string('father_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('place_birth')->nullable();
            $table->string('place_issue')->nullable();
            $table->date('date_issue')->nullable();
            $table->date('date_expiry')->nullable();
            $table->string('passport_pic')->nullable();
            $table->string('citizenship_no')->nullable();
            $table->string('personal_address')->nullable();
            $table->string('permanant_address')->nullable();
            $table->string('booklet_number')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('name_of_mother')->nullable();
            $table->string('next_of_kin')->nullable();
            $table->string('relationship')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('attachment_name')->nullable();
            $table->bigInteger('attachment_id')->nullable();
            $table->string('status')->default('0');

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
        Schema::dropIfExists('passports');
    }
}
