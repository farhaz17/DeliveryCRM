<?php

namespace App\Http\Controllers\Lpo;

use App\Model\BikeDetail;
use App\Model\Lpo\SalikTag;
use App\Model\Lpo\LpoMaster;
use Illuminate\Http\Request;
use App\Model\Lpo\LpoVehicleInfo;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LpoVehicleInfoImport;
use App\Model\Master\Company\Traffic;
use Illuminate\Support\Facades\Storage;
use App\Model\Master\Vehicle\VehicleInsurance;

class LpoProcessController extends Controller
{

    public function lpo_process() {
        $traffic_file = Traffic::all();
        $insurance = VehicleInsurance::all();
        $lpos = LpoMaster::get();
        $tags = SalikTag::all();
        $vehicles = LpoVehicleInfo::all();
        return view('admin-panel.lpo-process.lpo-process', compact('lpos', 'traffic_file', 'insurance', 'tags', 'vehicles'));
    }

    public function ajax_lpo_process(Request $request) {
        $lpo = LpoVehicleInfo::where('id', $request->lpo_id)->first();
        $view = view('admin-panel.lpo-process.ajax-lpo-process', compact('lpo'))->render();
        return response()->json($view);
    }

    public function ajax_store_lpo_vehicle(Request $request) {

        \DB::beginTransaction();
        try {
            if($request->inventory_type == 1){
                Excel::import(new LpoVehicleInfoImport($request->lpo_id), request()->file('vehicle_info'));
            }

            $lpo = LpoMaster::where('id', $request->lpo_id)->update(['process' => 2]);

            $message = [
                'message' => 'Details Added Successfully',
                'alert-type' => 'success'
            ];

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $message = [
                'message' => 'Something went wrong',
                'alert-type' => 'error'
            ];
        }

        return response()->json($message);
    }

    public function ajax_lpo_vcc_attachment(Request $request) {

        \DB::beginTransaction();
        try {

            $fileName = '';
            if($request->file('attachment')) {
                $name = rand(100,100000).'.'.time().'.'.$request->attachment->extension();
                $fileName = 'assets/upload/lpo/' . $name;
                $t = Storage::disk('s3')->put($fileName , file_get_contents($request->attachment));
            }
            // $vcc = LpoVehicleInfo::where('lpo_id', $request->lpo_id)->where('chassis_no', $request->chassis_no)->update(['vcc_attachment' => $fileName]);
            $lpo = LpoVehicleInfo::where('id', $request->vehicle_id)->update(['process' => 3, 'vcc_attachment' => $fileName]);

            $message = [
                'message' => 'Details Added Successfully',
                'alert-type' => 'success'
            ];

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
        }

        return response()->json($message);
    }

    public function ajax_lpo_add_insurance(Request $request) {

        \DB::beginTransaction();
        try {
            $insure = LpoVehicleInfo::where('id', $request->vehicle_id)->update([
                'insurance_id' => $request->insurance_id,
                'insurance_no' => $request->insurance_no,
                'traffic_file_id' => $request->traffic_file_id,
                'process' => 4
                ]);

            $message = [
                'message' => 'Details Added Successfully',
                'alert-type' => 'success'
            ];

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
        }

        return response()->json($message);
    }

    public function ajax_lpo_add_no_plate(Request $request) {

        \DB::beginTransaction();
        try {

            $plate = LpoVehicleInfo::where('id', $request->vehicle_id)->update([
                'plate_no' => $request->plate_no,
                'process' => 5
            ]);

            $message = [
                'message' => 'Details Added Successfully',
                'alert-type' => 'success'
            ];

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $message = [
                'message' => 'Something went wrong',
                'alert-type' => 'error'
            ];
        }

        return response()->json($message);
    }

    public function ajax_salik_tags(Request $request) {

        \DB::beginTransaction();
        try {

            $plate = LpoVehicleInfo::where('id', $request->vehicle_id)->update([
                'salik_tag_id' => $request->salik_tag,
                'process' => 6
            ]);

            $message = [
                'message' => 'Details Added Successfully',
                'alert-type' => 'success'
            ];

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $message = [
                'message' => 'Something went wrong',
                'alert-type' => 'error'
            ];
        }

        return response()->json($message);

    }

    public function ajax_bike_ready(Request $request) {

        \DB::beginTransaction();
        try {

            $lpo = LpoVehicleInfo::where('id', $request->vehicle_id)->update(['process' => 7]);
            $bike = LpoVehicleInfo::where('id', $request->vehicle_id)->first();

            $obj = new BikeDetail();
            $obj->plate_no = $bike->plate_no;
            $obj->model = $bike->model_id;
            $obj->chassis_no = $bike->chassis_no;
            $obj->insurance_co = $bike->insurance_id;
            $obj->traffic_file = $bike->traffic_file_id;
            $obj->engine_no = $bike->engine_no;
            $obj->save();

            $message = [
                'message' => 'Details Added Successfully',
                'alert-type' => 'success'
            ];

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
        }

        return response()->json($message);
    }

    public function get_lpo_process_details(Request $request) {
        $bike = LpoVehicleInfo::with('model')->where('id', $request->vehicle_id)->first();
        $process = $request->process;
        $view = view('admin-panel.lpo-process.ajax-modal-details', compact('bike', 'process'))->render();
        return response()->json($view);
    }

    public function fetch_lpo_chassis(Request $request) {
        $bikes = LpoVehicleInfo::where('lpo_id', $request->lpo_id)->get();
        // $view = view('admin-panel.lpo-process.ajax-cha', compact('bikes'))->render();
        return response()->json($bikes);
    }

    public function lpo_vehicle_info(Request $request) {
        $lpos = LpoVehicleInfo::with('lpo')->get();
        return view('admin-panel.lpo-process.vehicle-info', compact('lpos'));
    }
}
