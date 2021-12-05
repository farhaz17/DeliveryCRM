<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniqueEmailIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unique_email_ids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('status')->nullable();
            $table->bigInteger('passport_id')->nullable();
            $table->dateTime('issue_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->bigInteger('attachment_id')->nullable();
            $table->string('is_complete')->default('0');


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
        Schema::dropIfExists('unique_email_ids');
    }
}
