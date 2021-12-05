<?php

namespace App\Imports;

use App\Model\Passport\Passport;
use App\Model\Wps\WpsBankDetails;
use App\Model\Wps\WpsCThreeDetail;
use App\Model\Wps\WpsLuluCardDetail;
use App\Model\Wps\WpsPaymentDetail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class WpsDetailsImport implements ToCollection, WithHeadingRow
{
    public function headingRow(): int
    {
        return 2;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            // print_r( Date::excelToDateTimeObject($row['1_card_type'])); exit;
            // print_r($row); exit;
            $ppuid = $row['ppuid'];

                if(strtolower(trim($row['payment_method'])) == 'office cash') {

                    $passport_id = $this->checkCashExistData($ppuid);

                    if($passport_id) {
                        WpsPaymentDetail::create([
                            'passport_id'  => $passport_id,
                            'cash_or_exchange'  => 1,
                        ]);
                    }

                }
                elseif(strtolower(trim($row['payment_method'])) == 'exchange cash') {

                    $passport_id = $this->checkExchangeExistData($ppuid);
                    if($passport_id) {
                        WpsPaymentDetail::create([
                            'passport_id'  => $passport_id,
                            'cash_or_exchange'  => 2,
                            'exchange_location'  => $row['payment_location'],
                        ]);
                    }

                }
                elseif(strtolower(trim($row['payment_method'])) == 'card/bank') {

                    $passport_id = $this->checkExistData($ppuid);

                    if($passport_id) {
                        WpsPaymentDetail::create([
                            'passport_id'  => $passport_id,
                            'cash_or_exchange'  => 1,
                        ]);
                    }

                    if(strtolower(trim($row['1_card_type'])) == 'c3') {

                        $passport_id = $this->checkCThreeExistData($ppuid);
                        if($passport_id) {

                            WpsCThreeDetail::create([
                                'passport_id'  => $passport_id,
                                'card_no'  => $row['1_card_no'],
                                'code_no'  => $row['1_code_no'],
                                'expiry'  =>  Date::excelToDateTimeObject($row['1_expiry']),
                            ]);

                        }

                    }

                    if(strtolower(trim($row['2_card_type'])) == 'lulu') {

                        $passport_id = $this->checkLuluExistData($ppuid);
                        if($passport_id) {
                            WpsLuluCardDetail::create([
                                'passport_id'  => $passport_id,
                                'card_no'  => $row['2_card_no'],
                                'code_no'  => $row['2_code_no'],
                                'expiry'  =>  Date::excelToDateTimeObject($row['2_expiry']),
                            ]);
                        }

                    }

                    if(strtolower(trim($row['3_card_type'])) == 'bank') {

                        $passport_id = $this->checkBankExistData($ppuid);
                            if($passport_id) {
                            WpsBankDetails::create([
                                'passport_id'  => $passport_id,
                                'bank_name'  => $row['3_bank_name'],
                                'iban_no'  => $row['3_iban_no'],
                            ]);
                        }

                    }

                }

        }
    }

    public function checkCashExistData($ppuid){

        $passport_id = Passport::where('pp_uid', '=', $ppuid)->first();
        if($passport_id) {
            $details = WpsPaymentDetail::where('passport_id', '=', $passport_id->id)
                     ->where('cash_or_exchange', '=', 1)->get();

            if(count($details) > 0)
                return 0;
            else
                return $passport_id->id;
        }

        return 0;

    }

    public function checkExchangeExistData($ppuid){

        $passport_id = Passport::where('pp_uid', '=', $ppuid)->first();
        if($passport_id) {
            $details = WpsPaymentDetail::where('passport_id', '=', $passport_id->id)
                     ->where('cash_or_exchange', '=', 2)->get();

            if(count($details) > 0)
                return 0;
            else
                return $passport_id->id;
        }

        return 0;

    }

    public function checkCThreeExistData($ppuid){

        $passport_id = Passport::where('pp_uid', '=', $ppuid)->first();
        if($passport_id) {
            $details = WpsCThreeDetail::where('passport_id', '=', $passport_id->id)->get();

            if(count($details) > 0)
                return 0;
            else
                return $passport_id->id;
        }

        return 0;

    }

    public function checkLuluExistData($ppuid){

        $passport_id = Passport::where('pp_uid', '=', $ppuid)->first();
        if($passport_id) {
            $details = WpsLuluCardDetail::where('passport_id', '=', $passport_id->id)->get();

            if(count($details) > 0)
                return 0;
            else
                return $passport_id->id;
        }

        return 0;

    }

    public function checkBankExistData($ppuid){

        $passport_id = Passport::where('pp_uid', '=', $ppuid)->first();
        if($passport_id) {
            $details = WpsBankDetails::where('passport_id', '=', $passport_id->id)->get();

            if(count($details) > 0)
                return 0;
            else
                return $passport_id->id;
        }

        return 0;

    }

    public function checkExistData($ppuid){

        $passport_id = Passport::where('pp_uid', '=', $ppuid)->first();
        if($passport_id) {
            $details = WpsPaymentDetail::where('passport_id', '=', $passport_id->id)->get();

            if(count($details) > 0)
                return 0;
            else
                return $passport_id->id;
        }

        return 0;

    }

}
