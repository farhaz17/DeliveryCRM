<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenewalEmiratesIdTypingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewal_emirates_id_typings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('passport_id');
            $table->integer('status');
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->text('attachment');
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
        Schema::dropIfExists('renewal_emirates_id_typings');
    }
}
