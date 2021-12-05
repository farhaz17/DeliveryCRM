<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRefernceNumberToOnInterviewBatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interview_batches', function (Blueprint $table) {
            $table->string('reference_number');
            $table->dateTime('interview_date');
            $table->dateTime('due_date_time');
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
            $table->dropColumn([
                'reference_number',
                'interview_date',
                'due_date_time'
            ]);
        });
    }
}
