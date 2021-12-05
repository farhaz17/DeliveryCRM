<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('platform_id');
            $table->string('platform_code');
            $table->string('plate_no');
            $table->string('bike_pic');
            $table->string('mulkiya_pic');
            $table->string('emirates_pic');
            $table->string('selfie_pic');
            $table->string('simcard_no');
            $table->bigInteger('user_id');
            $table->text('remark')->nullable();
            $table->bigInteger('status')->default(0); //verified = 1 , rejected =2 // 0 = not verified
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
        Schema::dropIfExists('verification_forms');
    }
}
