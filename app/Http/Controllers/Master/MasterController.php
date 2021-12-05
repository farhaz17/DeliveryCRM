<?php

namespace App\Http\Controllers\Master;

use DateTime;
use Carbon\Carbon;
use App\CommonStatus;
use App\Model\Cities;
use App\Model\Telecome;
use App\Model\BikeCencel;
use App\Model\BikeDetail;
use App\Model\Departments;
use App\Model\Form_upload;
use App\Model\Nationality;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\Seeder\Company;
use App\Model\MajorDepartment;
use App\Model\Master\Category;
use App\Model\Assign\AssignSim;
use App\Model\Master\Company\Du;
use App\Model\Passport\Passport;
use App\Model\Master\Company\Moa;
use App\Model\Master\SubCategory;
use App\Model\Seeder\Designation;
use App\Model\Master\Sub_Category;
use App\Model\UserCodes\UserCodes;
use App\Model\Master\Company\Ejari;
use App\Model\Master\Company\Salik;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use App\Model\Master\CategoryAssign;
use Illuminate\Support\Facades\Auth;
use App\Model\Assign\AssignPlateform;
use App\Model\Master\Company\Renewal;
use App\Model\Master\Company\Traffic;
use App\Model\Master\VisaSubCategory;
use App\Model\Master\Company\Etisalat;
use App\Model\Master\VisaCategoryMain;
use App\Model\Passport\AttachmentTypes;
use App\Model\Master\Company\LabourCard;
use App\Model\Master\VisaCategoryAssign;
use App\Model\Seeder\CompanyInformation;
use phpseclib\System\SSH\Agent\Identity;
use App\Model\Master\Vehicle\VehicleMake;
use App\Model\Master\Vehicle\VehicleYear;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\Vehicle\VehicleModel;
use App\Model\Master\WorkingCategoryAssign;
use App\Model\Master\WorkingStatusCategory;
use App\Model\Master\Company\EEstablishment;
use App\Model\Master\Vehicle\VehicleCategory;
use App\Model\Master\Vehicle\VehicleMortgage;
use App\Model\Master\Vehicle\VehicleInsurance;
use App\Model\Master\Vehicle\VehiclePlateCode;
use App\Model\Master\WorkingStatusSubCategory;
use App\Model\Master\ActiveInactiveSubCategory;
use App\Model\Master\ActiveInactiveCategoryMain;
use App\Model\Master\Vehicle\VehicleSubCategory;
use App\Model\Master\Company\MasterMajorCategory;
use App\Model\Master\ActiveInactiveCategoryAssign;
use App\Model\Master\Vehicle\VehicleBulkUploadHistory;
use App\Model\Master\CustomerSupplier\CustomerSupplier;
use App\Model\Master\ActiveInactiveCategoryAssignHistory;
use App\Model\Master\Company\MasterUtilityElectricityWater;

