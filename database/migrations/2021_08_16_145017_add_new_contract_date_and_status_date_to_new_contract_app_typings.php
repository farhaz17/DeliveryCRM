<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewContractDateAndStatusDateToNewContractAppTypings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_contract_app_typings', function (Blueprint $table) {
            //
            $table->date('new_contract_date')->nullable();
            $table->integer('status')->nullable()->comment('0 for No 1 for Yes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_contract_app_typings', function (Blueprint $table) {
            //
        });
    }
}
