<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class E_visa extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable=['employment','entry_permit_number','date_of_issue','place_of_issue','valid_until','uid_no','full_name','nationality','place_of_birth','passport_number','profession','sponser_name','entry_date'];

}
