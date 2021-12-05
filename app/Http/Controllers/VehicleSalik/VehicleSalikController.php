<?php

namespace App\Http\Controllers\VehicleSalik;

use DB;
use File;
use Calendar;
use DataTables;
use App\Model\BikeDetail;
use App\Model\Vehicle_salik;
use Illuminate\Http\Request;
use App\Model\Seeder\Company;
use App\Model\Assign\AssignBike;
use App\Model\Master\Company\Salik;
use App\Http\Controllers\Controller;
use App\Model\FineUpload\FineUpload;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\VehicleSalikOtherTable;
use App\Model\ArBalance\ArBalanceSheet;
use Illuminate\Support\Facades\Storage;
use App\Model\Seeder\CompanyInformation;
use Illuminate\Support\Facades\Validator;
use App\Model\Vehicle_salik_sheet_account;
use App\Model\FineUpload\FineUploadTrafficeCode;

class VehicleSalikController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|salik-upload-uploaded-data', ['only' => ['index']]);
        $this->middleware('role_or_permission:Admin|salik-upload-upload-salik-sheet', ['only' => ['create']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax()) {

            if(!empty($request->from_date)){
                $company_id = $request->company_id;
                 $ids = Vehicle_salik_sheet_account::where('account_no','=',$company_id)->pluck('id')->toArray();
                 $data = Vehicle_salik::whereIn('vehicle_salik_sheet_account_id',$ids)->whereBetween('trip_date', [$request->from_date, $request->end_date])->orderby('trip_date','desc')->get();
            }else{
                $data = Vehicle_salik::orderby('id','desc')->get();
            }
            return Datatables::of($data)
                ->editColumn('company', function (Vehicle_salik $upload) {
                     $name = $upload->get_account_detail->get_company_info->company_detail->name ? $upload->get_account_detail->get_company_info->company_detail->name : 'N/A';
                    return $name;
                })
                ->make(true);
        }
        $total_fess = Vehicle_salik::sum('amount');
        $total_bikes = Vehicle_salik::distinct('plate')->count();
        $companies = Company::all();

        return  view('admin-panel.salik_upload.index',compact('total_fess','total_bikes','companies'));
    }

    public function render_ajax_index(){


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $salik_last_date = Vehicle_salik_sheet_account::orderby('id','desc')->first();
        return view('admin-panel.salik_upload.create',compact('salik_last_date'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->upload_or_delete == "delete"){
            $validator = Validator::make($request->all(), [
                'start_date' => 'required',
                'end_date' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }

            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $uploaded_sheets = Vehicle_salik_sheet_account::where('start_date', $start_date)->where('end_date', $end_date)->get();
            if(count($uploaded_sheets) > 1)
            {
                $sheets = [];
                $ids = [];
                $account = [];
                foreach($uploaded_sheets as $key => $row) {
                    $riderid_exists  = $row;
                    if($riderid_exists != null) {
                        $sheets[] = $row->file_path;
                        $ids[] = $row->id;
                        $account[] = $row->get_account_no->salik_acc;
                    }
                }
                $message = [
                    'message' => "Salik Excel Sheet Upload Failed",
                    'alert-type' => 'error',
                    'uploaded_sheet' => implode(',' , $sheets),
                    'id' => implode(',' , $ids),
                    'account' => implode(',' , $account)
                ];
                return redirect()->back()->with($message);

            }else{
                $exits = Vehicle_salik_sheet_account::where('start_date', $start_date)->where('end_date', $end_date)->first();
                if($exits){
                    $exits->file_path ? Storage::disk('s3')->delete($exits->file_path) : "";
                    $get_datas = Vehicle_salik::where('vehicle_salik_sheet_account_id', $exits->id)->delete();
                    $delete = Vehicle_salik_sheet_account::where('start_date', $start_date)->where('end_date', $end_date)->delete();
                    $message = [
                        'message' => "Salik on between " . $start_date." and ".$end_date. " deleted successfully.",
                        'alert-type' => 'success'
                    ];
                    return redirect()->back()->with($message);
                }else{
                    $message = [
                        'message' => "Salik not found on " . $start_date." to ".$end_date,
                        'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);
                }
            }
        }elseif($request->upload_or_delete == "Upload")
        {
        $validator = Validator::make($request->all(), [
            'select_file' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }

        Excel::import(new \App\Imports\SalikUploadSheetAccount(), request()->file('select_file'));
        $last_id = Excel::toArray(new \App\Imports\SalikUploadSheetAccount(), request()->file('select_file'));
        $data = collect(head($last_id));
        // dd($data);
        $final_start_date = "";
        $final_end_date = "";
        $final_account_no = "";
        $account_id = "";

        if(isset($data['6']['1'])) {
            $dates_sheet_array = explode(" ",$data['6']['1']);
            $final_start_date = isset($dates_sheet_array[2]) ? date("Y-m-d", strtotime($dates_sheet_array[2])) : '';
            $final_end_date = isset($dates_sheet_array[4]) ? date("Y-m-d", strtotime($dates_sheet_array[4])) : '';

            $sheet_account_no = isset($data['5']['2']) ? $data['5']['2'] : '' ;
            if(empty($sheet_account_no)) {

                $message = [
                    'message' => "Salik Account Number is not exist in excel Sheet",
                    'alert-type' => 'error',
                    'error' => 'error'
                ];
                return redirect()->back()->with($message);
            }

            $account_no_array = explode(":",$sheet_account_no);
            $final_account_no = trim($account_no_array[1]);
            $company_info = Salik::where('salik_acc','=',$final_account_no)->first();

            if($company_info==null) {
                $message = [
                    'message' => "Salik Account Number is not Matched",
                    'alert-type' => 'error',
                    'error' => 'error'
                ];
                return redirect()->back()->with($message);
            }
            else {
                $account_id =  $company_info->company_id;
            }
        }
        else {
            $message = [
                'message' => "Date Not Found in Excel Sheet",
                'alert-type' => 'error',
                'error' => 'error'
            ];
            return redirect()->back()->with($message);
        }
        $last_id = Excel::toArray(new \App\Imports\VehicleSalik(null,null), request()->file('select_file'));

        $excel_data = collect(head($last_id));
        $last_row = count($excel_data);
        unset($excel_data[$last_row - 1]);
        // dd($excel_data);
        $missing_plate = [];
        foreach($excel_data as $key => $row) {
            $riderid_exists  = \App\Model\BikeDetail::where('plate_no',$row['plate'])->first();
            if(!$riderid_exists) {
                $missing_plate[] = $row['plate'];
            }
        }

        if(count($missing_plate) > 0) {
            $message = [
                'message' => "Salik Excel Sheet Upload Failed",
                'alert-type' => 'error',
                'missing_plate' => implode(',' , $missing_plate)
            ];
            return redirect()->back()->with($message);
        }
        else {
            $last_id = "";
            $file_image = "";

            if(!empty($_FILES['select_file']['name'])){

                $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;
                $file_path_image = 'assets/upload/excel_file/salik_upload/' . $file_name;
                $t = Storage::disk('s3')->put($file_path_image, file_get_contents($request->select_file));

                $vehicle_sheet = new  Vehicle_salik_sheet_account();
                $vehicle_sheet->account_no = $account_id;
                $vehicle_sheet->start_date = $final_start_date;
                $vehicle_sheet->end_date =  $final_end_date;
                $vehicle_sheet->file_path = $file_path_image;
                $vehicle_sheet->save();

                $last_id = $vehicle_sheet->id;
            }

            Excel::import(new \App\Imports\VehicleSalik($final_account_no,$last_id), $file_path_image);

            $duplicate_plate = [];
            foreach($excel_data as $excel_row) {
                $excel_row['account_number'] = $final_account_no;
                $duplicate = BikeDetail::where('plate_no',$excel_row['plate'])->get();
                if(count($duplicate) > 1) {
                    foreach($duplicate as $bike_detail_rows) {
                        $bike_detail_rows->salik_details = $excel_row;
                        $duplicate_plate[] = $bike_detail_rows;
                    }
                }
            }
            if(count($duplicate_plate) > 0) {
                $message = [
                    'message' => "Salik Excel Sheet Upload Failed",
                    'alert-type' => 'error',
                    'duplicate_plate' => $duplicate_plate,
                ];
                return redirect()->back()->with($message);
            }

            $message = [
                'message' => 'Salik Uploaded Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        }}
    }

    public function delete_salik(Request $request)
    {
        $exits = Vehicle_salik_sheet_account::find($request->sheet_id);
        $exits->file_path ? Storage::disk('s3')->delete($exits->file_path) : "";
        $get_datas = Vehicle_salik::where('vehicle_salik_sheet_account_id',$request->sheet_id)->delete();
        $delete = Vehicle_salik_sheet_account::find($request->sheet_id)->delete();
        $message = [
            'message' => "Salik deleted successfully.",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function update_duplicate_salik(Request $request)
    {
        foreach($request->details as $key => $value) {
            if(isset($request->details[$key]['bike_id'])) {
                $get_datas = Vehicle_salik::where('transaction_id',$request->details[$key]['transaction_id'])
                            ->where('account_number',$request->details[$key]['account_number'])
                            ->where('transaction_post_date',$request->details[$key]['transaction_post_date'])->first();
                $get_datas->plate = $request->details[$key]['bike_id'];
                $get_datas->save();
            }
        }
        $message = [
            'message' => "Salik Uploaded successfully.",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public  function salik_render_calender(Request $request) {

        if($request->ajax()) {
            $events = [];
            $data  = Vehicle_salik_sheet_account::Orderby('end_date','desc')->get(['start_date','end_date']);

            if($data->count()) {
                foreach ($data as $key => $value) {
                    $events[] = Calendar::event(
                        'Sheet Uploaded',
                        true,
                        new \DateTime($value->start_date),
                        new \DateTime($value->end_date.' +1 day'),
                        null,
                        // Add color and link on event
                        [
                            'color' => '#f05050',
                            'contentHeight' => 100,
                        ]
                    );
                }
            }
            $calendar = Calendar::addEvents($events);
            $html = view('admin-panel.cod_uploads.render_calender_ajax',compact('calendar'))->render();
            return $html;
        }
    }

    public function check_the_account_number($number){

         $company_info = CompanyInformation::where('traffic_fle_no','=',$number)->first();

         if($company_info!=null){
             return true;
         }else{
             return false;
         }
    }

    public function salik_data($type,$id){

        if($type=="new"){

            $new_data = Vehicle_salik::leftjoin('vehicle_salik_other_tables','vehicle_salik_other_tables.vehicle_salik_id','=','vehicle_saliks.id')
                ->select('vehicle_saliks.*')
                ->whereNull('vehicle_salik_other_tables.vehicle_salik_id')->where('vehicle_saliks.vehicle_salik_sheet_account_id','=',$id)->orderby('vehicle_saliks.id','desc')->get();

                return  view('admin-panel.salik_upload.type_over_new',compact('new_data','type'));

        }elseif("overwrite"){

            $new_data = Vehicle_salik::join('vehicle_salik_other_tables','vehicle_salik_other_tables.vehicle_salik_id','=','vehicle_saliks.id')
                ->select('vehicle_saliks.*','vehicle_salik_other_tables.amount as  old_amount')->where('vehicle_saliks.vehicle_salik_sheet_account_id','=',$id)->orderby('vehicle_saliks.id','desc')->get();

            return  view('admin-panel.salik_upload.type_over_new',compact('new_data','type'));

        }else{
            $message = [
                'message' => "URL parameters not correct",
                'alert-type' => 'error',
                'error' => 'error'
            ];
            return redirect()->back()->with($message);

        }

    }

    public function salikget_salik_total_amount_ajax(Request $request){

        if($request->ajax()){

            if($request->start_date=="ab"){

                $data = Vehicle_salik::orderby('id','desc')->get();

                $array_to_send = array(
                    'total_amount' => $data->sum('amount') ? number_format($data->sum('amount'), 2) : 0,
                    'total_rider' => $data->count() ? number_format($data->count(), 2) : 0,
                );

                echo json_encode($array_to_send);
                exit;

            }else{

                $company_id = $request->company_id;

                $ids = Vehicle_salik_sheet_account::where('account_no','=',$company_id)->pluck('id')->toArray();

                $data = Vehicle_salik::whereIn('vehicle_salik_sheet_account_id',$ids)->whereBetween('trip_date', [$request->start_date, $request->end_date])->orderby('trip_date','desc')->get();

                $array_to_send = array(
                    'total_amount' => $data->sum('amount') ? number_format($data->sum('amount'), 2) : 0,
                    'total_rider' => $data->count() ? $data->count() : 0,
                );

                echo json_encode($array_to_send);
                exit;
            }

         }

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $data = Vehicle_salik::where('vehicle_salik_sheet_account_id',$id)->get();


        $not_match=array();
        foreach($data as $row){
            $new_formate =  $row->trip_date;

            $formate_time = $this->get_twenty_four_formate_time($new_formate);
            $salik_date = $new_formate." ".$formate_time;
            $payment_date = strtotime($salik_date);


            if(isset($row->bike_detail->id)){


            $checkindata = AssignBike::
            where('bike','=',$row->bike_detail->id)
            ->where('checkin', '<=',$salik_date)
            ->first();


            if(isset($checkindata))
            {
                if($checkindata->status == 1 || $checkindata->checkout >= $salik_date)
                {
                    $name= isset($checkindata->passport->personal_info->full_name) ? $checkindata->passport->personal_info->full_name : 'N/A';
                }
                else{
                    $name= "1";
                }
            }
            else{
                $name= "1";
            }
        }
            else{
                $name="1";
            }





            $gamer = array(

                'rider_name' =>  $name,
                'transaction_id' =>  $row->transaction_id,
                'trip_date' =>  $row->trip_date,
                'transaction_post_date' =>  $row->transaction_post_date,
                'toll_gate' =>  $row->toll_gate,
                'direction' =>  $row->direction,
                'tag_number' =>  $row->tag_number,
                'plate' =>  $row->plate,
                'amount' =>  $row->amount,
                'account_number' =>  $row->account_number,
                'vehicle_salik_sheet_account_id' =>  $row->vehicle_salik_sheet_account_id,

            );
            $not_match[] = $gamer;
        }
            // dd($not_match);





            return  view('admin-panel.fine_uploads.salik_not_matched',compact('not_match'));
    }

    public function get_twenty_four_formate_time($_a){


        $_a = explode(':',$_a);
        $_time = "";                    //initialised the variable.
        if($_a[0] == 12 && $_a[1] <= 59 && strpos($_a[2],"PM") > -1)
        {
            $_rpl = str_replace("PM","",$_a[2]);
            $_time = $_a[0].":".$_a[1].":".$_rpl;
        }
        elseif($_a[0] < 12 && $_a[1] <= 59 && strpos($_a[2],"PM")>-1)
        {
            $_a[0] += 12;
            $_rpl = str_replace("PM","",$_a[2]);
            $_time = $_a[0].":".$_a[1].":".$_rpl;
        }
        elseif($_a[0] == 12 && $_a[1] <= 59 && strpos($_a[2],"AM" ) >-1)
        {
            $_a[0] = 00;
            $_rpl = str_replace("AM","",$_a[2]);
            $_time = $_a[0].":".$_a[1].":".$_rpl;
        }
        elseif($_a[0] < 12 && $_a[1] <= 59 && strpos( $_a[2],"AM")>-1)
        {
            $_rpl = str_replace("AM","",$_a[2]);
            $_time = $_a[0].":".$_a[1].":".$_rpl;
        }

        return $_time;

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $traffic_code = Vehicle_salik_sheet_account::where('id','=',$id)->first();
        $file_path=$traffic_code->file_path;








        if(Storage::disk('s3')->exists('assets/upload/excel_file/salik_upload/'.$file_path)) {
            Storage::disk('s3')->delete('assets/upload/excel_file/salik_upload/'.$file_path);


            Vehicle_salik_sheet_account::where('id','=',$id)->delete();
            DB::table('vehicle_saliks')->where('vehicle_salik_sheet_account_id', $id)->delete();

            ArBalanceSheet::where('balance_type','3')->where('upload_file_sheet_id','=',$id)->delete();


             $message = [
                'message' => 'Salik Deleted Permanetly Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        }


        // if(File::exists(public_path($file_path))){
        // //     dd('asdf');
        // DB::table('vehicle_saliks')->where('vehicle_salik_sheet_account_id', $id)->delete();

        //     File::delete(public_path($file_path));
        //     Vehicle_salik_sheet_account::where('id','=',$id)->delete();

        //    ArBalanceSheet::where('balance_type','3')->where('upload_file_sheet_id','=',$id)->delete();

        // //    Vehicle_salik::where('vehicle_salik_sheet_account_id','=',$id)->delete();



        //     //Delete from

        //     $message = [
        //         'message' => 'Salik Deleted Permanetly Successfully',
        //         'alert-type' => 'success'
        //     ];
        //     return redirect()->back()->with($message);
        //     }

            else{
                $message = [
                    'message' => 'Something Went Wrong!',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }

    }


    public function ajax_company_name(Request $request){

        if($request->ajax()){
            $id  = $request->id;
             $company = Company::find($id);

              $vehicle_sheet = Vehicle_salik_sheet_account::where('account_no','=',$id)->orderby('id','desc')->first();

             $gamer  = array(
                'name' => $company->name,
                'start_date' => isset($vehicle_sheet->start_date) ? $vehicle_sheet->start_date : 'N/A',
                'end_date' => isset($vehicle_sheet->end_date) ? $vehicle_sheet->end_date : 'N/A',
             );


            echo json_encode($gamer);
            exit;

        }

    }
}
