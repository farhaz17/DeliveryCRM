<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPoliceRequestAttachmentColumnInBikeMissingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_missings', function (Blueprint $table) {
            $table->string('police_request_attachment', 300)->after('complaint_remarks')->nullable();
            $table->string('police_report_attachment', 300)->after('complaint_remarks')->nullable();
            $table->string('found_attachment', 300)->after('complaint_remarks')->nullable();
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
            $table->dropColumn(['police_request_attachment', 'police_report_attachment', 'found_attachment']);
        });
    }
}
