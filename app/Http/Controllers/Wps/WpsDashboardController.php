<?php

namespace App\Http\Controllers\Wps;

use App\Exports\WpsAddDetails;
use App\Exports\WpsDataExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\WpsDetailsImport;
use App\Model\ElectronicApproval\ElectronicPreApproval;
use App\Model\Master\FourPl;
use App\Model\Offer_letter\Offer_letter;
use App\Model\Passport\Passport;
use App\Model\Seeder\Company;
use App\Model\Wps\WpsBankDetails;
use App\Model\Wps\WpsCThreeDetail;
use App\Model\Wps\WpsLuluCardDetail;
use App\Model\Wps\WpsPaymentDetail;
use App\SThreeDemo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;


class WpsDashboardController extends Controller
{
    public function dashboard() {
        return view('admin-panel.wps.wps_dashboard');
    }

    public function company_listed() {

        $companies = Company::select('companies.id', 'companies.name', 'trade_license_no', DB::raw('count(offer_letters.id) as total_employee'))
                ->with('mol_no', 'moi_no')
                ->leftjoin('offer_letters', 'companies.id', '=', 'offer_letters.company')
                ->leftJoin('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'offer_letters.passport_id')
                ->groupBy('companies.id')
                ->get();

        return view('admin-panel.wps.company_listed', compact(('companies')));
    }

    public function employee_details() {

        $company = Company::select('companies.id', 'companies.name', 'trade_license_no', DB::raw('count(offer_letters.id) as total_employee'))
                    ->leftjoin('offer_letters', 'companies.id', '=', 'offer_letters.company')
                    ->leftJoin('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'offer_letters.passport_id')
                    ->groupBy('companies.id')
                    ->get();

        $employees = Company::select('companies.name', 'passport_additional_info.full_name', 'passports.passport_no')
                            ->leftjoin('offer_letters', 'companies.id', '=', 'offer_letters.company')
                            ->leftJoin('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'offer_letters.passport_id')
                            ->join('passports', 'passports.id', '=', 'offer_letters.passport_id')
                            ->join('passport_additional_info', 'passports.id', '=', 'passport_additional_info.passport_id')
                            ->get();

        return view('admin-panel.wps.employee_details', compact('company', 'employees'));
    }

    public function get_employee_details(Request $request) {

        $query = Offer_letter::select('companies.name', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid', 'user_codes.zds_code', 'entry_print_inside_outside.visa_number', 'emirates_id_cards.card_no','nationalities.name as country', 'offer_letter_submission.mb_no as mb_no', 'electronic_pre_approval.person_code', 'electronic_pre_approval.labour_card_no')
                            ->leftjoin('companies', 'companies.id', '=', 'offer_letters.company')
                            ->leftJoin('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'offer_letters.passport_id')
                            ->join('passports', 'passports.id', '=', 'offer_letters.passport_id')
                            ->leftJoin('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->leftJoin('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                            ->leftJoin('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                            ->join('nationalities', 'nationalities.id', '=', 'passports.nation_id')
                            ->leftJoin('agreements', 'agreements.passport_id', '=', 'passports.id')
                            ->join('passport_additional_info', 'passports.id', '=', 'passport_additional_info.passport_id')
                            ->leftJoin('offer_letter_submission', 'passports.id', '=', 'offer_letter_submission.passport_id')
                            ->groupBy('offer_letters.passport_id');

        if($request->company_id) {
            $query = $query->where('companies.id', $request->company_id);
        }
        if($request->employee_type) {
            $query = $query->where('agreements.employee_type_id', $request->employee_type);
        }
        $employees = $query->get();

        $table = Datatables::of($employees);
        return $table->make(true);
    }

    public function wps_pay_master(Request $request) {

        $company = Company::select('companies.id', 'companies.name', 'trade_license_no', DB::raw('count(offer_letters.id) as total_employee'))
                    ->leftjoin('offer_letters', 'companies.id', '=', 'offer_letters.company')
                    ->leftJoin('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'offer_letters.passport_id')
                    ->groupBy('companies.id')
                    ->get();

        return view('admin-panel.wps.pay_master', compact('company'));

    }

    public function store_wps_pay_master(Request $request) {

        $this->validate($request,[
            'passport_id'=>'required',
        ]);


        $wps_details = WpsPaymentDetail::where('passport_id', $request->passport_id)->get();

        if(count($wps_details) > 0) {
            $message = [
                'message' => 'WPS Details ALready Added',
                'alert-type' => 'error'
            ];

            return redirect()->route('wps-pay-master')->with($message);
        }


        //payment office cash
        if($request->payment_method == 2) {
            $obj = new WpsPaymentDetail();
            $obj->passport_id = $request->passport_id;
            $obj->cash_or_exchange = 1;
            $obj->save();

            $message = [
                'message' => 'Details Added Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('wps-pay-master')->with($message);
        }

        //payment exchange cash
        if($request->payment_method == 3) {
            $obj = new WpsPaymentDetail();
            $obj->passport_id = $request->passport_id;
            $obj->cash_or_exchange = 2;
            $obj->save();

            $message = [
                'message' => 'Details Added Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('wps-pay-master')->with($message);
        }

        if($request->c3_checkbox) {

            foreach($request->c_three_details as $key => $value) {

                $imageName = '';
                if(isset($value['attachment'])) {
                    $imageName = rand(100,100000).'.'.time().'.'.$value['attachment']->extension();
                    $value['attachment']->move(public_path().'/assets/upload/wps/', $imageName);
                }

                $obj = new WpsCThreeDetail();
                $obj->passport_id = $request->passport_id;
                $obj->card_no = $request->c_three_details[$key]['card_no'];
                $obj->code_no = $request->c_three_details[$key]['code_no'];
                $obj->expiry = $request->c_three_details[$key]['expiry'];
                $obj->attachment = $imageName;
                $obj->remarks = $request->c_three_details[$key]['remarks'];
                $obj->save();

                if($request->c_three_details[$key]['active'] == $request->bank_radio) {
                    $details_obj = new WpsPaymentDetail();
                    $details_obj->passport_id = $request->passport_id;
                    $details_obj->wps_payment_id = $obj->id;
                    $details_obj->cash_or_exchange = 3;
                    $details_obj->wps_payment_type = 'App\Model\Wps\WpsCThreeDetail';
                    $details_obj->save();
                }
            }

        }

        if($request->lulu_checkbox) {

            foreach($request->lulu_details as $key => $value) {

                $imageName = '';
                if(isset($value['attachment'])) {
                    $imageName = rand(100,100000).'.'.time().'.'.$value['attachment']->extension();
                    $value['attachment']->move(public_path().'/assets/upload/wps/', $imageName);
                }

                $obj = new WpsLuluCardDetail();
                $obj->passport_id = $request->passport_id;
                $obj->card_no = $request->lulu_details[$key]['card_no'];
                $obj->code_no = $request->lulu_details[$key]['code_no'];
                $obj->expiry = $request->lulu_details[$key]['expiry'];
                $obj->attachment = $imageName;
                $obj->remarks = $request->lulu_details[$key]['remarks'];
                $obj->save();

                if($request->lulu_details[$key]['active'] == $request->bank_radio) {
                    $details_obj = new WpsPaymentDetail();
                    $details_obj->passport_id = $request->passport_id;
                    $details_obj->wps_payment_id = $obj->id;
                    $details_obj->cash_or_exchange = 4;
                    $details_obj->wps_payment_type = 'App\Model\Wps\WpsLuluCardDetail';
                    $details_obj->save();
                }
            }

        }

        if($request->bank_checkbox) {

            foreach($request->bank_details as $key => $value) {

                $imageName = '';
                if(isset($value['attachment'])) {
                    $imageName = rand(100,100000).'.'.time().'.'.$value['attachment']->extension();
                    $value['attachment']->move(public_path().'/assets/upload/wps/', $imageName);
                }

                $obj = new WpsBankDetails();
                $obj->passport_id = $request->passport_id;
                $obj->bank_name = $request->bank_details[$key]['bank_name'];
                $obj->iban_no = $request->bank_details[$key]['iban_no'];
                $obj->attachment = $imageName;
                $obj->remarks = $request->bank_details[$key]['bank_remarks'];
                $obj->save();

                if($request->bank_details[$key]['active'] == $request->bank_radio) {
                    $details_obj = new WpsPaymentDetail();
                    $details_obj->passport_id = $request->passport_id;
                    $details_obj->cash_or_exchange = 5;
                    $details_obj->wps_payment_id = $obj->id;
                    $details_obj->wps_payment_type = 'App\Model\Wps\WpsBankDetails';
                    $details_obj->save();
                }
            }


        }

        $message = [
            'message' => 'Details Added Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('wps-pay-master')->with($message);


    }



    public function wps_ajax_employee_list(Request $request) {

        $query = Offer_letter::select('companies.name', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.id as primary_id','passports.pp_uid', 'user_codes.zds_code', 'entry_print_inside_outside.visa_number', 'emirates_id_cards.card_no','nationalities.name as country', 'offer_letter_submission.mb_no as mb_no', 'electronic_pre_approval.person_code', 'electronic_pre_approval.labour_card_no')
                            ->leftjoin('companies', 'companies.id', '=', 'offer_letters.company')
                            ->leftJoin('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'offer_letters.passport_id')
                            ->join('passports', 'passports.id', '=', 'offer_letters.passport_id')
                            ->leftJoin('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->leftJoin('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                            ->leftJoin('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                            ->join('nationalities', 'nationalities.id', '=', 'passports.nation_id')
                            ->leftJoin('agreements', 'agreements.passport_id', '=', 'passports.id')
                            ->join('passport_additional_info', 'passports.id', '=', 'passport_additional_info.passport_id')
                            ->leftJoin('offer_letter_submission', 'passports.id', '=', 'offer_letter_submission.passport_id')
                            ->groupBy('offer_letters.passport_id');

        if($request->id) {
            $query = $query->where('companies.id', $request->id);
        }

        $table = Datatables::of($query)
                    ->addColumn('action', function ($query) {
                        return '<button class="btn btn-xs btn-success add-wps" value="'.$query->passport_no.'">
                                    <span class="glyphicon glyphicon-edit"></span> Add WPS
                                </button>';
                    });
        return $table->make(true);

    }


    public function employee_payment_details(Request $request) {

        $companies = Company::all();
        $four_pls = FourPl::all();

        return view('admin-panel.wps.employee_payment_details', compact('companies', 'four_pls'));

    }

    public function wps_employee_data_list(Request $request) {

        $query = WpsPaymentDetail::select('passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid', 'companies.name', 'electronic_pre_approval.labour_card_no', 'wps_payment_details.cash_or_exchange', 'wps_payment_details.id', 'wps_payment_details.wps_payment_type', 'wps_payment_details.wps_payment_id' )
                        // ->with('wps_payment')
                        ->join('passports', 'passports.id', '=', 'wps_payment_details.passport_id')
                        ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'wps_payment_details.passport_id')
                        ->join('offer_letters', 'wps_payment_details.passport_id', '=', 'offer_letters.passport_id')
                        ->join('companies', 'companies.id', '=', 'offer_letters.company')
                        ->join('passport_additional_info', 'passports.id', '=', 'passport_additional_info.passport_id');


        if($request->id) {
            $query = $query->where('companies.id', $request->id);
        }

        if($request->four_pl_id) {
            $query = $query->join('agreements', 'agreements.passport_id', '=', 'wps_payment_details.passport_id');
                    // ->join('four_pls', 'four_pls.id', '=', 'agreements.four_pl_name')
                    // ->where('four_pls.id', $request->four_pl_id);
        }

        $employees = $query->get();

        $table = Datatables::of($employees)
                    ->addColumn('action', function ($query) {
                        return '<a id="wpsModalBtn" class="text-primary mr-2 renew_btn_cls" data-id=" '.$query->id .'" data-target="#wpsDetails" type="button" data-toggle="modal" href="javascript:void(0)">
                                    <i class="fa fa-eye fa-lg" aria-hidden="true"></i>
                                </a>
                                <a href="'.route('wps-individual-details-edit', ['id' => $query->id ]).'"> <i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>';
                    })
                    ->addColumn('cash_or_exchange', function($data) {
                        if($data->cash_or_exchange == 1){
                            return 'Office Cash';
                        }elseif($data->cash_or_exchange == 2) {
                            return 'Exchange Cash (Lulu)';
                        }
                        elseif($data->cash_or_exchange == 3) {
                            return 'C3 Card';
                        }
                        elseif($data->cash_or_exchange == 4) {
                            return 'Lulu Card';
                        }
                        elseif($data->cash_or_exchange == 5) {
                            return 'Bank';
                        }
                    });
        return $table->make(true);

    }


    public function wps_details_import(Request $request) {
        Excel::import(new WpsDetailsImport, request()->file('excel_file'));

        $message = [
            'message' => 'Details Added Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('wps-pay-master')->with($message);
    }

    public function wps_individual_details(Request $request) {

        $details = WpsPaymentDetail::where('wps_payment_details.id', $request->wps_id)
                    ->with('c_three_details', 'lulu_card_details', 'bank_details')
                    ->join('passports', 'passports.id', '=', 'wps_payment_details.passport_id')
                    ->select('passports.passport_no','passports.pp_uid', 'passport_additional_info.full_name', 'companies.name', 'electronic_pre_approval.labour_card_no', 'wps_payment_details.*')
                    ->join('offer_letters', 'wps_payment_details.passport_id', '=', 'offer_letters.passport_id')
                    ->join('companies', 'companies.id', '=', 'offer_letters.company')
                    ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'wps_payment_details.passport_id')
                    ->join('passport_additional_info', 'passports.id', '=', 'passport_additional_info.passport_id')
                    ->get();

       return response()->json($details);
    }

    public function wps_individual_details_edit($id) {

        $details = WpsPaymentDetail::where('wps_payment_details.id', $id)
                    ->with('c_three_details', 'lulu_card_details', 'bank_details')
                    ->join('passports', 'passports.id', '=', 'wps_payment_details.passport_id')
                    ->select('passports.passport_no','passports.pp_uid', 'passport_additional_info.full_name', 'companies.name', 'electronic_pre_approval.labour_card_no', 'wps_payment_details.*')
                    ->join('offer_letters', 'wps_payment_details.passport_id', '=', 'offer_letters.passport_id')
                    ->join('companies', 'companies.id', '=', 'offer_letters.company')
                    ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'wps_payment_details.passport_id')
                    ->join('passport_additional_info', 'passports.id', '=', 'passport_additional_info.passport_id')
                    ->first();

        return view('admin-panel.wps.employee_details_edit', compact('details'));
    }

    public function wps_individual_details_update($id, Request $request) {

        $message = [
            'message' => 'Details Updated Successfully',
            'alert-type' => 'success'
        ];

        $obj = WpsPaymentDetail::find($id);

        if($request->wps_type == 'c3') {
            $wps_type = 'App\Model\Wps\WpsCThreeDetail';
            $obj->cash_or_exchange = 3;
        }
        elseif($request->wps_type == 'lulu') {
            $wps_type = 'App\Model\Wps\WpsLuluCardDetail';
            $obj->cash_or_exchange = 4;
        }
        elseif($request->wps_type == 'bank') {
            $wps_type = 'App\Model\Wps\WpsBankDetails';
            $obj->cash_or_exchange = 5;
        }
        elseif($request->wps_type == 'office') {
            $obj->cash_or_exchange = 1;
            $obj->wps_payment_type = '';
            $obj->wps_payment_id = '';
            $obj->save();

            return redirect()->back()->with($message);
        }
        elseif($request->wps_type == 'exchange') {
            $obj->cash_or_exchange = 2;
            $obj->wps_payment_type = '';
            $obj->wps_payment_id = '';
            $obj->save();

            return redirect()->back()->with($message);
        }


        $obj->wps_payment_type = $wps_type;
        $obj->wps_payment_id = $request->wps_id;
        $obj->save();

        return redirect()->back()->with($message);
    }

    public function wps_data_export(Request $request) {

        return Excel::download(new WpsDataExport($request->company_id), 'Wps Employee Data.xlsx');
    }


    public function autocomplete_passport(Request $request){

        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->get();

        if (count($passport_data)=='0')
        {
            // return "pp";
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->get();

                        if (count($zds_data)=='0')
                        {
                            $labour_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code', 'electronic_pre_approval.labour_card_no')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->leftJoin('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->where("electronic_pre_approval.labour_card_no","LIKE","%{$request->input('query')}%")
                            ->get();



                        //zds code response
                            $pass_array=array();
                            foreach ($labour_data as $pass){
                            $gamer = array(
                                'name' => $pass->labour_card_no,
                                'passport' => $pass->passport_no,
                                'ppuid' => $pass->pp_uid,
                                'full_name' => $pass->full_name,
                                'zds_code' => $pass->zds_code,
                                'type'=>'4',
                            );
                            $pass_array[]= $gamer;
                            }
                            return response()->json($pass_array);

                        }

                    //zds code response
                    $pass_array=array();
                    foreach ($zds_data as $pass){
                        $gamer = array(
                            'name' => $pass->zds_code,
                            'passport' => $pass->passport_no,
                            'ppuid' => $pass->pp_uid,
                            'full_name' => $pass->full_name,
                            'type'=>'3',
                        );
                        $pass_array[]= $gamer;
                    }
                    return response()->json($pass_array);

                }

                //full name response
                $pass_array=array();
                foreach ($full_data as $pass){
                    $gamer = array(
                        'name' => $pass->full_name,
                        'passport' => $pass->passport_no,
                        'ppuid' => $pass->pp_uid,
                        'zds_code' => $pass->zds_code,
                        'type'=>'2',
                    );
                    $pass_array[]= $gamer;
                }
                return response()->json($pass_array);

            }
            //ppuid response

            $pass_array=array();
            foreach ($puid_data as $pass){
                $gamer = array(
                    'name' => $pass->pp_uid,
                    'passport' => $pass->passport_no,
                    'full_name' => $pass->full_name,
                    'zds_code' => $pass->zds_code,
                    'type'=>'1',
                );
                $pass_array[]= $gamer;
            }
            return response()->json($pass_array);
            }


        //passport number response
        $pass_array=array();
        foreach ($passport_data as $pass){
        $gamer = array(
            'name' => $pass->passport_no,
            'ppuid' => $pass->pp_uid,
            'full_name' => $pass->full_name,
            'zds_code' => $pass->zds_code,
            'type'=>'0',
        );
        $pass_array[]= $gamer;
        }
        return response()->json($pass_array);

    }

    public function get_s3_demo() {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        // $images = [];
        // $files = Storage::disk('s3')->files('images');
        //     foreach ($files as $file) {
        //         $images[] = [
        //             'name' => str_replace('images/', '', $file),
        //             'src' => $url . $file
        //         ];
        //     }

        $url = Storage::temporaryUrl(
            '1619859239.jpg', now()->addMinutes(5)
        );
        // $url = Storage::url('1619688955.jpg');
        $images = SThreeDemo::all();

        return view('admin-panel.wps.s3_demo', compact('images', 'url'));
    }

    public function s3_demo(Request $request) {

        $fileName = time().'.'.$request->image->extension();
        // $request->image->move(public_path('/assets/upload/wps/'), $fileName);
        $t = Storage::disk('s3')->put($fileName, file_get_contents($request->image));

        $obj = new SThreeDemo();
        $obj->title = $request->title;
        $obj->image = $fileName;
        $obj->save();

        return back();
    }

}
