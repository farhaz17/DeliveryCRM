<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medical_info extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable=['app_id_number','medical_date','name','urgency_type','medical_center','passport_number','emirates_id','email',
        'sponser_name','residency_number','medical_status'];

}
