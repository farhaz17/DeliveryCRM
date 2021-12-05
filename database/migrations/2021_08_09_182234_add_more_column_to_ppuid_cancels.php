<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumnToPpuidCancels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppuid_cancels', function (Blueprint $table) {
            //
            $table->dropColumn('working_status');
            $table->dropColumn('visa_status');
            $table->dropColumn('working_status_remarks');
            $table->dropColumn('visa_status_remarks');
            $table->dropColumn('id_status');
            $table->dropColumn('id_status_remarks');
            // $table->dropColumn('status');


            // $table->integer('status');
            $table->dateTime('cancel_date_time');
            $table->dateTime('reactivate_date_time')->nullable();
            $table->text('cancel_remarks');
            $table->text('reactivate_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppuid_cancels', function (Blueprint $table) {
            //
            // $table->dropColumn('status');
            $table->dropColumn('cancel_date_time');
            $table->dropColumn('reactivate_date_time');
            $table->dropColumn('cancel_remarks');
            $table->dropColumn('reactivate_remarks');
        });
    }
}
