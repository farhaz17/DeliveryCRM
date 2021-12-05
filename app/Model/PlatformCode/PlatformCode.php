<?php

namespace App\Model\PlatformCode;

use App\Model\Platform;
use App\Model\Passport\Passport;
use App\Model\UserCodes\UserCodes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\PlatformCode\PlatformCodeUpdateHistory;

class PlatformCode extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'passport_id', 'platform_id', 'platform_code'
    ];

    public function platform_name()
    {
        return $this->belongsTo(Platform::class,'platform_id');
    }

    public function zds_code()
    {
        return $this->hasOne(UserCodes::class,'passport_id','passport_id');
    }

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function update_histories()
    {
        return $this->hasMany(PlatformCodeUpdateHistory::class, 'platform_code_id');
    }
}
