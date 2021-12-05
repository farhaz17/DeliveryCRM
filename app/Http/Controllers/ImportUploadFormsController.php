<?php

namespace App\Http\Controllers;
use App\Model\Telecome;
use App\Model\BikeDetail;
use App\Model\BikeImports;
use App\Model\Form_upload;
use App\Imports\FuelImport;
use App\Imports\SimImports;
use App\Imports\BikesImport;
use App\Imports\FinesImport;
use App\Imports\ppuidImport;
use App\Imports\Uber_Import;
use App\Model\Vehicle_salik;
use Illuminate\Http\Request;
use App\Imports\CareemImport;
use App\Imports\LabourUpload;
use App\Model\Seeder\Company;
use App\Imports\TelecomeImport;
use App\Imports\ Uber_Eats_Import;
use App\Imports\ FormsUploadImport;
use App\Imports\Rta_Vehicle_Import;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BikeComparisonImport;
use App\Imports\Employee_list_Import;
use App\Imports\FromUploadSaveImport;
use App\Model\Offer_letter\Offer_letter;
use App\Model\Seeder\CompanyInformation;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\Vehicle\VehiclePlateReplace;
use App\Model\Master\Vehicle\VehicleBulkUploadHistory;
use App\Model\ElectronicApproval\ElectronicPreApproval;

