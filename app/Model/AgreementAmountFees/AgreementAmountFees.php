<?php

namespace App\Model\AgreementAmountFees;

use App\Model\Master_steps;
use App\Model\Seeder\Company;
use App\Model\Seeder\EmployeeType;
use App\Model\Seeder\MedicalCategory;
use App\Model\Seeder\LabourFeesOption;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Agreement\AgreementCategoryTree;

class AgreementAmountFees extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function get_employee_type(){
        return $this->belongsTo(EmployeeType::class,'employee_type_id');
    }
    public function  get_company_name(){
        return $this->belongsTo(Company::class,'company_id');
    }

    public function get_current_status(){
        return $this->belongsTo(AgreementCategoryTree::class,'current_status_id');
    }
    public function labour_fess(){

        return $this->hasMany(Master_steps::class,'option_value');
    }

    public function get_medical_company(){
        return $this->belongsTo(MedicalCategory::class,'child_option_id');
    }

    public function get_labor_option(){
        return $this->belongsTo(LabourFeesOption::class,'option_value');
    }


}
