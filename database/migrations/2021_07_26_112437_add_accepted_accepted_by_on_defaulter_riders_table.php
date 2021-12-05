<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAcceptedAcceptedByOnDefaulterRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defaulter_riders', function (Blueprint $table) {
            $table->boolean('accepted')->default(0)->comment('0 = pending, 1 = accepted, 2 = rejected');
            $table->unsignedInteger('accepted_by')->nullable()->after('accepted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('defaulter_riders', function (Blueprint $table) {
            $table->dropColumn([
                'accepted',
                'accepted_by'
            ]);
        });
    }
}
