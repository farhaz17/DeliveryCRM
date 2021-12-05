<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('traffic_file_no');
            $table->string('plate_number');
            $table->string('plate_category');
            $table->string('plate_code');
            $table->string('license_number');
            $table->string('license_from');
            $table->string('ticket_number');
            $table->string('ticket_date');
            $table->string('fines_source');
            $table->string('ticket_fee');
            $table->string('ticket_status');
            $table->string('the_terms_of_the_offense')->nullable();
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
        Schema::dropIfExists('fines');
    }
}
