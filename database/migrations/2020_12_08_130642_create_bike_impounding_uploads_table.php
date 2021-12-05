<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikeImpoundingUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bike_impounding_uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plate_number');
            $table->string('plate_category');
            $table->string('ticket_number');
            $table->string('ticket_date');
            $table->string('ticket_time');
            $table->string('value_instead_of_booking');
            $table->string('number_of_days_of_booking');
            $table->text('text_violation')->nullable();
            $table->bigInteger('bike_impounding_upload_file_path_id');
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
        Schema::dropIfExists('bike_impounding_uploads');
    }
}
