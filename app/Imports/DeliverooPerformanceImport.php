<?php

namespace App\Imports;

use App\Model\Performance\DeliverooPerformance;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Monolog\Handler\IFTTTHandler;

class DeliverooPerformanceImport implements  ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public $from=NULL;
    public  $to=NULL;

    public function  __construct($from,$to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function model(array $row)
    {
        try {
//getting date ragnes
            $date_from = $this->from;
            $date_to = $this->to;


            $rider_id_array = trim($row['rider_id']);
            $rider_name_array = $row['rider_name'];
            $status_array = $row['stauts'];
            $hours_scheduled_array = trim($row['hours_scheduled']);
            $hours_worked_array = $row['hours_worked'];
            $attendance_array = $row['attendance'];
            $no_of_orders_delivered_array = $row['no_of_orders_delivered'];
            $no_of_orders_unassignedr_array = $row['no_of_orders_unassignedr'];
            $Unassigned_array = $row['unassigned'];
            $wait_time_at_customer_array = $row['wait_time_at_customer'];


            if(!isset($hours_scheduled_array) || empty($hours_scheduled_array)){
                $hours_scheduled_array = 0;
            }
//            $attendance= trim($attendance_array,'0.');



           $attendance_val=$attendance_array*100;
            $Unassigned_val=$Unassigned_array*100;
            return new DeliverooPerformance([
                'rider_id' => $rider_id_array,
                'rider_name' => $rider_name_array,
                'hours_scheduled' => $hours_scheduled_array,
                'hours_worked' => $hours_worked_array,
                'attendance' =>     number_format($attendance_val,2),
                'no_of_orders_delivered' => $no_of_orders_delivered_array,
                'no_of_orders_unassignedr' => $no_of_orders_unassignedr_array,
                'unassigned' => number_format($Unassigned_val,2),
                'wait_time_at_customer' => $wait_time_at_customer_array,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'status' => $status_array,
            ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $message = [
                'error' => $e->getMessage()
            ];
            return redirect()->back()->with($message);
        }

    }

//    public function getPartNumberId($account_number){
//
//        $account_id = DB::table('sim_imports')->where('account_number', $account_number)->first();
//
//        return optional($account_id)->id;
//    }
//
//    public function checkExistData($account_number){
//
//        $query=\App\Model\SimImports::where('id', $account_number)->get()->first();
//
//        $account_id= isset($query->id)?$query->id:"";
//        return $account_id;
//    }


}
