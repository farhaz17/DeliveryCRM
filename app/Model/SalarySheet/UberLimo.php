<?php

namespace App\Model\SalarySheet;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class UberLimo extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //


    public $table = "uber_limos";
    //
    protected $fillable=['driver_u_uid',
        'trip_u_uid',
        'first_name',
        'last_name',
        'amount',
        'timestamp',
        'item_type',
        'description',
        'disclaimer',
        'date_from',
        'date_to',
        'file_path',
        'sheet_id'];

}
