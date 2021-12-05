<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeedbackIdColumnOnTalabatCodFollowUps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talabat_cod_follow_ups', function (Blueprint $table) {
            $table->unsignedBigInteger('feedback_id');
            $table->text('remarks')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('talabat_cod_follow_ups', function (Blueprint $table) {
            $table->dropColumn('feedback_id');
        });
    }
}
