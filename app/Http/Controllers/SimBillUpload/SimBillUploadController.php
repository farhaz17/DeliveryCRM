<?php

namespace App\Http\Controllers\SimBillUpload;

use App\Model\Seeder\CompanyInformation;
use App\Model\SimBills;
use App\Model\SimBillUploadPath\SimBillUploadPath;
use App\Model\Vehicle_salik_sheet_account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\ArBalance\ArBalanceSheet;
use Illuminate\Support\Facades\Storage;
use App\Model\Assign\AssignSim;
use File;
use DB;
use DateTime;


class SimBillUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

           $total_amount_to_pay = SimBills::sum('amount_to_pay');
           $total_amount_due = SimBills::sum('total_amount_due');
           $total_count = SimBills::count();

        $sim_bills = SimBills::orderby('id','desc')->get();

        return view('admin-panel.simbill_upload.index',compact('sim_bills','total_amount_to_pay','total_amount_due','total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $uploads = SimBillUploadPath::orderby('id','desc')->get();
        return view('admin-panel.simbill_upload.create',compact('uploads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request);
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


        $last_id = Excel::toArray(new \App\Imports\SimBillUpload(null,null), request()->file('select_file'));
        $data = collect(head($last_id));


        $missing_sim = [];
        foreach($data as $key => $row){
            // dd($row['account_number']);
            $riderid_exists  = \App\Model\Telecome::where('account_number',$row['account_number'])->first();
            if(!$riderid_exists){
                $missing_sim[] = $row['account_number'];
            }
        }


        if(count($missing_sim) > 0){
            $message = [
                'message' => "SIM Bill Excel Sheet Upload Failed",
                'alert-type' => 'error',
                'missing_plate' => implode(',' , $missing_sim)
            ];
            return redirect()->back()->with($message);
        }else{

        // if (!file_exists('../public/assets/upload/excel_file/simbill_upload')) {
        //     mkdir('../public/assets/upload/excel_file/simbill_upload', 0777, true);
        // }
        $last_id = "";
        $file_image = "";
        if(!empty($_FILES['select_file']['name'])){



            $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;
            $file_path_image = 'assets/upload/excel_file/simbill_upload/' . $file_name;
            $t = Storage::disk('s3')->put($file_path_image, file_get_contents($request->select_file));


            // $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
            // $file_name = time()."_" .$request->start_date.'.'.$ext;
            // move_uploaded_file($_FILES["select_file"]["tmp_name"], '../public/assets/upload/excel_file/simbill_upload/'.$file_name);
            // $file_path_image = 'assets/upload/excel_file/simbill_upload/'.$file_name;
            $vehicle_sheet = new  SimBillUploadPath();
            $vehicle_sheet->file_path = $file_name;
            $vehicle_sheet->save();
            $last_id = $vehicle_sheet->id;

            // $file_image = public_path($file_path_image);
        }
       Excel::import(new \App\Imports\SimBillUpload($last_id), $file_path_image);
        $message = [
            'message' => 'Sim Bill Uploaded Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);

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

        $data = SimBills::where('sim_bill_upload_path_id',$id)->get();


        $not_match=array();
        foreach($data as $row){
            $new_formate =  $row->invoice_date;
            // $ab = explode(" ",$row->ticket_time);
            // $time_pay_now = $ab[0].':00'.$ab[1];

            $formate_time = $this->get_twenty_four_formate_time($new_formate);
            $bil_date = $new_formate." ".$formate_time;
            $payment_date = strtotime($bil_date);
            // dd($fine_date);

// dd($row->sim_detail->id);
//             $array_ab = array(
//                 $payment_date,
//                 $row->sim_detail->id
//             );

            // $query->whereDate('created_at', '=', date('Y-m-d'));
            if(isset($row->sim_detail->id)){


            $checkindata = AssignSim::
            where('sim','=',$row->sim_detail->id)
            ->where('checkin', '<=',$bil_date)
                ->first();


            if(isset($checkindata))
            {
                if($checkindata->status == 1 || $checkindata->checkout >= $bil_date)
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
                'account_number' =>  $row->account_number,
                'party_id' =>  $row->party_id,
                'product_type' =>  $row->product_type,
                'invoice_number' =>  $row->invoice_number,
                'invoice_date' =>  $row->invoice_date,
                'service_rental' =>  $row->service_rental,
                'usage_charge' =>  $row->usage_charge,
                'one_time_charges' =>  $row->one_time_charges,
                'other_credit_and_charges' =>  $row->other_credit_and_charges,
                'vat_on_taxable_services' =>  $row->vat_on_taxable_services,
                'billed_amoount' =>  $row->billed_amoount,
                'total_amount_due' =>  $row->total_amount_due,
                'amount_to_pay' =>  $row->amount_to_pay,





            );
            $not_match[] = $gamer;
        }
            // dd($not_match);





            return  view('admin-panel.fine_uploads.sim_not_matched',compact('not_match'));
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
        //



        $traffic_code = SimBillUploadPath::where('id','=',$id)->first();
        $file_path=$traffic_code->file_path;


        if(Storage::disk('s3')->exists('assets/upload/excel_file/simbill_upload/'.$file_path)) {
            Storage::disk('s3')->delete('assets/upload/excel_file/simbill_upload/'.$file_path);


            SimBillUploadPath::where('id','=',$id)->delete();
            ArBalanceSheet::where('balance_type','2')->where('upload_file_sheet_id','=',$id)->delete();
            SimBills::where('sim_bill_upload_path_id',$id)->delete();


             $message = [
                'message' => 'SIM Bill Deleted Permanetly Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        }




        // if(File::exists(public_path($file_path))){
        // //     dd('asdf');

        //     File::delete(public_path($file_path));
        //     SimBillUploadPath::where('id','=',$id)->delete();

        //    ArBalanceSheet::where('balance_type','2')->where('upload_file_sheet_id','=',$id)->delete();
        //    SimBills::where('sim_bill_upload_path_id',$id)->delete();

        //     //Delete from

        //     $message = [
        //         'message' => 'SIM Bill Deleted Permanetly Successfully',
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
}
