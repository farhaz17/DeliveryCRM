<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTakenStatusToRenewAgreedAmounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renew_agreed_amounts', function (Blueprint $table) {
            //
            $table->integer('taken_status')->default(0)->comment('0=pending, 1=approved,2=rejected');
            $table->dateTime('updated_status_time')->nullable();
            $table->integer('action_by')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('renew_agreed_amounts', function (Blueprint $table) {
            //
        });
    }
}
