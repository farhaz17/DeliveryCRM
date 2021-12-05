<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_permits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bike_id');
            $table->bigInteger('status')->comment('1=requested, 2=doc_uploaded, 3=permit_uploaded, 4=expired');
            $table->bigInteger('requested_by');
            $table->date('documents');
            $table->text('box_img')->nullable();
            $table->text('food_permit')->nullable();
            $table->date('expiry_date');
            $table->date('permit_upload_date');
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
        Schema::dropIfExists('food_permits');
    }
}
