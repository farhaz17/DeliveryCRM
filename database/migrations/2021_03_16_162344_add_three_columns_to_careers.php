<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreeColumnsToCareers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->string('status_after_shortlist')->default(0);
            $table->string('visa_status_after_shortlist')->nullable();
            $table->string('visa_status_one_after_shortlist')->nullable();
            $table->string('visa_status_two_after_shortlist')->nullable();
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
            $table->dropColumn(['status_after_shortlist']);
            $table->dropColumn(['visa_status_after_shortlist']);
            $table->dropColumn(['visa_status_one_after_shortlist']);
            $table->dropColumn(['visa_status_two_after_shortlist']);
        });
    }
}
