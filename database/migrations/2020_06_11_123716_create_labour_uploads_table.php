<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabourUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labour_uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('person_code');
            $table->string('person_name');
            $table->string('job');
            $table->string('passport');
            $table->string('nationality');
            $table->string('labour_card');
            $table->string('labour_card_expiry');
            $table->string('card_type');
            $table->string('class');
            $table->string('company_no');
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
        Schema::dropIfExists('labour_uploads');
    }
}
