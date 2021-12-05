<?php

namespace App\Http\Controllers;

use App\Model\BikeCencel;
use App\Model\BikeDetail;
use App\Model\BikeDetailHistory;
use App\Model\Employee_list;
use App\Model\Fines;
use App\Model\Form_upload;
use App\Model\Fuel;
use App\Model\Rta_Vehicle;
use App\Model\Telecome;
use App\Model\Uber;
use App\Model\UberEats;
use App\Model\Vehicle_salik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ViewFormsController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|upload-form-view-forms', ['only' => ['index','store','destroy','edit','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(in_array(16, Auth::user()->user_group_id)){
            $result=Form_upload::where('id','=','9')->get();
        }else{
            $result=Form_upload::all();
        }


       return view('admin-panel.uploading_forms.view_form',compact('result'));
//      return view('admin-panel.masters.view_permit',compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //





        $form_type=$request->input('form_type');
        if ($form_type=='1'){

            if(in_array(16, Auth::user()->user_group_id)){
                $result=Form_upload::where('id','=','9')->get();
            }else{
                $result=Form_upload::all();
            }

            $salik=Vehicle_salik::all();
            return view('admin-panel.uploading_forms.view_form',compact('result','salik'));
        }

        if ($form_type=='2'){

            if(in_array(16, Auth::user()->user_group_id)){
                $result=Form_upload::where('id','=','9')->get();
            }else{
                $result=Form_upload::all();
            }

            $fines=Fines::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','fines'));
        }

        if ($form_type=='3'){

            if(in_array(16, Auth::user()->user_group_id)){
                $result=Form_upload::where('id','=','9')->get();
            }else{
                $result=Form_upload::all();
            }

            $fuels=Fuel::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','fuels'));
        }
        if ($form_type=='4'){

            if(in_array(16, Auth::user()->user_group_id)){
                $result=Form_upload::where('id','=','9')->get();
            }else{
                $result=Form_upload::all();
            }


            $rta_veh=Rta_Vehicle::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','rta_veh'));
        }
        if ($form_type=='5'){

            if(in_array(16, Auth::user()->user_group_id)){
                $result=Form_upload::where('id','=','9')->get();
            }else{
                $result=Form_upload::all();
            }


            $UberEats=UberEats::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','UberEats'));
        }
        if ($form_type=='6'){

            if(in_array(16, Auth::user()->user_group_id)){
                $result=Form_upload::where('id','=','9')->get();
            }else{
                $result=Form_upload::all();
            }


            $Employee=Employee_list::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','Employee'));
        }
        if ($form_type=='7'){

            if(in_array(16, Auth::user()->user_group_id)){
                $result=Form_upload::where('id','=','9')->get();
            }else{
                $result=Form_upload::all();
            }


            $Uber=Uber::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','Uber'));
        }
        if ($form_type=='9'){

            if(in_array(16, Auth::user()->user_group_id)){
                $result=Form_upload::where('id','=','9')->get();
            }else{
                $result=Form_upload::all();
            }

            $Telecom=Telecome::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','Telecom'));
        }
        if ($form_type=='10'){

            if(in_array(16, Auth::user()->user_group_id)){
                $result=Form_upload::where('id','=','9')->get();
            }else{
                $result=Form_upload::all();
            }



            $bike_cencel=BikeCencel::all();
            $bike_detail = BikeDetail::select('bike_details.*')
                ->leftjoin('bike_cencels', 'bike_cencels.bike_id', '=', 'bike_details.id')
                ->whereNull('bike_cencels.bike_id')
                ->get();

            return view('admin-panel.uploading_forms.view_form',compact('result','bike_detail','bike_cencel'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        $result=Form_upload::all();
        $salik=Vehicle_salik::all();
        $salik_edit=Vehicle_salik::find($id);
        $modal='modal';
        return view('admin-panel.uploading_forms.view_form',compact('result','salik_edit','modal','salik'));
    }

    public function fine_edit($id)
    {
        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }

        $result=Form_upload::all();
        $fines=Fines::all();
        $fines_edit=Fines::find($id);
        $modal='modal';
        return view('admin-panel.uploading_forms.view_form',compact('result','fines_edit','modal','fines'));
    }

    public function fuel_edit($id)
    {
        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }

        $result=Form_upload::all();
        $fuels=Fuel::all();
        $fuel_edit=Fuel::find($id);
        $modal='modal';
        return view('admin-panel.uploading_forms.view_form',compact('result','fuel_edit','modal','fuels'));
    }

    public function rta_edit($id)
    {
        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        $result=Form_upload::all();
        $rta_veh=Rta_Vehicle::all();
        $rta_edit=Rta_Vehicle::find($id);

        $modal='modal';
        return view('admin-panel.uploading_forms.view_form',compact('result','rta_edit','modal','rta_veh'));
    }

    public function ubereats_edit($id)
    {
        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        $result=Form_upload::all();
        $UberEats=UberEats::all();
        $ubereats_edit=UberEats::find($id);

        $modal='modal';
        return view('admin-panel.uploading_forms.view_form',compact('result','ubereats_edit','modal','UberEats'));
    }
    public function employee_edit($id)
    {
        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        $result=Form_upload::all();
        $Employee=Employee_list::all();
        $emp_edit=Employee_list::find($id);

        $modal='modal';
        return view('admin-panel.uploading_forms.view_form',compact('result','emp_edit','modal','Employee'));
    }
    public function uber_edit($id)
    {
        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        $result=Form_upload::all();
        $Uber=Uber::all();
        $uber_edit=Uber::find($id);

        $modal='modal';
        return view('admin-panel.uploading_forms.view_form',compact('result','uber_edit','modal','Uber'));
    }

    public function telecome_edit($id)
    {
        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        $result=Form_upload::all();
        $Telecom=Telecome::all();
        $telecome_edit=Telecome::find($id);

        $modal='modal';
        return view('admin-panel.uploading_forms.view_form',compact('result','telecome_edit','modal','Telecom'));
    }

    public function bikedetail_edit($id)
    {
        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        $result=Form_upload::all();
        $bike_detail=BikeDetail::all();
        $bike_detail_edit=BikeDetail::find($id);
        $bike_cencel=BikeCencel::all();
        $modal='modal';
        return view('admin-panel.uploading_forms.view_form',compact('result','bike_detail_edit','modal','bike_detail','bike_cencel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        $form_type = $request->get('form_type');

        if ($form_type=='1'){
//            try {
//
//                $validator = Validator::make($request->all(), [
//
//                    'transaction_id' => 'unique:vehicle_saliks,transaction_id,'.$id
//                ]);
//
//                if ($validator->fails()) {
//                    $validate = $validator->errors();
//                    $message = [
//                        'message' => 'Transaction ID already exist',
//                        'alert-type' => 'error',
//                        'error' => $validate->first()
//                    ];
//                    return back()->with($message);
//                }



                $transaction_id = $request->get('transaction_id');
                $trip_date = $request->get('trip_date');
                $trip_time = $request->get('trip_time');
                $transaction_post_date = $request->get('transaction_post_date');
                $toll_gate = $request->get('toll_gate');
                $direction = $request->get('direction');
                $tag_number = $request->get('tag_number');
                $plate = $request->get('plate');
                $amount = $request->get('amount');
                $account_number = $request->get('account_number');


                DB::table('vehicle_saliks')->where('id', $id)->update([
                    'transaction_id' => $transaction_id,
                    'trip_date'=> $trip_date,
                    'trip_time' => $trip_time,
                    'transaction_post_date'=> $transaction_post_date,
                    'toll_gate' => $toll_gate,
                    'direction'=> $direction,
                    'tag_number' => $tag_number,
                    'plate'=> $plate,
                    'amount'=> $amount,
                    'account_number'=> $account_number
                ]);

                $message = [
                    'message' => 'Updated Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);

            }
//            catch (\Illuminate\Database\QueryException $e) {
//                $message = [
//                    'message' => 'Error Occured',
//                    'alert-type' => 'error'
//                ];
//                return back()->with($message);
//            }
//        }
        if ($form_type=='2'){
//            try {

//                $validator = Validator::make($request->all(), [
//                    'traffic_file_no' => 'unique:fines,traffic_file_no,'.$id
//                ]);
//
//                if ($validator->fails()) {
//                    $validate = $validator->errors();
//                    $message = [
//                        'message' => 'Traffic File No ID already exist',
//                        'alert-type' => 'error',
//                        'error' => $validate->first()
//                    ];
//                    return back()->with($message);
//                }



                $traffic_file_no = $request->get('traffic_file_no');
                $plate_number = $request->get('plate_number');
                $plate_category = $request->get('plate_category');
                $plate_code= $request->get('plate_code');
                $license_number = $request->get('license_number');
                $license_from = $request->get('license_from');
                $ticket_number = $request->get('ticket_number');
                $ticket_date = $request->get('ticket_date');
                $fines_source= $request->get('fines_source');
                $ticket_fee = $request->get('ticket_fee');
                $ticket_status = $request->get('ticket_status');
                $the_terms_of_the_offense = $request->get('the_terms_of_the_offense');

                DB::table('fines')->where('id', $id)->update([
                    'traffic_file_no' => $traffic_file_no,
                    'plate_number'=> $plate_number,
                    'plate_category' => $plate_category,
                    'plate_code'=> $plate_code,
                    'license_number' => $license_number,
                    'license_from'=> $license_from,
                    'ticket_number' => $ticket_number,
                    'ticket_date'=> $ticket_date,
                    'fines_source'=> $fines_source,
                    'ticket_fee'=> $ticket_fee,
                    'ticket_status'=> $ticket_status,
                    'the_terms_of_the_offense'=> $the_terms_of_the_offense
                ]);

                $message = [
                    'message' => 'Updated Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);

//            }
//            catch (\Illuminate\Database\QueryException $e) {
//                $message = [
//                    'message' => 'Error Occured',
//                    'alert-type' => 'error'
//                ];
//                return back()->with($message);
//            }
        }
        if ($form_type=='3'){
//            try {
//
//                $validator = Validator::make($request->all(), [
//                    'rid' => 'unique:fuels,rid,'.$id
//                ]);
//
//                if ($validator->fails()) {
//                    $validate = $validator->errors();
//                    $message = [
//                        'message' => 'RID already exist',
//                        'alert-type' => 'error',
//                        'error' => $validate->first()
//                    ];
//                    return back()->with($message);
//                }



                $rid = $request->get('rid');
                $vehicle_plate_number = $request->get('vehicle_plate_number');
                $license_plate_nr = $request->get('license_plate_nr');
                $sale_end= $request->get('sale_end');
                $unit_price = $request->get('unit_price');
                $volume = $request->get('volume');
                $total = $request->get('total');
                $product_name = $request->get('product_name');
                $receipt_nr= $request->get('receipt_nr');
                $odometer = $request->get('odometer');
                $id_unit_code = $request->get('id_unit_code');
                $station_name = $request->get('station_name');
                $station_code = $request->get('station_code');
                $fleet_name = $request->get('fleet_name');
                $p_product_name = $request->get('p_product_name');
                $group_name = $request->get('group_name');
                $vehicle_code = $request->get('vehicle_code');
                $city_code = $request->get('city_code');
                $cost_center = $request->get('cost_center');
                $vat_rate = $request->get('vat_rate');
                $vat_amount = $request->get('vat_amount');
                $actual_amount = $request->get('actual_amount');

                DB::table('fuels')->where('id', $id)->update([
                    'rid' => $rid,
                    'vehicle_plate_number'=> $vehicle_plate_number,
                    'license_plate_nr' => $license_plate_nr,
                    'sale_end'=> $sale_end,
                    'unit_price' => $unit_price,
                    'volume'=> $volume,
                    'total' => $total,
                    'product_name'=> $product_name,
                    'receipt_nr'=> $receipt_nr,
                    'odometer'=> $odometer,
                    'id_unit_code'=> $id_unit_code,
                    'station_name'=> $station_name,
                    'station_code'=> $station_code,
                    'fleet_name'=> $fleet_name,
                    'p_product_name'=> $p_product_name,
                    'group_name'=> $group_name,
                    'vehicle_code'=> $vehicle_code,
                    'city_code'=> $city_code,
                    'cost_center'=> $cost_center,
                    'vat_rate'=> $vat_rate,
                    'vat_amount'=> $vat_amount,
                    'actual_amount'=> $actual_amount
                ]);

                $message = [
                    'message' => 'Updated Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);

//            }
//            catch (\Illuminate\Database\QueryException $e) {
//                $message = [
//                    'message' => 'Error Occured',
//                    'alert-type' => 'error'
//                ];
//                return back()->with($message);
//            }
        }
        if ($form_type=='4'){
//            try {
//
//                $validator = Validator::make($request->all(), [
//                    'chassis_no' => 'unique:rta_vehicles,chassis_no,'.$id
//                ]);
//
//                if ($validator->fails()) {
//                    $validate = $validator->errors();
//                    $message = [
//                        'message' => 'Chassis Number already exist',
//                        'alert-type' => 'error',
//                        'error' => $validate->first()
//                    ];
//                    return back()->with($message);
//                }



                $mortgaged_by = $request->get('mortgaged_by');
                $insurance_co = $request->get('insurance_co');
                $expiry_date = $request->get('expiry_date');
                $issue_date= $request->get('issue_date');
                $fines_amount = $request->get('fines_amount');
                $number_of_fines = $request->get('number_of_fines');
                $registration_valid_for_days= $request->get('registration_valid_for_days');
                $make_year = $request->get('make_year');
                $plate_no= $request->get('plate_no');
                $chassis_no = $request->get('chassis_no');
                $model = $request->get('model');
                $traffic_file_number = $request->get('traffic_file_number');

                DB::table('rta_vehicles')->where('id', $id)->update([
                    'mortgaged_by' => $mortgaged_by,
                    'insurance_co'=> $insurance_co,
                    'expiry_date' => $expiry_date,
                    'issue_date'=> $issue_date,
                    'fines_amount' => $fines_amount,
                    'number_of_fines'=> $number_of_fines,
                    'registration_valid_for_days' => $registration_valid_for_days,
                    'make_year'=> $make_year,
                    'plate_no'=> $plate_no,
                    'chassis_no'=> $chassis_no,
                    'model'=> $model,
                    'traffic_file_number'=> $traffic_file_number

                ]);

                $message = [
                    'message' => 'Updated Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);

//            }
//            catch (\Illuminate\Database\QueryException $e) {
//                $message = [
//                    'message' => 'Error Occured',
//                    'alert-type' => 'error'
//                ];
//                return back()->with($message);
//            }
        }


        if ($form_type=='5'){
//            try {
//
//                $validator = Validator::make($request->all(), [
//                    'trip_u_uid' => 'unique:uber_eats_payment,trip_u_uid,'.$id
//                ]);
//
//                if ($validator->fails()) {
//                    $validate = $validator->errors();
//                    $message = [
//                        'message' => 'Chassis Number already exist',
//                        'alert-type' => 'error',
//                        'error' => $validate->first()
//                    ];
//                    return back()->with($message);
//                }
                $driver_u_uid = $request->get('driver_u_uid');
                $trip_u_uid = $request->get('trip_u_uid');
                $first_name = $request->get('first_name');
                $last_name= $request->get('last_name');
                $amount = $request->get('amount');
                $timestamp= $request->get('timestamp');
                $item_type= $request->get('item_type');
                $description = $request->get('description');
                $disclaimer= $request->get('disclaimer');

                DB::table('uber_eats_payment')->where('id', $id)->update([
                    'driver_u_uid' => $driver_u_uid,
                    'trip_u_uid'=> $trip_u_uid,
                    'first_name' => $first_name,
                    'last_name'=> $last_name,
                    'amount' => $amount,
                    'timestamp'=> $timestamp,
                    'item_type' => $item_type,
                    'description'=> $description,
                    'disclaimer'=> $disclaimer
                ]);

                $message = [
                    'message' => 'Updated Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);

//            }
//            catch (\Illuminate\Database\QueryException $e) {
//                $message = [
//                    'message' => 'Error Occured',
//                    'alert-type' => 'error'
//                ];
//                return back()->with($message);
//            }
        }


        if ($form_type=='6'){
//            try {
//
//                $validator = Validator::make($request->all(), [
//                    'no' => 'unique:employee_list_payment,no,'.$id
//                ]);
//
//                if ($validator->fails()) {
//                    $validate = $validator->errors();
//                    $message = [
//                        'message' => 'No already exist',
//                        'alert-type' => 'error',
//                        'error' => $validate->first()
//                    ];
//                    return back()->with($message);
//                }
                $no = $request->get('no');
                $person_code = $request->get('person_code');
                $person_name = $request->get('person_name');
                $job= $request->get('job');
                $passport_details = $request->get('passport_details');
                $card_details= $request->get('card_details');


                DB::table('employee_list_payment')->where('id', $id)->update([
                    'no' => $no,
                    'person_code'=> $person_code,
                    'person_name' => $person_name,
                    'job'=> $job,
                    'passport_details' => $passport_details,
                    'card_details'=> $card_details

                ]);

                $message = [
                    'message' => 'Updated Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);

//            }
//            catch (\Illuminate\Database\QueryException $e) {
//                $message = [
//                    'message' => 'Error Occured',
//                    'alert-type' => 'error'
//                ];
//                return back()->with($message);
//            }
        }

        if ($form_type=='7'){


                $name = $request->get('name');
                $cash = $request->get('cash');
                $credit = $request->get('credit');



                DB::table('uber')->where('id', $id)->update([
                    'name' => $name,
                    'cash'=> $cash,
                    'credit' => $credit


                ]);

                $message = [
                    'message' => 'Updated Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);

            }

        if ($form_type=='9'){
            $telecome = Telecome::where('id', $id)->first();
            $telecome->account_number = $request->account_number;
            $telecome->party_id = $request->party_id;
            $telecome->product_type = $request->product_type;
            $telecome->network = $request->network;
            $telecome->category_types = $request->category_types;
            $telecome->contract_issue_date = $request->contract_issue_date;
            $telecome->contract_expiry_date = $request->contract_expiry_date;
            $telecome->sim_sl_no = $request->sim_sl_no;
            $telecome->update();
            // return $telecome;
                $message = [
                    'message' => 'Updated Successfully',
                    'alert-type' => 'success'
                ];
                return back()->with($message);

            }
        else{


            $plate_no = $request->get('plate_no');
            $plate_code = $request->get('plate_code');
            $model = $request->get('model');
            $make_year= $request->get('make_year');
            $chassis_no = $request->get('chassis_no');
            $mortgaged_by = $request->get('mortgaged_by');
            $insurance_co = $request->get('insurance_co');
            $expiry_date= $request->get('expiry_date');
            $issue_date = $request->get('issue_date');
            $traffic_file = $request->get('traffic_file');
            $category_type = $request->get('category_type');



            $bike_details=BikeDetail::where('chassis_no','=',$chassis_no)->first();
            $bike_id=$bike_details->id;
            $old_plate_no=$bike_details->plate_no;
            if ($plate_no != $old_plate_no) {
                $obj2 = new BikeDetailHistory();
                $obj2->bike_id = $bike_id;
                $obj2->plate_no = $old_plate_no;
                $obj2->save();
            }


            DB::table('bike_details')->where('id', $id)->update([
                'plate_no' => $plate_no,
                'plate_code'=> $plate_code,
                'model' => $model,
                'make_year'=> $make_year,
                'chassis_no'=> $chassis_no,
                'mortgaged_by'=> $mortgaged_by,
                'insurance_co'=> $insurance_co,
                'expiry_date'=> $expiry_date,
                'issue_date'=> $issue_date,
                'traffic_file'=> $traffic_file,
                'category_type'=> $category_type,


            ]);

                $message = [
                    'message' => 'Updated Successfully',
                    'alert-type' => 'success'

                ];
                return back()->with($message);

            }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }

        try {
            $obj = Vehicle_salik::find($id);
            $obj->delete();
            $message = [
                'message' => 'Deleted Successfully',
                'alert-type' => 'success'
            ];
//            return redirect()->route('view_form')->with($message);

            $result=Form_upload::all();
            $salik=Vehicle_salik::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','salik'));
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('view_form')->with($message);
        }
    }


    public function fine_destroy($id)
    {

        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        try {
            $obj = Fines::find($id);

            $obj->delete();
            $message = [
                'message' => 'Deleted Successfully',
                'alert-type' => 'success'
            ];
            $result=Form_upload::all();
            $fines=Fines::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','fines'));
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('view_form')->with($message);
        }
    }

    public function fuel_destroy($id)
    {

        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }



        try {
            $obj = Fuel::find($id);

            $obj->delete();
            $message = [
                'message' => 'Deleted Successfully',
                'alert-type' => 'success'
            ];

            $result=Form_upload::all();
            $fuels=Fuel::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','fuels'));
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('view_form')->with($message);
        }
    }

    public function rta_destroy($id)
    {
        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        try {
            $obj = Rta_Vehicle::find($id);

            $obj->delete();
            $message = [
                'message' => 'Deleted Successfully',
                'alert-type' => 'success'
            ];
            $result=Form_upload::all();
            $rta_veh=Rta_Vehicle::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','rta_veh'));
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('view_form')->with($message);
        }
    }
    public function ubereats_destroy($id)
    {
        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }



        try {
            $obj = UberEats::find($id);

            $obj->delete();
            $message = [
                'message' => 'Deleted Successfully',
                'alert-type' => 'success'
            ];
            $result=Form_upload::all();
            $UberEats=UberEats::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','UberEats'));
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('view_form')->with($message);
        }
    }
    public function employee_destroy($id)
    {
        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        try {
            $obj = Employee_list::find($id);

            $obj->delete();
            $message = [
                'message' => 'Deleted Successfully',
                'alert-type' => 'success'
            ];

            $result=Form_upload::all();
            $Employee=Employee_list::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','Employee'));
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('view_form')->with($message);
        }
    }

    public function uber_destroy($id)
    {

        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        try {
            $obj = Uber::find($id);

            $obj->delete();
            $message = [
                'message' => 'Deleted Successfully',
                'alert-type' => 'success'
            ];

            $result=Form_upload::all();
            $Uber=Uber::all();

            return view('admin-panel.uploading_forms.view_form',compact('result','Uber'));
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('view_form')->with($message);
        }
    }


    public function ajax_bike_history(Request $request){

        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        $id = $request->id;
        $bike_history = BikeDetailHistory::where('bike_id',$id)->get();
        $view = view("admin-panel.uploading_forms.ajax_bike_history",compact('bike_history'))->render();

        return response()->json(['html'=>$view]);


    }


    public function ajax_bike_cencel(Request $request){

        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }


        $id = $request->id;
        $bike_detail = BikeDetail::where('id',$id)->first();
        $plate_no=$bike_detail->plate_no;
        $bike_cencel = BikeCencel::where('bike_id',$id)->first();

        $view = view("admin-panel.uploading_forms.ajax_bike_cencel",compact('bike_cencel','id','plate_no'))->render();

        return response()->json(['html'=>$view]);


    }
    public  function cencel_plate_no_store(Request $request){

        if(!in_array(1,Auth::user()->user_group_id)){
            $message = [
                'message' => 'Access Denied',
                'alert-type' => 'error',
                'error' => '',
            ];
            return  redirect()->back()->with($message);
        }

        $obj=new BikeCencel();
        $obj->bike_id=$request->input('bike_id');
        $obj->plate_no=$request->input('plate_no');
        $obj->remarks=$request->input('remarks');
        $obj->date_and_time=$request->input('date_and_time');

        $obj->save();
        $result=Form_upload::all();
        $bike_detail=BikeDetail::all();
        $bike_cencel=BikeCencel::all();
        $msg='message';
//        return redirect()->back()->with($message);

        return view('admin-panel.uploading_forms.view_form',compact('result','bike_detail','bike_cencel','msg'));
    }


}
