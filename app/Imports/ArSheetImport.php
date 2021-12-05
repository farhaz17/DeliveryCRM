<?php

namespace App\Imports;

use App\Model\ArBalance\ArBalance;
use App\Model\ArBalance\ArBalanceSheet;
use App\Model\UserCodes\UserCodes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArSheetImport implements ToModel,WithHeadingRow
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
        $ar_dection_array = $row['a_r_deduction'];
        $advance_dection_array = $row['advance_deduction'];
        $rent_array = $row['rent'];
        $sim_charge_array = $row['sim_charge'];
        $salik_array = $row['salik'];
        $fine_array = $row['fine'];
        $sim_exccess_array = $row['sim_exccess'];
        $others_array = $row['others'];
        $fuel_used_array = $row['fuel_used'];
        $salik_used_array = $row['salik_used'];
        $advance_array = $row['advance'];
        $traffice_fine_array = $row['traffice_fine'];
        $penalties_by_platform_array = $row['penalties_by_platform'];
        $cod_penalty_array = $row['cod_penalty'];
        $cod_ded_by_agency_array = $row['cod_ded_by_agency'];
        $cod_ded_by_platform_array = $row['cod_ded_by_platform'];
        $hour_deduction_array = $row['hour_deduction'];
        $health_insurance_array = $row['health_insurance'];
        $sim_lost_array = $row['sim_lost'];
        $accidental_insurance_excess_array = $row['accidental_insurance_excess'];
        $loss_and_damages_array = $row['loss_and_damages'];
        $deliveroo_kit_array = $row['deliveroo_kit'];
        $no_plate_charges_array = $row['no_plate_charges'];
        $other_deductionothers_array = $row['other_deduction'];
        $emirates_id_lost_array = $row['emirates_id_lost'];
        $over_stay_fine_array = $row['over_stay_fine'];
        $labour_fine_array = $row['labour_fine'];
        $urgent_visa_pasting_array = $row['urgent_visa_pasting'];
        $urgent_medical_array = $row['urgent_medical'];
        $trip_deduction_array = $row['trip_deduction'];







        $status_array = '1';
        $passport=UserCodes::where('zds_code',$zds_code_array)->first();
        $passport_id= $passport->passport_id;


