<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterMajorCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_major_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('model_name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        DB::table('master_major_categories')->insert([
            'name' => 'Licenes', 
            'model_name' => 'App\Model\Seeder\Company'
            ]);//1 only enter Model name of Master with namespace
        DB::table('master_major_categories')->insert([
            'name' => 'App\Model\Master\Company\EEstablishment',
            'model_name' => 'EEstablishment'
            ]);//2 only enter Model name of Master with namespace
        DB::table('master_major_categories')->insert([
            'name' => 'MOL',
            'model_name' => 'App\Model\Master\Company\LabourCard'
            ]);//3 only enter Model name of Master with namespace
        DB::table('master_major_categories')->insert([
            'name' => 'Ejari',
            'model_name' => 'App\Model\Master\Company\Ejari'
            ]);//4 only enter Model name of Master with namespace
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_major_categories');
    }
}
