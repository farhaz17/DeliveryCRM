<?php

namespace App\Http\Controllers\PassportHandler;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PassportDashboardController extends Controller
{
    public function passport_handler_dashboard() {
        return view('admin-panel.passport_collect.passport_dashboard');
    }
}
