<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoxInstallationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box_installations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bike_id');
            $table->bigInteger('platform');
            $table->bigInteger('user_id');
            $table->bigInteger('status')->comment('1=pending, 2=accept, 3=reject, 4=doc_uploaded, 5=bike_sented, 6=installed, 7=removed');
            $table->text('documents')->nullable();
            $table->string('remark')->nullable();
            $table->date('doc_date');
            $table->bigInteger('doc_uploaded_by');
            $table->bigInteger('batch_id');
            $table->date('sended_date');
            $table->text('box_image')->nullable();
            $table->string('img_remark')->nullable();
            $table->date('img_date');
            $table->date('remove_date');
            $table->string('remove_remark')->nullable();
            $table->bigInteger('removed_by');
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
        Schema::dropIfExists('box_installations');
    }
}
