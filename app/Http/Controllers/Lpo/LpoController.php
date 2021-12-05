<?php

namespace App\Http\Controllers\Lpo;

use App\Model\Parts;
use App\Model\Cities;
use App\Model\InvParts;
use App\Model\BikeDetail;
use App\Model\Lpo\SalikTag;
use App\Model\Lpo\LpoCheque;
use App\Model\Lpo\LpoMaster;
use Illuminate\Http\Request;
use App\Imports\SalikImports;
use App\Model\Lpo\LpoInvoice;
use App\Model\Lpo\LpoPayment;
use App\Model\Seeder\Company;
use App\Model\Lpo\LpoContract;
use App\Imports\LpoSpareImport;
use App\Model\Lpo\LpoSpareInfo;
use App\Model\Lpo\LpoVehicleInfo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\Lpo\LpoInventoryModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LpoVehicleInfoImport;
use App\Model\Master\Company\Traffic;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\Vehicle\VehicleModel;
use App\Model\Master\Vehicle\VehicleInsurance;
use App\Model\Master\CustomerSupplier\CustomerSupplier;

class LpoController extends Controller
{
    public function create_lpo_contract() {
        $cities = Cities::all();
        $rental_supplier = CustomerSupplier::where('contact_category_id', 1)->get();
        $lease_supplier = CustomerSupplier::where('contact_category_id', 2)->get();
        $companies = Company::all();
        return view('admin-panel.lpo.create_lpo_contract', compact('rental_supplier', 'lease_supplier', 'cities', 'companies'));
    }

