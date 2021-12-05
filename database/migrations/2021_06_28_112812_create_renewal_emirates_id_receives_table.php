<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenewalEmiratesIdReceivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewal_emirates_id_receives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('passport_id');
            $table->text('visa_attachment');
            $table->bigInteger('status');
            $table->date('issue_date');
            $table->date('expiry_date');
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
        Schema::dropIfExists('renewal_emirates_id_receives');
    }
}
