<?php

namespace App\Http\Controllers\Lpo;

use Illuminate\Http\Request;
use App\Model\Lpo\BikeMissing;
use App\Http\Controllers\Controller;
use App\Model\BikeImpounding\BikeImpoundingUpload;

class AccountsDashboardController extends Controller
{
    public function accounts_dashboard() {
        return view('admin-panel.accounts.dashboard');
    }

    public function insurance_claim_report() {
        $report = BikeMissing::with('bike')->where('payment_amount', '!=', NULL)->get();
        $amount = BikeMissing::where('payment_amount', '!=', NULL)->sum('payment_amount');
        return view('admin-panel.accounts.insurance_claim_report', compact('report', 'amount'));
    }

    public function bike_impound_report() {
        $report = BikeImpoundingUpload::where('fine_date', '!=', NULL)->get();
        $amount = BikeImpoundingUpload::where('fine_date', '!=', NULL)->sum('value_instead_of_booking');
        return view('admin-panel.accounts.bike_impound_report', compact('report', 'amount'));
    }
}
