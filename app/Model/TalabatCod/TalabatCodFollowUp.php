<?php

namespace App\Model\TalabatCod;

use App\User;
use App\Model\Passport\Passport;
use App\Model\TalabatCod\TalabatCod;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TalabatCodFollowUp extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable = ['user_id', 'passport_id', 'talabat_cod_id', 'feedback_id', 'remarks'];
    protected $with = ['creator','passport.personal_info','talabat_cod'];
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function passport()
    {
        return $this->belongsTo(Passport::class, 'passport_id');
    }
    public function talabat_cod()
    {
        return $this->belongsTo(TalabatCod::class, 'talabat_cod_id');
    }
}
