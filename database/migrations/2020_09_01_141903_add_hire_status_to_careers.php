<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHireStatusToCareers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->integer('hire_status')->nullable(); // null = not interview sent,
                                                               // 0 = means interview send it,
                                                               // 1=means acknowledged,
                                                               // 2= means rejected,
                                                               // 3= pass and hired ,
                                                              // 4 = means fail in interview
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('careers', function (Blueprint $table) {
            //
        });
    }
}
