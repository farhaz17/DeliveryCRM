<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefalterRiderReassignRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defalter_rider_reassign_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('defaulter_rider_id');
            $table->unsignedBigInteger('requested_to_dc_id');
            $table->unsignedBigInteger('requested_by');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedInteger('approval_status')->comment('0 = pending, 1 = approved, 2 = rejected')->default(0);
            $table->unsignedInteger('status')->default(1)->comment('1 = active, 0 = inactive');
            $table->softDeletes();
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
        Schema::dropIfExists('defalter_rider_reassign_requests');
    }
}
