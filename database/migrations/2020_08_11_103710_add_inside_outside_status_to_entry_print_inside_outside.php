<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInsideOutsideStatusToEntryPrintInsideOutside extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entry_print_inside_outside', function (Blueprint $table) {
            //
            $table->integer('inside_out_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entry_print_inside_outside', function (Blueprint $table) {
            //
        });
    }
}
