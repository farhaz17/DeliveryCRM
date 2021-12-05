<?php

namespace App\Model\LicenseAmount;

use App\Model\Seeder\Company;
use App\Model\Seeder\EmployeeType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Agreement\AgreementCategoryTree;

class LicenseAmount extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    function get_employee_type(){
        return $this->belongsTo(EmployeeType::class,'employee_type_id');
    }
    function get_company(){
        return $this->belongsTo(Company::class,'company_id');
    }

    public function get_current_status(){
        return $this->belongsTo(AgreementCategoryTree::class,'current_status_id');
    }

}