class MasterController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|master-major-department', ['only' => ['index','edit','destroy','update','store']]);
        $this->middleware('role_or_permission:Admin|master-nationality', ['only' => ['nation','nation_edit','nation_update','nation_store']]);
        $this->middleware('role_or_permission:Admin|master-companies', ['only' => ['company','company_store','company_edit','company_update']]);
        $this->middleware('role_or_permission:Admin|master-company-info', ['only' => ['company_info','company_info_store','company_info_edit','company_info_update']]);
        $this->middleware('role_or_permission:Admin|master-designation', ['only' => ['designation','designation_store','designation_edit','designation_update']]);
        $this->middleware('role_or_permission:Admin|master-master-category|current-status', ['only' => ['category_master','category_store','sub_category_store','designation_update']]);
        $this->middleware('role_or_permission:Admin|category_assign_category_assign', ['only' => ['category_master']]);
        $this->middleware('role_or_permission:Admin|Employee Position Manager', ['only' => ['category_assign','category_assign_store']]);
        $this->middleware('role_or_permission:Admin|master-sim-master', ['only' => ['sim_master','sim_master_store']]);
        $this->middleware('role_or_permission:Admin|master-bike-master', ['only' => ['bikes_master','bikes_master_store']]);
        $this->middleware('role_or_permission:Admin|RTAManage', ['only' => ['vehicle_master_create','vehicle_master_store','vehicle_master_edit','vehicle_master_update','vehicle_report']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        //
        $major_departments=MajorDepartment::all();
        return view('admin-panel.masters.major_department',compact('major_departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'major_department' => 'unique:major_departments,major_department,'
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'Major Department is already exist',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->route('major_department')->with($message);
        }
        try {

            $obj = new MajorDepartment();
            $obj->major_department=$request->input('major_department');
            $obj->save();

            $message = [
                'message' => 'Major Department Added Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('major_department')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('major_department')->with($message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $departments_data=MajorDepartment::find($id);

        $major_departments=MajorDepartment::all();
        return view('admin-panel.masters.major_department',compact('major_departments','departments_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $validator = Validator::make($request->all(), [
            'major_department' => 'unique:major_departments,major_department,'. $id
        ]);

//        dd($validator);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'Major Department is already exist',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->route('major_department')->with($message);
        }

        try {

            $obj = MajorDepartment::find($id);
            $obj->major_department=$request->input('major_department');
            $obj->save();

            $message = [
                'message' => 'Major Department Updated Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('major_department')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('major_department')->with($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function nation()
    {

        $nation=Nationality::all();
        return view('admin-panel.masters.nationalities',compact('nation'));
    }


    public function nation_edit($id)
    {

        //
        $nation_data=Nationality::find($id);
        $nation=Nationality::all();
        return view('admin-panel.masters.nationalities',compact('nation','nation_data'));
    }

    public function nation_update(Request $request, $id)
    {
        //


        $validator = Validator::make($request->all(), [
            'nationalities' => 'unique:nationalities,name,'. $id
        ]);

//        dd($validator);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'Nationality is already exist',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }

        try {

            $obj = Nationality::find($id);
            $obj->name=$request->input('name');
            $obj->save();

            $message = [
                'message' => 'Nationality Updated Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    public function nation_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nationalities' => 'unique:nationalities,name,'
        ]);

        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'Nationality is already exist',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {
            $obj = new Nationality();
            $obj->name=$request->input('name');
            $obj->save();

            $message = [
                'message' => 'Nationality Added Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }
    public function company()
    {
        $company=Company::all();
        return view('admin-panel.masters.companies',compact('company'));
    }

    public function company_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companies' => 'unique:companies,name,'
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'Company is already exist',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {
            $obj = new Company();
            $obj->name=$request->input('name');
            $obj->type=$request->input('type');
            $obj->save();

            $message = [
                'message' => 'Company Added Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    public function company_edit($id)
    {
        $company_data=Company::find($id);
        $company=Company::all();
        return view('admin-panel.masters.companies',compact('company','company_data'));
    }

    public function company_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'companies' => 'unique:companies,name,'. $id
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'Company is already exist',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }

        try {

            $obj = Company::find($id);
            $obj->name=$request->input('name');
            $obj->type=$request->input('type');
            $obj->save();

            $message = [
                'message' => 'Company Updated Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }


    public function company_info()
    {
        $company_info=CompanyInformation::all();
        $company=Company::all();
        return view('admin-panel.masters.company_information',compact('company_info','company'));
    }

    public function company_info_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'unique:company_informations,company_id,'
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'Company Infomation is already exist',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {
            $obj = new CompanyInformation();
            $obj->company_id=$request->input('company_id');
            $obj->trade_license_no=$request->input('trade_license_no');
            $obj->establishment_card=$request->input('establishment_card');
            $obj->labour_card=$request->input('labour_card');
            $obj->salik_acc=$request->input('salik_acc');
            $obj->traffic_fle_no=$request->input('traffic_fle_no');
            $obj->etisalat_party_id=$request->input('etisalat_party_id');
            $obj->du_acc=$request->input('du_acc');
            $obj->save();

            $message = [
                'message' => 'Company Infomation Added Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }
    public function company_license_info_store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'company_id' => 'unique:company_informations,company_id,',
            'name' => 'unique:companies|required',
            'trade_license_no' => 'nullable|unique:companies',
            'uuns' => 'nullable|unique:companies',
            'registration_no' => 'nullable|unique:companies',
            'dcci' => 'nullable|unique:companies',
            'tax' => 'nullable|unique:companies',
            'issue_date' => 'nullable|before:expiry_date',
            'expiry_date' => 'nullable'
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {
            $obj = new Company();
            $obj->license_type=$request->input('license_type');
            $obj->license_category=$request->input('license_category');
            $obj->trade_license_no=$request->input('trade_license_no');
            $obj->registration_no=$request->input('registration_no');
            $obj->name=$request->input('name');
            $obj->state_id=$request->input('state_id');
            $obj->tax=$request->input('tax');
            // $obj->license_for=$request->input('license_for');
            // if($request->input('license_for') == 'rental'){
            //     $obj->rent_for=$request->input('rent_for');
            // }
            $obj->type= 1 ;

            $obj->issue_date=$request->input('issue_date');
            $obj->expiry_date=$request->input('expiry_date');
            $obj->uuns=$request->input('uuns');
            $obj->dcci=$request->input('dcci');

           $obj->member_ids=json_encode($request->input('member_ids'));
            $obj->member_no=json_encode($request->input('member_no'));
            $obj->member_share=json_encode($request->input('member_share'));
            $obj->member_role=json_encode($request->input('member_role'));

            $obj->partner_ids=json_encode($request->input('partner_ids'));
            $obj->partner_no=json_encode($request->input('partner_no'));
            $obj->partner_share=json_encode($request->input('partner_share'));

            $obj->license_activity=json_encode($request->input('license_activity'));
            // license_attachment upload
            if($request->hasFile('license_attachment')){
                if (!file_exists('../public/assets/upload/license/license_attachment/')) {
                    mkdir('../public/assets/upload/license/license_attachment/', 0777, true);
                }
                $ext = pathinfo($_FILES['license_attachment']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["license_attachment"]["tmp_name"], '../public/assets/upload/license/license_attachment/' . $file_name);
                $file_path = 'assets/upload/license/license_attachment/' . $file_name;
                $obj->license_attachment ? file_exists($obj->license_attachment) ? unlink($obj->license_attachment) : "" : "";
                $obj->license_attachment = $file_path;
            }
            // tax_attachment upload
            if($request->hasFile('tax_attachment')){
                if (!file_exists('../public/assets/upload/license/tax_attachment/')) {
                    mkdir('../public/assets/upload/license/tax_attachment/', 0777, true);
                }
                $ext = pathinfo($_FILES['tax_attachment']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["tax_attachment"]["tmp_name"], '../public/assets/upload/license/tax_attachment/' . $file_name);
                $file_path = 'assets/upload/license/tax_attachment/' . $file_name;
                $obj->tax_attachment ? file_exists($obj->tax_attachment) ? unlink($obj->tax_attachment) : "" : "";
                $obj->tax_attachment = $file_path;
            }
            // contract_attachment attachment
            if($request->hasFile('contract_attachment')){
                if (!file_exists('../public/assets/upload/license/contract_attachment/')) {
                    mkdir('../public/assets/upload/license/contract_attachment/', 0777, true);
                }
                $ext = pathinfo($_FILES['contract_attachment']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["contract_attachment"]["tmp_name"], '../public/assets/upload/license/contract_attachment/' . $file_name);
                $file_path = 'assets/upload/license/contract_attachment/' . $file_name;
                $obj->contract_attachment ? file_exists($obj->contract_attachment) ? unlink($obj->contract_attachment) : "" : "";
                $obj->contract_attachment = $file_path;
            }
            // contract_upload attachment

        // license_attachment upload
            $obj->save();

                $renewal = new Renewal();
                $renewal->issue_date = $obj->issue_date;
                $renewal->expiry_date = $obj->expiry_date;
                $renewal->master_id = $obj->id;
                $renewal->master_category_id = 1;
                $renewal->remarks = 'License created';
                $renewal->save();

            $company_info_exist = CompanyInformation::where('trade_license_no', $request->input('trade_license_no'))->first();
            if(!$company_info_exist){
                $newCompanyInformation = new CompanyInformation();
                $newCompanyInformation->company_id = $obj->id;
                $obj->trade_license_no = $newCompanyInformation->trade_license_no = $request->input('trade_license_no');
                $newCompanyInformation->save();
            }

            $message = [
                'message' => 'Company Infomation Added Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    public function company_license_edit($id)
    {
        $passport_members = Passport::where('passport_category','1')->get();
        $passport_partners = Passport::where('passport_category','1')->get();
        $license = Company::find($id);
        $states = Cities::all();
        return view('admin-panel.company.master.license_edit' , compact('license','states','passport_members','passport_partners'));
    }
    public function company_license_info_update(Company $company, Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'unique:companies,name,'.$company->id,
            'trade_license_no' => 'nullable|unique:companies,trade_license_no,'.$company->id,
            'uuns' => 'nullable|unique:companies,uuns,'.$company->id,
            'registration_no' => 'nullable|unique:companies,registration_no,'.$company->id,
            'dcci' => 'nullable|unique:companies,dcci,'.$company->id,
            'tax' => 'nullable|unique:companies,tax,'.$company->id,
            'issue_date' => 'nullable|before:expiry_date',
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }

        try {
            $company->license_type=$request->input('license_type');
            $company->license_category=$request->input('license_category');
            $company->trade_license_no=$request->input('trade_license_no');
            $company->registration_no=$request->input('registration_no');
            $company->name=$request->input('name');
            $company->state_id=$request->input('state_id');
            $company->tax=$request->input('tax');
            $company->license_for=$request->input('license_for');
            if($request->input('license_for') == 'rental'){
                $company->rent_for=$request->input('rent_for');
            }
            $company->type= 1 ;
            $company->issue_date=$request->input('issue_date');
            $company->expiry_date=$request->input('expiry_date');
            $company->uuns=$request->input('uuns');
            $company->dcci=$request->input('dcci');

            $company->member_ids=json_encode($request->input('member_ids'));
            $company->member_no=json_encode($request->input('member_no'));
            $company->member_share=json_encode($request->input('member_share'));
            $company->member_role=json_encode($request->input('member_role'));

            $company->partner_ids=json_encode($request->input('partner_ids'));
            $company->partner_no=json_encode($request->input('partner_no'));
            $company->partner_share=json_encode($request->input('partner_share'));
            $company->license_activity=json_encode($request->input('license_activity'));
            // license_attachment upload
            if($request->hasFile('license_attachment')){
                if (!file_exists('../public/assets/upload/license/license_attachment/')) {
                    mkdir('../public/assets/upload/license/license_attachment/', 0777, true);
                }
                $ext = pathinfo($_FILES['license_attachment']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["license_attachment"]["tmp_name"], '../public/assets/upload/license/license_attachment/' . $file_name);
                $file_path = 'assets/upload/license/license_attachment/' . $file_name;
                $company->license_attachment ? file_exists($company->license_attachment) ? unlink($company->license_attachment) : "" : "";
                $company->license_attachment = $file_path;
            }
            // tax_attachment upload
            if($request->hasFile('tax_attachment')){
                if (!file_exists('../public/assets/upload/license/tax_attachment/')) {
                    mkdir('../public/assets/upload/license/tax_attachment/', 0777, true);
                }
                $ext = pathinfo($_FILES['tax_attachment']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["tax_attachment"]["tmp_name"], '../public/assets/upload/license/tax_attachment/' . $file_name);
                $file_path = 'assets/upload/license/tax_attachment/' . $file_name;
                $company->tax_attachment ? file_exists($company->tax_attachment) ? unlink($company->tax_attachment) : "" : "";
                $company->tax_attachment = $file_path;
            }
            // contract_attachment attachment
            if($request->hasFile('contract_attachment')){
                if (!file_exists('../public/assets/upload/license/contract_attachment/')) {
                    mkdir('../public/assets/upload/license/contract_attachment/', 0777, true);
                }
                $ext = pathinfo($_FILES['contract_attachment']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["contract_attachment"]["tmp_name"], '../public/assets/upload/license/contract_attachment/' . $file_name);
                $file_path = 'assets/upload/license/contract_attachment/' . $file_name;
                $company->contract_attachment ? file_exists($company->contract_attachment) ? unlink($company->contract_attachment) : "" : "";
                $company->contract_attachment = $file_path;
            }
            // contract_upload attachment

        // license_attachment upload
            $company->update();

            $company_info_exist = CompanyInformation::where('trade_license_no', $request->input('trade_license_no'))->first();
            if(!$company_info_exist){
                $newCompanyInformation = new CompanyInformation();
                $newCompanyInformation->company_id = $company->id;
                $company->trade_license_no = $newCompanyInformation->trade_license_no = $request->input('trade_license_no');
                $newCompanyInformation->save();
            }

            $message = [
                'message' => 'Company Infomation Added Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    public function e_establishment_card_list()
    {
        $e_establishment_cards =  EEstablishment::all();
        foreach($e_establishment_cards as $card){
            $card->partners = Passport::whereIn('id',json_decode($card->partners) ?? [])->get();
        }
        $labourCards = LabourCard::all();
        foreach($labourCards as $card){
            $card->partners = Passport::whereIn('id',json_decode($card->partners) ?? [])->get();
        }

        return view('admin-panel.company.master.e-establishment-card-list',compact('e_establishment_cards','labourCards'));
    }
    public function e_establishment_card_documents()
    {
        $e_establishment_cards =  EEstablishment::all();
        $labourCards = LabourCard::all();
        return view('admin-panel.company.master.e-establishment-card-documents',compact('e_establishment_cards','labourCards'));
    }
    public function e_establishment_card(Request $request)
    {
        $establishment_companies = Company::doesnthave('stablishment_card')->get();
        $labour_card_companies = Company::doesnthave('labour_card')->get();
        $partners = Passport::where('passport_category','1')->get();
        return view('admin-panel.company.master.e-establishment-card',compact('establishment_companies','labour_card_companies','partners'));
    }
    public function company_establishment_card_store(Request $request)
        {
            // return $request->all();
            $validator = Validator::make($request->all(), [
                'company_id' => 'required',
                'moi_no' => 'nullable|unique:e_establishments',
                'issue_date' => 'before:expiry_date'
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),// 'Error occurred while storing',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return back()->with($message);
            }
            try {
                $obj = new EEstablishment();
                $obj->company_id = $request->input('company_id');
                $obj->issue_date = $request->input('issue_date');
                $obj->expiry_date = $request->input('expiry_date');
                $obj->moi_no = $request->input('moi_no');

                $obj->partners = json_encode($request->input('moi_partners'));
                 // attachment upload
                if($request->hasFile('attachment')){
                    if (!file_exists('../public/assets/upload/e_establishment/attachment/')) {
                        mkdir('../public/assets/upload/e_establishment/attachment/', 0777, true);
                    }
                    $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;
                    move_uploaded_file($_FILES["attachment"]["tmp_name"], '../public/assets/upload/e_establishment/attachment/' . $file_name);
                    $file_path = 'assets/upload/e_establishment/attachment/' . $file_name;
                    $obj->attachment ? file_exists($obj->attachment) ? unlink($obj->attachment) : "" : "";
                    $obj->attachment = $file_path;
                }
                // attachment upload
                $obj->save();

                $renewal = new Renewal();
                $renewal->issue_date = $obj->issue_date;
                $renewal->expiry_date = $obj->expiry_date;
                $renewal->master_id = $obj->id;
                $renewal->master_category_id = 2;
                $renewal->remarks = 'E-Estblishment Card created';
                $renewal->save();

                $company_info_exist = CompanyInformation::where('establishment_card', $request->input('moi_no'))->first();
                if(!$company_info_exist){
                    $newCompanyInformation = new CompanyInformation();
                    $newCompanyInformation->company_id = $obj->id;
                    $newCompanyInformation->establishment_card = $request->input('moi_no');
                    $newCompanyInformation->save();
                }
                $message = [
                    'message' => 'E-Establishment Card Added Successfully',
                    'alert-type' => 'success'
                ];
                return back()->with($message);
            } catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' => $e->getMessage(), // 'Error Occured',
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }
        }
        public function e_establishment_card_edit(EEstablishment $eEstablishment)
            {
                $partners = Passport::wherePassportCategory('1')->get();
                $companies = Company::all();
                return view('admin-panel.company.master.e-establishment-card-edit',compact('eEstablishment','companies','partners'));
            }
        public function company_establishment_card_update(EEstablishment $eEstablishment,  Request $request)
        {
            $validator = Validator::make($request->all(), [
                'company_id' => 'required',
                'moi_no' => 'unique:e_establishments,moi_no,'.$eEstablishment->id,
                'issue_date' => 'before:expiry_date',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => 'Error occurred while storing',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return back()->with($message);
            }
            try {
                $eEstablishment->company_id = $request->input('company_id');
                $eEstablishment->issue_date = $request->input('issue_date');
                $eEstablishment->expiry_date = $request->input('expiry_date');
                $eEstablishment->moi_no = $request->input('moi_no');

                $eEstablishment->partners = json_encode($request->input('partners'));
                 // attachment upload
                if($request->hasFile('attachment')){
                    if (!file_exists('../public/assets/upload/e_establishment/attachment/')) {
                        mkdir('../public/assets/upload/e_establishment/attachment/', 0777, true);
                    }
                    $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;
                    move_uploaded_file($_FILES["attachment"]["tmp_name"], '../public/assets/upload/e_establishment/attachment/' . $file_name);
                    $file_path = 'assets/upload/e_establishment/attachment/' . $file_name;
                    $eEstablishment->attachment ? file_exists($eEstablishment->attachment) ? unlink($eEstablishment->attachment) : "" : "";
                    $eEstablishment->attachment = $file_path;
                }
                // attachment upload
                $eEstablishment->update();
                $company_info_exist = CompanyInformation::where('establishment_card', $request->input('moi_no'))->first();
                if(!$company_info_exist){
                    $newCompanyInformation = new CompanyInformation();
                    $newCompanyInformation->company_id = $eEstablishment->id;
                    $newCompanyInformation->establishment_card = $request->input('moi_no');
                    $newCompanyInformation->save();
                }
                $message = [
                    'message' => 'E-Establishment Card Updated Successfully',
                    'alert-type' => 'success'
                ];
                return back()->with($message);
            } catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' => 'Error Occured',
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }
        }

        public function company_labour_card_store(Request $request)
        {
            // return $request->all();
            $validator = Validator::make($request->all(), [
                'company_id' => 'required',
                'mol_no' => 'unique:master_labour_cards',
                'issue_date' => 'before:expiry_date'
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(), //'Error Occured',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return back()->with($message);
            }
            try {
                $obj = new LabourCard();
                $obj->company_id = $request->input('company_id');
                $obj->issue_date = $request->input('issue_date');
                $obj->expiry_date = $request->input('expiry_date');
                $obj->mol_no = $request->input('mol_no');
                $obj->partners = json_encode($request->input('mol_partners'));
                 // attachment upload
                if($request->hasFile('labour_card_attachment')){
                    if (!file_exists('../public/assets/upload/labour_card/attachment/')) {
                        mkdir('../public/assets/upload/labour_card/attachment/', 0777, true);
                    }
                    $ext = pathinfo($_FILES['labour_card_attachment']['name'], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;

                    move_uploaded_file($_FILES["labour_card_attachment"]["tmp_name"], '../public/assets/upload/labour_card/attachment/' . $file_name);
                    $file_path = 'assets/upload/labour_card/attachment/' . $file_name;
                    $obj->attachment ? file_exists($obj->attachment) ? unlink($obj->attachment) : "" : "";
                    $obj->attachment = $file_path;
                }
                // attachment upload

                $obj->save();
                $renewal = new Renewal();
                $renewal->issue_date = $obj->issue_date;
                $renewal->expiry_date = $obj->expiry_date;
                $renewal->master_id = $obj->id;
                $renewal->master_category_id = 3;
                $renewal->remarks = 'Labour Card created';
                $renewal->save();


                $company_info_exist = CompanyInformation::where('labour_card', $request->input('mol_no'))->first();
                if(!$company_info_exist){
                    $newCompanyInformation = new CompanyInformation();
                    $newCompanyInformation->company_id = $obj->id;
                    $newCompanyInformation->labour_card = $request->input('mol_no');
                    $newCompanyInformation->save();
                }
                $message = [
                    'message' => 'Labour Card Added Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);
            } catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' => 'Error Occured',
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }
        }


        public function company_master_traffic_create()
        {
            $traffic_companies = [];//Company::doesnthave('traffic')->with('state')->get();
            $salik_companies = [];//Company::doesnthave('salik')->with('state')->get();
            $companies = Company::all();
            $states = Cities::all();
            return view('admin-panel.company.master.traffic', compact('traffic_companies','salik_companies','companies','states'));
        }

        public function get_ajax_traffic_for_data(){
            $data = [];
            $traffic_for = request()->traffic_for;
            if($traffic_for == 1){
                $data = Company::all();
            }elseif($traffic_for == 2){
                $data = Passport::where('passport_category','1')->get();
            }elseif($traffic_for == 3){
                $data = CustomerSupplier::all();
            }
            $view = view('admin-panel.company.master.shared_blades.traffic_company_id', compact('data','traffic_for'))->render();
                return response()->json(['html'=>$view]);
            }

        public function get_ajax_salik_for_data(){
            $data = [];
            $salik_for = request()->salik_for;
            if($salik_for == '1'){
                $data = Company::all();
            }elseif($salik_for == 'personal'){
                $data = Passport::where('passport_category','1')->get();
            }elseif($salik_for == 'contacts'){
                $data = CustomerSupplier::all();
            }
            $view = view('admin-panel.company.master.shared_blades.salik_company_id', compact('data','salik_for'))->render();
                return response()->json(['html'=>$view]);
            }
        public function company_master_traffic_edit(Traffic $traffic)
        {
            // $traffic_companies = Company::doesnthave('traffic')->with('state')->get();
            // $salik_companies = Company::doesnthave('salik')->with('state')->get();
            $companies = Company::all();
            $states = Cities::all();
            return view('admin-panel.company.master.traffic-edit', compact('traffic','companies','states'));
        }
       public function company_master_traffic_list()
        {
            $companies = Company::all();
            $traffics  = Traffic::all();
            $saliks = Salik::all();
            return view('admin-panel.company.master.traffic-list', compact('companies','traffics','saliks'));
        }
        public function company_master_traffic_documents()
        {
            $companies = Company::all();
            $traffics  = Traffic::all();
            $saliks = Salik::all();
            return view('admin-panel.company.master.traffic-documents', compact('companies','traffics','saliks'));
        }
        public function company_master_traffic_store(Request $request)
        {

            // dd($request->all());

                if(!request()->isMethod('post')){
                   return redirect()->route('company_master_traffic_create');
                }else{
                //    return $request->all();
                if(collect($request->traffic_file_no)->duplicates()->count() > 0){
                    $message = [
                        'message' => 'Duplicates in Traffic file no',
                        'alert-type' => 'error',
                    ];
                    return back()->with($message);
                }else{
                    foreach($request->traffic_file_no as $traffic_file_no){
                        if(Traffic::whereTrafficFileNo($traffic_file_no)->first()){
                            $message = [
                                'message' => 'File No Already Exists!',
                                'alert-type' => 'error'
                            ];
                            return back()->with($message);
                        }
                    }
                }
                $validator = Validator::make($request->all(), [
                    'traffic_for_model_id' => 'required',
                    'traffic_file_no' => 'unique:traffic'
                ],
                $messages = [
                    'traffic_for_model_id.required' => "Please select one from Zone Group, Personal, Customer Or Supplier"
                ]
            );
                if ($validator->fails()) {
                    $validate = $validator->errors();
                    $message = [
                        'message' => $validate->first(), //'Errors Occurred',
                        'alert-type' => 'error',
                        'error' => $validate->first()
                    ];
                    return back()->with($message);
                }
                try {
                    foreach($request->input('traffic_state') as $k => $v){
                        // dd($request->input('traffic_for_model_id'));
                        $obj = new Traffic();
                        $obj->company_id = $request->input('traffic_for_model_id'); // Company Id may Company Id Or Customer/supplier Id or Passport Id
                        $obj->state_id = $request->input('traffic_state')[$k];
                        $obj->traffic_for = $request->input('traffic_for');
                        $obj->traffic_file_no = $request->input('traffic_file_no')[$k];

                        // attachment upload
                        if(isset($request->traffic_attachment[$k])){
                            if (!file_exists('../public/assets/upload/moa/traffic_attachment/'.$k.'/')) {
                                mkdir('../public/assets/upload/moa/traffic_attachment/'.$k.'/', 0777, true);
                            }
                            $ext = pathinfo($_FILES['traffic_attachment']['name'][$k], PATHINFO_EXTENSION);
                            $file_name = time() . "_" . $request->date . '.' . $ext;

                            move_uploaded_file($_FILES["traffic_attachment"]["tmp_name"][$k], '../public/assets/upload/moa/traffic_attachment/'.$k.'/'. $file_name);
                            $file_path = 'assets/upload/moa/traffic_attachment/'.$k.'/' . $file_name;
                            $obj->traffic_attachment ? file_exists($obj->traffic_attachment) ? unlink($obj->traffic_attachment) : "" : "";
                            $obj->traffic_attachment = $file_path;
                        }

                        // attachment upload

                        $obj->save();
                        $company_info_exist = CompanyInformation::where('traffic_fle_no', $request->input('traffic_file_no')[$k])->first();
                        if(!$company_info_exist){
                        $newCompanyInformation = new CompanyInformation();
                        $newCompanyInformation->company_id = $obj->id;
                        $newCompanyInformation->traffic_fle_no = $request->input('traffic_file_no')[$k];
                        // $newCompanyInformation->save(); // we are not going to use the table any more
                    }
                }
                $message = [
                    'message' => 'Traffic Added Successfully',
                    'alert-type' => 'success'

                ];

                return back()->with($message);
                } catch (\Illuminate\Database\QueryException $e) {
                    $message = [
                        // 'message' => 'Error Occured',
                        'message' => $e->getMessage(),
                        'alert-type' => 'error'
                    ];
                    return back()->with($message);
                }
                return view('admin-panel.company.master.traffic-list');
            }
        }
        public function company_master_traffic_update(Traffic $traffic, Request $request)
        {
                //    return $request->all();
                $validator = Validator::make($request->all(), [
                    'company_id' => 'required',
                    'traffic_file_no' => 'unique:traffic,traffic_file_no,'. $traffic->id
                ]);
                if ($validator->fails()) {
                    $validate = $validator->errors();
                    $message = [
                        'message' => 'Errors Occurred',
                        'alert-type' => 'error',
                        'error' => $validate->first()
                    ];
                    return back()->with($message);
                }
                try {
                    $traffic->company_id = $request->input('company_id');
                    $traffic->state_id = $request->input('traffic_state');
                    $traffic->traffic_file_no = $request->input('traffic_file_no');
                    // attachment upload
                    if(isset($request->traffic_attachment)){
                        if (!file_exists('../public/assets/upload/moa/traffic_attachment/')) {
                            mkdir('../public/assets/upload/moa/traffic_attachment/', 0777, true);
                        }
                        $ext = pathinfo($_FILES['traffic_attachment']['name'], PATHINFO_EXTENSION);
                        $file_name = time() . "_" . $request->date . '.' . $ext;

                        move_uploaded_file($_FILES["traffic_attachment"]["tmp_name"], '../public/assets/upload/moa/traffic_attachment/'. $file_name);
                        $file_path = 'assets/upload/moa/traffic_attachment/' . $file_name;
                        $traffic->traffic_attachment ? file_exists($traffic->traffic_attachment) ? unlink($traffic->traffic_attachment) : "" : "";
                        $traffic->traffic_attachment = $file_path;
                    }
                    // attachment upload

                    $traffic->save();

                    $company_info_exist = CompanyInformation::where('traffic_fle_no', $request->input('traffic_file_no'))->first();
                    if(!$company_info_exist){
                        $newCompanyInformation = new CompanyInformation();
                        $newCompanyInformation->company_id = $traffic->id;
                        $newCompanyInformation->traffic_fle_no = $request->input('traffic_file_no');
                        $newCompanyInformation->save();
                        $message = [
                            'message' => 'Traffic Added Successfully',
                            'alert-type' => 'success'

                        ];
                    }
                }catch (\Illuminate\Database\QueryException $e) {
                    $message = [
                        'message' => 'Error Occured',
                        'message' => $e->getMessage(),
                        'alert-type' => 'error'
                    ];
                    return back()->with($message);
                }
                return redirect()->route('company_master_traffic_list');
            }
        public function company_master_salik_edit(Salik $salik )
        {
            $companies = Company::all();
            return view('admin-panel.company.master.salik-edit', compact('salik','companies'));
        }

        public function company_master_salik_update(Salik $salik , Request $request)
        {
             $validator = Validator::make($request->all(), [
                 'company_id' => 'required',
                 'salik_acc' => 'unique:saliks,salik_acc,'. $salik->id
             ]);
             if ($validator->fails()) {
                 $validate = $validator->errors();
                 $message = [
                     'message' => 'Errors Occurred',
                     'alert-type' => 'error',
                     'error' => $validate->first()
                 ];
                 return back()->with($message);
             }
             try {
                $salik->company_id = $request->input('company_id');
                $salik->state_id = $request->input('salik_state');
                $salik->salik_acc = $request->input('salik_acc');
                // attachment upload
                if(isset($request->salik_attachment)){
                    if (!file_exists('../public/assets/upload/moa/salik_attachment/')) {
                        mkdir('../public/assets/upload/moa/salik_attachment/', 0777, true);
                    }
                    $ext = pathinfo($_FILES['salik_attachment']['name'], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;

                    move_uploaded_file($_FILES["salik_attachment"]["tmp_name"], '../public/assets/upload/moa/salik_attachment/' . $file_name);
                    $file_path = 'assets/upload/moa/salik_attachment/' . $file_name;
                    $salik->salik_attachment ? file_exists($salik->salik_attachment) ? unlink($salik->salik_attachment) : "" : "";
                    $salik->salik_attachment = $file_path;
                }
                // attachment upload
                $salik->update();
                $company_info_exist = CompanyInformation::where('salik_acc', $request->input('salik_acc'))->first();
                if(!$company_info_exist){
                    $newCompanyInformation = new CompanyInformation();
                    $newCompanyInformation->company_id = $salik->company_id;
                    $newCompanyInformation->salik_acc = $request->input('salik_acc');
                    $newCompanyInformation->save();
                }
                $message = [
                    'message' => 'Salik updated Successfully',
                    'alert-type' => 'success'

                ];
                return redirect()->route('company_master_traffic_list')->with($message);
             } catch (\Illuminate\Database\QueryException $e) {
                 $message = [
                     'message' => 'Error Occured',
                     'message' => $e->getMessage(),
                     'alert-type' => 'error'
                 ];
                 return back()->with($message);
             }
             return redirect()->route('company_master_traffic_list');
        }
        public function company_master_salik_store(Request $request)
        {
            if(!request()->isMethod('post')){
                return redirect()->route('company_master_traffic_create');
             }else{
             //    return $request->all();
             if(collect($request->salik_acc)->duplicates()->count() > 0){
                $message = [
                    'message' => 'Duplicates in Salik account no',
                    'alert-type' => 'error',
                ];
                return back()->with($message);
            }else{
                foreach($request->salik_acc as $salik_acc){
                    if(Salik::whereSalikAcc($salik_acc)->first()){
                        $message = [
                            'message' => 'Salik Account No Already Exists!',
                            'alert-type' => 'error'
                        ];
                        return back()->with($message);
                    }
                }
            }
             $validator = Validator::make($request->all(), [
                 'company_id' => 'required',
                 'salik_acc' => 'unique:saliks'
             ]);
             if ($validator->fails()) {

                 $validate = $validator->errors();
                 $message = [
                     'message' => 'Errors Occurred',
                     'alert-type' => 'error',
                     'error' => $validate->first()
                 ];
                 return back()->with($message);
             }
             try {
                foreach($request->input('salik_state') as $k => $v){
                $obj = new Salik();
                $obj->company_id = $request->input('company_id');
                $obj->state_id = $request->input('salik_state')[$k];
                $obj->salik_acc = $request->input('salik_acc')[$k];
                // attachment upload
                if(isset($request->salik_attachment[$k])){
                    if (!file_exists('../public/assets/upload/moa/salik_attachment/'.$k.'/')) {
                        mkdir('../public/assets/upload/moa/salik_attachment/'.$k.'/', 0777, true);
                    }
                    $ext = pathinfo($_FILES['salik_attachment']['name'][$k], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;

                    move_uploaded_file($_FILES["salik_attachment"]["tmp_name"][$k], '../public/assets/upload/moa/salik_attachment/'.$k.'/'. $file_name);
                    $file_path = 'assets/upload/moa/salik_attachment/'.$k.'/' . $file_name;
                    $obj->salik_attachment ? file_exists($obj->salik_attachment) ? unlink($obj->salik_attachment) : "" : "";
                    $obj->salik_attachment = $file_path;
                }
                // attachment upload


                $obj->save();

                $company_info_exist = CompanyInformation::where('salik_acc', $request->input('salik_acc')[$k])->first();
                if(!$company_info_exist){
                    $newCompanyInformation = new CompanyInformation();
                    $newCompanyInformation->company_id = $obj->id;
                    $newCompanyInformation->salik_acc = $request->input('salik_acc')[$k];
                    $newCompanyInformation->save();
                }
            }
             $message = [
                 'message' => 'Salik Added Successfully',
                 'alert-type' => 'success'

             ];
             return back()->with($message);
             } catch (\Illuminate\Database\QueryException $e) {
                 $message = [
                     'message' => 'Error Occured',
                     'message' => $e->getMessage(),
                     'alert-type' => 'error'
                 ];
                 return back()->with($message);
             }
             return view('admin-panel.company.master.traffic-list');
         }
        }
        public function company_master_utilities()
        {
            // $companies = Company::all();
            $electricity_companies = Company::doesnthave('electricity_water')->get();
            $etisalat_companies = Company::doesnthave('etisalat')->get();
            $du_companies = Company::doesnthave('du')->get();
            return view('admin-panel.company.master.utilities', compact('electricity_companies','etisalat_companies','du_companies'));
        }
        public function company_master_utilities_list()
        {
            $electricity = MasterUtilityElectricityWater::all();
            $etisalats = Etisalat::all();
            $dus = Du::all();
            return view('admin-panel.company.master.utilities-list', compact('electricity','etisalats','dus'));
        }
        public function company_master_utilities_documents()
        {
            $electricity = MasterUtilityElectricityWater::all();
            $etisalats = Etisalat::all();
            $dus = Du::all();
            return view('admin-panel.company.master.utilities-documents', compact('electricity','etisalats','dus'));
        }


        public function company_master_ejari_documents()
        {
            $ejaris = Ejari::all();
            return view('admin-panel.company.master.ejari-documents', compact('ejaris'));
        }
        public function company_license_create()
        {
            $states = Cities::all();
            $passport_members = Passport::where('passport_category','1')->get();
            $passport_partners = Passport::where('passport_category','1')->get();
            return view('admin-panel.company.master.license_create', compact('states','passport_members','passport_partners'));
        }
        public function company_license_list()
        {
            $licenses = Company::with('state')->get();
            return view('admin-panel.company.master.license-list' , compact('licenses'));
        }

        public function company_license_documents()
        {
            $licenses = Company::all();
            return view('admin-panel.company.master.license-documents' , compact('licenses'));
        }
        public function company_master_utilities_water_electiricity_store(Request $request)
        {
            //    return $request->all();
            $validator = Validator::make($request->all(), [
                'company_id' => 'required',
                'account_no' => 'unique:master_utility_electricity_waters'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'Errors Occurred',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return back()->with($message);
            }
            try {

                $obj = new MasterUtilityElectricityWater();
                $obj->company_id = $request->input('company_id');
                $obj->account_no = $request->input('account_no');
                $obj->account_type = $request->input('account_type');
                $obj->business_partner = $request->input('business_partner');
                $obj->bill_name = $request->input('bill_name');
                $obj->permise_number = $request->input('permise_number');
                 // attachment upload
                if($request->hasFile('attachment')){
                    if (!file_exists('../public/assets/upload/ElectricityWater/attachment/')) {
                        mkdir('../public/assets/upload/ElectricityWater/attachment/', 0777, true);
                    }
                    $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;

                    move_uploaded_file($_FILES["attachment"]["tmp_name"], '../public/assets/upload/ElectricityWater/attachment/' . $file_name);
                    $file_path = 'assets/upload/ElectricityWater/attachment/' . $file_name;
                    $obj->attachment ? file_exists($obj->attachment) ? unlink($obj->attachment) : "" : "";
                    $obj->attachment = $file_path;
                }
                // attachment upload

                $obj->save();
                $message = [
                    'message' => 'Electicity/Water Added Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);
            } catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' => 'Error Occured',
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }
        }
        function company_master_utilities_water_electiricity_edit(MasterUtilityElectricityWater $electricity){
            $electricity_companies = Company::all();
            return view('admin-panel.company.master.utilities-electricy-edit' , compact('electricity','electricity_companies'));
        }
        public function company_master_utilities_water_electiricity_update(MasterUtilityElectricityWater $electricity,  Request $request)
        {
            //    return $request->all();
            // return $electricity;
            $validator = Validator::make($request->all(), [
                'company_id' => 'required',
                'account_no' => 'unique:master_utility_electricity_waters,account_no,'.$electricity->id
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),//'Errors Occurred',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return back()->with($message);
            }
            try {
                $electricity->company_id = $request->input('company_id');
                $electricity->account_no = $request->input('account_no');
                $electricity->account_type = $request->input('account_type');
                $electricity->business_partner = $request->input('business_partner');
                $electricity->bill_name = $request->input('bill_name');
                $electricity->permise_number = $request->input('permise_number');
                 // attachment upload
                if($request->hasFile('attachment')){
                    if (!file_exists('../public/assets/upload/ElectricityWater/attachment/')) {
                        mkdir('../public/assets/upload/ElectricityWater/attachment/', 0777, true);
                    }
                    $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;

                    move_uploaded_file($_FILES["attachment"]["tmp_name"], '../public/assets/upload/ElectricityWater/attachment/' . $file_name);
                    $file_path = 'assets/upload/ElectricityWater/attachment/' . $file_name;
                    $electricity->attachment ? file_exists($electricity->attachment) ? unlink($electricity->attachment) : "" : "";
                    $electricity->attachment = $file_path;
                }
                // attachment upload

                $electricity->save();
                $message = [
                    'message' => 'Electicity/Water updated Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);
            } catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' => 'Error Occured',
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }
        }

        public function company_master_utilities_etisalat_edit(Etisalat $etisalat)
        {
            $etisalat_companies =  Company::all();
            return view('admin-panel.company.master.utilities-etisalat-edit' , compact('etisalat','etisalat_companies'));
        }
        public function company_master_utilities_etisalat_store(Request $request)
        {
            //    return $request->all();
            $validator = Validator::make($request->all(), [
                'company_id' => 'required',
                'account_no' => 'unique:etisalats'
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => 'Errors Occurred',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return back()->with($message);
            }

            try {

                $obj = new Etisalat();
                $obj->company_id = $request->input('company_id');
                $obj->etisalat_party_id = $request->input('etisalat_party_id');
                $obj->account_no = $request->input('account_no');

                 // attachment upload
                if($request->hasFile('attachment')){
                    if (!file_exists('../public/assets/upload/Etisalat/attachment/')) {
                        mkdir('../public/assets/upload/Etisalat/attachment/', 0777, true);
                    }
                    $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;

                    move_uploaded_file($_FILES["attachment"]["tmp_name"], '../public/assets/upload/Etisalat/attachment/' . $file_name);
                    $file_path = 'assets/upload/Etisalat/attachment/' . $file_name;
                    $obj->attachment ? file_exists($obj->attachment) ? unlink($obj->attachment) : "" : "";
                    $obj->attachment = $file_path;
                }
                // attachment upload
                 $obj->save();
                    $company_info_exist = CompanyInformation::where('etisalat_party_id', $request->input('etisalat_party_id'))->first();
                if(!$company_info_exist){
                    $newCompanyInformation = new CompanyInformation();
                    $newCompanyInformation->company_id = $obj->id;
                    $newCompanyInformation->etisalat_party_id = $request->input('etisalat_party_id');
                    $newCompanyInformation->save();
                }
                $message = [
                    'message' => 'Etisalat Added Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);
            } catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' => 'Error Occured',
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }
        }

        public function company_master_utilities_etisalat_update(Request $request, Etisalat $etisalat)
        {
            //    return $request->all();
            $validator = Validator::make($request->all(), [
                'company_id' => 'required',
                'account_no' => 'unique:etisalats,account_no,'. $etisalat->id
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => 'Errors Occurred',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return back()->with($message);
            }

            try {
                $etisalat->company_id = $request->input('company_id');
                $etisalat->etisalat_party_id = $request->input('etisalat_party_id');
                $etisalat->account_no = $request->input('account_no');

                 // attachment upload
                if($request->hasFile('attachment')){
                    if (!file_exists('../public/assets/upload/Etisalat/attachment/')) {
                        mkdir('../public/assets/upload/Etisalat/attachment/', 0777, true);
                    }
                    $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;

                    move_uploaded_file($_FILES["attachment"]["tmp_name"], '../public/assets/upload/Etisalat/attachment/' . $file_name);
                    $file_path = 'assets/upload/Etisalat/attachment/' . $file_name;
                    $etisalat->attachment ? file_exists($etisalat->attachment) ? unlink($etisalat->attachment) : "" : "";
                    $etisalat->attachment = $file_path;
                }
                // attachment upload
                 $etisalat->save();
                    $company_info_exist = CompanyInformation::where('etisalat_party_id', $request->input('etisalat_party_id'))->first();
                if(!$company_info_exist){
                    $newCompanyInformation = new CompanyInformation();
                    $newCompanyInformation->company_id = $etisalat->id;
                    $newCompanyInformation->etisalat_party_id = $request->input('etisalat_party_id');
                    $newCompanyInformation->save();
                }
                $message = [
                    'message' => 'Etisalat Updated Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);
            } catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' => 'Error Occured',
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }
        }


        public function company_master_utilities_dus_edit(Du $du)
        {
            $du_companies =  Company::all();
            return view('admin-panel.company.master.utilities-du-edit' , compact('du','du_companies'));
        }
        public function company_master_utilities_dus_store(Request $request)
        {
            //    return $request->all();
            $validator = Validator::make($request->all(), [
                'company_id' => 'required',
                'du_acc' => 'unique:dus'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'Errors Occurred',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return back()->with($message);
            }
            try {

                $obj = new Du();
                $obj->company_id = $request->input('company_id');
                $obj->du_acc = $request->input('du_acc');

                 // attachment upload
                if($request->hasFile('attachment')){
                    if (!file_exists('../public/assets/upload/Du/attachment/')) {
                        mkdir('../public/assets/upload/Du/attachment/', 0777, true);
                    }
                    $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;

                    move_uploaded_file($_FILES["attachment"]["tmp_name"], '../public/assets/upload/Du/attachment/' . $file_name);
                    $file_path = 'assets/upload/Du/attachment/' . $file_name;
                    $obj->attachment ? file_exists($obj->attachment) ? unlink($obj->attachment) : "" : "";
                    $obj->attachment = $file_path;
                }
                // attachment upload
                 $obj->save();
                    $company_info_exist = CompanyInformation::where('du_acc', $request->input('du_acc'))->first();
                if(!$company_info_exist){
                    $newCompanyInformation = new CompanyInformation();
                    $newCompanyInformation->company_id = $obj->id;
                    $newCompanyInformation->du_acc = $request->input('du_acc');
                    $newCompanyInformation->save();
                }
                $message = [
                    'message' => 'Du Added Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);
            } catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' => 'Error Occured',
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }
        }
        public function company_master_utilities_dus_update(Du $du, Request $request)
        {
            //    return $request->all();
            $validator = Validator::make($request->all(), [
                'company_id' => 'required',
                'du_acc' => 'unique:dus,du_acc,'.$du->id
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'Errors Occurred',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return back()->with($message);
            }
            try {

                $du->company_id = $request->input('company_id');
                $du->du_acc = $request->input('du_acc');

                 // attachment upload
                if($request->hasFile('attachment')){
                    if (!file_exists('../public/assets/upload/Du/attachment/')) {
                        mkdir('../public/assets/upload/Du/attachment/', 0777, true);
                    }
                    $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;

                    move_uploaded_file($_FILES["attachment"]["tmp_name"], '../public/assets/upload/Du/attachment/' . $file_name);
                    $file_path = 'assets/upload/Du/attachment/' . $file_name;
                    $du->attachment ? file_exists($du->attachment) ? unlink($du->attachment) : "" : "";
                    $du->attachment = $file_path;
                }
                // attachment upload
                 $du->save();
                    $company_info_exist = CompanyInformation::where('du_acc', $request->input('du_acc'))->first();
                if(!$company_info_exist){
                    $newCompanyInformation = new CompanyInformation();
                    $newCompanyInformation->company_id = $du->id;
                    $newCompanyInformation->du_acc = $request->input('du_acc');
                    $newCompanyInformation->save();
                }
                $message = [
                    'message' => 'Du Added Successfully',
                    'alert-type' => 'success'
                ];
                return back()->with($message);
            } catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' =>  $validate->first(),
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }
        }
        public function company_master_ejari_list()
        {
            $ejaris = Ejari::all();
            foreach($ejaris as $ejari){$ejari->state_name = Cities::find($ejari->state)->name ?? "";}
            return view('admin-panel.company.master.ejari-list', compact('ejaris'));
        }

        public function pdc_payments(){
            $ejari = Ejari::find(request('ejari_id'));
            $view = view("admin-panel.company.master.shared_blades.pdc_payments",compact('ejari'))->render();
            return response()->json(['html'=>$view]);
        }

        public function company_master_ejari_create()
        {
            $states = Cities::all();
            $companies = Company::all();
            return view('admin-panel.company.master.ejari', compact('companies','states'));
        }
        public function company_master_ejari_edit(Ejari $ejari)
        {
            $companies = Company::all();
            $states = Cities::all();
            return view('admin-panel.company.master.ejari_edit', compact('companies','ejari','states'));
        }
        public function company_master_ejari_store(Request $request)
        {
            //    return $request->all();
            $validator = Validator::make($request->all(), [
                'company_id' => 'required',
                'issue_date' => 'before:expiry_date'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'Please Select A company form list',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return back()->with($message);
            }

            try {

            $obj = new Ejari();
            $obj->company_id = $request->company_id;
            $obj->ejari_type= $request->ejari_type;
            $obj->state= $request->state;
            $obj->contract_no= $request->contract_no;
            $obj->registration_date= $request->registration_date;
            $obj->issue_date= $request->issue_date;
            $obj->expiry_date= $request->expiry_date;
            $obj->contract_amount= $request->contract_amount;
            $obj->security_deposit= $request->security_deposit;
            $obj->land_area= $request->land_area;
            $obj->plot_no= $request->plot_no;
            $obj->land_dm_no= $request->land_dm_no;
            $obj->makani_no= $request->makani_no;
            $obj->size= $request->size;
            $obj->pdc_check_no = json_encode($request->pdc_check_no);
            $obj->pdc_company_account_no= json_encode($request->pdc_company_account_no);
            $obj->pdc_company_account_name= json_encode($request->pdc_company_account_name);
            $obj->pdc_date = json_encode($request->pdc_date);
            $obj->pdc_amount = json_encode($request->pdc_amount);
            $obj->shared_company_ids = json_encode($request->shared_company_ids);


            // pdc_attachment upload
            $pdc_attachments = [];
            if($request->hasFile('pdc_attachment')){
                foreach($request->pdc_attachment as $key => $pdc_attachment){
                    if (!file_exists('../public/assets/upload/Ejari/pdc_attachment/'.$key.'/')) {
                        mkdir('../public/assets/upload/Ejari/pdc_attachment/'.$key.'/', 0777, true);
                    }
                        $ext = pathinfo($_FILES['pdc_attachment']['name'][$key], PATHINFO_EXTENSION);
                        $file_name = time() . "_" . $request->date . '.' . $ext;
                        move_uploaded_file($_FILES["pdc_attachment"]["tmp_name"][$key], '../public/assets/upload/Ejari/pdc_attachment/'. $key .'/' . $file_name);
                        $file_path = 'assets/upload/Ejari/pdc_attachment/' . $key .'/'. $file_name;
                        $obj->pdc_attachment ? file_exists($obj->pdc_attachment) ? unlink($obj->pdc_attachment) : "" : "";
                        $pdc_attachments[] = $file_path;
                        // $obj->pdc_attachment = $file_path;
                    }
            }
            // pdc_attachment upload
            $obj->pdc_attachment = json_encode($pdc_attachments);
            $obj->save();

            $renewal = new Renewal();
            $renewal->issue_date = $obj->issue_date;
            $renewal->expiry_date = $obj->expiry_date;
            $renewal->master_id = $obj->id;
            $renewal->master_category_id = 4;
            $renewal->remarks = 'Ejari created';
            $renewal->save();


            $message = [
                'message' => 'Ejari Added Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                // 'message' => 'Error Occured',
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }
    public function company_master_ejari_update(Ejari $ejari,Request $request)
    {
        //    return $request->all();
        // return $ejari;
        $validator = Validator::make($request->all(), [
            'company_id' => 'required'
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'Please Select A company form list',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }

        try {
        $ejari->company_id = $request->company_id;
        $ejari->ejari_type= $request->ejari_type;
        $ejari->state= $request->state;
        $ejari->contract_no= $request->contract_no;
        $ejari->registration_date= $request->registration_date;
        $ejari->issue_date= $request->issue_date;
        $ejari->expiry_date= $request->expiry_date;
        $ejari->contract_amount= $request->contract_amount;
        $ejari->security_deposit= $request->security_deposit;
        $ejari->land_area= $request->land_area;
        $ejari->plot_no= $request->plot_no;
        $ejari->land_dm_no= $request->land_dm_no;
        $ejari->makani_no= $request->makani_no;
        $ejari->size= $request->size;
        $ejari->pdc_check_no = json_encode($request->pdc_check_no);
        $ejari->pdc_company_account_no= json_encode($request->pdc_company_account_no);
        $ejari->pdc_company_account_name= json_encode($request->pdc_company_account_name);
        $ejari->pdc_date = json_encode($request->pdc_date);
        $ejari->pdc_amount = json_encode($request->pdc_amount);
        $ejari->shared_company_ids = json_encode($request->shared_company_ids);
        // pdc_attachment upload
        $pdc_attachments = [];
        if($request->hasFile('pdc_attachment')){
            foreach($request->pdc_attachment as $key => $pdc_attachment){
                if (!file_exists('../public/assets/upload/Ejari/pdc_attachment/'.$key.'/')) {
                    mkdir('../public/assets/upload/Ejari/pdc_attachment/'.$key.'/', 0777, true);
                }
                    $ext = pathinfo($_FILES['pdc_attachment']['name'][$key], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;
                    move_uploaded_file($_FILES["pdc_attachment"]["tmp_name"][$key], '../public/assets/upload/Ejari/pdc_attachment/'. $key .'/' . $file_name);
                    $file_path = 'assets/upload/Ejari/pdc_attachment/' . $key .'/'. $file_name;
                    $ejari->pdc_attachment ? file_exists($ejari->pdc_attachment) ? unlink($ejari->pdc_attachment) : "" : "";
                    $pdc_attachments[] = $file_path;
                    // $ejari->pdc_attachment = $file_path;
                }
        }
        // pdc_attachment upload
        $ejari->pdc_attachment = json_encode($pdc_attachments);
        $ejari->update();
        $message = [
            'message' => 'Ejari updated Successfully',
            'alert-type' => 'success'
        ];
        return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                // 'message' => 'Error Occured',
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    public function company_master_moa_create()
    {
        $moa_companies = Company::doesnthave('moa')->get();
        return view('admin-panel.company.master.moa_create', compact('moa_companies'));
    }
    public function company_master_moa_list()
    {
        $moas = Moa::all();
        return view('admin-panel.company.master.moa-list', compact('moas'));
    }

    public function company_master_moa_store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'company_id' => 'required',
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'Please Select A company form list',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return back()->with($message);
            }
            try {
                foreach($request->input('moa_date') as $k => $v){
                $obj = new Moa();
                $obj->company_id = $request->company_id;
                $obj->moa_date = $request->moa_date[$k];
                $obj->moa_no = $request->moa_no[$k];
                // attachment upload
                if(isset($request->moa_attachment[$k])){
                    if (!file_exists('../public/assets/upload/moa/moa_attachment/'.$k.'/')) {
                        mkdir('../public/assets/upload/moa/moa_attachment/'.$k.'/', 0777, true);
                    }
                    $ext = pathinfo($_FILES['moa_attachment']['name'][$k], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;

                    move_uploaded_file($_FILES["moa_attachment"]["tmp_name"][$k], '../public/assets/upload/moa/moa_attachment/'.$k.'/'. $file_name);
                    $file_path = 'assets/upload/moa/moa_attachment/'.$k.'/' . $file_name;
                    $obj->moa_attachment ? file_exists($obj->moa_attachment) ? unlink($obj->moa_attachment) : "" : "";
                    $obj->moa_attachment = $file_path;
                }
                // attachment upload
                $obj->save();
            }
            $message = [
                'message' => 'MOA Added Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }
    public function company_master_moa_edit(Moa $moa)
    {
        $companies = Company::all();
        return view('admin-panel.company.master.moa_edit', compact('companies','moa'));
    }
    public function company_master_moa_update(Request $request, Moa $moa)
        {
        // return $request->all();
            $validator = Validator::make($request->all(), [
                'company_id' => 'required'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'Please Select A company form list',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return back()->with($message);
            }
            try {

                $moa->company_id = $request->company_id;
                $moa->moa_date = $request->moa_date;
                $moa->moa_no = $request->moa_no;
                // attachment upload
                if(isset($request->moa_attachment)){
                    if (!file_exists('../public/assets/upload/moa/moa_attachment/')) {
                        mkdir('../public/assets/upload/moa/moa_attachment/', 0777, true);
                    }
                    $ext = pathinfo($_FILES['moa_attachment']['name'], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;

                    move_uploaded_file($_FILES["moa_attachment"]["tmp_name"][$k], '../public/assets/upload/moa/moa_attachment/'. $file_name);
                    $file_path = 'assets/upload/moa/moa_attachment/' . $file_name;
                    $moa->moa_attachment ? file_exists($moa->moa_attachment) ? unlink($moa->moa_attachment) : "" : "";
                    $moa->moa_attachment = $file_path;
                }
                // attachment upload
                $moa->update();

                $message = [
                    'message' => 'MOA Updated Successfully',
                    'alert-type' => 'success'
                ];
                return back()->with($message);

            } catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' => 'Error Occured',
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }
        }
    public function company_labour_card__edit(LabourCard $labourCard)
    {
        // return $labourCard;
        $labour_card_companies = Company::all();
        $partners = Passport::where('passport_category','1')->get();
        return view('admin-panel.company.master.labour-card-edit',compact('labourCard','labour_card_companies','partners'));
    }
    public function company_labour_card_update(LabourCard $labourCard, Request $request){
        //  return $request->all();
         $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'issue_date' => 'before:expiry_date',
            'mol_no' => 'nullable|unique:master_labour_cards,mol_no,'. $labourCard->id
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first() , //'Please Select A company form list',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {
            $labourCard->company_id = $request->company_id;
            $labourCard->mol_no = $request->mol_no;
            $labourCard->issue_date = $request->issue_date;
            $labourCard->expiry_date = $request->expiry_date;
            $labourCard->partners = json_encode($request->partners);
            // attachment upload
            if(isset($request->attachment)){
                if (!file_exists('../public/assets/upload/labourCard/attachment/')) {
                    mkdir('../public/assets/upload/labourCard/attachment/', 0777, true);
                }
                $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["attachment"]["tmp_name"][$k], '../public/assets/upload/labourCard/attachment/'. $file_name);
                $file_path = 'assets/upload/labourCard/attachment/' . $file_name;
                // $labourCard->attachment ? file_exists($labourCard->attachment) ? unlink($labourCard->attachment) : "" : "";
                $labourCard->attachment = $file_path;
            }
            // attachment upload
            $labourCard->update();

            $message = [
                'message' => 'Labour card Updated Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);

        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }
    public function company_master_moa_documents()
    {
        $moas = Moa::all();
        return view('admin-panel.company.master.moa-documents', compact('moas'));
    }
    public function company_info_edit($id)
    {

        $company_info_data=CompanyInformation::find($id);
        $company=Company::all();
        $company_info=CompanyInformation::all();

        return view('admin-panel.masters.company_information',compact('company','company_info_data','company_info'));
    }


    public function company_info_update(Request $request, $id)
    {
        //


        $validator = Validator::make($request->all(), [
            'companies' => 'unique:company_id,name,'. $id
        ]);

//        dd($validator);
        // if ($validator->fails()) {

        //     $validate = $validator->errors();
        //     $message = [
        //         'message' => 'Company Information is already exist',
        //         'alert-type' => 'error',
        //         'error' => $validate->first()
        //     ];
        //     return back()->with($message);
        // }

        // try {

            $obj = CompanyInformation::find($id);
            $obj->company_id=$request->input('company_id');
            $obj->trade_license_no=$request->input('trade_license_no');
            $obj->establishment_card=$request->input('establishment_card');
            $obj->labour_card=$request->input('labour_card');
            $obj->salik_acc=$request->input('salik_acc');
            $obj->traffic_fle_no=$request->input('traffic_fle_no');
            $obj->etisalat_party_id=$request->input('etisalat_party_id');
            $obj->du_acc=$request->input('du_acc');
            $obj->save();

            $message = [
                'message' => 'Company Information Updated Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        // } catch (\Illuminate\Database\QueryException $e) {
        //     $message = [
        //         'message' => 'Error Occured',
        //         'alert-type' => 'error'
        //     ];
        //     return back()->with($message);
        // }
    }

    public function designation()
    {
        $designation=Designation::all();
        return view('admin-panel.masters.designation',compact('designation'));
    }
    public function designation_status_update(Request $request){
            $designation = Designation::findOrFail($request->designation_id);
            $designation->status =  $designation->status == 1 ? 0 : 1 ;
            $designation->update();
            return response(['Success' ,200]);
    }
    public function designation_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'unique:designations,name,'
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'Designation is already exist',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {
            $obj = new Designation();
            $obj->name=$request->input('name');
            $obj->save();
            $message = [
                'message' => 'Designation Added Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    public function designation_edit($id)
    {
        $designation_data=Designation::find($id);
        $designation=Designation::all();
        return view('admin-panel.masters.designation',compact('designation_data','designation'));
    }

    public function designation_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'designations' => 'unique:designations,name,'. $id
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => 'Designation is already exist',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {

            $obj = Designation::find($id);
            $obj->name=$request->input('name');
            $obj->save();

            $message = [
                'message' => 'Designation Updated Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }


    //categort master

    public function category_master()
    {

        //
        $main_category=Category::all();
        $sub_category=SubCategory::whereNull('sub_category')->get();
//        $company=Company::all();
//        $company_info=CompanyInformation::all();

        return view('admin-panel.masters.category',compact('main_category','sub_category'));
    }
    public function category_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'main_category' => 'unique:categories,name',

        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";

            foreach ($validate->all() as $error){
                $message_error .= $error;
            }

            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }
        $obj = new Category();
        $obj->name=$request->input('main_category');
        $obj->save();


        $message = [
            'message' => 'Main Added Successfully',
            'alert-type' => 'success'

        ];
        return back()->with($message);


    }

    public function sub_category_store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'sub_category' => 'unique:sub_categories,name',

        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";

            foreach ($validate->all() as $error){
                $message_error .= $error;
            }

            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }

        if(isset($request->category_id)){
            $main_id = $request->category_id;

            $obj = new SubCategory();
            $obj->name=$request->input('sub_category');
            $obj->main_category=$main_id;
            $obj->save();
        }elseif(isset($request->sub_category_id)){

            $obj = new SubCategory();
            $obj->name=$request->input('sub_category');
            $obj->sub_category=$request->sub_category_id;
            $obj->save();
        }




        $message = [
            'message' => ' Sub Category Added Successfully',
            'alert-type' => 'success'

        ];
        return back()->with($message);


    }


    public function attachment_type()
    {

        //
        $attachment=AttachmentTypes::all();

//        $company=Company::all();
//        $company_info=CompanyInformation::all();

        return view('admin-panel.masters.attachment_types',compact('attachment'));
    }

    public function attachment_store(Request $request)
    {

        //
        $validator = Validator::make($request->all(), [
            'attachment_type' => 'unique:attachment_types,name',

        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";

            foreach ($validate->all() as $error){
                $message_error .= $error;
            }

            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }
        $obj = new AttachmentTypes();
        $obj->name=$request->input('attachment_type');
        $obj->save();


        $message = [
            'message' => 'Attachment Types Added Successfully!',
            'alert-type' => 'success'

        ];
        return back()->with($message);
    }



    public function attachment_edit($id)
    {


        $attachment=AttachmentTypes::all();
        $edit_attach=AttachmentTypes::find($id);


        return view('admin-panel.masters.attachment_types',compact('attachment','edit_attach'));
    }


    public function attachment_update(Request $request, $id)
    {
        //


        $validator = Validator::make($request->all(), [
            'attachment_type' => 'unique:attachment_types,name,'. $id
        ]);

//        dd($validator);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'Attachment Type already exists',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }

        try {

            $obj = AttachmentTypes::find($id);
            $obj->name=$request->input('attachment_type');
            $obj->save();

            $message = [
                'message' => 'Attachment Updated Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    //assign categories

    public function autocomplete_passport(Request $request){
        // $assigned_platform_passport_ids = AssignPlateform::whereStatus(1)->pluck('passport_id');
        $rider_passport_ids;
        $rider_supervisor_passport_ids;
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            // ->whereNotIn('passports.id',$assigned_platform_passport_ids) // get passport only those which have platform
            ->get();

        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                // ->whereNotIn('passports.id',$assigned_platform_passport_ids) // get passport only those which have platform
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    // ->whereNotIn('passports.id',$assigned_platform_passport_ids) // get passport only those which have platform
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        // ->whereNotIn('passports.id',$assigned_platform_passport_ids) // get passport only those which have platform
                        ->get();

                        if (count($zds_data)=='0')
                        {
                            $labour_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code', 'electronic_pre_approval.labour_card_no')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->leftJoin('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->where("electronic_pre_approval.labour_card_no","LIKE","%{$request->input('query')}%")
                            // ->whereNotIn('passports.id',$assigned_platform_passport_ids) // get passport only those which have platform
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
    public function get_full_passport_detail_for_category_assign(Request $request){
        $passport = Passport::with('zds_code')->wherePassportNo($request->passport_no)->first();
            $gamer = array(
                'id' => $passport->id,
                'name' => $passport->personal_info->full_name,
                'pp_uid' => $passport->pp_uid,
                'passport_no' => $passport->passport_no,
                'zds_code' => $passport->zds_code->zds_code,
            );
        echo json_encode($gamer);
    }

    public function category_assign_get_rider_details(Request $request){
        $searach = '%'.$request->passport_id.'%';
        $passport = Passport::with('zds_code')->where('passport_no', 'like', $searach)->first();
        $sim_card = AssignSim::wherePassportId($passport->id)->whereStatus(1)->first();
        $category_assign = CategoryAssign::with(['main_cate','sub_cate1','sub_cate2'])->wherePassportId($passport->id)->whereStatus(1)->first();
        $main_cate = $category_assign ? $category_assign->main_cate->name : '';
        $sub_cate1 = $category_assign ? $category_assign->sub_cate1->name : '';
        $sub_cate2 = $category_assign ? $category_assign->sub_cate2->name : 'Not Assigned';
        return [
            'name' => $passport->personal_info->full_name, // Str::words($passport->personal_info->full_name, 3),
            'image' => asset($passport->profile->image ?? asset('/assets/images/user_avatar.jpg')),
            'id' => $passport->id,
            'pp_uid' => $passport->pp_uid,
            'passport_no' => $passport->passport_no,
            'passport_id' => $passport->id,
            'sim_card' => $sim_card ? $sim_card->telecome->account_number : "Not Assigned",
            'main_cate' => $main_cate,
            'sub_cate1' => $sub_cate1,
            'sub_cate2' => $sub_cate2,
        ];
    }

    public function category_assign()
    {
        $main_category = Category::latest()->get();
        $assinged_cate = CategoryAssign::with(['passport.personal_info','sub_cate2.subcate_one'])->latest()->get();
        return view('admin-panel.masters.category_assign',compact('main_category','assinged_cate'));
    }

    public function  ajax_render_cat_dropdown(Request $request){

        if($request->type=="1"){

            $current_pass_id=CategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $ppuid = Passport::whereNotIn('id',$current_pass_id)->get();
            $select  = "User Codes";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('ppuid','select'))->render();
            return response()->json(['html'=>$view]);

        }elseif($request->type=="2"){

            $current_pass_id=CategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $user_codes = UserCodes::whereNotIn('passport_id',$current_pass_id)->get();
            $select  = "User Codes";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('user_codes','select'))->render();
            return response()->json(['html'=>$view]);
        }elseif($request->type=="3"){
            $current_pass_id=CategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $passports= Passport::whereNotIn('id',$current_pass_id)->get();
            $select  = "Passport Number";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('passports','select'))->render();
            return response()->json(['html'=>$view]);

        }
    }

    public function ajax_render_subcategory(Request $request){

        if($request->type=="1"){
             $sub_cat = SubCategory::where('main_category','=',$request->select_v)->get();

            echo json_encode($sub_cat);
            exit;

        }else{
            $sub_cat = SubCategory::where('sub_category','=',$request->select_v)->get();

            echo json_encode($sub_cat);
            exit;

        }
    }

    public function ajax_render_subcategory_visa(Request $request){

        if($request->type=="1"){
            $sub_cat = VisaSubCategory::where('main_category','=',$request->select_v)->get();
            echo json_encode($sub_cat);
            exit;
        }else{
            $sub_cat = VisaSubCategory::where('sub_category','=',$request->select_v)->get();
            echo json_encode($sub_cat);
            exit;
        }
    }

    public function category_assign_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transfer_or_permanent'   => 'required',
            'main_category' => 'required_if:transfer_or_permanent,0',
            'sub_category1' => 'required_if:transfer_or_permanent,0',
            'sub_category2' => 'required_if:transfer_or_permanent,0',
            'passport_id'   => 'required'
        ],
        $messages = [
            // 'main_category.required_if'
        ]
    );
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {
            $category_assign_exists = CategoryAssign::wherePassportId($request->passport_id)->whereStatus(1)->first();
            $message = '';
            if($category_assign_exists){
                $category_assign_exists->assign_started_at = $category_assign_exists->created_at; //
                $category_assign_exists->assign_ended_at = Carbon::now(); //
                // $category_assign_exists->remarks = $request->remarks;
                $category_assign_exists->status = 0; // 0 = checked out
                $category_assign_exists->update();
                $request->transfer_or_permanent == 0 ? $message .= 'Staff old Position removed and ' : $message .= '';
                $request->transfer_or_permanent == 1 ? $message .= 'Staff Position removed.' : $message .= '';
            }
            if($request->transfer_or_permanent == 0){
                $category_assign = new CategoryAssign();
                $category_assign->passport_id = $request->passport_id;
                $category_assign->assign_started_at = Carbon::now();
                $category_assign->main_category = $request->main_category;
                $category_assign->sub_category1 = $request->sub_category1;
                $category_assign->sub_category2 = $request->sub_category2;
                // $category_assign->remarks = $request->remarks;
                $category_assign->save();
                $message .= 'New possition registered!';
            }
            $message = [
                'message' => $message,
                'alert-type' => 'success'
            ];
            return back()->with($message);
       }catch (\Illuminate\Database\QueryException $e) {
           $message = [
               'message' => $e->getMessage(),
               'alert-type' => 'error'
           ];
           return back()->with($message);
       }

    }

    public function category_checkout(Request $request, $id)
    {
        //
        $ids=$request->primary_id;

        $obj = CategoryAssign::find($ids);
        $obj->status='0';
        $obj->save();

        $message = [
            'message' => 'Checkout Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }
    //sim master starts
    public function get_network_accounts(Request $request){
        if($request->network == 'Etisalat'){
            $accounts = Etisalat::all();
        }elseif( $request->network == 'DU'){
            $accounts = Du::all();
        }
        foreach($accounts as $account){
            $account->company_name = Company::find($account->company_id)->name;
        }
        $view = view('admin-panel.vehicle_master.shared_blades.network_account_list', compact('accounts','request'))->render();
        return response()->json(['html' => $view]);

    }
    public function sim_master(Request $request){
        $Telecom=Telecome::all();
        return view('admin-panel.masters.sim_master',compact('Telecom'));
    }
    public function sim_master_store(Request $request){
// return $request->all();
        $validator = Validator::make($request->all(), [
            'account_number' => 'unique:telecomes,account_number',
            'party_id' => 'required'

        ], $messages=[
            'party_id.required' => 'Please Select Account No / Party ID after Selecting Networks!'
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";

            foreach ($validate->all() as $error){
                $message_error .= $error;
            }

            $validate = $validator->errors();
            $message = [
                'message' =>  $validate->first(), //"SIM Number Already Exist",
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }

        $obj=new Telecome();
        $obj->account_number=$request->input('account_number');
        $obj->party_id=$request->input('party_id');
        $obj->product_type=$request->input('product_type');
        $obj->network=$request->input('network');
        $obj->category_types=$request->input('category_types');
        $obj->contract_issue_date=$request->input('contract_issue_date');
        $obj->contract_expiry_date=$request->input('contract_expiry_date');
        $obj->sim_sl_no=$request->input('sim_sl_no');
        $obj->save();
        $message = [
            'message' => 'Sim Details Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function telecome_edit2($id)
    {

        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }



        $Telecom=Telecome::all();
        $telecome_edit=Telecome::find($id);


        return view('admin-panel.masters.sim_master',compact('telecome_edit','Telecom'));
    }


    //sim master ends

    public function bikes_master(Request $request){

        $total_bikes = BikeDetail::with([
                'traffic',
                'traffic.passport_info.personal_info',
                'traffic.state',
                'traffic.company',
                'traffic.customer_supplier_info',
                'plate_code',
                'model_info',
                'make',
                'year',
                'category',
                'category',
                'sub_category',
                'insurance'
            ])->get();
        $all_bike_cencel_ids = BikeCencel::pluck('bike_id');
        $all_traffics =  Traffic::with('company')->withCount('bikes')->get();
        $all_customer_suppliers = CustomerSupplier::get();
        $cancelled_bikes = $total_bikes->whereIn('id', $all_bike_cencel_ids);

        $registered_bikes = $total_bikes->whereNotIn('id', $all_bike_cencel_ids);

        $company_bikes = $total_bikes->whereIn('traffic_file', $all_traffics->where('traffic_for', 1)->pluck('id'))->whereNotIn('id', $all_bike_cencel_ids); // Traffic for Zone Company is 1

        $traffic_with_companies = $all_traffics->where('traffic_for', 1);


        $customer_supplier_array = $all_customer_suppliers->where('contact_sub_category_id', 1)->pluck('id')->toArray();
        $traffic_primary_array = $all_traffics->whereIn('company_id',$customer_supplier_array)->where('traffic_for','=','3')->pluck('id')->toArray();
        $own_to_lease_bikes =  $total_bikes->whereIn('traffic_file', $traffic_primary_array)->whereNotIn('id', $all_bike_cencel_ids);

        $customer_supplier_array = $all_customer_suppliers->where('contact_sub_category_id', 2)->pluck('id')->toArray();
        $traffic_primary_array = $all_traffics->whereIn('company_id', $customer_supplier_array)->where('traffic_for','=','3')->pluck('id')->toArray();
        $leased_bikes =  $total_bikes->whereIn('traffic_file',$traffic_primary_array)->whereNotIn('id', $all_bike_cencel_ids);

        $personal_bikes = $total_bikes->whereIn('traffic_file', $all_traffics->where('traffic_for', 2)->pluck('id'))->whereNotIn('id', $all_bike_cencel_ids); // Traffic for personal is 2
        return view('admin-panel.masters.bikes_master',compact('total_bikes','cancelled_bikes','registered_bikes','company_bikes','personal_bikes','leased_bikes','own_to_lease_bikes','traffic_with_companies'));
    }
    public function bikes_master_store(Request $request){
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'plate_no' => 'unique:bike_details,plate_no',
            'expiry_date' => 'date:bike_details,expiry_date',
            'issue_date' => 'date:bike_details,issue_date',
            'make_year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
        ]);
        if ($validator->fails()) {
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }
        $obj=new BikeDetail();
        $obj->plate_no=$request->input('plate_no');
        $obj->plate_code=$request->input('plate_code');
        $obj->model=$request->input('model');
        $obj->make_year=$request->input('make_year');
        $obj->chassis_no=$request->input('chassis_no');
        $obj->mortgaged_by=$request->input('mortgaged_by');
        $obj->insurance_no=$request->input('insurance_no');
        $obj->insurance_co=$request->input('insurance_co');
        $obj->issue_date=$request->input('issue_date');
        $obj->expiry_date=$request->input('expiry_date');
        $obj->traffic_file=$request->input('traffic_file');
        $obj->insurance_issue_date=$request->input('insurance_issue_date');
        $obj->insurance_expiry_date=$request->input('insurance_expiry_date');
        $obj->category_type=$request->input('category_type');
        $obj->engine_no=$request->input('engine_no');
        $obj->seat=$request->input('seat');
        $obj->color=$request->input('color');
         // attachment upload
         if(isset($request->attachment)){
            if (!file_exists('../public/assets/upload/bike_master/attachment/')) {
                mkdir('../public/assets/upload/bike_master/attachment/', 0777, true);
            }
            $ext = pathinfo($_FILES["attachment"]["name"], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["attachment"]["tmp_name"], '../public/assets/upload/bike_master/attachment/'. $file_name);
            $file_path = 'assets/upload/bike_master/attachment/' . $file_name;
            $obj->attachment ? file_exists($obj->attachment) ? unlink($obj->attachment) : "" : "";
            $obj->attachment = $file_path;
        }
        // attachment upload

        $obj->save();

        $message = [
            'message' => 'Bikes Details Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }
    public function bikedetail_update(Request $request, BikeDetail $bikeDetail){
    //     return $bikeDetail;
        $validator = Validator::make($request->all(), [
            'plate_no' => 'unique:bike_details,plate_no,'.$bikeDetail->id,
            'expiry_date' => 'date:bike_details,expiry_date',
            'issue_date' => 'date:bike_details,issue_date',
            'make_year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }
        $bikeDetail->plate_no=$request->input('plate_no');
        $bikeDetail->plate_code=$request->input('plate_code');
        $bikeDetail->model=$request->input('model');
        $bikeDetail->make_year=$request->input('make_year');
        $bikeDetail->chassis_no=$request->input('chassis_no');
        $bikeDetail->mortgaged_by=$request->input('mortgaged_by');
        $bikeDetail->insurance_no=$request->input('insurance_no');
        $bikeDetail->insurance_co=$request->input('insurance_co');
        $bikeDetail->issue_date=$request->input('issue_date');
        $bikeDetail->expiry_date=$request->input('expiry_date');
        $bikeDetail->traffic_file=$request->input('traffic_file');
        $bikeDetail->insurance_issue_date=$request->input('insurance_issue_date');
        $bikeDetail->insurance_expiry_date=$request->input('insurance_expiry_date');
        $bikeDetail->category_type=$request->input('category_type');
        $bikeDetail->engine_no=$request->input('engine_no');
        $bikeDetail->seat=$request->input('seat');
        $bikeDetail->color=$request->input('color');
        $bikeDetail->update();

        $message = [
            'message' => 'Bikes Details updated Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }
    public function bikedetail_edit2($id)
    {
        if (!in_array(1, Auth::user()->user_group_id)) {
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return redirect()->back()->with($message);
        }
        $bike_detail=BikeDetail::all();
        $vehicle_models = VehicleModel::all();
        $bike_detail_edit=BikeDetail::find($id);
        $bike_cencel=BikeCencel::all();
        $plate_codes = VehiclePlateCode::all();
        return view('admin-panel.masters.bikes_master',compact('bike_detail_edit','bike_detail','bike_cencel','vehicle_models','plate_codes'));
    }

//visa status
    public function category_visa_status()
    {
        //
        $main_category=VisaCategoryMain::all();
        $sub_category=VisaSubCategory::whereNull('sub_category')->get();
//        $company=Company::all();
//        $company_info=CompanyInformation::all();

        return view('admin-panel.masters.visa_status',compact('main_category','sub_category'));
    }

    public function category_visa_store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'visa_category_mains' => 'unique:categories,name',

        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";

            foreach ($validate->all() as $error){
                $message_error .= $error;
            }

            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }
        $obj = new VisaCategoryMain();
        $obj->name=$request->input('main_category');
        $obj->save();


        $message = [
            'message' => 'Main Added Successfully',
            'alert-type' => 'success'

        ];
        return back()->with($message);

    }


    public function sub_category_visa_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'visa_sub_categories' => 'unique:sub_categories,name',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";
            foreach ($validate->all() as $error){
                $message_error .= $error;
            }
            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }
        if(isset($request->category_id)){
            $main_id = $request->category_id;
            $obj = new VisaSubCategory();
            $obj->name=$request->input('sub_category');
            $obj->main_category=$main_id;
            $obj->save();
        }elseif(isset($request->sub_category_id)){
            $obj = new VisaSubCategory();
            $obj->name=$request->input('sub_category');
            $obj->sub_category=$request->sub_category_id;
            $obj->save();
        }




        $message = [
            'message' => ' Sub Category Added Successfully',
            'alert-type' => 'success'

        ];
        return back()->with($message);


    }

    public function active_inactive_category_status()
    {
        $main_category = ActiveInactiveCategoryMain::with(['active_inactive_subcategories'])->paginate(8);
        return view('admin-panel.masters.active_inactive_category',compact('main_category'));
    }

    public function active_main_category_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:active_inactive_category_mains,name',
        ],
        $messages = [
            'name.required' => "Please enter main category name"
        ]
    );
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";
            foreach ($validate->all() as $error){
                $message_error .= $error;
            }
            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }
        $obj = new ActiveInactiveCategoryMain();
        $obj->name=$request->input('name');
        $obj->save();
        $message = [
            'message' => 'Main Added Successfully',
            'alert-type' => 'success'
        ];
        return back()->with($message);
    }


    public function active_sub_category_store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'sub_category' => 'required|unique:active_inactive_sub_categories,name',
        ],
        $messages = [
            'category_id.required' => "Please select a main category. ",
            'sub_category.required' => "Please enter name of sub category",
        ]
    );
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";
            foreach ($validate->all() as $error){
                $message_error .= $error;
            }
            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }
        if(isset($request->category_id)){
            $main_id = $request->category_id;
            $obj = new ActiveInactiveSubCategory();
            $obj->name=$request->input('sub_category');
            $obj->main_category=$main_id;
            $obj->save();
        }elseif(isset($request->sub_category_id)){
            $obj = new ActiveInactiveSubCategory();
            $obj->name=$request->input('sub_category');
            $obj->sub_category=$request->sub_category_id;
            $obj->save();
        }
        $message = [
            'message' => ' Sub Category Added Successfully',
            'alert-type' => 'success'
        ];
        return back()->with($message);
    }

    public function working_category_status()
    {
        $main_category=WorkingStatusCategory::all();
        $sub_category=WorkingStatusSubCategory::whereNull('sub_category')->get();
        return view('admin-panel.masters.working_category',compact('main_category','sub_category'));
    }

    public function working_category_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'active_inactive_category_mains' => 'unique:categories,name',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";

            foreach ($validate->all() as $error){
                $message_error .= $error;
            }
            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }
        $obj = new WorkingStatusCategory();
        $obj->name=$request->input('main_category');
        $obj->save();

        $message = [
            'message' => 'Main Added Successfully',
            'alert-type' => 'success'
        ];
        return back()->with($message);
    }


    public function working_sub_category_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'active_inactive_sub_categories' => 'unique:sub_categories,name',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";
            foreach ($validate->all() as $error){
                $message_error .= $error;
            }
            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }
        if(isset($request->category_id)){
            $main_id = $request->category_id;
            $obj = new WorkingStatusSubCategory();
            $obj->name=$request->input('sub_category');
            $obj->main_category=$main_id;
            $obj->save();
        }elseif(isset($request->sub_category_id)){
            $obj = new WorkingStatusSubCategory();
            $obj->name=$request->input('sub_category');
            $obj->sub_category=$request->sub_category_id;
            $obj->save();
        }

        $message = [
            'message' => ' Sub Category Added Successfully',
            'alert-type' => 'success'
        ];
        return back()->with($message);
    }


    public function category_assign_visa()
    {
        $main_category=VisaCategoryMain::all();
        $sub_category=VisaSubCategory::all();
        $assinged_cate=VisaCategoryAssign::all();
        $current_pass_id=VisaCategoryAssign::where('status',1)->pluck('passport_id')
            ->toArray();
        $ppuid = Passport::whereNotIn('id',$current_pass_id)->get();
        return view('admin-panel.masters.category_assign_visa',compact('main_category','sub_category','ppuid','assinged_cate'));
    }

    public function visa_category_assign_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'main_category' => 'required',
            'sub_category1' => 'required',
            'sub_category2' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
//        try {
        $passport_id = null;

        if($request->search_type=="1"){
            $passport_id = $request->ppui_id;
        }elseif($request->search_type=="2"){
            $passport_id = $request->zds_code;
        }else{
            $passport_id = $request->passport_id;
        }

        $is_already = VisaCategoryAssign::where('passport_id','=',$passport_id)
            ->where('status','=','1')
            ->first();

        if($is_already == null){
            $obj = new VisaCategoryAssign();
            $obj->passport_id= $passport_id;
            $obj->main_category=$request->input('main_category');
            $obj->sub_category1=$request->input('sub_category1');
            $obj->sub_category2=$request->input('sub_category2');
            $obj->status='1';
            $obj->save();
        }else{

            $message = [
                'message' => 'This Selection Already Exist',
                'alert-type' => 'error'

            ];
            return back()->with($message);
        }
        $message = [
            'message' => 'Category Assigned Successfully!',
            'alert-type' => 'success'

        ];
        return back()->with($message);
    }


    public function visa_category_checkout(Request $request, $id)
    {
        $ids=$request->primary_id;
        $obj = VisaCategoryAssign::find($ids);
        $obj->status='0';
        $obj->save();

        $message = [
            'message' => 'Checkout Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function  ajax_render_visa_cat_dropdown(Request $request){

        if($request->type=="1"){

            $current_pass_id=VisaCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $ppuid = Passport::whereNotIn('id',$current_pass_id)->get();
            $select  = "User Codes";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('ppuid','select'))->render();
            return response()->json(['html'=>$view]);
        }elseif($request->type=="2"){
            $current_pass_id=VisaCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $user_codes = UserCodes::whereNotIn('passport_id',$current_pass_id)->get();
            $select  = "User Codes";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('user_codes','select'))->render();
            return response()->json(['html'=>$view]);
        }elseif($request->type=="3"){
            $current_pass_id=VisaCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $passports= Passport::whereNotIn('id',$current_pass_id)->get();
            $select  = "Passport Number";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('passports','select'))->render();
            return response()->json(['html'=>$view]);

        }
    }

    public function category_assign_working()
    {

        $main_category=WorkingStatusCategory::all();
        $sub_category=WorkingStatusSubCategory::all();
        $assinged_cate=WorkingCategoryAssign::all();
        $current_pass_id=WorkingCategoryAssign::where('status',1)->pluck('passport_id')
            ->toArray();
        $ppuid = Passport::whereNotIn('id',$current_pass_id)->get();
        return view('admin-panel.masters.category_assign_working',compact('main_category','sub_category','ppuid','assinged_cate'));
    }

    public function working_category_assign_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'main_category' => 'required',
            'sub_category1' => 'required',
            'sub_category2' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
//        try {
        $passport_id = null;

        if($request->search_type=="1"){
            $passport_id = $request->ppui_id;
        }elseif($request->search_type=="2"){
            $passport_id = $request->zds_code;
        }else{
            $passport_id = $request->passport_id;
        }

        $is_already = WorkingCategoryAssign::where('passport_id','=',$passport_id)
            ->where('status','=','1')
            ->first();

        if($is_already == null){
            $obj = new WorkingCategoryAssign();
            $obj->passport_id= $passport_id;
            $obj->main_category=$request->input('main_category');
            $obj->sub_category1=$request->input('sub_category1');
            $obj->sub_category2=$request->input('sub_category2');
            $obj->status='1';
            $obj->save();
        }else{
            $message = [
                'message' => 'This Selection Already Exist',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
        $message = [
            'message' => 'Category Assigned Successfully!',
            'alert-type' => 'success'
        ];
        return back()->with($message);
    }


    public function working_category_checkout(Request $request, $id)
    {
        $ids=$request->primary_id;
        $obj = WorkingCategoryAssign::find($ids);
        $obj->status='0';
        $obj->save();

        $message = [
            'message' => 'Checkout Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }



    public function  ajax_render_working_cat_dropdown(Request $request){
        if($request->type=="1"){
            $current_pass_id=VisaCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $ppuid = Passport::whereNotIn('id',$current_pass_id)->get();
            $select  = "User Codes";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('ppuid','select'))->render();
            return response()->json(['html'=>$view]);

        }elseif($request->type=="2"){

            $current_pass_id=VisaCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $user_codes = UserCodes::whereNotIn('passport_id',$current_pass_id)->get();
            $select  = "User Codes";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('user_codes','select'))->render();
            return response()->json(['html'=>$view]);
        }elseif($request->type=="3"){
            $current_pass_id=VisaCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $passports= Passport::whereNotIn('id',$current_pass_id)->get();
            $select  = "Passport Number";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('passports','select'))->render();
            return response()->json(['html'=>$view]);
        }
    }

    public function ajax_render_subcategory_working(Request $request){
        if($request->type=="1"){
            $sub_cat = WorkingStatusSubCategory::where('main_category','=',$request->select_v)->get();
            echo json_encode($sub_cat);
            exit;
        }else{
            $sub_cat = WorkingStatusSubCategory::where('sub_category','=',$request->select_v)->get();

            echo json_encode($sub_cat);
            exit;
        }
    }


    public function  ajax_render_working_dropdown(Request $request){

        if($request->type=="1"){
            $current_pass_id=WorkingCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $ppuid = Passport::whereNotIn('id',$current_pass_id)->get();
            $select  = "User Codes";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('ppuid','select'))->render();
            return response()->json(['html'=>$view]);

        }elseif($request->type=="2"){

            $current_pass_id=WorkingCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $user_codes = UserCodes::whereNotIn('passport_id',$current_pass_id)->get();
            $select  = "User Codes";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('user_codes','select'))->render();
            return response()->json(['html'=>$view]);
        }elseif($request->type=="3"){
            $current_pass_id=WorkingCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $passports= Passport::whereNotIn('id',$current_pass_id)->get();
            $select  = "Passport Number";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('passports','select'))->render();
            return response()->json(['html'=>$view]);

        }
    }



    //active in active
    public function get_rider_list_for_active_inactive_category(Request $request)
    {
        $search_text = $request->get('query');
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->where('employee_category', 0)
            ->get();
        if(count($passport_data)=='0'){
            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->where('employee_category', 0)
                ->get();
        }
        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->where('employee_category', 0)
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->where('employee_category', 0)
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->where('employee_category', 0)
                        ->get();
                    if (count($zds_data)=='0')
                    {
                        $mobile_data =Passport::select('passport_additional_info.personal_mob','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->where("passport_additional_info.personal_mob","LIKE","%{$request->input('query')}%")
                            ->where('employee_category', 0)
                            ->get();

                        if (count($mobile_data)=='0')
                        {
                            $platform_code =Passport::select('platform_codes.platform_code','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                ->join('platform_codes', 'platform_codes.passport_id', '=', 'passports.id')
                                ->where("platform_codes.platform_code","LIKE","%{$request->input('query')}%")
                                ->where('employee_category', 0)
                                ->get();
                        if (count($platform_code)=='0') {
                            $emirates_code = Passport::select('emirates_id_cards.card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                ->join('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                                ->where("emirates_id_cards.card_no", "LIKE", "%{$request->input('query')}%")
                                ->where('employee_category', 0)
                                ->get();
                            if (count($emirates_code) == '0') {
                                $drive_lin_data = Passport::select('driving_licenses.license_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                    ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
                                    ->where("driving_licenses.license_number", "LIKE", "%{$request->input('query')}%")
                                    ->where('employee_category', 0)
                                    ->get();
                                if (count($drive_lin_data) == '0') {
                                    $labour_card_data = Passport::select('electronic_pre_approval.labour_card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                        ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                                        ->where("electronic_pre_approval.labour_card_no", "LIKE", "%{$request->input('query')}%")
                                        ->where('employee_category', 0)
                                        ->get();
                                    if( count($labour_card_data)=='0') {
                                        $visa_number = Passport::select('entry_print_inside_outside.visa_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                            ->join('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                                            ->where("entry_print_inside_outside.visa_number", "LIKE", "%{$request->input('query')}%")
                                            ->where('employee_category', 0)
                                            ->get();
                                        if (count($visa_number) == '0') {
                                            $platno = $request->input('query');
                                            $bike_id = BikeDetail::where('plate_no', $platno)->first();
                                            if($bike_id != null){
                                                $plat_data = Passport::select('assign_bikes.bike', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                    ->join('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
                                                    ->where("assign_bikes.bike", "LIKE", "%{$bike_id->id}%")
                                                    ->where("assign_bikes.status", "1")
                                                    ->where('employee_category', 0)
                                                    ->get();
                                                //platnumber response
                                                $pass_array = array();
                                                foreach ($plat_data as $pass) {
                                                    $gamer = array(
                                                        'name' => $bike_id->plate_no,
                                                        'zds_code' => $pass->zds_code,
                                                        'passport' => $pass->passport_no,
                                                        'passport_id' => $pass->id,
                                                        'ppuid' => $pass->pp_uid,
                                                        'full_name' => $pass->full_name,
                                                        'type' => '5',
                                                    );
                                                    $pass_array[] = $gamer;
                                                    return response()->json($pass_array);
                                                }
                                            }
                                        }
                                        //visa number search
                                        $pass_array = array();
                                        foreach ($visa_number as $pass) {
                                            $gamer = array(
                                                'name' => $pass->visa_number,
                                                'zds_code' => $pass->zds_code,
                                                'passport' => $pass->passport_no,
                                                'passport_id' => $pass->id,
                                                'ppuid' => $pass->pp_uid,
                                                'full_name' => $pass->full_name,
                                                'type' => '10',
                                            );
                                            $pass_array[] = $gamer;
                                            return response()->json($pass_array);
                                        }
                                    }
                                    $pass_array = array();
                                    foreach ($labour_card_data as $pass) {
                                        $gamer = array(
                                            'name' => $pass->labour_card_no,
                                            'zds_code' => $pass->zds_code,
                                            'passport' => $pass->passport_no,
                                            'passport_id' => $pass->id,
                                            'ppuid' => $pass->pp_uid,
                                            'full_name' => $pass->full_name,
                                            'type' => '9',
                                        );
                                        $pass_array[] = $gamer;
                                        return response()->json($pass_array);
                                    }
                                }
                                //platnumber response
                                $pass_array = array();
                                foreach ($drive_lin_data as $pass) {
                                    $gamer = array(
                                        'name' => (string)$pass->license_number,
                                        'zds_code' => $pass->zds_code,
                                        'passport' => $pass->passport_no,
                                        'passport_id' => $pass->id,
                                        'ppuid' => $pass->pp_uid,
                                        'full_name' => $pass->full_name,
                                        'type' => '8',
                                    );
                                    $pass_array[] = $gamer;

                                    return response()->json($pass_array);
                                }
                            }
                                //emirates ID response
                                $pass_array = array();
                                foreach ($emirates_code as $pass) {
                                    $gamer = array(

                                        'name' => $pass->card_no,
                                        'zds_code' => $pass->zds_code,
                                        'passport' => $pass->passport_no,
                                        'passport_id' => $pass->id,
                                        'ppuid' => $pass->pp_uid,
                                        'full_name' => $pass->full_name,
                                        'type' => '7',
                                    );
                                    $pass_array[] = $gamer;

                                }
                                return response()->json($pass_array);
                            }
                        //platform code  response
                            $pass_array=array();
                            foreach ($platform_code as $pass){
                                $gamer = array(
                                    'name' => $pass->platform_code,
                                    'zds_code' => $pass->zds_code,
                                    'passport' => $pass->passport_no,
                                    'passport_id' => $pass->id,
                                    'ppuid' => $pass->pp_uid,
                                    'full_name' => $pass->full_name,
                                    'type'=>'6',
                                );
                                $pass_array[]= $gamer;
                            }

                            return response()->json($pass_array);
                        }
                        //mobile number response
                        $pass_array=array();
                        foreach ($mobile_data as $pass){
                            $gamer = array(
                                'name' => $pass->personal_mob,
                                'zds_code' => $pass->zds_code,
                                'passport' => $pass->passport_no,
                                'passport_id' => $pass->id,
                                'ppuid' => $pass->pp_uid,
                                'full_name' => $pass->full_name,
                                'type'=>'5',
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
                            'passport_id' => $pass->id,
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
                        'passport_id' => $pass->id,
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
                    'passport_id' => $pass->id,
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
                'zds_code' => isset($pass->zds_code) ? $pass->zds_code : '',
                'type'=>'0',
            );
            $pass_array[]= $gamer;
        }
        return response()->json($pass_array);
    }
    public function ajax_passport_id_for_active_inactive_category(Request $request)
    {
        return response()->json([
            'passport_id' => Passport::where('passport_no', 'like', '%' . $request->keyword . '%')->first()->id
        ]);
    }
    public function ajax_rider_category_active_inactive_history(Request $request)
    {
        $histories = ActiveInactiveCategoryAssignHistory::wherePassportId($request->passport_id)->latest()->get();
        $view = view('admin-panel.masters.shared_blades.category_assign_history', compact('histories'))->render();
        return response()->json(['html' => $view]);
    }
    public function category_assign_active()
    {
        $current_user = auth()->user();
        $assign_to_dc_passport_ids = collect();
        if($current_user->hasRole(['Admin'])){
            $assign_to_dc_passport_ids = AssignToDc::distinct('rider_passport_id')->whereStatus(1)->pluck('rider_passport_id');
        }elseif($current_user->designation_type == 1){
            $assign_to_dc_passport_ids = AssignToDc::distinct('rider_passport_id')->whereIn('platform_id', $current_user->user_platform_id)->whereStatus(1)->pluck('rider_passport_id');
        }elseif($current_user->hasRole(['DC_roll'])){
            $assign_to_dc_passport_ids = AssignToDc::distinct('rider_passport_id')->where('user_id', $current_user->id)->whereStatus(1)->pluck('rider_passport_id');
        }
        $assinged_cate = ActiveInactiveCategoryAssign::with(['passport.personal_info','main_cate','sub_cate1','passport.zds_code'])->whereIn('passport_id', $assign_to_dc_passport_ids->toArray())->pluck('passport_id')->toArray();
        $main_category = ActiveInactiveCategoryMain::all();
        $non_assigned_riders_ids = $assign_to_dc_passport_ids->filter(function($assign_to_dc_passport_id)use($assinged_cate){
            return !in_array($assign_to_dc_passport_id, $assinged_cate);
        });
        $non_assigned_riders = Passport::with(['personal_info','platform_assign.plateformdetail','assign_to_dcs.user_detail', 'platform_codes', 'zds_code'])->whereIn('id', $non_assigned_riders_ids)->get();
        return view('admin-panel.masters.category_assign_active', compact('main_category','assinged_cate','non_assigned_riders'));
    }



    public function active_category_assign_store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'main_category' => 'required',
            'sub_category1' => 'required',
            'passport_ids.*' => 'required'
        ],
        $messages = [
            // 'passport_id.required' => 'Please select a rider first'
        ]
    );

        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        if(isset($request->passport_ids) && count($request->passport_ids) > 0){
            foreach($request->passport_ids as $passport){
                $is_already = ActiveInactiveCategoryAssign::wherePassportId($request->passport_id)->first();
                if(!$is_already){
                    $obj = new ActiveInactiveCategoryAssign();
                    $obj->passport_id = $passport;
                    $obj->main_category = $request->input('main_category');
                    $obj->sub_category1 = $request->input('sub_category1');
                    $obj->common_status_id = $request->input('common_status_id');
                    $obj->user_id = auth()->id();
                    $obj->save();
                }
            }
            $message = [
                'message' => 'Category Assigned Successfully!',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        }else{
            $message = [
                'message' => 'Pleas select at least one rider',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }


    public function active_category_checkout(Request $request)
    {
        $ids=$request->primary_id;
        $obj = ActiveInactiveCategoryAssign::find($ids);
        $obj->status='0';
        $obj->save();

        $message = [
            'message' => 'Checkout Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }



    public function  ajax_render_active_cat_dropdown(Request $request){

        if($request->type=="1"){

            $current_pass_id=ActiveInactiveCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $ppuid = Passport::whereNotIn('id',$current_pass_id)->get();
            $select  = "User Codes";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('ppuid','select'))->render();
            return response()->json(['html'=>$view]);

        }elseif($request->type=="2"){

            $current_pass_id=ActiveInactiveCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $user_codes = UserCodes::whereNotIn('passport_id',$current_pass_id)->get();
            $select  = "User Codes";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('user_codes','select'))->render();
            return response()->json(['html'=>$view]);
        }elseif($request->type=="3"){
            $current_pass_id=ActiveInactiveCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $passports= Passport::whereNotIn('id',$current_pass_id)->get();
            $select  = "Passport Number";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('passports','select'))->render();
            return response()->json(['html'=>$view]);

        }
    }



    public function ajax_render_subcategory_active(Request $request){

        if($request->type=="1"){
            $sub_cat = ActiveInactiveSubCategory::where('main_category','=',$request->select_v)->get();
            echo json_encode($sub_cat);
            exit;
        }else{
            $sub_cat = ActiveInactiveSubCategory::where('sub_category','=',$request->select_v)->get();

            echo json_encode($sub_cat);
            exit;

        }
    }


    public function  ajax_render_active_dropdown(Request $request){
        if($request->type=="1"){
            $current_pass_id=ActiveInactiveCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $ppuid = Passport::whereNotIn('id',$current_pass_id)->get();
            $select  = "User Codes";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('ppuid','select'))->render();
            return response()->json(['html'=>$view]);
        }elseif($request->type=="2"){

            $current_pass_id=ActiveInactiveCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $user_codes = UserCodes::whereNotIn('passport_id',$current_pass_id)->get();
            $select  = "User Codes";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('user_codes','select'))->render();
            return response()->json(['html'=>$view]);
        }elseif($request->type=="3"){
            $current_pass_id=ActiveInactiveCategoryAssign::where('status',1)->pluck('passport_id')
                ->toArray();
            $passports= Passport::whereNotIn('id',$current_pass_id)->get();
            $select  = "Passport Number";
            $view = view("admin-panel.masters.ajax_category_dropdowns",compact('passports','select'))->render();
            return response()->json(['html'=>$view]);

        }
    }


    public function state_list()
    {
        $current_state = Company::find(request('company_id'))->state ?? null;
        $view  = view('admin-panel.company.master.shared_blades.state_list',compact('current_state'))->render();
        return response()->json(['html'=>$view]);
    }

    public function renewal_history()
    {
        $renewals = Renewal::whereMasterCategoryId(request('master_category_id'))->whereMasterId(request('master_id'))->get();
        $view  = view('admin-panel.company.master.shared_blades.expiry_history',compact('renewals'))->render();
        return response()->json(['html'=>$view]);
    }
    public function company_master_expiry_reports(){
        $master_categories = MasterMajorCategory::all();
        $searchBy = request('searchBy');
        $dataRange = request('dateRange');
        // add days to the current time
        $date_after_dateRange = Carbon::today()->addDays($dataRange ?? 90);
        $data = [];
        if(isset($searchBy)){
            $data = $master_categories->find($searchBy)->model_name::all();
            foreach($data as $key => $item){
                if($master_categories->find($searchBy)->model_name !== 'App\Model\Seeder\Company'){
                    $item->company = Company::find($item->company_id);
                }
                $item->renewals =  Renewal::whereMasterCategoryId($searchBy)
                ->whereMasterId($item->id)
                ->whereDate('expiry_date','<=',$date_after_dateRange)
                ->latest()->get();
                $count= count( $item->renewals);
                if($count=='0'){
                    unset($data[$key]);
                }
            }
        };
        // return $data;
        foreach($data as $item){
            $current_date = new DateTime();
            $expiry_date = new DateTime($item->expiry_date);
            $item->expires_in = $current_date > $expiry_date  ? "Expired" :Carbon::today()->diffInDays($item->expiry_date);
            $item->master = $master_categories->find(1)->model_name::find($item->master_id);
        }
        return view('admin-panel.company.master.expiry_reports', compact('data', 'master_categories'));
    }

    public function company_master_expiry_reports_update(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'issue_date' => 'before:expiry_date'
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),// 'Please Select A company form list',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {
            $obj = new Renewal();
            $obj->master_category_id = $request->master_category_id;
            $obj->master_id  = $request->master_id   ;
            $obj->issue_date  = $request->issue_date;
            $obj->expiry_date  = $request->expiry_date;
            $obj->remarks  = $request->remarks;

            // attachment upload
            if(isset($request->attachment)){
                if (!file_exists('../public/assets/upload/expiry/attachment/')) {
                    mkdir('../public/assets/upload/expiry/attachment/', 0777, true);
                }
                    $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;

                    move_uploaded_file($_FILES["attachment"]["tmp_name"], '../public/assets/upload/expiry/attachment/'. $file_name);
                    $file_path = 'assets/upload/expiry/attachment/' . $file_name;
                    $obj->attachment = $file_path;
                }
                // attachment upload
                $obj->save();
                $message = [
                    'message' => 'Renewal Successfully',
                    'alert-type' => 'success'
                ];
                return back()->with($message);
            }catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' =>  $e->getMessage(), //'Error Occured',
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }
        }

    function vehicle_master_create(){
        $plate_codes  = VehiclePlateCode::all();
        $vehicle_models = VehicleModel::all();
        $vehicle_mortgages = VehicleMortgage::all();
        $vehicle_categories = VehicleCategory::all();
        $vehicle_insurances = VehicleInsurance::all();
        $traffics = Traffic::all();
        $result = Form_upload::all();
        $makes = VehicleMake::all();
        $years = VehicleYear::all();
        $total_bikes = BikeDetail::count();
        return view('admin-panel.company.master.vehicle_master_create', compact('plate_codes','vehicle_models','vehicle_mortgages','vehicle_categories','vehicle_insurances','traffics','result','makes','years','total_bikes'));
    }

    public function vehicle_master_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'traffic_file' => 'required',
            'plate_no' => 'unique:bike_details,plate_no|required',
            'chassis_no' => 'unique:bike_details,chassis_no|required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),// 'Please Select A company form list',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {
            $obj = new BikeDetail();
            $obj->plate_no=$request->input('plate_no');
            $obj->plate_code=$request->input('plate_code');
            $obj->model=$request->input('model');
            $obj->make_year=$request->input('make_year');
            $obj->chassis_no=$request->input('chassis_no');
            $obj->mortgaged_by=$request->input('mortgaged_by');
            $obj->vehicle_mortgage_no=$request->input('vehicle_mortgage_no');
            $obj->insurance_no=$request->input('insurance_no');
            $obj->insurance_co=$request->input('insurance_co');
            $obj->issue_date=$request->input('issue_date');
            $obj->expiry_date=$request->input('expiry_date');
            $obj->traffic_file=$request->input('traffic_file');
            $obj->insurance_issue_date=$request->input('insurance_issue_date');
            $obj->insurance_expiry_date=$request->input('insurance_expiry_date');
            $obj->category_type=$request->input('category_type');
            $obj->vehicle_sub_category_id=$request->input('vehicle_sub_category_id');
            $obj->engine_no=$request->input('engine_no');
            $obj->seat=$request->input('seat');
            $obj->color=$request->input('color');
            // attachment_insurance upload
            $obj->save();

            // attachment_reg_front upload
            if(isset($request->attachment_reg_front)){
                if (!file_exists('../public/assets/upload/bike_detail/attachment_reg_front/')) {
                    mkdir('../public/assets/upload/bike_detail/attachment_reg_front/', 0777, true);
                }
                $ext = pathinfo($_FILES['attachment_reg_front']['name'], PATHINFO_EXTENSION);
                $file_name = time() . '.' . $ext;

                move_uploaded_file($_FILES["attachment_reg_front"]["tmp_name"], '../public/assets/upload/bike_detail/attachment_reg_front/'. $file_name);
                $file_path = 'assets/upload/bike_detail/attachment_reg_front/' . $file_name;
                $obj->attachment_reg_front = $file_path;
            }
            // attachment_reg_front upload

            // attachment_reg_back upload
            if(isset($request->attachment_reg_back)){
                if (!file_exists('../public/assets/upload/bike_detail/attachment_reg_back/')) {
                    mkdir('../public/assets/upload/bike_detail/attachment_reg_back/', 0777, true);
                }
                $ext = pathinfo($_FILES['attachment_reg_back']['name'], PATHINFO_EXTENSION);
                $file_name = time() . '.' . $ext;

                move_uploaded_file($_FILES["attachment_reg_back"]["tmp_name"], '../public/assets/upload/bike_detail/attachment_reg_back/'. $file_name);
                $file_path = 'assets/upload/bike_detail/attachment_reg_back/' . $file_name;
                $obj->attachment_reg_back = $file_path;
            }
            // attachment_reg_back upload

            // attachment_insurance upload
            if(isset($request->attachment_insurance)){
                if (!file_exists('../public/assets/upload/bike_detail/attachment_insurance/')) {
                    mkdir('../public/assets/upload/bike_detail/attachment_insurance/', 0777, true);
                }
                $ext = pathinfo($_FILES['attachment_insurance']['name'], PATHINFO_EXTENSION);
                $file_name = time() . '.' . $ext;

                move_uploaded_file($_FILES["attachment_insurance"]["tmp_name"], '../public/assets/upload/bike_detail/attachment_insurance/'. $file_name);
                $file_path = 'assets/upload/bike_detail/attachment_insurance/' . $file_name;
                $obj->attachment_insurance = $file_path;
            }
            // attachment_insurance upload
            $obj->update();
            $message = [
                'message' => 'Bike Registered Succussful. ',
                'alert-type' => 'success'
            ];
            if($obj->id){
                $upload_history = new VehicleBulkUploadHistory();
                $upload_history->vehicle_ids = json_encode([$obj->id]);
                $upload_history->user_id = auth()->user()->id;
                $upload_history->updated_form = 1;
                $upload_history->save();
                $message['message'] .= "Vehicle Upload history added";
            }
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' =>  $e->getMessage(), //'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }
    public function vehicle_master_edit(Request $request)
    {
        $bike_id = request('bike_id') ?? null;
        $bike_detail_edit = BikeDetail::whereId($bike_id)->whereNotIn('id', BikeCencel::pluck('bike_id'))->first();
        $bikes = BikeDetail::whereNotIn('id', BikeCencel::pluck('bike_id'))->get(['id','plate_no','chassis_no']);
        $traffics = Traffic::all();
        $vehicle_categories = VehicleCategory::all();
        $plate_codes = VehiclePlateCode::all();
        $vehicle_models = VehicleModel::all();
        $years = VehicleYear::all();
        $vehicle_insurances = VehicleInsurance::all();
        $vehicle_mortgages = VehicleMortgage::all();
        return view('admin-panel.company.master.vehicle_master_edit', compact('bike_detail_edit','traffics','vehicle_categories','plate_codes','vehicle_models','years','vehicle_insurances','vehicle_mortgages','bikes'));
    }
    public function vehicle_master_update(Request $request)
    {
        $validator = Validator::make($request->all(), []);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),// 'Please Select A company form list',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {
            // dd($request->all());
            // BikeDetail::disableAuditing();
            $bike_exists = BikeDetail::find($request->bike_id);
            if($bike_exists !== null){
                $bike_exists->traffic_file  =   $request->traffic_file;
                $bike_exists->category_type =   $request->category_type;
                $bike_exists->vehicle_sub_category_id   =   $request->vehicle_sub_category_id;
                $bike_exists->plate_code    =   $request->plate_code;
                $bike_exists->model =   $request->model;
                $bike_exists->make_year =   $request->make_year;
                $bike_exists->issue_date    =   $request->issue_date;
                $bike_exists->expiry_date   =   $request->expiry_date;
                $bike_exists->engine_no =   $request->engine_no;
                $bike_exists->seat  =   $request->seat;
                $bike_exists->color =   $request->color;
                $bike_exists->insurance_co  =   $request->insurance_co;
                $bike_exists->insurance_no  =   $request->insurance_no;
                $bike_exists->insurance_issue_date  =   $request->insurance_issue_date;
                $bike_exists->insurance_expiry_date =   $request->insurance_expiry_date;
                $bike_exists->mortgaged_by  =   $request->mortgaged_by;
                $bike_exists->vehicle_mortgage_no   =   $request->vehicle_mortgage_no;
                $bike_exists->update();
            }
                $message = [
                    'message' => 'Vehicle Info updated successfully',
                    'alert-type' => 'success'
            ];
            // BikeDetail::enableAuditing();
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' =>  $e->getMessage(), //'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }
    public function vehicle_master_list()
    {
        $bike_detail=BikeDetail::all();
        return view('admin-panel.company.master.vehicle_master_list', compact('bike_detail'));
    }

    public function get_vehicle_sub_category_list(){
        $vehicle_sub_categories = VehicleSubCategory::whereVehicleCategoryId(request()->vehicle_category_id)->get();
        $view = view('admin-panel.company.master.shared_blades.vehicle_sub_category_dropdown_list',compact('vehicle_sub_categories'))->render();
        return response([
            'html' => $view
        ]);
    }
    public function vehicle_report()
    {
        $vehicle_categories = VehicleCategory::withCount(['bikes'])->orderBy('bikes_count','desc')->get();
        $vehicle_models = VehicleModel::withCount(['bikes'])->orderBy('bikes_count','desc')->get();
        $vehicle_plate_codes = VehiclePlateCode::withCount(['bikes'])->orderBy('bikes_count','desc')->get();
        $vehicle_makes = VehicleMake::withCount(['bikes'])->orderBy('bikes_count','desc')->get();
        $vehicle_years = VehicleYear::withCount(['bikes'])->orderBy('bikes_count','desc')->get();
        $vehicle_insurances = VehicleInsurance::withCount(['bikes'])->orderBy('bikes_count','desc')->get();
        $vehicle_mortgages = VehicleMortgage::withCount(['bikes'])->orderBy('bikes_count','desc')->get();

        return view('admin-panel.vehicle_master.vehicle_report', compact('vehicle_categories','vehicle_models','vehicle_plate_codes','vehicle_makes','vehicle_years','vehicle_insurances','vehicle_mortgages'));
    }

}
