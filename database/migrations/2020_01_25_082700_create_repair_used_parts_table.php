<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairUsedPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_used_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('repair_job_id');
            $table->bigInteger('part_id');
            $table->bigInteger('quantity');
            $table->float('part_price');
            $table->float('amount');
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
        Schema::dropIfExists('repair_used_parts');
    }
}
