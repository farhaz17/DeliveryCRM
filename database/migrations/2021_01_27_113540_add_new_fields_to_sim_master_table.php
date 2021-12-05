<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToSimMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telecomes', function (Blueprint $table) {
            $table->date('contract_issue_date')->nullable();
            $table->date('contract_expiry_date')->nullable();
            $table->string('sim_sl_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telecomes', function (Blueprint $table) {
            $table->dropColumn('contract_issue_date','contract_expiry_date','sim_sl_no');
        });
    }
}
