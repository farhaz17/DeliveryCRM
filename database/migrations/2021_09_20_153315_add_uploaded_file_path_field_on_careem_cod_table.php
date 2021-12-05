<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUploadedFilePathFieldOnCareemCodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('careem_cod', function (Blueprint $table) {
            $table->string('uploaded_file_path')->after('type')->nullable();
            $table->integer('data_stored_form')->after('type')->default(1)->comment('1 = single add form, 2 = excel sheet upload form');
            $table->bigInteger('created_by')->after('type');
            $table->string("time")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('careem_cod', function (Blueprint $table) {
            $table->dropColumn(['uploaded_file_path','data_stored_form','created_by']);
        });
    }
}
