<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassportRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passport_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->date('receive_date');
            $table->date('return_date');
            $table->string('reason');
            $table->bigInteger('status')->default('0');
            $table->timestamps();
        });
    }
    //status 0 = request received for passport
    //status 1 = passport hand overed
    //status 2 = passport returned

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passport_requests');
    }
}
