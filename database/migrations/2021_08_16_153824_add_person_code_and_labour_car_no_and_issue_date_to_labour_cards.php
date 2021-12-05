<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPersonCodeAndLabourCarNoAndIssueDateToLabourCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('labour_cards', function (Blueprint $table) {
            //
            $table->string('person_code')->nullable();
            $table->string('labour_card_no')->nullable();
            $table->date('issue_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('labour_cards', function (Blueprint $table) {
            //
        });
    }
}
