<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTakenStatusToAgreedAmounts extends Migration
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
            $table->integer('taken_status')->default(0)->comment('0=pending, 1=approved,2=rejected');
            $table->datetime('updated_status_time')->nullable();
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
            $table->dropColumn('taken_status');
            $table->dropColumn('updated_status_time');
        });
    }
}
