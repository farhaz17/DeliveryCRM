<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniqueEmailIdHandoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unique_email_id_handovers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('unique_email_id_handovers');
    }
}
