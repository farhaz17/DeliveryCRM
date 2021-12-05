<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerSupplierDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_supplier_departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_supplier_id');
            $table->string('department_name');
            $table->integer('contact_method');
            $table->string('employee_name')->comment('Person name');
            $table->integer('employee_designation');
            $table->text('employee_contact');
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
        Schema::dropIfExists('customer_supplier_departments');
    }
}
