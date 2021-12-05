<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaulterRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defaulter_riders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('passport_id');
            $table->string('subject')->nullable();
            $table->json('attachments')->nullable();
            $table->integer('defaulter_level')->comment('1 = low, 2 = medium, 3 = high');
            $table->text('defaulter_details')->comment('all details');
            $table->boolean('status')->default(1)->comment('1 = active, 0 = inactive');
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
        Schema::dropIfExists('defaulter_riders');
    }
}
