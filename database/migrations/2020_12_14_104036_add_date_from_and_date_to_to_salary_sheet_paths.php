<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateFromAndDateToToSalarySheetPaths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_sheet_paths', function (Blueprint $table) {
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_sheet_paths', function (Blueprint $table) {
            $table->dropColumn(['date_from','date_to']);
        });
    }
}