    public function store_lpo_contract(Request $request) {

        $validator = Validator::make($request->all(), [
            'contract_no' => 'required',
            'supplier_id' => 'required',
            'supplier_category_id' => 'required',
            'attachment'  => 'max:1024'
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }

        $fileName = '';
        if($request->file()) {
            $fileName = rand(100,100000).'.'.time().'.'.$request->attachment->extension();
            $request->attachment->move(public_path('/assets/upload/lpo/'), $fileName);
        }

        $obj = new LpoContract();
        $obj->supplier_category_id = $request->supplier_category_id;
        $obj->supplier_id = $request->supplier_id;
        $obj->company_id = $request->company_id;
        $obj->contract_no = $request->contract_no;
        $obj->quantity = $request->quantity;
        $obj->state = json_encode($request->state_id);
        $obj->create_date = $request->create_date;
        $obj->attachment = $fileName;
        $obj->created_user_id = Auth::user()->id;
        $obj->save();

        $message = [
            'message' => 'Contract Added Successfully',
            'alert-type' => 'success'

        ];

        return back()->with($message);
    }

    public function report_lpo_contract() {
        $report = LpoContract::with('supplier:id,contact_name')->get();
        return view('admin-panel.lpo.report_lpo_contract', compact('report'));
    }

    public function create_master_lpo() {
        $rental_supplier = CustomerSupplier::where('contact_category_id', 1)->get();
        $lease_supplier = CustomerSupplier::where('contact_category_id', 2)->get();
        $supplier = CustomerSupplier::all();
        $companies = Company::all();
        $rental_contract = LpoContract::where('supplier_id', 1)->get();
        $lease_contract = LpoContract::where('supplier_id', 2)->get();
        $vehicle_models = VehicleModel::all();
        $parts = Parts::all();
        $cheques = LpoCheque::where('assigned_to', NULL)->where('cheque_type', 3)->get();
        return view('admin-panel.lpo.create_master_lpo', compact('rental_supplier', 'lease_supplier', 'supplier', 'companies', 'rental_contract', 'lease_contract', 'vehicle_models', 'parts', 'cheques'));
    }

    public function store_master_lpo(Request $request) {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'contract_id' => 'required_if:purchase_type,1,2',
            'supplier_id' => 'required_if:purchase_type,1,2',
            'inventory.*.model_id' => 'required_if:purchase_type,2,3',
            'inventory.*.vehicle_quantity' => 'required_if:purchase_type,2,3',
            'inventory.*.model_id' => 'required_if:inventory_type,2',
            'inventory.*.spare_quantity' => 'required_if:inventory_type,2',
            'attachment'  => 'max:1024',
            'lpo_no' => 'required|unique:lpo_masters'
        ]);

        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }

        //Check LPO quantity exceeds contract quantity
        if($request->purchase_type == 2) {

            $quantity = LpoContract::where('id', $request->contract_id)->value('quantity');
            $lpo_quantity = 0;
            $quantity_sum = 0;

            $existing_quantity = LpoMaster::with('inventory_model')->where('contract_id', $request->contract_id)->get();
            foreach($existing_quantity as $quant) {
                foreach($quant->inventory_model as $q) {
                    $quantity_sum += $q->quantity;
                }
            }

            foreach($request->inventory as $key => $value) {
                $lpo_quantity += $request->inventory[$key]['vehicle_quantity'];
            }

            $total_quantity = $quantity_sum + $lpo_quantity;

            if($lpo_quantity > $total_quantity) {
                $message = [
                    'message' => 'LPO Quantity exceeds quantity mentioned in Contract',
                    'alert-type' => 'error',
                    'error' => ''
                ];
                return back()->with($message);
            }

        }

        $quantity = '';
        if($request->quantity) {
            $quantity = $request->quantity;
        }

        if($request->inventory_type == 1) {
            $model_type = 'App\Model\Master\Vehicle\VehicleModel';
        }
        if($request->inventory_type == 2) {
            $model_type = 'App\Model\Parts';
        }

        $attachment = '';
        if($request->file()) {
            $attachment = rand(100,100000).'.'.time().'.'.$request->attachment->extension();
            $request->attachment->move(public_path('/assets/upload/lpo/'), $attachment);
        }

        $obj = new LpoMaster();
        $obj->inventory_type = $request->inventory_type;
        $obj->purchase_type = $request->purchase_type;
        $obj->supplier_id = $request->supplier_id;
        $obj->contract_id = $request->contract_id;
        $obj->company_id = $request->company_id;
        $obj->quantity = $quantity;
        $obj->amount = $request->amount;
        $obj->start_date = $request->start_date;
        $obj->lpo_no = $request->lpo_no;
        $obj->lpo_attachment = $attachment;
        $obj->created_user_id = Auth::user()->id;
        $obj->save();

        if($request->cheque_id) {
            foreach($request->cheque_id as $cheque) {
                $cheque_update = LpoCheque::where('id', $cheque)->update(['assigned_to' => $obj->id]);
                $obj_pay = new LpoPayment();
                $obj_pay->payment_method = 3;
                $obj_pay->lpo_id = $obj->id;
                $obj_pay->cheque_id = $cheque;
                $obj_pay->created_user_id = Auth::user()->id;
                $obj_pay->save();
            }
        }


        if($request->inventory_type == 2 || $request->purchase_type == 2 || $request->purchase_type == 3) {
            foreach($request->inventory as $key => $value) {

                if($request->inventory_type == 2) {
                    $quantity = $request->inventory[$key]['spare_quantity'];
                }
                else{
                    $quantity = $request->inventory[$key]['vehicle_quantity'];
                }

                $obj_inventory = new LpoInventoryModel();
                $obj_inventory->lpo_id = $obj->id;
                $obj_inventory->model_id = $request->inventory[$key]['model_id'];
                $obj_inventory->model_type = $model_type;
                $obj_inventory->quantity = $quantity;
                $obj_inventory->save();

            }
        }


        $message = [
            'message' => 'LPO Added Successfully',
            'alert-type' => 'success'
        ];

        return back()->with($message);
    }

    public function report_master_lpo() {

        // return $in = LpoInventoryModel::with('model')->get();
        $lpo = LpoMaster::with('supplier:id,contact_name', 'contract:id,contract_no', 'inventory_model')->get();
        // return $lpo[9]->inventory_model[0]->model()->name;
        return view('admin-panel.lpo.report_master_lpo', compact('lpo'));
    }

    public function create_lpo_invoice() {
        return view('admin-panel.lpo.create_lpo_invoice');
    }

    public function lpo_filter_invoice_lpo_no(Request $request) {
        $lpo = LpoMaster::where('inventory_type', $request->inventoryType)->get();
        return response()->json($lpo, 200);
    }

    public function store_lpo_invoice(Request $request) {

        // return $request->all();
        $validator = Validator::make($request->all(), [
            'invoice_no' => 'required|unique:lpo_invoices',
            'lpo_id' => 'required',
        ]);

        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }

        $fileName = '';
        if($request->file()) {
            $fileName = rand(100,100000).'.'.time().'.'.$request->attachment->extension();
            $request->attachment->move(public_path('/assets/upload/lpo/'), $fileName);
        }

        $obj = new LpoInvoice();
        $obj->lpo_id = $request->lpo_id;
        $obj->invoice_no = $request->invoice_no;
        $obj->amount = $request->amount;
        $obj->vat = $request->vat;
        $obj->invoice_date = $request->invoice_date;
        $obj->quantity = $request->quantity;
        $obj->attachment = $fileName;
        $obj->created_user_id = Auth::user()->id;
        $obj->save();

        $lpo = LpoMaster::where('id', $request->lpo_id)->update(['process' => 1]);

        $message = [
            'message' => 'Invoices Successfully',
            'alert-type' => 'success'
        ];

        return back()->with($message);

    }

    public function ajax_lpo_inventory_details(Request $request) {
        $details = LpoInventoryModel::with('model')->where('lpo_id', $request->id)->get();
        return response()->json($details, 200);
    }


    public function create_company_lpo() {
        return view('admin-panel.lpo.create_company_lpo');
    }

    public function create_emi() {
        $cheques = LpoCheque::where('assigned_to', NULL)->get();
        return view('admin-panel.lpo.create_emi', compact('cheques'));
    }

    public function store_emi(Request $request) {

        if($request->money_transfer) {
            $obj = new LpoPayment();
            $obj->payment_method = 1;
            $obj->lpo_id = $request->lpo_id;
            $obj->amount = $request->money_transfer_amount;
            $obj->created_user_id = Auth::user()->id;
            $obj->save();
        }

        if($request->cash) {
                $obj = new LpoPayment();
                $obj->payment_method = 2;
                $obj->lpo_id = $request->lpo_id;
                $obj->amount = $request->cash_amount;
                $obj->created_user_id = Auth::user()->id;
                $obj->save();
        }

        if($request->cheque) {
            foreach($request->cheque_id as $cheque) {
                $cheque = LpoCheque::where('id', $cheque)->update(['assigned_to' => $request->lpo_id]);
                $obj = new LpoPayment();
                $obj->payment_method = 3;
                $obj->lpo_id = $request->lpo_id;
                $obj->cheque_id = $cheque;
                $obj->created_user_id = Auth::user()->id;
                $obj->save();
            }
        }

        $message = [
            'message' => 'Payment Added Successfully',
            'alert-type' => 'success'
        ];

        return back()->with($message);

    }

    public function ajax_fetch_lpo_cheque(Request $request) {
        $lpo_cheque = LpoPayment::where('lpo_id', $request->lpo)->with('cheque')->get();
        return response()->json($lpo_cheque, 200);
    }

    public function report_cheque() {

        $cheque = LpoCheque::with('lpo')->get();
        return view('admin-panel.lpo.report_cheque', compact('cheque'));

    }

    public function create_cheque() {
        $supplier = CustomerSupplier::all();
        $companies = Company::all();
        return view('admin-panel.lpo.create_cheque', compact('companies', 'supplier'));
    }

    public function create_salik_tags() {

        return view('admin-panel.lpo.create_salik_tags');
    }

    public function store_salik_tags(Request $request) {

        $validator = Validator::make($request->all(), [
            'tag_no'  => 'required'
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }

        $obj = new SalikTag();
        $obj->tag_no = $request->tag_no;
        $obj->save();

        $message = [
            'message' => 'Salik Tag Added Successfully',
            'alert-type' => 'success'
        ];

        return back()->with($message);
    }

    public function upload_salik_tags(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'salik_upload' => 'required|mimes:xls,xlsx',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        $rows_to_be_updated = head(Excel::toArray(new \App\Imports\SalikImports(''), request()->file('salik_upload')));
        // dd($rows_to_be_updated);
        $salik_tag = [];
        foreach($rows_to_be_updated as $key => $row){
            if(!empty($row[0])){
                $tags  = SalikTag::where('tag_no',$row[0])->first();
                if($tags != null){
                    $salik_tag[] = $row[0];
                }
            }
        }
        if(count($salik_tag) > 0){
            $message = [
                'message' => "Excel Upload failed",
                'alert-type' => 'error',
                'salik_tag' => implode(',' , $salik_tag)
            ];
            return redirect()->back()->with($message);
        }else{
            if (!file_exists('../public/assets/upload/excel_file/salik_upload')) {
                mkdir('../public/assets/upload/excel_file/salik_upload', 0777, true);
            }

            if(!empty($_FILES['salik_upload']['name'])) {
                $ext = pathinfo($_FILES['salik_upload']['name'], PATHINFO_EXTENSION);
                $file_path_image = 'assets/upload/excel_file/salik_upload/' . date("Y-m-d") . '/';
                $fileName = $file_path_image . time().'.'.$request->salik_upload->extension();
                Storage::disk('s3')->put($fileName, file_get_contents($request->salik_upload));
            }
            Excel::import(new \App\Imports\SalikImports($fileName), request()->file('salik_upload'));
            $message = [
                'message' => 'Uploaded Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        }
    }

    public function report_salik_tags() {
        $report = SalikTag::get();
        return view('admin-panel.lpo.report_salik_tags', compact('report'));
    }

    public function store_cheque(Request $request) {
        // return $request->all();

        $validator = Validator::make($request->all(), [
            'attachment'  => 'max:1024'
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }

        $fileName = '';
        if($request->file()) {
            $fileName = rand(100,100000).'.'.time().'.'.$request->attachment->extension();
            $request->attachment->move(public_path('/assets/upload/lpo/'), $fileName);
        }

        $obj = new LpoCheque();
        $obj->bank_name = $request->bank;
        $obj->account_no = $request->account_no;
        $obj->company_id = $request->company_id;
        $obj->created_user_id = Auth::user()->id;
        $obj->amount = $request->amount;
        $obj->pdc_date = $request->pdc_date;
        $obj->cheque_no = $request->cheque_no;
        $obj->attachment = $fileName;
        $obj->cheque_type = $request->cheque_type;
        $obj->category = $request->category;
        $obj->save();

        $message = [
            'message' => 'Cheque Added Successfully',
            'alert-type' => 'success'
        ];

        return back()->with($message);
    }

    public function ajax_filter_lpo_emi(Request $request) {
        $lpo = LpoMaster::where('purchase_type', $request->purchase_type)->get();
        return response()->json($lpo, 200);
    }

    public function ajax_filter_lpo_vehicle_info(Request $request) {
        $lpo = LpoMaster::where('inventory_type', $request->inventory_type)->get();
        return response()->json($lpo, 200);
    }

    // public function ajax_filter_lpo_cheque(Request $request) {
    //     $lpo = LpoMaster::where('purchase_type', $request->purchase_type)->get();
    //     return response()->json($lpo, 200);
    // }

    public function create_lpo_vehicle() {
        return view('admin-panel.lpo.create_lpo_vehicle');
    }

    public function store_lpo_vehicle(Request $request) {

        if($request->inventory_type == 1){
            Excel::import(new LpoVehicleInfoImport($request->lpo_no), request()->file('vehicle_info'));
        }
        if($request->inventory_type == 2){
            Excel::import(new LpoSpareImport($request->lpo_no), request()->file('vehicle_info'));
        }

        $message = [
            'message' => 'Details Added Successfully',
            'alert-type' => 'success'
        ];

        return back()->with($message);
    }


    public function vehicle_receive() {
        $lpos = LpoMaster::where('inventory_type', 2)->get();
        return view('admin-panel.lpo.vehicle_receive', compact('lpos'));
    }

    public function lpo_filter_vehicle_receive(Request $request) {

        if($request->val == 1){
            $lpo = LpoVehicleInfo::select('lpo_vehicle_infos.*', 'lpo_masters.lpo_no')
                            ->with('model')
                            ->join('lpo_masters', 'lpo_masters.id', '=', 'lpo_vehicle_infos.lpo_id')
                            ->where('lpo_masters.purchase_type', 1)
                            ->where('received', NULL);
            if($request->lpo_id) {
                $lpo = $lpo->where('lpo_id', $request->lpo_id);
            }
            $lpo = $lpo->get();
            $table = Datatables::of($lpo)
                        ->addColumn('action', function ($query) {
                            return '<a href="javascript:void(0)" id="vccModal" data-toggle="modal" class="btn btn-success btn-sm vcc-modal" data-id="'.$query->id.'" data-target="#receiveVehicle">Mark as received</a>';
                        });
            return $table->make(true);
        }
        if($request->val == 2){
            $lpo = LpoVehicleInfo::select('lpo_vehicle_infos.*', 'lpo_masters.lpo_no')
                            ->with('model')
                            ->join('lpo_masters', 'lpo_masters.id', '=', 'lpo_vehicle_infos.lpo_id')
                            ->where('vcc_attachment', '!=', NULL)
                            ->where('insurance_id', '!=', NULL)
                            ->where('plate_no', '!=', NULL)
                            ->where('received', NULL)
                            ->where('lpo_masters.purchase_type', 2);
            if($request->lpo_id) {
                $lpo = $lpo->where('lpo_id', $request->lpo_id);
            }
            $lpo = $lpo->get();
            $table = Datatables::of($lpo)
                        ->addColumn('action', function ($query) {
                            return '<a href="javascript:void(0)" id="vccModal" data-toggle="modal" class="btn btn-success btn-sm vcc-modal" data-id="'.$query->id.'" data-target="#receiveVehicle">Mark as received</a>';
                        });
            return $table->make(true);
        }
        if($request->val == 3){
            $lpo = LpoVehicleInfo::select('lpo_vehicle_infos.*', 'lpo_masters.lpo_no')
                            ->with('model')
                            ->join('lpo_masters', 'lpo_masters.id', '=', 'lpo_vehicle_infos.lpo_id')
                            ->where('vcc_attachment', '!=', NULL)
                            ->where('insurance_id', '!=', NULL)
                            ->where('plate_no', '!=', NULL)
                            ->where('received', NULL)
                            ->where('lpo_masters.purchase_type', 3);
            if($request->lpo_id) {
                $lpo = $lpo->where('lpo_id', $request->lpo_id);
            }
            $lpo = $lpo->get();
            $table = Datatables::of($lpo)
                        ->addColumn('action', function ($query) {
                            return '<a href="javascript:void(0)" id="vccModal" data-toggle="modal" class="btn btn-success btn-sm vcc-modal" data-id="'.$query->id.'" data-target="#receiveVehicle">Mark as received</a>';
                        });
            return $table->make(true);
        }

    }

    public function lpo_filter_spare_receive(Request $request) {

            $lpo = LpoSpareInfo::with('model')
                    ->select('lpo_spare_infos.*', 'lpo_masters.lpo_no')
                    ->join('lpo_masters', 'lpo_masters.id', '=', 'lpo_spare_infos.lpo_id')
                    ->where('received', 0);
            if($request->lpo_id) {
                $lpo = $lpo->where('lpo_id', $request->lpo_id);
            }
            $lpo = $lpo->get();
            $table = Datatables::of($lpo)
                        ->addColumn('quantity_pending', function ($query) {
                            return $query->quantity - $query->quantity_received;
                        })
                        ->addColumn('action', function ($query) {
                            return '<a href="javascript:void(0)" id="vccModal" data-toggle="modal" class="btn btn-success btn-sm vcc-modal" data-id="'.$query->id.'" data-target="#receiveSpare">Mark as received</a>';
                        });
            return $table->make(true);

    }

    public function lpo_vehicle_received(Request $request) {

        $bike = LpoVehicleInfo::where('id', $request->vehicle_info)->first();

        DB::beginTransaction();
        try {
            $received = LpoVehicleInfo::where('id', $request->vehicle_info)->update(['received' => 1]);

            $obj = new BikeDetail();
            $obj->model = $bike->model_id;
            $obj->chassis_no = $bike->chassis_no;
            $obj->make_year = $bike->make_year;
            $obj->engine_no = $bike->engine_no;
            $obj->insurance_co = $bike->insurance_id;
            $obj->insurance_no = $bike->insurance_id;
            $obj->traffic_file = $bike->traffic_file_id;
            $obj->plate_no = $bike->plate_no;
            $obj->save();

            DB::commit();

            $message = [
                'message' => 'Added Successfully',
                'alert-type' => 'success',
                'code' => 201
            ];


        } catch (\Exception $e) {
            DB::rollback();
            $message = [
                'message' => 'Failed',
                'alert-type' => $e,
                'code' => 200
            ];

        }


        return response()->json($message, 200);
        // return back()->with($message);
    }

    public function lpo_spare_received(Request $request) {
        $spare = LpoSpareInfo::where('id', $request->vehicle_info)->first();
        // $quantity_to_receive = $spare->quantity - $spare->quantity_received;
        $quantity_received = $request->quantity +  $spare->quantity_received;

        if($quantity_received > $spare->quantity) {
            $message = [
                'message' => 'Quantity entered is more than quantity to be received',
                'alert-type' => 'error',
                'code' => '202'
            ];

            return response()->json($message, 200);
        }

        if($quantity_received == $spare->quantity) {
            $received = 1;
        }
        else {
            $received = 0;
        }

        $parts = InvParts::where('parts_id', $spare->parts_id)->first();

        DB::beginTransaction();
        try {
            $received = LpoSpareInfo::where('id', $request->vehicle_info)->update(['quantity_received' => $quantity_received, 'received' => $received]);

            if($parts == NULL) {
                $obj = new InvParts();
                $obj->parts_id = $spare->parts_id;
                $obj->quantity =  $request->quantity;
                $obj->save();
            }
            else {
                $inv_quantity = $parts->quantity + $request->quantity;
                $updated_spare = InvParts::where('parts_id', $spare->parts_id)->update(['quantity' => $inv_quantity]);
            }


            DB::commit();

            $message = [
                'message' => 'Quantity Added Successfully',
                'alert-type' => 'success',
                'code' => 201
            ];

        } catch (\Exception $e) {
            DB::rollback();
            $message = [
                'message' => 'Failed',
                'alert-type' => 'error',
                'code' => 200
            ];
        }

        return response()->json($message, 200);
    }

    public function report_lpo_received_vehicle(Request $request) {
        return view('admin-panel.lpo.report_lpo_received_vehicle');
    }

    public function report_lpo_dashboard(Request $request) {
        $supplier = CustomerSupplier::all();
        return view('admin-panel.lpo.report_lpo_dashboard', compact('supplier'));
    }

    public function lpo_ajax_dashboard_report(Request $request) {

        // $contracts = LpoContract::get();
        // $lpos = LpoMaster::where('inventory_type', 1)->get();
        // $bikes_received = LpoVehicleInfo::where('received', 1)->get();

        // $bikes_requested_rental = LpoMaster::where('inventory_type', 1)->where('purchase_type', 1)->sum('quantity');
        // $bikes_requested_lease = LpoInventoryModel::where('lpo_masters.inventory_type', 1)
        //                         ->select('lpo_inventory_models.*')
        //                         ->join('lpo_masters', 'lpo_masters.id', '=', 'lpo_inventory_models.lpo_id')
        //                         ->where('lpo_masters.purchase_type', 2)
        //                         ->sum('lpo_inventory_models.quantity');

        // $bikes_requested_company = LpoInventoryModel::where('lpo_masters.inventory_type', 1)
        //                         ->select('lpo_inventory_models.*')
        //                         ->join('lpo_masters', 'lpo_masters.id', '=', 'lpo_inventory_models.lpo_id')
        //                         ->where('lpo_masters.purchase_type', 3)
        //                         ->sum('lpo_inventory_models.quantity');

        // $bikes_requested = $bikes_requested_rental + $bikes_requested_lease + $bikes_requested_company;

        //Contract created
        $contracts =  LpoContract::select();
        if($request->purchaseType) {
            $contracts = $contracts->where('supplier_category_id', $request->purchaseType);
        }
        if($request->supplierId) {
            $contracts = $contracts->where('supplier_id', $request->supplierId);
        }
        $contracts = $contracts->get();

        //LPOS Created
        $lpos = LpoMaster::where('inventory_type', 1);
        if($request->purchaseType) {
            $lpos = $lpos->where('purchase_type', $request->purchaseType);
        }
        if($request->supplierId) {
            $lpos = $lpos->where('supplier_id', $request->supplierId);
        }
        $lpos = $lpos->get();

        //Bikes Received
        $bikes_received = LpoVehicleInfo::join('lpo_masters', 'lpo_masters.id', '=', 'lpo_vehicle_infos.lpo_id')
                            ->where('received', 1);
        if($request->purchaseType) {
            $bikes_received = $bikes_received->where('lpo_masters.purchase_type', $request->purchaseType);
        }
        if($request->supplierId) {
            $bikes_received = $bikes_received->where('lpo_masters.supplier_id', $request->supplierId);
        }
        $bikes_received = $bikes_received->get();


        //Bikes Info
        $bikes_info = LpoVehicleInfo::join('lpo_masters', 'lpo_masters.id', '=', 'lpo_vehicle_infos.lpo_id');
        if($request->purchaseType) {
            $bikes_info = $bikes_info->where('lpo_masters.purchase_type', $request->purchaseType);
        }
        if($request->supplierId) {
            $bikes_info = $bikes_info->where('lpo_masters.supplier_id', $request->supplierId);
        }
        $bikes_info = $bikes_info->get();

        // Bikes Requested
        $bikes_requested_rental = LpoMaster::where('inventory_type', 1)->where('purchase_type', 1);
        if($request->supplierId) {
            $bikes_requested_rental =  $bikes_requested_rental->where('supplier_id', $request->supplierId);
        }
        $bikes_requested_rental = $bikes_requested_rental->sum('quantity');

        $bikes_requested_lease = LpoInventoryModel::where('lpo_masters.inventory_type', 1)
                                ->select('lpo_inventory_models.*')
                                ->join('lpo_masters', 'lpo_masters.id', '=', 'lpo_inventory_models.lpo_id')
                                ->where('lpo_masters.purchase_type', 2);
        if($request->supplierId) {
            $bikes_requested_lease =  $bikes_requested_lease->where('lpo_masters.supplier_id', $request->supplierId);
        }
        $bikes_requested_lease =  $bikes_requested_lease->sum('lpo_inventory_models.quantity');


        $bikes_requested_company = LpoInventoryModel::where('lpo_masters.inventory_type', 1)
                                ->select('lpo_inventory_models.*')
                                ->join('lpo_masters', 'lpo_masters.id', '=', 'lpo_inventory_models.lpo_id')
                                ->where('lpo_masters.purchase_type', 3);
        if($request->supplierId) {
            $bikes_requested_company =  $bikes_requested_company->where('lpo_masters.supplier_id', $request->supplierId);
        }
        $bikes_requested_company = $bikes_requested_company->sum('lpo_inventory_models.quantity');

        $bikes_requested = $bikes_requested_rental + $bikes_requested_lease + $bikes_requested_company;

        if($request->purchaseType == 1) {
            $bikes_requested = $bikes_requested_rental;
        }
        if($request->purchaseType == 2) {
            $bikes_requested = $bikes_requested_lease;
        }
        if($request->purchaseType == 3) {
            $bikes_requested = $bikes_requested_company;
        }

        // Lpo Amount
        $lpo_amount = LpoMaster::where('inventory_type', 1);
        if($request->purchaseType) {
            $lpo_amount = $lpo_amount->where('purchase_type', $request->purchaseType);
        }
        if($request->supplierId) {
            $lpo_amount = $lpo_amount->where('supplier_id', $request->supplierId);
        }
        $lpo_amount = $lpo_amount->sum('amount');

        //Spare Parts LPOS created
        $spare_lpos = LpoMaster::where('inventory_type', 2);
        if($request->spareSupplierId) {
            $spare_lpos = $spare_lpos->where('supplier_id', $request->spareSupplierId);
        }
        $spare_lpos = $spare_lpos->get();


        //Parts Received
        $parts_received = LpoSpareInfo::join('lpo_masters', 'lpo_masters.id', '=', 'lpo_spare_infos.lpo_id');
        if($request->spareSupplierId) {
            $parts_received = $parts_received->where('lpo_masters.supplier_id', $request->spareSupplierId);
        }
        $parts_received = $parts_received->sum('quantity_received');

        // Parts Requested
        $parts_requested = LpoInventoryModel::where('lpo_masters.inventory_type', 2)
                                ->select('lpo_inventory_models.*')
                                ->join('lpo_masters', 'lpo_masters.id', '=', 'lpo_inventory_models.lpo_id');

        if($request->spareSupplierId) {
            $parts_requested =  $parts_requested->where('lpo_masters.supplier_id', $request->spareSupplierId);
        }
        $parts_requested =  $parts_requested->sum('lpo_inventory_models.quantity');

        //Spare Lpo Amount
        $spare_lpo_amount = LpoMaster::where('inventory_type', 2);
        if($request->spareSupplierId) {
            $spare_lpo_amount = $spare_lpo_amount->where('supplier_id', $request->spareSupplierId);
        }
        $spare_lpo_amount = $spare_lpo_amount->sum('amount');

        $data = [
            'contracts' => count($contracts),
            'lpos' => count($lpos),
            'bikes_received' => count($bikes_received),
            'bikes_info' => count($bikes_info),
            'bikes_requested' => $bikes_requested,
            'lpo_amount' => $lpo_amount,
            'spare_lpos' => count($spare_lpos),
            'parts_received' => $parts_received,
            'parts_requested' => $parts_requested,
            'spare_lpo_amount' => $spare_lpo_amount,
        ];

        return response()->json($data, 200);

    }

    public function report_lpo_spare_receive(Request $request) {
        $lpo = LpoSpareInfo::with('model')->get();
        $table = Datatables::of($lpo)
                    ->addColumn('quantity_pending', function ($query) {
                        return $query->quantity - $query->quantity_received;
                    });
        return $table->make(true);
    }

    public function report_lpo_filter_vehicle_receive(Request $request) {

            $lpo = LpoVehicleInfo::select('lpo_vehicle_infos.*')
                            ->with('model')
                            ->join('lpo_masters', 'lpo_masters.id', '=', 'lpo_vehicle_infos.lpo_id')
                            ->where('lpo_masters.purchase_type', $request->val)
                            ->get();
            $table = Datatables::of($lpo)
                        ->addColumn('status', function ($query) {
                            if($query->received == 1)
                                return "received";
                            return "not received";
                        });
            return $table->make(true);
    }

    public function create_vcc_attachment() {
        $traffic_file = Traffic::all();
        $insurance = VehicleInsurance::all();
        return view('admin-panel.lpo.create_vcc_attachment', compact('traffic_file', 'insurance'));
    }

    public function lpo_vcc_attachment(Request $request) {

        $validator = Validator::make($request->all(), [
            'attachment'  => 'max:1024'
        ]);

        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }

        $fileName = '';
        if($request->file()) {
            $fileName = rand(100,100000).'.'.time().'.'.$request->attachment->extension();
            $request->attachment->move(public_path('/assets/upload/lpo/'), $fileName);
        }

        $vcc = LpoVehicleInfo::where('id', $request->vehicle_info)->update(['vcc_attachment' => $fileName]);

        $message = [
            'message' => 'Attachment Added Successfully',
            'alert-type' => 'success'
        ];

        return back()->with($message);
    }

    public function lpo_add_insurance(Request $request) {

        $insure = LpoVehicleInfo::where('id', $request->vehicle_info)->update([
            'insurance_id' => $request->insurance_id,
            'insurance_no' => $request->insurance_no,
            'traffic_file_id' => $request->traffic_file_id
            ]);

        $message = [
            'message' => 'Attachment Added Successfully',
            'alert-type' => 'success'
        ];

        return back()->with($message);
    }

    public function lpo_add_no_plate(Request $request) {

        $plate = LpoVehicleInfo::where('id', $request->vehicle_info)->update([
            'plate_no' => $request->plate_no
        ]);

        $message = [
            'message' => 'Attachment Added Successfully',
            'alert-type' => 'success'
        ];

        return back()->with($message);

    }

    public function lpo_filter_vcc_vehicle(Request $request) {

        if($request->val == 1){
            $lpo = LpoVehicleInfo::select('lpo_vehicle_infos.*')
                            ->where('lpo_vehicle_infos.vcc_attachment', NULL)
                            ->join('lpo_masters', 'lpo_masters.id', '=', 'lpo_vehicle_infos.lpo_id')
                            ->whereIn('lpo_masters.purchase_type', [2,3])
                            ->get();
            $table = Datatables::of($lpo)
                        ->addColumn('action', function ($query) {
                            return '<a href="javascript:void(0)" id="vccModal" data-toggle="modal" class="btn btn-success btn-sm vcc-modal" data-id="'.$query->id.'" data-target="#attachVcc">Attach VCC</a>';
                        });
            return $table->make(true);
        }
        if($request->val == 2){
            $lpo = LpoVehicleInfo::select('lpo_vehicle_infos.*')
                    ->where('vcc_attachment', '!=', NULL)
                    ->join('lpo_masters', 'lpo_masters.id', '=', 'lpo_vehicle_infos.lpo_id')
                    ->whereIn('lpo_masters.purchase_type', [2,3])
                    ->where('insurance_id', NULL)
                    ->get();
            $table = Datatables::of($lpo)
                        ->addColumn('action', function ($query) {
                            return '<a href="javascript:void(0)" data-toggle="modal" class="btn btn-success btn-sm vcc-modal" data-id="'.$query->id.'" data-target="#addInsurance">Add Insurance</a>';
                        });
            return $table->make(true);
        }
        if($request->val == 3){
            $lpo = LpoVehicleInfo::select('lpo_vehicle_infos.*')
                    ->where('vcc_attachment', '!=', NULL)
                    ->where('insurance_id', '!=', NULL)
                    ->join('lpo_masters', 'lpo_masters.id', '=', 'lpo_vehicle_infos.lpo_id')
                    ->whereIn('lpo_masters.purchase_type', [2,3])
                    ->where('plate_no', NULL)
                    ->get();
            $table = Datatables::of($lpo)
                        ->addColumn('action', function ($query) {
                            return '<a href="javascript:void(0)" data-toggle="modal" class="btn btn-success btn-sm vcc-modal" data-id="'.$query->id.'" data-target="#noPlate">Plate Registration</a>';
                        });
            return $table->make(true);
        }


    }


    public function vehicle_assignment_company() {
        return view('admin-panel.lpo.vehicle_assignment_company');
    }

    public function vehicle_assignment_insurance() {
        return view('admin-panel.lpo.vehicle_assignment_insurance');
    }

    public function plate_registration() {
        return view('admin-panel.lpo.plate_registration');
    }

}
