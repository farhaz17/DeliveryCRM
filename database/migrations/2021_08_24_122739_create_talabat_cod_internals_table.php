<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalabatCodInternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talabat_cod_internals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('city_id');
            $table->bigInteger('upload_by');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->bigInteger('passport_id');
            $table->string('courier_name')->nullable();
            $table->string('uploaded_file_path')->nullable();
            $table->decimal('cash');
            $table->decimal('bank');
            $table->softDeletes();
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
        Schema::dropIfExists('talabat_cod_internals');
    }
}
