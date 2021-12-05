<?php

namespace App\Imports;

use App\Model\SimBills;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Model\ArBalance\ArBalanceSheet;
class SimBillUpload implements ToModel,WithHeadingRow
{

    use Importable, SkipsErrors;

    private  $last_id = "";

    public function __construct($last_id)
    {
        $this->last_id = $last_id;
    }

    public function model(array $row)
    {
//        echo $row['invoice_number'];
//dd($row);
        $invoice_num = trim($row['invoice_number']);
        $trans_id= $this->checkExistData($invoice_num);
        if($trans_id=="" && !empty($row['invoice_number'])){

            $date = explode("T",trim($row['invoice_date']));

            $date_change =  date("Y-m-d", strtotime(trim($date[0])));
            $sim=\App\Model\Telecome::where('account_number',trim($row['account_number']))->first();



            if($sim!=null){

            $checkin_detail = \App\Model\Assign\AssignSim::where('checkin', '<=',$date_change)
                    ->where('sim','=',$sim->id)
                    ->first();


                if($checkin_detail!=null){
                    $platform_detail=\App\Model\Assign\AssignPlateform::where('passport_id',$checkin_detail->passport_id)
                    ->where('checkin', '<=',$date_change)
                    ->first();
                    if($platform_detail!=null){
                        $platform_id=$platform_detail;
                    }
                    else{
                        $platform_id='';
                    }

                    $obj = new ArBalanceSheet();
                    $obj->passport_id =$checkin_detail->passport_id;
                    $obj->date_saved = date("Y-m-d");
                    $obj->balance_type = '2';
                    $obj->balance = trim($row['amount_to_pay']);
                    $obj->status = '0';
                    $obj->platform_id=$platform_id;
                    $obj->upload_file_sheet_id=trim($this->last_id);
                    $obj->save();
                }
            }






                return new SimBills([
                    'account_number'  => trim($row['account_number']),
                    'party_id'  => trim($row['partyid']),
                    'product_type'  => trim($row['producttype']),
                    'invoice_number'  => trim($row['invoice_number']),
                    'invoice_date' => $date_change,
                    'service_rental' =>  trim($row['service_rentals']),
                    'usage_charge' =>  trim($row['usage_charges']),
                    'one_time_charges' => trim($row['one_time_charges']),
                    'other_credit_and_charges' => trim($row['other_credits_and_charges']),
                    'vat_on_taxable_services' => trim($row['vat_on_taxable_services']),
                    'billed_amount' => trim($row['billed_amount']),
                    'total_amount_due' => trim($row['total_amount_due']),
                    'amount_to_pay' => trim($row['amount_to_pay']),
                    'sim_bill_upload_path_id' => trim($this->last_id),
                ]);

        }else{

            return  null;
        }



    }


//    public function headingRow()
//    {
//        return 0;
//    }


    public function checkExistData($invoice_number){

        $query= SimBills::where('invoice_number', '=', $invoice_number)->first();

        $trans_id = isset($query->id)?$query->id:"";

        return $trans_id;

    }
}
