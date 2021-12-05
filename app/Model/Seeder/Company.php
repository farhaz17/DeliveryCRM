<?php

namespace App\Model\Seeder;

use App\Model\Cities;
use App\Model\Agreement\Agreement;
use Illuminate\Database\Eloquent\Model;
use App\Model\Offer_letter\Offer_letter;
use OwenIt\Auditing\Contracts\Auditable;

class Company extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public function agreement(){
        return $this->belongsTo(Agreement::class);
    }

    public function offer_letters(){

        return $this->hasMany(Offer_letter::class,'company');
    }

    public function total_apply_visa_company(){
        return $this->hasMany(Agreement::class,'applying_visa');
    }

    public function total_apply_visa_company_not_employee(){
        return $this->total_apply_visa_company()->where('employee_type_id','=','1')->count();
    }

    public function total_apply_visa_company_full_time(){
        return $this->total_apply_visa_company()->where('employee_type_id','=','2')->count();
    }
    public function total_apply_visa_company_part_time(){
        return $this->total_apply_visa_company()->where('employee_type_id','=','3')->count();
    }


    public function comp_info(){
       return $this->hasOne(CompanyInformation::class,'company_id');
    }

    public function state()
    {
        return $this->belongsTo('App\Model\Cities');
    }
    public function stablishment_card()
    {
        return $this->hasMany('App\Model\Master\Company\EEstablishment');
    }
    public function traffic()
    {
        return $this->hasMany('App\Model\Master\Company\Traffic');
    }
        public function salik()
    {
        return $this->hasMany('App\Model\Master\Company\Salik');
    }
    public function labour_card()
    {
        return $this->hasMany('App\Model\Master\Company\LabourCard');
    }
    public function electricity_water()
    {
        return $this->hasMany('App\Model\Master\Company\MasterUtilityElectricityWater');
    }
    public function etisalat()
    {
        return $this->hasMany('App\Model\Master\Company\Etisalat');
    }
    public function du()
    {
        return $this->hasMany('App\Model\Master\Company\Du');
    }    
    public function moa()
    {
        return $this->hasMany('App\Model\Master\Company\Moa');
    }
    public function mol_no()
    {
        return $this->hasOne('App\Model\Master\Company\LabourCard');
    }
    public function moi_no()
    {
        return $this->hasOne('App\Model\Master\Company\EEstablishment');
    }
}
