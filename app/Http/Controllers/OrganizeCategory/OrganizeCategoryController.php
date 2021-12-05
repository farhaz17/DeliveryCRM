<?php

namespace App\Http\Controllers\OrganizeCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\CustomerSupplier\CustomerSupplierCategory;
use App\Model\Master\CustomerSupplier\CustomerSupplierSubCategory;
use App\Model\Master\Vehicle\VehicleCategory;

class OrganizeCategoryController extends Controller
{
    public function create_vehicle_category()
    {
        $vehicle_categories = VehicleCategory::with('sub_category')->get();
        return view('admin-panel.category_dashboard.create_vehicle_category', compact('vehicle_categories'));
    }

    public function create_supplier_category()
    {
        $customerSupplierCategory = CustomerSupplierCategory::with('sub_categories')->get();
        $customerSupplierSubCategory = CustomerSupplierSubCategory::all();
        return view('admin-panel.category_dashboard.create_supplier_category', compact('customerSupplierCategory', 'customerSupplierSubCategory'));
    }
}
