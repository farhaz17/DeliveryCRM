<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttachment2AndAttachment3ToOfferLetterSubmission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer_letter_submission', function (Blueprint $table) {
            //
            $table->string('attachment2')->nullable();
            $table->string('attachment3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offer_letter_submission', function (Blueprint $table) {
            //
        });
    }
}
