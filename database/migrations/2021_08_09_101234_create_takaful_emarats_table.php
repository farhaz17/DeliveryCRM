<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTakafulEmaratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('takaful_emarats', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('insurance_company');
            $table->string('member_id');
            $table->bigInteger('company_id');
            $table->bigInteger('passport_id');
            $table->string('card_no')->nullable();
            $table->string('emirates_id');
            $table->string('network_type');
            $table->string('pid');
            $table->date('effective_date');
            $table->date('expiry_date');
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
        Schema::dropIfExists('takaful_emarats');
    }
}
