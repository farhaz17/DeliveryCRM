<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaulterRiderCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defaulter_rider_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('defaulter_rider_id');
            $table->unsignedInteger('commenter_id');
            $table->string('comment');
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
        Schema::dropIfExists('defaulter_rider_comments');
    }
}