class ImportUploadFormsController extends Controller
{
    public function import(Request $request)
    {
        $form_type = $request->get('form_type');
        if ($form_type == '1') {
            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->route('upload_form')->with($message);
            }else{
                $not_exist = false;
                $last_id = Excel::toArray(new \App\Imports\FormsUploadImport(), request()->file('select_file'));
                $data = collect(head($last_id));
                $gamer_array = [];
                $count = 0;
                foreach ( $data as $res){
                    $id_traffic_code = $this->get_last_id_traffic_code($res['plate']);
                    if($id_traffic_code['plate']=="N/A"){
                        $not_exist = true;
                        $count = $count+1;
                        $gamer =  array(
                            'transaction_id'=> $res['transaction_id'],
                            'trip_date'=> $res['trip_date'],
                            'trip_time'=> $res['trip_time'],
                            'transaction_post_date'=> $res['transaction_post_date'],
                            'toll_gate'=> $res['toll_gate'],
                            'direction'=> $res['direction'],
                            'tag_number'=> $res['tag_number'],
                            'plate'=> $res['plate'],
                            'amount'=> $res['amount'],
                            'account_number'=> $res['account_number'],
                        );
                        $gamer_array [] = $gamer;
                    }
                }
            if ($count=='0'){
                Excel::import(new FormsUploadImport(), request()->file('select_file'));
                $message = [
                    'message' => 'Uploaded Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
                }
                else{
                    $result=Form_upload::all();
                    return view('admin-panel.uploading_forms.upload_forms',compact('result','gamer_array'));
                }
            }
                // Excel::import(new FormsUploadImport, request()->file('select_file'));
                // $message = [
                //     'message' => 'Uploaded Successfully',
                //     'alert-type' => 'success'
                // ];
                // return redirect()->route('upload_form')->with($message);
            }else if ($form_type == '2') {

                $validator = Validator::make($request->all(), [
                    'select_file' => 'required|mimes:xls,xlsx'
                ]);
                if ($validator->fails()) {
                    $validate = $validator->errors();
                    $message = [
                        'message' => $validate->first(),
                        'alert-type' => 'error'
                    ];
                    return redirect()->route('upload_form')->with($message);
                } else {
    //            Excel::import(new PartsImport,request()->file('select_file'));

                    Excel::import(new FinesImport, request()->file('select_file'));
                    // Excel::import(new FromUploadSaveImport,request()->file('select_file'));

                    $message = [
                        'message' => 'Uploaded Successfully',
                        'alert-type' => 'success'
                    ];
                    return redirect()->route('upload_form')->with($message);
                }
            } else if ($form_type == '3') { //end else if fines

            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->route('upload_form')->with($message);
            } else {

                Excel::import(new FuelImport, request()->file('select_file'));

                $message = [
                    'message' => 'Uploaded Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->route('upload_form')->with($message);
            }
        } else if ($form_type == '4') {

            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->route('upload_form')->with($message);
            } else {

                Excel::import(new Rta_Vehicle_Import, request()->file('select_file'));

                $message = [
                    'message' => 'Uploaded Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->route('upload_form')->with($message);
            }
        } else if ($form_type == '5') {

            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->route('upload_form')->with($message);
            } else {

                Excel::import(new Uber_Eats_Import, request()->file('select_file'));

                $message = [
                    'message' => 'Uploaded Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->route('upload_form')->with($message);
            }
        } else if ($form_type == '6') {

            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->route('upload_form')->with($message);
            } else {

                Excel::import(new Employee_list_Import, request()->file('select_file'));

                $message = [
                    'message' => 'Uploaded Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->route('upload_form')->with($message);
            }
        } else if ($form_type == '7') {

            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->route('upload_form')->with($message);
            } else {

                Excel::import(new Uber_Import, request()->file('select_file'));

                $message = [
                    'message' => 'Uploaded Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->route('upload_form')->with($message);
            }
        } else if ($form_type == '8') {

            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->route('upload_form')->with($message);
            } else {

                Excel::import(new CareemImport, request()->file('select_file'));
                $message = [
                    'message' => 'Uploaded Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->route('upload_form')->with($message);
            }
        } else if ($form_type == '9') {

            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->route('upload_form')->with($message);
            } else {

                Excel::import(new  TelecomeImport, request()->file('select_file'));
                $message = [
                    'message' => 'Uploaded Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->route('upload_form')->with($message);
            }
        } else {

            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->route('upload_form')->with($message);
            }else{
                $bikes_to_be_updated = head(Excel::toArray(new \App\Imports\BikesImport(), request()->file('select_file')));
                $new_plate_nos = [];
                $current_plate_nos = [];
                $new_chassis_nos = null;
                foreach ($bikes_to_be_updated as $bike){
                    // check chassis no is available or not
                    $bike_exist = BikeDetail::whereChassisNo(trim($bike['chassis_no']))->first();
                    if($bike_exist != null){
                        // if yes, plate no is same or not
                        if($bike_exist->plate_no != $bike['plate_no']){
                            // if no, put plate no in an array and save plate no replace request
                            $new_plate_nos[] = trim($bike['plate_no']);
                            $current_plate_nos[] = $bike_exist->plate_no;
                            $replace_request_exist = VehiclePlateReplace::whereStatus(0)->wherePlateNo($bike_exist->plate_no)->first();
                            if(!$replace_request_exist){
                                $obj = new VehiclePlateReplace();
                                $obj->plate_no = $bike_exist->plate_no;
                                $obj->new_plate_no = trim($bike['plate_no']);
                                $obj->bike_id = $bike_exist->id;
                                // $obj->reson_of_replacement = $request->reson_of_replacement; Excel doesnot have any reason column
                                $obj->remarks = 'Requested form excel upload operation';
                                $obj->save();
                            }
                        }
                    }else{
                        if(!empty(trim($bike['chassis_no']))){
                            $new_chassis_nos[] = trim($bike['chassis_no']);
                        }
                        // if no, save all info including chassis no and plate no
                    }
                }
                    Excel::import(new BikesImport, request()->file('select_file')); // bike_master bulk upload function here
                    $message = [
                        'message' =>  "Excel upload operation successful. ",
                        'alert-type' => 'success',
                        'new_plate_nos' =>  count($new_plate_nos) > 0 ? implode(",", $new_plate_nos) : '',
                        'current_plate_nos' => count($current_plate_nos) > 0 ? implode(",", $current_plate_nos) : ''
                    ];
                    if($new_chassis_nos != null){
                        $upload_history = new VehicleBulkUploadHistory();
                        $upload_history->vehicle_ids = json_encode(BikeDetail::whereIn('chassis_no',$new_chassis_nos)->pluck('id'));
                        $upload_history->user_id = auth()->user()->id;
                        $upload_history->updated_form = 2;
                        $upload_history->save();
                        $message['message'] .= "Vehicle Upload history added";
                    }
                    return redirect()->back()->with($message);
                }
            }
        }

    public function import2(Request $request)
    {
        $company = Company::all();
        $company_ids = $request->get('company_ids');
//     dd($company_ids);


        $validator = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->route('labour_upload')->with($message);
        } else {
            \App\Model\LabourUpload::query()->truncate();
            Excel::import(new LabourUpload, request()->file('select_file'));


            $ap_electronics_exist = ElectronicPreApproval::select('electronic_pre_approval.*')
                ->get();

            $new_updloads = \App\Model\LabourUpload::select('labour_uploads.*')
                ->get();

            $uploads_labour_card_no = array();

            foreach ($new_updloads as $upload) {
                $uploads_labour_card_no [] = $upload->labour_card;
            }


            $approval_electronics_exist = array();
            foreach ($ap_electronics_exist as $ab) {

                if (isset($ab->passport->offer->company)) {
//                if ( isset($ab->passport->offer->designation)) {
                    if (in_array($ab->passport->offer->company, $company_ids)) {
                        $gamer = array(
                            'person_code' => $ab->person_code,
                            'labour_card_no' => $ab->labour_card_no,
                            'person_name' => $ab->passport->personal_info->full_name,
                            'passport_number' => $ab->passport->passport_no,
                            'nation' => $ab->passport->nation->name,
                            'expiry_date' => $ab->expiry_date,
                            'card_type' => isset($ab->passport->card_type->card_type_name->name)?$ab->passport->card_type->card_type_name->name:"",
                            'job' => isset($ab->passport->offer->designation->name)?$ab->passport->offer->designation->name:""
                        );

                        $approval_electronics_exist [] = $gamer;
                    } else {

                        if (in_array($ab->labour_card_no, $uploads_labour_card_no)) {

                            $gamer = array(
                                'person_code' => $ab->person_code,
                                'labour_card_no' => $ab->labour_card_no,
                                'person_name' => $ab->passport->personal_info->full_name,
                                'passport_number' => $ab->passport->passport_no,
                                'nation' => $ab->passport->nation->name,
                                'expiry_date' => $ab->expiry_date,
                                'card_type' => $ab->passport->card_type->card_type_name->name,
                                'job' => isset($ab->passport->offer->designation->name)?$ab->passport->offer->designation->name:""
                            );

                            $approval_electronics_exist [] = $gamer;

                        }

                    }

//                }
                } else {

                    if (in_array($ab->labour_card_no, $uploads_labour_card_no)) {

                        $gamer = array(
                            'person_code' => $ab->person_code,
                            'labour_card_no' => $ab->labour_card_no,
                            'person_name' => $ab->passport->personal_info->full_name,
                            'passport_number' => $ab->passport->passport_no,
                            'nation' => $ab->passport->nation->name,
                            'expiry_date' => $ab->expiry_date,
                            'card_type' => $ab->passport->card_type->card_type_name->name,
                            'job' => isset($ab->passport->offer->designation)
                        );

                        $approval_electronics_exist [] = $gamer;

                    }
                }

            }

//          dd($approval_electronics_exist);

            $gamer_exist = \App\Model\LabourUpload::select('labour_uploads.*')
                ->leftjoin('electronic_pre_approval', 'electronic_pre_approval.labour_card_no', '=', 'labour_uploads.labour_card')
                ->get();


            $approval_electronics = ElectronicPreApproval::select('electronic_pre_approval.*')
                ->leftjoin('labour_uploads', 'labour_uploads.labour_card', '=', 'electronic_pre_approval.labour_card_no')
                ->whereNull('labour_uploads.labour_card')
                ->get();

            $gamer = \App\Model\LabourUpload::select('labour_uploads.*')
                ->leftjoin('electronic_pre_approval', 'electronic_pre_approval.labour_card_no', '=', 'labour_uploads.labour_card')
                ->whereNull('electronic_pre_approval.labour_card_no')
                ->get();

//               print_r($gamer->count());
//                dd($approval_electronics);


            return view('admin-panel.uploading_forms.LabourUpload', compact('person_code', 'approval_electronics', 'gamer', 'company', 'company_ids',
                'approval_electronics_exist', 'gamer_exist'));

        }
    }

    //---------end if--------------------


    public function import3(Request $request)
    {

        $company = Company::where('type', '=', '1')->get();
        $company_ids = $request->get('company_ids');



        $validator = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xls,xlsx',
            'company_ids' => 'required'

        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->route('sim_upload')->with($message);
        } else {
            \App\Model\SimImports::query()->truncate();

            Excel::import(new SimImports, request()->file('select_file'));


            $ap_sim_exist = Telecome::all();


            $new_updloads = \App\Model\SimImports::select('sim_imports.*')
                ->get();

            $uploads_sims_no = array();

            foreach ($new_updloads as $upload) {
                $uploads_sims_no [] = $upload->account_number;
            }

//            dd($ap_sim_exist);

            $sims_exist = array();
            foreach ($ap_sim_exist as $ab) {

                if (isset($ab->network)) {

                    if ($ab->network == "Etisalat") {

                        if (isset($ab->get_party_etisalat->company_id)) {
                            if (in_array($ab->get_party_etisalat->company_id, $company_ids)) {

                                $gamer = array(
                                    'account_no' => $ab->account_number,
                                    'party_id' => $ab->party_id,
                                    'product_type' => $ab->product_type,
                                    'network' => $ab->network,
                                );

                                $sims_exist [] = $gamer;

                            } else {
                                if (in_array($ab->account_number, $uploads_sims_no)) {
                                    $gamer = array(
                                        'account_no' => $ab->account_number,
                                        'party_id' => $ab->party_id,
                                        'product_type' => $ab->product_type,
                                        'network' => $ab->network,
                                    );

                                    $sims_exist [] = $gamer;

                                }

                            }

                        }
                    } elseif ($ab->network == "DU") {

                        if (isset($ab->get_du->company_id)) {
                            if (in_array($ab->get_du->company_id, $company_ids)) {
                                $gamer = array(
                                    'account_no' => $ab->account_number,
                                    'party_id' => $ab->party_id,
                                    'product_type' => $ab->product_type,
                                    'network' => $ab->network,
                                );
                                $sims_exist [] = $gamer;
                            } else {

                                if (in_array($ab->account_number, $uploads_sims_no)) {
                                    $gamer = array(
                                        'account_no' => $ab->account_number,
                                        'party_id' => $ab->party_id,
                                        'product_type' => $ab->product_type,
                                        'network' => $ab->network,
                                    );

                                    $sims_exist [] = $gamer;

                                }
                            }
                        }
                    }

                }

            }
//   foreach end here

            $gamer_exist = \App\Model\SimImports::select('sim_imports.*')
                ->leftjoin('telecomes', 'telecomes.account_number', '=', 'sim_imports.account_number')
                ->get();
//            dd($gamer_exist);

            $missing_sims = Telecome::select('telecomes.*')
                ->leftjoin('sim_imports', 'sim_imports.account_number', '=', 'telecomes.account_number')
                ->whereNull('sim_imports.account_number')
                ->get();

            $missing_uploads = \App\Model\SimImports::select('sim_imports.*')
                ->leftjoin('telecomes', 'telecomes.account_number', '=', 'sim_imports.account_number')
                ->whereNull('telecomes.account_number')
                ->get();


            return view('admin-panel.uploading_forms.sims_upload', compact('missing_uploads', 'missing_sims', '', 'company', 'company_ids',
                'sims_exist', 'gamer_exist'));


        }
    }


    public function import4(Request $request)
    {
        $company = Company::where('type', '=', '1')->get();
        $company_names = $request->get('company_ids');
        $company_informations=CompanyInformation::select('company_informations.*')->get();
        $traffic_file_exist = array();

        foreach ($company_informations as $company_info) {
            if (in_array($company_info->id, $company_names)) {

                $traffic_file_exist [] = $company_info->traffic_fle_no;
            }
        }
        $validator = Validator::make($request->all(), [
            'company_ids' => 'required'
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->route('bike_upload')->with($message);
        }


        $validator = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->route('bike_upload')->with($message);
        } else {
            BikeImports::query()->truncate();

            Excel::import(new BikeComparisonImport, request()->file('select_file'));

        }


        $bike_exist = BikeDetail::select('bike_details.*')->get();


        $new_updloads =BikeImports::select('bike_imports.*')->get();

        $uploads_bike_chassis_no = array();

        foreach ($new_updloads as $upload) {
            $uploads_bike_chassis_no [] = $upload->chassis_no;
        }


//        $approval_electronics_exist = array();
        $approval_bikes_exist = array();
        foreach ($bike_exist as $ab) {

            if (isset($ab->traffic_file)) {
//                if ( isset($ab->passport->offer->designation)) {
                if (in_array($ab->traffic_file,$traffic_file_exist)) {
                    $gamer = array(
                        'plate_no' => $ab->plate_no,
                        'plate_code' => $ab->plate_code,
                        'model' => $ab->model,
                        'make_year' => $ab->make_year,
                        'chassis_no' => $ab->chassis_no,
                        'insurance_co' => $ab->insurance_co,
                        'expiry_date' => $ab->expiry_date,
                        'issue_date' => $ab->issue_date,
                        'traffic_file' => $ab->traffic_file,
                        'mortgaged_by' => $ab->mortgaged_by,
                    );

                    $approval_bikes_exist [] = $gamer;
                } else {

                    if (in_array($ab->chassis_no, $uploads_bike_chassis_no)) {

                        $gamer = array(
                            'plate_no' => $ab->plate_no,
                            'plate_code' => $ab->plate_code,
                            'model' => $ab->model,
                            'make_year' => $ab->make_year,
                            'chassis_no' => $ab->chassis_no,
                            'insurance_co' => $ab->insurance_co,
                            'expiry_date' => $ab->expiry_date,
                            'issue_date' => $ab->issue_date,
                            'traffic_file' => $ab->traffic_file,
                            'mortgaged_by' => $ab->mortgaged_by,
                        );

                        $approval_bikes_exist [] = $gamer;

                    }

                }

//                }
            }

        }

//dd($company_names);
//   dd($approval_bikes_exist);

        $gamer_exist = BikeImports::select('bike_imports.*')
            ->leftjoin('bike_details', 'bike_details.chassis_no', '=', 'bike_imports.chassis_no')
            ->get();
//
//
        $bike_detail = BikeDetail::select('bike_details.*')
            ->leftjoin('bike_imports', 'bike_imports.chassis_no', '=', 'bike_details.chassis_no')
            ->whereNull('bike_imports.chassis_no')
            ->get();



//
        $gamer = BikeImports::select('bike_imports.*')
            ->leftjoin('bike_details', 'bike_details.chassis_no', '=', 'bike_imports.chassis_no')
            ->whereNull('bike_details.chassis_no')
            ->get();

//               print_r($gamer->count());
//                dd($approval_electronics);
//       dd($gamer_exist);


        return view('admin-panel.uploading_forms.bike_upload', compact( 'company','approval_bikes_exist','company_names','gamer_exist','bike_detail',
            'gamer'));

    }
    public function ppuid(Request $request){

        $validator = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        } else {

            Excel::import(new  ppuidImport(), request()->file('select_file'));
            $message = [
                'message' => 'Uploaded Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        }
    }


        //endshere
        public function get_last_id_traffic_code($gamer){

            $obj = BikeDetail::where('plate_no','=',$gamer)->first();


            $gamer =array(
                'plate' => isset($obj->plate_no)?$obj->plate_no:"N/A",

            );

            return $gamer;


        }

}



