<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFineUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fine_uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fine_upload_traffic_code_id');
            $table->integer('plate_number');
            $table->string('ticket_number');
            $table->string('ticket_date');
            $table->string('ticket_time');
            $table->text('fines_source');
            $table->double('ticket_fee');
            $table->text('offense')->nullable();
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
        Schema::dropIfExists('fine_uploads');
    }
}
