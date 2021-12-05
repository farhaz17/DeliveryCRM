<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisaApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid_number');
            $table->string('file_number');
            $table->bigInteger('state_id');
            $table->bigInteger('passport_id');
            $table->bigInteger('visa_profession_id');
            $table->bigInteger('visa_company_id');
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->string('attachment');
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('visa_applications');
    }
}
