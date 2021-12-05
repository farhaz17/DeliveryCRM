<?php

namespace App\Model;

use App\Model\Master\Company\Salik;
use Illuminate\Database\Eloquent\Model;
use App\Model\Seeder\CompanyInformation;
use OwenIt\Auditing\Contracts\Auditable;

class Vehicle_salik_sheet_account extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable=['account_no','start_date','end_date','file_path'];


    public function get_company_info(){
       return $this->belongsTo(CompanyInformation::class,'account_no');
    }

    public function get_account_no(){
        return $this->belongsTo(Salik::class,'account_no');
     }

    public function salik_detail(){
        return $this->hasMany(Vehicle_salik::class);
    }

    public function get_total_amount(){
        return $this->salik_detail()->sum('amount');
    }
    public function get_total_bikes(){
        return $this->salik_detail()->count();
    }


}
