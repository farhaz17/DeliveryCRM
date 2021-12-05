<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_repairs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('chassis_no');
            $table->string('zds_code');
            $table->string('name');
            $table->string('ckm');
            $table->string('nkm');
            $table->float('discount')->nullable();
            $table->tinyInteger('company');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }


}
