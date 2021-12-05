<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cod_uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rider_id');
            $table->string('amount');
            $table->date('start_date');
            $table->date('end_date');
            $table->bigInteger('platform_id');
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
        Schema::dropIfExists('cod_uploads');
    }
}
