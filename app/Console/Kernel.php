<?php

namespace App\Console;

use App\Model\Assign\AssignBike;
use App\Model\Bike_person_fuels;
use App\Model\BikeReplacement\BikeReplacement;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->call(function() {


            $bike_person_fuel = Bike_person_fuels::where('status','=','1')->get();

            foreach ($bike_person_fuel as $bike){
                if($bike->bike_type_from==1){
                    $assign_bike = AssignBike::where('passport_id','=',$bike->passport_id)
                        ->where('bike','=',$bike->bike_id)
                        ->where('status','=','0')
                        ->orderby('id','desc')
                        ->first();

                    if($assign_bike!=null){
                        Bike_person_fuels::where('bike_id','=',$bike->bike_id)
                            ->where('status','=','1')
                            ->update(['status' => '0','checkout'=> $assign_bike->checkout]);
                    }


                }else{

                    $replace_bike = BikeReplacement::where('passport_id','=',$bike->passport_id)
                        ->where('new_bike_id','=',$bike->bike_id)
                        ->where('status','=','0')
                        ->orderby('id','desc')
                        ->first();

                    if($replace_bike!=null){
                        Bike_person_fuels::where('bike_id','=',$bike->bike_id)
                            ->where('status','=','1')
                            ->update(['status' => '0','checkout'=> $replace_bike->checkout]);
                    }


                }

            }

       })->dailyAt('23:59');


//        return "success";

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
