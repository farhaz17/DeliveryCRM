<?php

namespace App\Http\Controllers\Lpo;

use DB;
use App\Model\BikeCencel;
use App\Model\BikeDetail;
use Illuminate\Http\Request;
use App\Model\Lpo\BikeMissing;
use App\Model\Assign\AssignSim;
use App\Model\Assign\AssignBike;
use App\Model\Passport\Passport;
use App\Model\AccidentRiderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Assign\AssignPlateform;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BikeMissingController extends Controller
{
    public function bike_missing_request() {
        $bikes = BikeDetail::get();
        return view('admin-panel.bike-missing.bike-missing-request', compact('bikes'));
    }

    public function dc_bike_missing_request() {
        $bikes = BikeDetail::get();
        return view('admin-panel.bike-missing.dc-bike-missing-request', compact('bikes'));
    }

    public function store_bike_missing(Request $request) {
        // return $request->all();
        // $validator = Validator::make($request->all(), [
        //     'bike_id'  => 'unique:bike_missings'
        // ]);

        // if ($validator->fails()) {
        //     $validate = $validator->errors();
        //     $message = [
        //         'message' => 'bike already submitted',
        //         'alert-type' => 'error',
        //         'error' => $validate->first()
        //     ];
        //     return back()->with($message);
        // }

        if($request->search == 1) {
            $bike_id = $request->bike_id;
        }
        elseif($request->search == 2){
            $bike = AssignBike::where('passport_id','=', $request->passport_id)->where('status','=','1')->first();
            if(!$bike) {
                $message = [
                    'message' => 'Bike Not Assigned',
                    'alert-type' => 'error',
                ];
                return back()->with($message);
            }

            $bike_id = $bike->bike;
        }

        $missing = BikeMissing::where('bike_id', $bike_id)->where('found_status', '!=',1)->first();
        if($missing){
            $message = [
                'message' => 'Already Requested',
                'alert-type' => 'error',
            ];
            return back()->with($message);
        }

        $bike = BikeDetail::where('id', $bike_id)->where('status', 1)->first();
        if($bike) {
            $use_bike = AssignBike::where('bike','=', $bike_id)->where('status','=','1')->first();
            $sim = AssignSim::where('passport_id','=',$use_bike->passport_id)->where('status','=','1')->first();
            if($use_bike && $sim) {
                $already_request = AccidentRiderRequest::where('rider_passport_id','=', $use_bike->passport_id)
                ->where('status','=','0')->first();

                if($already_request != null){
                $message = [
                'message' => "Request already in pending",
                'alert-type' => 'error',
                ];
                return back()->with($message);

                }

                $accident_rider = new AccidentRiderRequest();
                $accident_rider->rider_passport_id = $use_bike->passport_id;
                $accident_rider->checkout_date =  $request->missing_date;
                //  $accident_rider->request_type =  $request->checkout_type;
                $accident_rider->checkout_type =  "5";
                $accident_rider->rta_request = 1;
                $accident_rider->remarks = $request->remarks;
                 $accident_rider->bike_id = $bike_id;
                 $accident_rider->sim_id = $sim->sim;
                $accident_rider->dc_id =   Auth::user()->id;
                $accident_rider->save();


                $message = [
                'message' => "request has been sent successfully",
                'alert-type' => 'success',
                ];
            } else{
                $message = [
                    'message' => "Bike not assigned",
                    'alert-type' => 'error',
                    ];
            }

            return back()->with($message);

        } else{

        \DB::beginTransaction();

        try {

            $obj = new BikeMissing();
            $obj->bike_id = $bike_id;
            $obj->remarks = $request->remarks;
            $obj->missing_date= $request->missing_date;
            $obj->process = 1;
            $obj->created_user_id = Auth::user()->id;
            $obj->save();

            // BikeDetail::where('id', $request->bike)->update(['status' => 4]);

            $message = [
                'message' => 'Request Made Successfully',
                'alert-type' => 'success',
            ];

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();

            $message = [
                'message' => 'Something Went Wrong',
                'alert-type' => 'success',
            ];
        }

        return back()->with($message);
    }

    }

    public function checkout_missing_bike() {
        $bikes = BikeMissing::get();
        return view('admin-panel.bike-missing.checkout-missing-bike', compact('bikes'));
    }

    public function store_police_complaint(Request $request) {

        if($request->hasfile('police_request_attachment')) {
            foreach($request->file('police_request_attachment') as $file) {

                $name = rand(100,100000).'.'.time().'.'.$file->extension();
                $police_request_attachment = 'assets/upload/bike-missing/' . $name;
                $t = Storage::disk('s3')->put($police_request_attachment, file_get_contents($file));
                $data_police_request_attachment[] =  $police_request_attachment;

            }
        }

            $bike = BikeMissing::where('id', $request->bike_id)->update([
                'process' => 2,
                'complaint_date' => $request->complaint_date,
                'complaint_remarks' => $request->complaint_remarks,
                'police_station' => $request->police_station,
                'police_request_attachment' => isset($data_police_request_attachment) ? json_encode($data_police_request_attachment) : '',
            ]);

            $message = [
                'message' => 'Successfull',
                'alert-type' => 'success',
                'code' => 200,
            ];

            return response()->json($bike);
    }

    public function store_police_report(Request $request) {

        if($request->hasfile('police_report_attachment')) {
            foreach($request->file('police_report_attachment') as $file) {

                $name = rand(100,100000).'.'.time().'.'.$file->extension();
                $police_report_attachment = 'assets/upload/bike-missing/' . $name;
                $t = Storage::disk('s3')->put($police_report_attachment, file_get_contents($file));
                $data_police_report_attachment[] =  $police_report_attachment;

            }
        }

        $bike = BikeMissing::where('id', $request->bike_id)->update([
            'process' => 3,
            'police_report' => $request->police_report,
            'police_report_attachment' => isset($data_police_report_attachment) ? json_encode($data_police_report_attachment) : ''
        ]);

        $message = [
            'message' => 'Successfull',
            'alert-type' => 'success',
            'code' => 200,
        ];

        return response()->json($message);
    }

    public function store_found_remarks(Request $request) {

        if($request->hasfile('found_attachment')) {
            foreach($request->file('found_attachment') as $file) {

                $name = rand(100,100000).'.'.time().'.'.$file->extension();
                $found_attachment = 'assets/upload/bike-missing/' . $name;
                $t = Storage::disk('s3')->put($found_attachment, file_get_contents($file));
                $data_found_attachment[] =  $found_attachment;

            }
        }

        \DB::beginTransaction();
        try {
            $bike = BikeMissing::where('id', $request->bike_id)->update([
                'process' => 3,
                'found_remarks' => $request->found_remarks,
                'found_status' => 1,
                'found_attachment' => isset($data_found_attachment) ? json_encode($data_found_attachment) : ''
            ]);

            // BikeDetail::where('id', $request->bike)->update(['status' => 0]);

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
        }


        $message = [
            'message' => 'Successfull',
            'alert-type' => 'success',
            'code' => 200,
        ];

        return response()->json($message);
    }

    public function store_insurance_claim(Request $request) {

        if($request->hasfile('claim_documents')) {
            foreach($request->file('claim_documents') as $file) {

                $name = rand(100,100000).'.'.time().'.'.$file->extension();
                $claim_documents = 'assets/upload/bike-missing/' . $name;
                $t = Storage::disk('s3')->put($claim_documents, file_get_contents($file));
                $data_documents[] =  $claim_documents;

            }
        }

        if($request->hasfile('claim_offer')) {
            foreach($request->file('claim_offer') as $file) {

                $name = rand(100,100000).'.'.time().'.'.$file->extension();
                $claim_offer = 'assets/upload/bike-missing/' . $name;
                $t = Storage::disk('s3')->put( $claim_offer, file_get_contents($file));
                $data_offer[] =  $claim_offer;

            }
        }


        $bike = BikeMissing::where('id', $request->bike_id)->update([
            'process' => 4,
            'claim_remarks' => $request->claim_remarks,
            'claim_documents' => isset($data_documents) ? json_encode($data_documents) : '',
            'claim_offer' => isset($data_offer) ? json_encode($data_offer) : '',
        ]);

        $message = [
            'message' => 'Successfull',
            'alert-type' => 'success',
            'code' => 200,
        ];

        return response()->json($message);
    }

    public function store_payment_receive(Request $request) {

        if($request->hasfile('payment_attachment')) {
            foreach($request->file('payment_attachment') as $file) {

                $name = rand(100,100000).'.'.time().'.'.$file->extension();
                $payment_attachment= 'assets/upload/bike-missing/' . $name;
                $t = Storage::disk('s3')->put( $payment_attachment, file_get_contents($file));
                $data_payment[] =  $payment_attachment;

            }
        }


        $bike = BikeMissing::where('id', $request->bike_id)->update([
            'process' => 5,
            'payment_amount' => $request->payment_amount,
            'payment_attachment' => isset($data_payment) ? json_encode($data_payment) : '',
        ]);

        $message = [
            'message' => 'Successfull',
            'alert-type' => 'success',
            'code' => 200,
        ];

        return response()->json($message);
    }

    public function store_vehicle_cancellation(Request $request) {

        \DB::beginTransaction();
        try {
            $bike = BikeMissing::where('id', $request->bike_id)->update([
                'process' => 6,
                'cancellation_date' => $request->cancellation_date,
                'cancellation_remarks' => $request->cancellation_remarks,
            ]);

            $bike = BikeMissing::where('id', $request->bike_id)->first();

            $bike_exist = BikeDetail::find($bike->bike_id);
            if($bike_exist->status != 1){
                $new_bike_cancel = new BikeCencel();
                $new_bike_cancel->bike_id = $bike_exist->id;
                $new_bike_cancel->date_and_time = $request->cancellation_date;
                $new_bike_cancel->remarks = $request->cancellation_remarks;
                $new_bike_cancel->save();
                $message = [
                    'message' => 'Vehicle Cancelled Successfully',
                    'alert-type' => 'success'
                ];
            }else if($bike_exist->status == 1){
                $message = [
                    'message' => 'Selected bike is active. Please inactive the bike first',
                    'alert-type' => 'error'
                ];
            }

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

    public function missing_bike_process() {
        $bikes = BikeMissing::with('bike:id,plate_no')->get();
        return view('admin-panel.bike-missing.missing-bike-process', compact('bikes'));
    }

    public function bike_process_single() {
        $bikes = BikeDetail::get();
        return view('admin-panel.bike-missing.bike-process-single', compact('bikes'));
    }

    public function ajax_missing_process(Request $request) {
        $bike = BikeMissing::with('bike:id,plate_no')->where('bike_id', $request->bike_id)->first();
        $view = view('admin-panel.bike-missing.ajax-missing-process', compact('bike'))->render();
        return response()->json($view);
    }

    public function get_missing_process_details(Request $request) {
        $bike = BikeMissing::with('bike:id,plate_no')->where('bike_id', $request->bike_id)->first();
        $process = $request->process;
        $view = view('admin-panel.bike-missing.ajax-view-details', compact('bike', 'process'))->render();
        return response()->json($view);
    }

    public function get_missing_bike_details(Request $request) {
        $bike = AssignBike::where('bike', $request->bike_id)->where('status', 1)->first();
        if($bike) {
            $passport = Passport::with('personal_info')->where('id', $bike->passport_id)->first();
            $platform = AssignPlateform::with('plateformdetail')->where('passport_id', $bike->passport_id)->where('status', 1)->first();
            $view = view('admin-panel.bike-missing.ajax-bike-details', compact('bike', 'passport', 'platform'))->render();
        } else{
            $view = '<center><h4 class="alert-warning p-2">Free Bike</h4></center>';
        }

        return response()->json($view);
    }

    function station_autocomplete(Request $request)
    {
        $data = $request->all();
        $query = $data['query'];
        $filter_data = BikeMissing::select('police_station')->where('police_station', 'LIKE', '%'.$query.'%')->distinct()->get();
        $data = array();
        foreach ($filter_data as $hsl)
        {
            $data[] = $hsl->police_station;
        }
        return response()->json($data);
    }

}
