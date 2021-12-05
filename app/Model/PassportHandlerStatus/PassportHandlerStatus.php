<?php

namespace App\Model\PassportHandlerStatus;

use App\Model\Passport\Passport;
use App\Model\Seeder\PassportHandler;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PassportHandlerStatus extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "passport_handler_statuses";
    protected $fillable = [
        'passport_id',
        'passport_handler_id',
        'remarks',
    ];

    public function passport_detail()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function passport_status()
    {
        return $this->belongsTo(PassportHandler::class,'passport_handler_id');
    }



}
