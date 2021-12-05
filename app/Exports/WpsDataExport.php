<?php

namespace App\Exports;

use App\Model\Wps\WpsPaymentDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;

class WpsDataExport implements FromView
{

    protected $company_id;
    public function __construct($company_id)
    {
        $this->company_id = $company_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     $data = WpsPaymentDetail::select('passports.pp_uid', 'passports.passport_no', 'user_codes.zds_code' , 'electronic_pre_approval.labour_card_no', 'electronic_pre_approval.person_code','wps_payment_details.cash_or_exchange', 'wps_payment_details.exchange_location', 'wps_payment_details.wps_payment_id', 'wps_payment_details.wps_payment_type')
    //             ->with('wps_payment')
    //             ->join('passports', 'passports.id', '=', 'wps_payment_details.passport_id')
    //             ->leftJoin('user_codes', 'user_codes.passport_id', '=', 'passports.id')
    //             ->leftJoin('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'wps_payment_details.passport_id')
    //             ->get();

    //     return $data;

    //     $data->map(function ($item, $key) {
    //                 $item->person_code = "'" . $item->person_code;
    //                 if($item->cash_or_exchange == 1) {
    //                     $item->cash_or_exchange = 'Office Cash';
    //                 }
    //                 elseif($item->cash_or_exchange == 2) {
    //                     $item->cash_or_exchange = 'Exchange Cash';
    //                 }
    //                 elseif($item->cash_or_exchange == 3 || $item->cash_or_exchange == 4 || $item->cash_or_exchange == 5) {
    //                     $item->cash_or_exchange = 'Bank/Card';
    //                 }
    //                 return $item;
    //             });

    //     return $data;
    // }

    // public function headings(): array
    // {
    //     return [
    //         'PP UID',
    //         'Passport No',
    //         'ZDS Code',
    //         'Labour Card No',
    //         'Person Code',
    //         'Payment Method',
    //         'Payment Location',
    //         '1 Card No',
    //         '1 Code No',
    //     ];
    // }

    public function view(): View
    {

        $query = WpsPaymentDetail::select('passports.pp_uid', 'passports.passport_no', 'user_codes.zds_code' , 'electronic_pre_approval.labour_card_no', 'electronic_pre_approval.person_code','wps_payment_details.cash_or_exchange', 'wps_payment_details.exchange_location', 'wps_payment_details.wps_payment_id', 'wps_payment_details.wps_payment_type', 'wps_payment_details.passport_id')
                    ->with('wps_payment', 'c_three_details', 'lulu_card_details', 'bank_details')
                    ->join('passports', 'passports.id', '=', 'wps_payment_details.passport_id')
                    ->leftJoin('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->leftJoin('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'wps_payment_details.passport_id')->join('offer_letters', 'wps_payment_details.passport_id', '=', 'offer_letters.passport_id')
                    ->join('companies', 'companies.id', '=', 'offer_letters.company');

        if($this->company_id) {
            $query = $query->where('companies.id', $this->company_id);
        }

        $data = $query->get();

        // dd($data);

        return view('admin-panel.wps.excel_export', [
            'data' => $data
        ]);
    }
}
