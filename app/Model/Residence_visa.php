<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Residence_visa extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable=['uid_no','file_no','passport_no','name','profession_visa','profession_working','company_visa','company_working',
        'work_permit_no','place_of_issue','issue_date','expiry_date'];
}
