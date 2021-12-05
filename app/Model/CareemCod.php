<?php

namespace App\Model;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareemCod extends Model  implements Auditable
{ 
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'passport_id',
        'type',
        'date',
        'time',
        'amount',
        'uploaded_file_path',
        'created_by',
        'data_stored_form'
    ];
    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
}
