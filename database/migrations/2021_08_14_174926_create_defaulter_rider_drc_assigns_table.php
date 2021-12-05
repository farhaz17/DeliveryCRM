<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaulterRiderDrcAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defaulter_rider_drc_assigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('defaulter_rider_id');
            $table->unsignedBigInteger('drcm_id')->comment('Defaulter Rider Co-ordinator Manager');
            $table->unsignedBigInteger('drc_id')->nullable()->comment('Defaulter Rider Co-ordinator');
            $table->integer('approval_status')->default(0)->comment('Approval Status of drc 0 = pending, 1 = accepted, 2 = rejected');
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
        Schema::dropIfExists('defaulter_rider_drc_assigns');
    }
}
