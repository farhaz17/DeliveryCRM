<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangeStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('new_file_number');
            $table->string('previous_file_number');
            $table->string('uid_no');
            $table->string('submission_date');
            $table->string('approval_date');
            $table->string('name');
            $table->string('nationality');
            $table->string('passport_number');
            $table->string('profession_visa');
            $table->string('profession_working');
            $table->string('company_visa');
            $table->string('company_working');
            $table->string('sponser_name');
            $table->string('note');
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
        Schema::dropIfExists('change_statuses');
    }
}
