<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work_permit extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable=['name','work_permit_issue_date','work_permit_expiry_date','personal_number','profession_visa','working_visa','nationality','working_company','visa_company','offer_letter_no',
        'transaction_no','passport_number','labour_card_permit_no','employment','visa','visa_print','work_permit_copy','status'];
}
