<?php

namespace App\Model;

use App\User;
use App\Model\Seeder\Company;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;


class VisaApplication extends Model  
{

    public function passport()
    {
        return $this->belongsTo(Passport::class, 'passport_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'visa_company_id');
    }
}
