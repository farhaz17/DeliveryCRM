<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHandoverPersonNameAndHandoverDateToUniqueEmailIdHandovers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unique_email_id_handovers', function (Blueprint $table) {
            //
            $table->bigInteger('handover_person_name')->nullable();
            $table->date('handover_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unique_email_id_handovers', function (Blueprint $table) {
            //
        });
    }
}
