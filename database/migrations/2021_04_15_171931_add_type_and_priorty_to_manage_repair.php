<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeAndPriortyToManageRepair extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manage_repairs', function (Blueprint $table) {
            //
            $table->bigInteger('type')->after('status')->nullable();
            $table->bigInteger('priorty')->after('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manage_repair', function (Blueprint $table) {
            //
        });
    }
}
