<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToAgreements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agreements', function (Blueprint $table) {
            $table->Integer('visa_pasting')->nullable();
            $table->Integer('rta_medical')->nullable();
            $table->Integer('english_test')->nullable();
            $table->Integer('cid_report')->nullable();
            $table->Integer('rta_card_print')->nullable();
            $table->Integer('rta_permit_training')->nullable();
            $table->Integer('e_test')->nullable();
            $table->Integer('e_visa_print')->nullable();
            $table->Integer('inside_e_visa_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agreements', function (Blueprint $table) {
            //
        });
    }
}
