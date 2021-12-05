<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEjarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ejaris', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("ejari_type")->nullable();
            $table->integer("company_id")->nullable();
            $table->string("state")->nullable();
            $table->string("contract_no")->nullable();
            $table->date("registration_date")->nullable();
            $table->date("issue_date")->nullable();
            $table->date("expiry_date")->nullable();
            $table->integer("contract_amount")->nullable();
            $table->integer("security_deposit")->nullable();
            $table->string("land_area")->nullable();
            $table->string("plot_no")->nullable();
            $table->string("land_dm_no")->nullable();
            $table->string("makani_no")->nullable();
            $table->string("size")->nullable();
            $table->json('shared_company_ids')->nullable();
            $table->json("pdc_check_no")->nullable();
            $table->json("pdc_company_account_no")->nullable();
            $table->json("pdc_company_account_name")->nullable();
            $table->json("pdc_date")->nullable();
            $table->json("pdc_amount")->nullable();
            $table->json("pdc_attachment")->nullable();
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
        Schema::dropIfExists('ejaris');
    }
}
