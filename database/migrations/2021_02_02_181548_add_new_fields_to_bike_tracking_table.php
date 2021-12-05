<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Model\BikesTracking\BikesTracking;
use Illuminate\Database\Migrations\Migration;
use App\Model\Master\Vehicle\VehicleTrackingInventory;

class AddNewFieldsToBikeTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bikes_trackings', function (Blueprint $table) {
            $table->bigInteger('new_shuffled_tracker_id')->nullable();
            $table->date('checkin');
            $table->date('checkout')->nullable();
            $table->integer('status')->comment('1 = Yes, 0 = No');
            $table->integer('type')->comment('1 = Installed, 2 = Removed, 3 = shuffle')->nullable();
            $table->string('remarks')->nullable();
        });

        $bike_trackers = BikesTracking::latest()->get();
        foreach($bike_trackers as $bike_tracker){
            $bike_tracker->tracking_number = VehicleTrackingInventory::updateOrCreate(
            [
                'tracking_no' => $bike_tracker->tracking_number 
            ],[
                'tracking_no' => $bike_tracker->tracking_number, 
                'status' =>  1,
            ])->id;
            $bike_tracker->checkin = date('Y-m-d').'T'.date('H:i');
            $bike_tracker->status = 1;
            $bike_tracker->remarks = "Data updated from migration file";
            $bike_tracker->update();  
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bikes_trackings', function (Blueprint $table) {
            $table->dropColumn(['new_shuffled_tracker_id','checkin','checkout','status','type','remarks']);
        });
    }
}
