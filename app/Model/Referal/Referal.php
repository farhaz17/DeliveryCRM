<?php

namespace App\Model\Referal;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Referal extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "referals";
    protected $fillable=['passport_id','name','passport_no','driving_license','driving_attachment','status','credit_amount'];

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }

}
