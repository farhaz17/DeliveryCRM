<?php

namespace App\Http\Controllers\FineUpload;

use App\Imports\CodUploads;
use App\Model\Assign\AssignBike;
use App\Model\CodUpload\ExcelFilePath;
use App\Model\FineUpload\FineUpload;
use App\Model\FineUpload\FineUploadTrafficeCode;
use App\Model\Seeder\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\ArBalance\ArBalanceSheet;
use Illuminate\Support\Facades\Storage;
use DataTables;
use DB;
use DateTime;
use File;

class FineUploadController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|fine-upload-uploaded-data', ['only' => ['index']]);
        $this->middleware('role_or_permission:Admin|fine-upload-upload-fine-sheet', ['only' => ['create']]);
        $this->middleware('role_or_permission:Admin|fine-upload-rider-fines', ['only' => ['rider_fines']]);
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
                $company_id = $request->platform;
                $company =Company::find($company_id);

                $traffic_no = isset($company->comp_info->traffic_fle_no) ? $company->comp_info->traffic_fle_no : '';

                $traffic_ab = FineUploadTrafficeCode::where('traffic_file_no','=',$traffic_no)->first();

                if(!empty($traffic_ab)){
                    $data = FineUpload::where('fine_upload_traffic_code_id','=',$traffic_ab->id)->whereBetween('ticket_date', [$request->from_date, $request->end_date])->orderby('ticket_date','desc')->get();
                }else{
                    $data = FineUpload::where('fine_upload_traffic_code_id','=','0')->whereBetween('ticket_date', [$request->from_date, $request->end_date])->get();
                }

            }else{
                $data = FineUpload::orderby('ticket_date','desc')->get();
            }

            return Datatables::of($data)
                ->editColumn('offense', function (FineUpload $fine_upload) {
                    $id = $fine_upload->id;
                    $mg = '<a href="javascript:void(0)" id="'.$id.'"  class="badge badge-primary msg_dipslay">click to read</a>';
                    return $mg;
                })
                ->editColumn('fine_upload_traffic_code_id', function (FineUpload $fine_upload) {
                    $company_name =  isset($fine_upload->company_detail_info->company_info->company_detail->name) ? $fine_upload->company_detail_info->company_info->company_detail->name : 'N/A';
                    return $company_name;
                })
                ->rawColumns(['offense'])
                ->make(true);
        }

        $total_fess = FineUpload::sum('ticket_fee');
        $total_bikes = FineUpload::distinct('plate_number')->count();
        $total_company = collect(FineUpload::get());
        $total_company = $total_company->unique('fine_upload_traffic_code_id')->count();

        $companies = Company::all();


         return  view('admin-panel.fine_uploads.index',compact('companies','total_company','total_fess','total_bikes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $fine_last_date = FineUploadTrafficeCode::orderby('id','desc')->first();
         $fine_loads = FineUploadTrafficeCode::orderby('id','desc')->get();


        return  view('admin-panel.fine_uploads.create',compact('fine_last_date','fine_loads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
            'select_file' => 'required',
        ]);
        if($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }


        $last_id = Excel::toArray(new \App\Imports\FineUploadTrafficCode(), request()->file('select_file'));


        $data = collect(head($last_id));
        $id_traffic_code = $this->get_last_id_traffic_code($data[0]['traffic_file_no']);
        $rows_to_be_updated = head(Excel::toArray(new \App\Imports\FineUpload($id_traffic_code), request()->file('select_file')));

        $missing_plate = [];


        foreach($rows_to_be_updated as $key => $row){
            $riderid_exists  = \App\Model\BikeDetail::where('plate_no',$row['plate_number'])->first();
            if(!$riderid_exists){
                $missing_plate[] = $row['plate_number'];
            }
        }
        if(count($missing_plate) > 0){
            $message = [
                'message' => "Fine Excel Sheet Upload Failed",
                'alert-type' => 'error',
                'missing_plate' => implode(',' , $missing_plate)
            ];
            return redirect()->back()->with($message);
        }
        else{
        Excel::import(new \App\Imports\FineUploadTrafficCode(), request()->file('select_file'));
        $last_id = Excel::toArray(new \App\Imports\FineUploadTrafficCode(), request()->file('select_file'));
        $data = collect(head($last_id));
        $id_traffic_code = $this->get_last_id_traffic_code($data[0]['traffic_file_no']);
        //   Excel::import(new \App\Imports\FineUploadTrafficCode(), request()->file('select_file'));

         $update_traffic_code = FineUploadTrafficeCode::find($id_traffic_code);
         $update_traffic_code->start_date =  $request->start_date;
         $update_traffic_code->end_date =  $request->end_date;


        Excel::import(new \App\Imports\FineUpload($id_traffic_code), request()->file('select_file'));
        // if (!file_exists('../public/assets/upload/excel_file/fine_upload')) {
        //     mkdir('../public/assets/upload/excel_file/fine_upload', 0777, true);
        // }
        if(!empty($_FILES['select_file']['name'])) {


            $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;
            $file_path_image = '/assets/upload/excel_file/fine_upload/' . $file_name;
            $t = Storage::disk('s3')->put($file_path_image, file_get_contents($request->select_file));



            // $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
            // $file_name = time()."_" .$request->start_date.'.'.$ext;
            // move_uploaded_file($_FILES["select_file"]["tmp_name"], '../public/assets/upload/excel_file/fine_upload/'.$file_name);
            // $file_path_image = 'assets/upload/excel_file/fine_upload/'.$file_name;
            $update_traffic_code->file_path = $file_name;
            $update_traffic_code->update();


        }
        $message = [
            'message' => 'Fine Uploaded Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }
    }

    public function rider_fines(Request $request){


        if($request->ajax()) {
            if(!empty($request->from_date)){
                $company_id = $request->platform;
                 $company =Company::find($company_id);

                  $traffic_no = isset($company->comp_info->traffic_fle_no) ? $company->comp_info->traffic_fle_no : '';
                  $traffic_ab = FineUploadTrafficeCode::where('traffic_file_no','=',$traffic_no)->first();
                  if(!empty($traffic_ab)){
                      $data = FineUpload::where('fine_upload_traffic_code_id','=',$traffic_ab->id)->whereBetween('ticket_date', [$request->from_date, $request->end_date])->orderby('ticket_date','desc')->get();
                    }else{
                      $data = FineUpload::where('fine_upload_traffic_code_id','=','0')->whereBetween('ticket_date', [$request->from_date, $request->end_date])->get();
                    }

            }else{
                $data = FineUpload::orderby('ticket_date','desc')->get();
            }


            return Datatables::of($data)
                ->editColumn('offense', function (FineUpload $fine_upload) {
                    $id = $fine_upload->id;
                    $mg = '<a href="javascript:void(0)" id="'.$id.'"  class="badge badge-primary msg_dipslay">click to read</a>';
                    return $mg;
                })
                ->editColumn('fine_upload_traffic_code_id', function (FineUpload $fine_upload) {
                    $company_name = isset($fine_upload->company->company_info->com->name) ? $fine_upload->company->company_info->com->name : 'N/A';
                    return $company_name;
                })
                ->addColumn('rider_name', function (FineUpload $fine_upload) {

//                    $date = DateTime::createFromFormat('d/m/Y', $fine_upload->ticket_date);
                    $new_formate =  $fine_upload->ticket_date;
                    $ab = explode(" ",$fine_upload->ticket_time);
                    $time_pay_now = $ab[0].':00'.$ab[1];


                    $formate_time = $this->get_twenty_four_formate_time($time_pay_now);
                    $fine_date = $new_formate." ".$formate_time;
                    $payment_date = strtotime($fine_date);


                    $array_ab = array(
                        $payment_date,
                        $fine_upload->bike_detail->id
                    );

                    $checkindata = AssignBike::where('checkin', '<=',$fine_date)
                        ->where('bike','=',$array_ab[1])
                        ->first();

                    if(isset($checkindata)){
                        if($checkindata->status==1 || $checkindata->checkout >= $fine_date){
                            //                            dd($checkindata->passport_id); //this is our fine guy
                            return isset($checkindata->passport->personal_info->full_name) ? $checkindata->passport->personal_info->full_name : '';
                        }
                        else{
                            $array_ab[1]; // this bike is not driving by enyone at this time
                            return "This fine not matched with our system gamer";
                        }
                    }else{
                        return "This fine not matched with our system gamer";
                    }

                })
                ->rawColumns(['offense'])
                ->make(true);
        }

        $total_fess = FineUpload::sum('ticket_fee');
        $total_bikes = FineUpload::distinct('plate_number')->count();
        $total_company = collect(FineUpload::get());
        $total_company = $total_company->unique('fine_upload_traffic_code_id')->count();

         $companies = Company::all();


        return  view('admin-panel.fine_uploads.rider_fine',compact('total_fess','total_bikes','total_company','companies'));
    }







        public function get_last_id_traffic_code($gamer){

       $traffic_code = FineUploadTrafficeCode::where('traffic_file_no','=',$gamer)->orderby('id','desc')->first();

       return isset($traffic_code->id) ? $traffic_code->id : "";
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data=FineUpload::where('fine_upload_traffic_code_id',$id)->get();
        // dd($data);
        $not_match=array();
        foreach($data as $row){
            $new_formate =  $row->ticket_date;
            $ab = explode(" ",$row->ticket_time);
            $time_pay_now = $ab[0].':00'.$ab[1];

            $formate_time = $this->get_twenty_four_formate_time($time_pay_now);
            $fine_date = $new_formate." ".$formate_time;
            $payment_date = strtotime($fine_date);
            // dd($fine_date);


            $array_ab = array(
                $payment_date,
                $row->bike_detail->id
            );
            // $query->whereDate('created_at', '=', date('Y-m-d'));

            $checkindata = AssignBike::
            where('bike','=',$array_ab[1])
            ->where('checkin', '<=',$fine_date)
                ->first();


            if(isset($checkindata))
            {
                if($checkindata->status == 1 || $checkindata->checkout >= $fine_date)
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

            $gamer = array(
                'rider_name' =>  $name,
                'plate_number' =>  $row->plate_number,
                'ticket_number' =>  $row->ticket_number,
                'ticket_date' =>  $row->ticket_date,
                'ticket_time' =>  $row->ticket_time,
                'fines_source' =>  $row->fines_source,
                'ticket_fee' =>  $row->ticket_fee,
                'offense' =>  $row->offense,
            );
            $not_match[] = $gamer;
        }
            // dd($not_match);



            return  view('admin-panel.fine_uploads.rider_not_matched',compact('not_match'));
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


//             return Datatables::of($data)
//                 ->editColumn('offense', function (FineUpload $fine_upload) {
//                     $id = $fine_upload->id;
//                     $mg = '<a href="javascript:void(0)" id="'.$id.'"  class="badge badge-primary msg_dipslay">click to read</a>';
//                     return $mg;
//                 })
//                 ->editColumn('fine_upload_traffic_code_id', function (FineUpload $fine_upload) {
//                     $company_name = isset($fine_upload->company->company_info->com->name) ? $fine_upload->company->company_info->com->name : 'N/A';
//                     return $company_name;
//                 })
//                 ->addColumn('rider_name', function (FineUpload $fine_upload) {

// //                    $date = DateTime::createFromFormat('d/m/Y', $fine_upload->ticket_date);
//                     $new_formate =  $fine_upload->ticket_date;
//                     $ab = explode(" ",$fine_upload->ticket_time);
//                     $time_pay_now = $ab[0].':00'.$ab[1];


//                     $formate_time = $this->get_twenty_four_formate_time($time_pay_now);
//                     $fine_date = $new_formate." ".$formate_time;
//                     $payment_date = strtotime($fine_date);


//                     $array_ab = array(
//                         $payment_date,
//                         $fine_upload->bike_detail->id
//                     );

//                     $checkindata = AssignBike::where('checkin', '<=',$fine_date)
//                         ->where('bike','=',$array_ab[1])
//                         ->first();

//                     if(isset($checkindata)){
//                         if($checkindata->status==1 || $checkindata->checkout >= $fine_date){
//                             //                            dd($checkindata->passport_id); //this is our fine guy
//                             return isset($checkindata->passport->personal_info->full_name) ? $checkindata->passport->personal_info->full_name : '';
//                         }
//                         else{
//                             $array_ab[1]; // this bike is not driving by enyone at this time
//                             return "This fine not matched with our system gamer";
//                         }
//                     }else{
//                         return "This fine not matched with our system gamer";
//                     }

//                 })
//                 ->rawColumns(['offense'])
//                 ->make(true);
//         }

        // $total_fess = FineUpload::sum('ticket_fee');
        // $total_bikes = FineUpload::distinct('plate_number')->count();
        // $total_company = collect(FineUpload::get());
        // $total_company = $total_company->unique('fine_upload_traffic_code_id')->count();

        //  $companies = Company::all();





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

        // first Delete file from the record
        //Delete all the data from the fine
        // delete the same data from the ar_balance sheet
        $traffic_code = FineUploadTrafficeCode::where('id','=',$id)->first();
        $file_path=$traffic_code->file_path;

    
        if(Storage::disk('s3')->exists('assets/upload/excel_file/fine_upload/'.$file_path)) {
            Storage::disk('s3')->delete('assets/upload/excel_file/fine_upload/'.$file_path);
            FineUploadTrafficeCode::where('id','=',$id)->delete();
            ArBalanceSheet::where('balance_type','4')->where('upload_file_sheet_id','=',$id)->delete();
             FineUpload::where('fine_upload_traffic_code_id',$id)->delete();

             $message = [
                'message' => 'Fine Deleted Permanetly Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        }


        // if(File::exists(public_path($file_path))){

        //     File::delete(public_path($file_path));
        //    FineUploadTrafficeCode::where('id','=',$id)->delete();

        //    ArBalanceSheet::where('balance_type','4')->where('upload_file_sheet_id','=',$id)->delete();
        //     FineUpload::where('fine_upload_traffic_code_id',$id)->delete();

        //     //Delete from

        //     $message = [
        //         'message' => 'Fine Deleted Permanetly Successfully',
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

    public function ajax_get_rider_filter_counts(Request $request){

        if($request->ajax()){
            if($request->start_date!="ab"){
                $company_id = $request->platform;
                $company =Company::find($company_id);
                $traffic_no = isset($company->comp_info->traffic_fle_no) ? $company->comp_info->traffic_fle_no : '';
                $traffic_ab = FineUploadTrafficeCode::where('traffic_file_no','=',$traffic_no)->first();
                $total_fess = 0;
                $total_bikes = 0;
                $total_company = 0;

                if(!empty($traffic_ab)){
                    $total_fess = FineUpload::where('fine_upload_traffic_code_id','=',$traffic_ab->id)->whereBetween('ticket_date', [$request->start_date, $request->end_date])->sum('ticket_fee');
                    $total_bikes = FineUpload::where('fine_upload_traffic_code_id','=',$traffic_ab->id)->whereBetween('ticket_date', [$request->start_date, $request->end_date])->distinct('plate_number')->count();
                    $total_company = collect(FineUpload::where('fine_upload_traffic_code_id','=',$traffic_ab->id)->whereBetween('ticket_date', [$request->start_date, $request->end_date])->get());
                    $total_company = $total_company->unique('fine_upload_traffic_code_id')->count();
                }else{
                    $total_fess = 0;
                    $total_bikes = 0;
                    $total_company = 0;
                }


                $array_to_send = array(
                    'total_fess' => $total_fess,
                    'total_bikes' => $total_bikes,
                    'total_company' => $total_company,
                );

                echo json_encode($array_to_send);
                exit;

            }else{

                $total_fess = FineUpload::sum('ticket_fee');
                $total_bikes = FineUpload::distinct('plate_number')->count();
                $total_company = collect(FineUpload::get());
                $total_company = $total_company->unique('fine_upload_traffic_code_id')->count();

                $array_to_send = array(
                    'total_fess' => $total_fess,
                    'total_bikes' => $total_bikes,
                    'total_company' => $total_company,
                );

                echo json_encode($array_to_send);
                exit;

            }


        }


    }

    public   function ajax_view_fine_offense(Request $request){

            $id = $request->primary_id;
            $fine = FineUpload::find($id);

            return $fine->offense;

        }

}
