<?php

namespace App\Http\Controllers\Master\Vehicle;

use App\Model\BikeCencel;
use App\Model\BikeDetail;
use Illuminate\Http\Request;
use App\Model\BikeDetailHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\Vehicle\AttachmentLabel;
use App\Model\Master\Vehicle\VehiclePlateReplace;

class VehiclePlateReplaceController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|RTAManage');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plate_repalce_requests = VehiclePlateReplace::all();
        return view('admin-panel.vehicle_master.vehicle_plate_replace_request_list', compact('plate_repalce_requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_bike_details = BikeDetail::whereNotIn('id', BikeCencel::pluck('bike_id'))
            ->whereNotIn('plate_no',VehiclePlateReplace::whereIn('status',[0])->pluck('plate_no'))
            ->get();
        $labels = AttachmentLabel::all();
        return view('admin-panel.vehicle_master.vehicle_plate_replace_create', compact('all_bike_details','labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            // '' => ''
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
        try {  
            $bike_exist = BikeDetail::find($request->bike_id);
            $replace_request_exist = VehiclePlateReplace::whereNotIn('id',[1])->wherePlateNo($bike_exist->plate_no)->first();
            if(!$replace_request_exist){
                $obj = new VehiclePlateReplace();
                $obj->plate_no = $bike_exist->plate_no;
                $obj->new_plate_no = $request->new_plate_no;
                $obj->bike_id = $bike_exist->id;
                $obj->reson_of_replacement = $request->reson_of_replacement;
                $obj->remarks = $request->remarks;
                $obj->save();

                $obj->attachment_labels = isset($request->attachment_labels) ? json_encode($request->attachment_labels) : null;
                // attachment_labels and attachment_files upload
                $attachment_paths = [];
                if($request->hasFile('attachment_files')){
                    foreach($request->attachment_files as $key => $attachment_file){
                        if (!file_exists('../public/assets/upload/plate_replace/attachment_files/'.$obj->id.'/')) {
                            mkdir('../public/assets/upload/plate_replace/attachment_files/'.$obj->id.'/', 0777, true);
                        }
                            $ext = pathinfo($_FILES['attachment_files']['name'][$key], PATHINFO_EXTENSION);
                            $file_name = time() . "_" . $key . '.' . $ext;
                            move_uploaded_file($_FILES["attachment_files"]["tmp_name"][$key], '../public/assets/upload/plate_replace/attachment_files/'. $obj->id .'/' . $file_name);
                            $file_path = 'assets/upload/plate_replace/attachment_files/' . $obj->id .'/'. $file_name;
                            // $obj->attachment_files ? file_exists($obj->attachment_files) ? unlink($obj->attachment_labels) : "" : "";
                            $attachment_paths[] = $file_path;
                            // $obj->attachment_labels = $file_path;
                        }
                }
                // attachment_paths upload
                $obj->attachment_paths = count($attachment_paths) > 0 ? json_encode($attachment_paths) : null;
                $obj->update();
                $message = [
                    'message' => "Plate No Replace Request Successful",
                    'alert-type' => 'success'
                ];
                return back()->with($message);
            }else{
                $message = [
                    'message' => "Plate No Replace Request already exist",
                    'alert-type' => 'error'
                ];
                return back()->with($message);  
            }
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Master\Vehicle\VehiclePlateReplace  $vehiclePlateReplace
     * @return \Illuminate\Http\Response
     */
    public function show(VehiclePlateReplace $vehiclePlateReplace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Master\Vehicle\VehiclePlateReplace  $vehiclePlateReplace
     * @return \Illuminate\Http\Response
     */
    public function edit(VehiclePlateReplace $vehiclePlateReplace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Master\Vehicle\VehiclePlateReplace  $vehiclePlateReplace
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehiclePlateReplace $vehiclePlateReplace)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Master\Vehicle\VehiclePlateReplace  $vehiclePlateReplace
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehiclePlateReplace $vehiclePlateReplace)
    {
        //
    }

    // Extra functions other then resource function

    public function vehicle_plate_replace_documents()
    {
        $plate_repalce_requests = VehiclePlateReplace::all();
        return view('admin-panel.vehicle_master.vehicle_plate_replace_request_documents', compact('plate_repalce_requests'));
    }

    public function reject_request(Request $request, VehiclePlateReplace  $reject_request)
    {
        try {  
            
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }
    
    public function get_bike_detail_for_cancellation_with_bike_id(Request $request)
    {
        $bike_detail =  BikeDetail::find($request->bike_id);
        if($bike_detail->traffic->traffic_for == 1){
            $bike_detail->company_name = $bike_detail->traffic->company->name ?? "";
        }
        elseif($bike_detail->traffic->traffic_for == 2){
            $bike_detail->company_name = $bike_detail->traffic->passport_info->personal_info->fullname ?? "";
        }
        elseif($bike_detail->traffic->traffic_for == 3){
            $bike_detail->company_name = $bike_detail->traffic->customer_supplier_info->contact_name ?? "";
        }
        return [
            'model' => is_numeric($bike_detail->model) ? $bike_detail->model_info->name : $bike_detail->model, // model ids have not updated yet
            'chassis_no' => $bike_detail->chassis_no,
            'vehicle_current_plate_no' => $bike_detail->plate_no,
            'company_name' =>  $bike_detail->company_name,
            'traffic_file_no'=> $bike_detail->traffic ? $bike_detail->traffic->traffic_file_no : '',
            'vehicle_working_status' =>$bike_detail->status
        ];
    }
    public function get_bike_detail_with_bike_id(Request $request)
    {
        $bike_exist =  BikeDetail::whereId($request->bike_id)->whereIn('status',[0,2,3])->first();
        if($bike_exist){
            if($bike_exist->traffic->traffic_for == 1){
                $bike_exist->company_name = $bike_exist->traffic->company->name ?? "";
            }
            elseif($bike_exist->traffic->traffic_for == 2){
                $bike_exist->company_name = $bike_exist->traffic->passport_info->personal_info->fullname ?? "";
            }
            elseif($bike_exist->traffic->traffic_for == 3 AND $bike_exist->company_id !== null){
                $bike_exist->company_name = $bike_exist->traffic->customer_supplier_info->contact_name ?? "";
            }
            return [
                'model' =>  is_numeric($bike_exist->model) ? $bike_exist->model_info->name : $bike_exist->model ,
                'chassis_no' => $bike_exist->chassis_no,
                'vehicle_current_plate_no' => $bike_exist->plate_no,
                'company_name' =>  $bike_exist->company_name,
                'traffic_file_no'=> $bike_exist->traffic ? $bike_exist->traffic->traffic_file_no : '',
                'vehicle_working_status' =>$bike_exist->status
            ];    
        }else{
            return [ 'model' => "",'chassis_no' => "" ,'vehicle_current_plate_no' => "",'company_name' => "",'traffic_file_no' => "",'vehicle_working_status' => ""]; // sendin empty to reset previous vehicle info on info table
        }
    }  
    public function get_plate_no_replace_info(Request $request)
    {
        $replace_request = VehiclePlateReplace::where('id',$request->request_id)->first();
        $labels = [];
        if($replace_request->attachment_labels !== null){
            foreach(json_decode($replace_request->attachment_labels) as $label){
                $labels[] = AttachmentLabel::find($label);
            }
        }
        $replace_request->attachment_labels = $labels;
        $replace_request->bike_details = BikeDetail::where('plate_no', $replace_request->plate_no)->first();
        $view = view('admin-panel.vehicle_master.shared_blades.plate_replace_documents', compact('replace_request'))->render();
        return response()->json(['html' => $view]);
    }

    public function approve_request(Request $request)
    {
        if($request->accept_reject == 'Accept'){
            $validator = Validator::make($request->all(), [
                'plate_no' => 'required_if:accept_reject,Accept|unique:bike_details'
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                //
            ]);
        }
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {  
            $plate_replace_request = VehiclePlateReplace::find($request->plate_replace_request_id);
            if($request->accept_reject == 'Reject'){
                $plate_replace_request->status = 2; // 2 = Rejected
                $plate_replace_request->update();   
                $message = [
                    'message' => "Request Rejected",
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }else{
                    // get bike details with old plate no
                    $bike_detail = BikeDetail::where('plate_no', $plate_replace_request->plate_no)->first();
                    // store bike details history with the old plate no and bike id
                    $bike_detail_history = new BikeDetailHistory();
                    $bike_detail_history->bike_id = $bike_detail->id;
                    $bike_detail_history->plate_no = $request->plate_no;
                    $bike_detail_history->save();
                    // update bike details with the new plate code
                    $bike_detail->plate_no = $request->plate_no;
                    $bike_detail->update();
                    
                    // update request to approved
                    $plate_replace_request->new_plate_no =  $request->plate_no; // store new plate no
                    $plate_replace_request->status = 1; // 1 = approved
                    $plate_replace_request->update();
                    $message = [
                        'message' => "Request Approved and Bike details updated",
                        'alert-type' => 'success'
                    ];
                    return back()->with($message);
                }
            }catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' => $e->getMessage(),
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }
            
    }
}
