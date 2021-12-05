<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Change_status extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable=['new_file_number','previous_file_number','uid_no','submission_date','approval_date','name',
        'nationality','passport_number','profession_visa','profession_working','company_visa','company_working','sponser_name','note'];

}
