<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikeRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bike_renewals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bike_id');
            $table->bigInteger('status')->comment('1=token, 2=cash_requested, 3=accpted, 4=rejected, 5=expiry_updated');
            $table->string('token');
            $table->text('token_attachment')->nullable();
            $table->date('old_expiry');
            $table->string('cash_amount')->nullable();
            $table->date('cash_date');
            $table->bigInteger('user_id');
            $table->bigInteger('accepted_by');
            $table->date('new_issue_date');
            $table->date('new_expiry_date');
            $table->text('mulkia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bike_renewals');
    }
}
