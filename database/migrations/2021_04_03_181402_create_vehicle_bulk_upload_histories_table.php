<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleBulkUploadHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_bulk_upload_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->json('vehicle_ids');
            $table->integer('updated_form')->comment('1 = individual , 2 = bulk upload');
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
        Schema::dropIfExists('vehicle_bulk_upload_histories');
    }
}
