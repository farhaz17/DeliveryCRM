<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterClaimDocumentsToColumnInBikeMissingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_missings', function (Blueprint $table) {
            $table->string('claim_documents', 300)->after('found_status')->nullable()->change();
            $table->string('claim_offer', 300)->after('found_status')->nullable()->change();
            $table->string('payment_attachment', 300)->after('complaint_remarks')->nullable()->change();
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
            //
        });
    }
}
