<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Labour_approval extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable=['app_number','company_name','name','nationality','labour_personal_no','passport_number','offer_latter','work_permit_no',
        'issue_date','expiry_date','profession_visa','profession_working','company_visa','company_working'];
}
