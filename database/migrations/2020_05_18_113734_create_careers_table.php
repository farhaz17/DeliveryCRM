<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->bigInteger('vehicle_type')->nullable(); //bike = 1, car = 2, both = 3
            $table->string('experience')->nullable();
            $table->string('cv')->nullable();
            $table->bigInteger('licence_status')->nullable(); //yes =1 no =2
            $table->bigInteger('licence_status_vehicle')->nullable(); //bike =1. car =2 ,both =3
            $table->string('licence_no')->nullable();
            $table->date('licence_issue')->nullable();
            $table->date('licence_expiry')->nullable();
            $table->string('licence_attach')->nullable();
            $table->string('nationality')->nullable();
            $table->date('dob')->nullable();
            $table->string('passport_no')->nullable();
            $table->date('passport_expiry')->nullable();
            $table->string('passport_attach')->nullable();
            $table->bigInteger('visa_status')->nullable(); //visit = 1,cancel =2,own = 3
            $table->bigInteger('visa_status_visit')->nullable(); //one month = 1,three month =2
            $table->bigInteger('visa_status_cancel')->nullable(); //free zone = 1,local land =2
            $table->bigInteger('visa_status_own')->nullable(); //noc = 1,without noc =2
            $table->date('exit_date')->nullable(); //common for every  selection
            $table->bigInteger('company_visa')->nullable(); //yes =1 ,no =2
            $table->bigInteger('inout_transfer')->nullable(); //here =1 ,home country =2
            $table->text('platform_id')->nullable();
            $table->bigInteger('applicant_status')->default('0'); // 0 = Not Verified , 1= rejected, 2 = document Pending , 3 = Short Listed, 4 = Hired, 5 = wait List
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('careers');
    }
}
