<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsFromAgreedAmounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agreed_amounts', function (Blueprint $table) {
            //
            $table->string('advance_amount')->nullable()->change();
            $table->string('discount_details')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agreed_amounts', function (Blueprint $table) {
            //
        });
    }
}
