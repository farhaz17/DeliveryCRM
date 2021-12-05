<?php

namespace App\Model\Agreement;

use App\User;
use App\Model\Master\FourPl;
use App\Model\Seeder\Company;
use App\Model\Passport\Passport;
use App\Model\Seeder\EmployeeType;
use App\Model\Seeder\PersonStatus;
use App\Model\Seeder\MedicalCategory;
use App\Model\Agreement\AgreemenUpload;
use Illuminate\Database\Eloquent\Model;
use App\Model\Agreement\AgreementAmount;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Seeder\AgreemtnDesignation;
use App\Model\Agreement\AgreementCategory;
use App\Model\VisaProcess\AssigningAmount;
use App\Model\Agreement\AgreementCategoryTree;
use App\Model\AgreementAmendment\AgreementAmendment;

class Agreement extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "agreements";
    protected $fillable = ['passport_id',
                           'agreement_no',
                            'discount',
                            'reference_type',
                            'reference_type_own',
                            'reference_type_outside',
                            'current_status_id',
                            'current_status_start_date',
                            'working_visa',
                            'applying_visa',
                            'working_designation',
                            'visa_designation',
                            'driving_licence',
                            'driving_licence_ownership',
                            'driving_licence_vehicle',
                            'driving_licence_vehicle_type',
                            'medical_ownership',
                            'medical_ownership_type',
                            'emiratesid_ownership',
                            'status_change',
                            'fine',
                            'rta_permit',
                            'employee_type_id',
                            'living_status_id',
                            'advance_amount',
                            'remarks',
                            'visa_pasting',
                            'rta_medical',
                            'english_test',
                            'cid_report',
                            'rta_card_print',
                            'rta_permit_training',
                            'e_test',
                            'e_visa_print',
                            'inside_e_visa_type',
                            'discount_details',
                            'signed_agreement_pic',
                            'admin_fee_id',
                            'payroll_deduct',
                            'four_pl_name',
    ];



    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function current_status_person()
    {
        return $this->belongsTo(PersonStatus::class,'current_status_id');
    }

    public function get_current_status(){
        return $this->belongsTo(AgreementCategoryTree::class,'current_status_id');
    }

    public function get_driving_license(){
        return $this->belongsTo(AgreementCategoryTree::class,'driving_licence');
    }

    public function get_driving_ownership(){
        return $this->belongsTo(AgreementCategoryTree::class,'driving_licence_ownership');
    }

    public function get_driving_vehicle(){
        return $this->belongsTo(AgreementCategoryTree::class,'driving_licence_vehicle');
    }

    public function get_driving_licence_vehicle_type(){
        return $this->belongsTo(AgreementCategoryTree::class,'driving_licence_vehicle_type');
    }

    public function get_medical_type(){
        return $this->belongsTo(AgreementCategoryTree::class,'medical_ownership');
    }
    public function get_medical_company(){

        return $this->belongsTo(AgreementCategoryTree::class,'medical_ownership_type');
    }

    public function get_emirates_id(){

        return $this->belongsTo(AgreementCategoryTree::class,'emiratesid_ownership');
    }

    public  function get_status_change(){
        return $this->belongsTo(AgreementCategoryTree::class,'status_change');
    }

    public  function get_rta_permit(){
        return $this->belongsTo(AgreementCategoryTree::class,'rta_permit');
    }

    public  function get_case_fine(){
        return $this->belongsTo(AgreementCategoryTree::class,'fine');
    }






    public function amounts(){

        return $this->hasMany(AgreementAmount::class);
    }

    public function employee_types(){
        return $this->belongsTo(EmployeeType::class,'employee_type_id');
    }




    public function doc_uploads(){

        return $this->hasMany(AgreemenUpload::class);
    }

    public function step_amounts(){

        return $this->hasMany(AssigningAmount::class);
    }





    public  function  get_working_visa(){

        return $this->belongsTo(Company::class,'working_visa');
    }

    public  function  get_applying_visa(){

        return $this->belongsTo(Company::class,'applying_visa');
    }

    public  function  get_working_designation(){

        return $this->belongsTo(Company::class,'working_designation');
    }

    public  function  get_visa_designation(){

        return $this->belongsTo(Company::class,'visa_designation');
    }

    public function medical_ownership_cat(){

        return $this->belongsTo(MedicalCategory::class,'medical_ownership_type');
    }

    public function reference_type_user(){

        return $this->belongsTo(Passport::class,'reference_type_own');
    }
    public function get_agreement_designation(){
        return $this->belongsTo(AgreemtnDesignation::class,'visa_designation');
    }

    public function get_ar_balance(){
        return $this->hasOne(AgreementArBalance::class,'agreement_id');
    }

    public function get_amendment(){
        return $this->hasMany(AgreementAmendment::class,'agreement_id');
    }

    public function count_amendment(){
        return $this->get_amendment()->count();
    }


    public function fourpl_contractor(){

        return $this->belongsTo(FourPl::class,'four_pl_name');
    }
    public function get_four_pl(){
        return $this->hasOne(FourPl::class,'id','four_pl_name');
    }



}
