<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTawjeehDateToTawjeehClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tawjeeh_classes', function (Blueprint $table) {
            //
            $table->date('tawjeeh_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tawjeeh_classes', function (Blueprint $table) {
            //
        });
    }
}
