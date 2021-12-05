<?php

namespace App\Model\Cods;

use App\User;
use App\Model\RiderProfile;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Cods extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "cods";
    protected $fillable = [
        'slip_number',
        'machine_number',
        'location_at_machine',
        'date',
        'time',
        'amount',
        'picture',
        'passport_id',
        'status',
        'verify_by',
        'reject_by'
    ];

    public function  user_detail(){
            return $this->belongsTo(User::class,'user_id');
    }

    public function  passport(){
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function  verifyby(){
        return $this->belongsTo(User::class,'verify_by','id');
    }

    public function  reject_by(){

        return $this->belongsTo(User::class,'reject_by');
    }

}
