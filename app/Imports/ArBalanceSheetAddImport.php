<?php

namespace App\Imports;

use App\Model\ArBalance\ArBalanceSheet;
use App\Model\UserCodes\UserCodes;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArBalanceSheetAddImport implements ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */


    public $platform_id=NULL;


    public function  __construct($platform_id)
    {
        $this->platform_id = $platform_id;

    }
    public function model(array $row)
    {

        $platform_id = $this->platform_id;
        $zds_code_array = trim($row['zds_code']);
        $date_saved_array = date('Y-m-d');
        $total_hours_array = $row['total_hours'];
        $orders_array = $row['orders'];
        $rider_distance_array = $row['rider_distance'];
        $stacked_order_array = $row['stacked_order'];
        $working_days_array = $row['working_days'];
        $monthly_salary_array = $row['monthly_salary'];
        $payout_against_orders_array = $row['payout_against_orders'];
        $payout_against_stacked_order_array = $row['payout_against_stacked_order'];
        $zone_block_incentive_array = $row['zone_block_incentive'];
        $zone_bonus_array = $row['zone_bonus'];
        $montly_bonus_array = $row['montly_bonus'];
        $platform_incentive_array = $row['platform_incentive'];
        $referal_cash_array = $row['referal_cash'];
        $fuel_fee_array = $row['fuel_fee'];
        $rider_guarantee_array = $row['rider_guarantee'];
        $tips_array = $row['tips'];
        $past_queries_adjustment_array = $row['past_queries_adjustment'];
        $bonus_array = $row['bonus'];
        $surge_array = $row['surge'];
        $rider_training_fee_array = $row['rider_training_fee'];
        $cod_penalty_return_array = $row['cod_penalty_return'];
        $ar_discount_array = $row['ar_discount'];
        $traffic_fine_discount_array = $row['traffic_fine_discount'];
        $salik_allowance_array = $row['salik_allowance'];
        $ot_array = $row['ot'];
        $guarantee_trips_array = $row['guarantee_trips'];
        $fuel_allownce_array = $row['fuel_allownce'];
        $other_adjusment_array = $row['other_adjusment'];


        $status_array = '0';
        $passport = UserCodes::where('zds_code', $zds_code_array)->first();
        $passport_id = $passport->passport_id;


//add first row---------------------------------------

        if ($total_hours_array != null) {
            $this->getData_total_hours($total_hours_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
        //rent

        if ($orders_array != null) {
            $this->getData_order_array($orders_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
        //sim charge

        if ($rider_distance_array != null) {
            $this->getData_rider_distance($rider_distance_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
        //salik

        if ($stacked_order_array != null) {
            $this->getData_stacked_order($stacked_order_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
        //fine
        if ($working_days_array != null) {
            $this->getData_working_days($working_days_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
        //

        if ($monthly_salary_array != null) {
            $this->getData_monthaly_salary($monthly_salary_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
        if ($payout_against_orders_array != null) {
            $this->getData_payout_against_order($payout_against_orders_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }

        if ($payout_against_stacked_order_array != null) {
            $this->getData_payout_against_stacked_order($payout_against_stacked_order_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
        if ($zone_block_incentive_array != null) {
            $this->getData_zone_block_incentive($zone_block_incentive_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
        if ($zone_bonus_array != null) {
            $this->getData_zone_bonus($zone_bonus_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }

        if ($montly_bonus_array != null) {
            $this->getData_montly_bonus_array($montly_bonus_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }

        if ($platform_incentive_array != null) {
            $this->getData_platform_incentive($platform_incentive_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }

        if ($referal_cash_array != null) {
            $this->getData_referal_cash($referal_cash_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }

        if ($fuel_fee_array != null) {
            $this->getData_fuel_fee($fuel_fee_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }

        if ($rider_guarantee_array != null) {
            $this->getData_rider_guarantee($rider_guarantee_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
        if ($tips_array != null) {
            $this->getData_tips($tips_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
//        ----------------
        if ($past_queries_adjustment_array != null) {
            $this->getData_past_queries_adjustment($past_queries_adjustment_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
        if ($bonus_array != null) {
            $this->getData_bonus($bonus_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
        if ($surge_array != null) {
            $this->getData_surge($surge_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }

        if ($rider_training_fee_array != null) {
            $this->getData_rider_training_fee($rider_training_fee_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
        if ($cod_penalty_return_array != null) {
            $this->getData_cod_penalty_return($cod_penalty_return_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
//        if ($ar_discount_array != null) {
//            $this->getData_ar_discount($ar_discount_array, $date_saved_array, $status_array, $zds_code_array, $passport_id);
//        }

        if ($ar_discount_array != null) {
            $this->getData_ar_discount($ar_discount_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }

        if ($traffic_fine_discount_array != null) {
            $this->getData_traffic_fine_discount($traffic_fine_discount_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }
        if ($salik_allowance_array != null) {
            $this->getData_salik_allowance($salik_allowance_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }


        if ($ot_array != null) {
            $this->getData_ot($ot_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }

        if ($guarantee_trips_array != null) {
            $this->getData_guarantee_trips($guarantee_trips_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }

        if ($fuel_allownce_array != null) {
            $this->getData_fuel_allownce($fuel_allownce_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }

        if ($other_adjusment_array != null) {
            $this->getData_other_adjusment($other_adjusment_array, $date_saved_array, $status_array, $zds_code_array, $passport_id,$platform_id);
        }

//        if ($total_hours_array != null) {
//            return new ArBalanceSheet([
//                'zds_code' => $zds_code_array,
//                'passport_id' => $passport_id,
//                'date_saved' => $date_saved_array,
//                'balance_type' => '37',
//                'balance' => $total_hours_array,
//                'status' => $status_array,
//            ]);
//
//        }


    }




        //---------------add 2nd row here-------------



//
    public function getData_total_hours($total_hours_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($total_hours_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '32';
            $gamer->balance = $total_hours_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    //rent row


    public function getData_order_array($orders_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($orders_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '33';
            $gamer->balance = $orders_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_rider_distance($rider_distance_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($rider_distance_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '34';
            $gamer->balance = $rider_distance_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_stacked_order($stacked_order_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($stacked_order_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '35';
            $gamer->balance = $stacked_order_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_working_days($working_days_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($working_days_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '36';
            $gamer->balance = $working_days_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_monthaly_salary($monthly_salary_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($monthly_salary_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '37';
            $gamer->balance = $monthly_salary_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_payout_against_order($payout_against_orders_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($payout_against_orders_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '38';
            $gamer->balance = $payout_against_orders_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_payout_against_stacked_order($payout_against_stacked_order_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($payout_against_stacked_order_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '39';
            $gamer->balance = $payout_against_stacked_order_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

//----------------------------------
//----------------------------------

    public function getData_zone_block_incentive($zone_block_incentive_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($zone_block_incentive_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '40';
            $gamer->balance = $zone_block_incentive_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_zone_bonus($zone_bonus_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($zone_bonus_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '41';
            $gamer->balance = $zone_bonus_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_montly_bonus_array($montly_bonus_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($montly_bonus_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '42';
            $gamer->balance = $montly_bonus_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_platform_incentive($platform_incentive_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($platform_incentive_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '43';
            $gamer->balance = $platform_incentive_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_referal_cash($referal_cash_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($referal_cash_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '44';
            $gamer->balance = $referal_cash_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_fuel_fee($fuel_fee_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($fuel_fee_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '45';
            $gamer->balance = $fuel_fee_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_rider_guarantee($rider_guarantee_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($rider_guarantee_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '46';
            $gamer->balance = $rider_guarantee_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_tips($tips_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($tips_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '47';
            $gamer->balance = $tips_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_past_queries_adjustment($past_queries_adjustment_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($past_queries_adjustment_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '48';
            $gamer->balance = $past_queries_adjustment_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_bonus($bonus_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($bonus_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '49';
            $gamer->balance = $bonus_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_surge($surge_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($surge_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '50';
            $gamer->balance = $surge_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_rider_training_fee($rider_training_fee_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($rider_training_fee_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '51';
            $gamer->balance = $rider_training_fee_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_cod_penalty_return($cod_penalty_return_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($cod_penalty_return_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '52';
            $gamer->balance = $cod_penalty_return_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_ar_discount($ar_discount_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($ar_discount_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '53';
            $gamer->balance = $ar_discount_array;
            $gamer->status = $status_array;
             $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_traffic_fine_discount($traffic_fine_discount_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($traffic_fine_discount_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '54';
            $gamer->balance = $traffic_fine_discount_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_salik_allowance($salik_allowance_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($salik_allowance_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '55';
            $gamer->balance = $salik_allowance_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }




    public function getData_ot($ot_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($ot_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '56';
            $gamer->balance = $ot_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_guarantee_trips($guarantee_trips_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($guarantee_trips_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '57';
            $gamer->balance = $guarantee_trips_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_fuel_allownce($fuel_allownce_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($fuel_allownce_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '58';
            $gamer->balance = $fuel_allownce_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_other_adjusment($other_adjusment_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($other_adjusment_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '59';
            $gamer->balance = $other_adjusment_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

}