//add first row---------------------------------------

        if($ar_dection_array!=null) {
            $this->getData($ar_dection_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        //rent

        if($rent_array!=null) {
            $this->getData_rent($rent_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        //sim charge

        if($sim_charge_array!=null) {
            $this->getData_sim_charge($sim_charge_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        //salik

        if($salik_array!=null) {
            $this->getData_sim_salik($salik_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        //fine
        if($fine_array!=null) {
            $this->getData_sim_fine($fine_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        //

        if($sim_exccess_array!=null) {
            $this->getData_sim_sim_eccess($sim_exccess_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        if($others_array!=null) {
            $this->getData_sim_sim_others($others_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }

        if($fuel_used_array!=null) {
            $this->getData_fuel($fuel_used_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        if($salik_used_array!=null) {
            $this->getData_salik_used($salik_used_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        if($advance_array!=null) {
            $this->getData_advance($advance_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }

        if($traffice_fine_array!=null) {
            $this->getData_traffice_fine($traffice_fine_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }

        if($penalties_by_platform_array!=null) {
            $this->getData_palanties_platform($penalties_by_platform_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }

        if($cod_penalty_array!=null) {
            $this->getData_cod_penalty_array($cod_penalty_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }

        if($hour_deduction_array!=null) {
            $this->getData_hour_ded($hour_deduction_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }

        if($health_insurance_array!=null) {
            $this->getData_health_insurance($health_insurance_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        if($sim_lost_array!=null) {
            $this->getData_sim_lost($sim_lost_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
//        ----------------
        if($accidental_insurance_excess_array!=null) {
            $this->getData_insurance_access($accidental_insurance_excess_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        if($loss_and_damages_array!=null) {
            $this->getData_loss_damage($loss_and_damages_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        if($deliveroo_kit_array!=null) {
            $this->getData_deliveroo_kit($deliveroo_kit_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }

        if($other_deductionothers_array!=null) {
            $this->getData_other_ded($other_deductionothers_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        if($emirates_id_lost_array!=null) {
            $this->getData_emirates_id_lost($emirates_id_lost_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        if($over_stay_fine_array!=null) {
            $this->getData_over_stay($over_stay_fine_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }

        if($labour_fine_array!=null) {
            $this->getData_labour_fine($labour_fine_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }

        if($urgent_visa_pasting_array!=null) {
            $this->getData_urgent_visa($urgent_visa_pasting_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }
        if($urgent_medical_array!=null) {
            $this->getData_urgent_med($urgent_medical_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }



        if($trip_deduction_array!=null) {
            $this->getData_trip($trip_deduction_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }

        if($no_plate_charges_array!=null) {
            $this->getData_no_plat_charges($no_plate_charges_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }

        if($cod_ded_by_platform_array!=null) {
            $this->getData_cod_ded_platform($cod_ded_by_platform_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }



        if($cod_ded_by_agency_array!=null) {
            $this->getData_cod_ded_by_agency($cod_ded_by_agency_array, $date_saved_array, $status_array, $zds_code_array,$passport_id,$platform_id);
        }




        //---------------add 2nd row here-------------
        if ($advance_dection_array != null) {
        return new ArBalanceSheet([
            'zds_code' => $zds_code_array,
            'passport_id' => $passport_id,
            'date_saved' => $date_saved_array,
            'balance_type' => '5',
            'balance' => $advance_dection_array,
            'status' => $status_array,
            'platform_id' => $platform_id,
        ]);

    }
    }



    public function getData($ar_dection_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($ar_dection_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '6';
            $gamer->balance = $ar_dection_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    //rent row


    public function getData_rent($rent_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($rent_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '1';
            $gamer->balance = $rent_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_sim_charge($sim_charge_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($sim_charge_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '2';
            $gamer->balance = $sim_charge_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_sim_salik($salik_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($salik_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '3';
            $gamer->balance = $salik_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_sim_fine($fine_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($fine_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '4';
            $gamer->balance = $fine_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_sim_sim_eccess($sim_exccess_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($sim_exccess_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '7';
            $gamer->balance = $sim_exccess_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_sim_sim_others($others_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($others_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '8';
            $gamer->balance = $others_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

//----------------------------------
//----------------------------------

    public function getData_fuel($fuel_used_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($fuel_used_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '9';
            $gamer->balance = $fuel_used_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_salik_used($salik_used_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($salik_used_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '10';
            $gamer->balance = $salik_used_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_advance($advance_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($advance_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '11';
            $gamer->balance = $advance_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_traffice_fine($traffice_fine_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($traffice_fine_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '13';
            $gamer->balance = $traffice_fine_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_palanties_platform($penalties_by_platform_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($penalties_by_platform_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '14';
            $gamer->balance = $penalties_by_platform_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_cod_penalty_array($cod_penalty_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($cod_penalty_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '15';
            $gamer->balance = $cod_penalty_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_cod_ded_by_agency($cod_ded_by_agency_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($cod_ded_by_agency_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '16';
            $gamer->balance = $cod_ded_by_agency_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_cod_ded_platform($cod_ded_by_platform_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($cod_ded_by_platform_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '17';
            $gamer->balance = $cod_ded_by_platform_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_hour_ded($hour_deduction_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($hour_deduction_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '18';
            $gamer->balance = $hour_deduction_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_health_insurance($health_insurance_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($health_insurance_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '19';
            $gamer->balance = $health_insurance_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_sim_lost($sim_lost_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($sim_lost_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '20';
            $gamer->balance = $sim_lost_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_insurance_access($accidental_insurance_excess_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($accidental_insurance_excess_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '21';
            $gamer->balance = $accidental_insurance_excess_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_loss_damage($loss_and_damages_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($loss_and_damages_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '22';
            $gamer->balance = $loss_and_damages_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_deliveroo_kit($deliveroo_kit_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($deliveroo_kit_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '23';
            $gamer->balance = $deliveroo_kit_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_no_plat_charges($no_plate_charges_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($no_plate_charges_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '24';
            $gamer->balance = $no_plate_charges_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_other_ded($other_deductionothers_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($other_deductionothers_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '25';
            $gamer->balance = $other_deductionothers_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_emirates_id_lost($emirates_id_lost_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($emirates_id_lost_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '26';
            $gamer->balance = $emirates_id_lost_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }


    public function getData_over_stay($over_stay_fine_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($over_stay_fine_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '27';
            $gamer->balance = $over_stay_fine_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_labour_fine($labour_fine_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($labour_fine_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '28';
            $gamer->balance = $labour_fine_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_urgent_visa($urgent_visa_pasting_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($urgent_visa_pasting_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '29';
            $gamer->balance = $urgent_visa_pasting_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }

    public function getData_urgent_med($urgent_medical_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($urgent_medical_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '30';
            $gamer->balance = $urgent_medical_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }
    public function getData_trip($trip_deduction_array,$date_saved_array,$status_array,$zds_code_array,$passport_id,$platform_id)
    {
        if ($trip_deduction_array != null) {
            $gamer = new ArBalanceSheet();
            $gamer->zds_code = $zds_code_array;
            $gamer->passport_id = $passport_id;
            $gamer->date_saved = $date_saved_array;
            $gamer->balance_type = '31';
            $gamer->balance = $trip_deduction_array;
            $gamer->status = $status_array;
            $gamer->platform_id = $platform_id;
            $gamer->save();
            //---------update ar_balance table with detucting amount
            return true;
        }
    }




}
