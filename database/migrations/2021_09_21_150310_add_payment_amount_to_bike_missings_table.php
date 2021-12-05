<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentAmountToBikeMissingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_missings', function (Blueprint $table) {
            $table->integer('payment_amount')->after('complaint_remarks')->nullable();
            $table->string('payment_attachment')->after('complaint_remarks')->nullable();
            $table->string('cancellation_remarks')->after('complaint_remarks')->nullable();
            $table->date('cancellation_date')->after('complaint_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bike_missings', function (Blueprint $table) {
            $table->dropColumn(['payment_amount', 'payment_attachment', 'cancellation_remarks', 'cancellation_date']);
        });
    }
}
