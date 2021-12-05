<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SimBills extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "sim_bills";
    protected $fillable = [
        'account_number',
        'party_id',
        'product_type',
        'invoice_number',
        'invoice_date',
        'service_rental',
        'usage_charge',
        'one_time_charges',
        'other_credit_and_charges',
        'vat_on_taxable_services',
        'billed_amount',
        'total_amount_due',
        'amount_to_pay',
        'sim_bill_upload_path_id',
    ];

    public function sim_detail(){
        return $this->belongsTo(Telecome::class,'account_number','account_number');
    }
}


