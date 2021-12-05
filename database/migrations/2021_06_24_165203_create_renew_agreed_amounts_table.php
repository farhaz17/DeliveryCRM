<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenewAgreedAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // protected $fillable = ['passport_id','agreed_amount','discount_id','discount_amount','final_amount','payroll_deduction','current_status'];


        Schema::create('renew_agreed_amounts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->double('passport_id');
            $table->bigInteger('agreed_amount');
            $table->double('discount_id')->nullable();
            $table->double('discount_amount')->nullable();
            $table->double('advance_amount')->nullable();
            $table->text('attachment')->nullable();
            $table->double('final_amount');
            $table->double('payroll_deduction')->nullable();
            $table->bigInteger('current_status')->nullable();
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
        Schema::dropIfExists('renew_agreed_amounts');
    }
}
