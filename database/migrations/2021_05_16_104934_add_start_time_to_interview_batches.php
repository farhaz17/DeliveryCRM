<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartTimeToInterviewBatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interview_batches', function (Blueprint $table) {
            //
            $table->time('start_time')->default(null);
            $table->time('end_time')->default(null);
            $table->dateTime('due_date_time')->nullable()->change();
            $table->date('interview_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interview_batches', function (Blueprint $table) {
            //
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
        });
    }
}
