<?php

namespace App\Http\Controllers\BikeImpoundingUpload;

use DataTables;
use App\Model\BikeDetail;
use Illuminate\Http\Request;
use App\Imports\BikeImpounding;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\Vehicle\VehiclePlateCode;
use App\Model\BikeImpounding\BikeImpoundingUpload;
use App\Model\BikeImpounding\BikeImpoundingUploadFile_Path;

class BikeImpoundingUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax()) {

            if(!empty($request->from_date)){

                $data = BikeImpoundingUpload::whereBetween('ticket_date', [$request->from_date, $request->end_date])->orderby('ticket_date','desc')->get();

            }else{
                $data = BikeImpoundingUpload::orderby('id','desc')->get();
            }

            return Datatables::of($data)
                ->editColumn('number_days', function (BikeImpoundingUpload $upload) {
                    return $upload->number_of_days_of_booking;
                })
                ->editColumn('fine_date', function (BikeImpoundingUpload $upload){
                        return $upload->fine_date;
                })
                ->editColumn('fine_days', function (BikeImpoundingUpload $upload){
                    if(!$upload->fine_date) {
                        $date = date("d-m-Y", strtotime("$upload->ticket_date +10 days"));

                        $now = date('d-m-Y', time());
                        $datediff =  strtotime($date) - strtotime($now);
                        $datediff = $datediff/86400;
                        return $datediff;
                    }
                    return '';

                })
                ->editColumn('action', function (BikeImpoundingUpload $upload){
                    if($upload->fine_date) {
                        return 'Completed';
                    } else{
                        return '<a class="btn btn-primary impound-btn" data-toggle="modal" data-id="'. $upload->id . '"  data-target="#impoundModal" type="button" href="javascript:void(0)">Impound</a>';
                    }

                })
                ->make(true);
        }

        $total_fess = BikeImpoundingUpload::sum('value_instead_of_booking');
        $total_bikes = BikeImpoundingUpload::distinct('plate_number')->count();


        return view('admin-panel.bike_impounding_upload.index',compact('total_fess','total_bikes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bike_uploads = BikeImpoundingUploadFile_Path::orderby('id','desc')->get();
        $uploads = BikeImpoundingUpload::with('excel_sheet')->get();
        $plates = BikeDetail::get();
        $vehicle_plate_codes = VehiclePlateCode::all();
        return view('admin-panel.bike_impounding_upload.create',compact('bike_uploads', 'plates', 'uploads', 'vehicle_plate_codes'));
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


        if (!file_exists('../public/assets/upload/excel_file/bike_impounding')) {
            mkdir('../public/assets/upload/excel_file/bike_impounding', 0777, true);
        }
        $last_id = "";
        $file_image = "";


        if(!empty($_FILES['select_file']['name'])){
            $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
            $file_name = time()."_" .$request->start_date.'.'.$ext;
            move_uploaded_file($_FILES["select_file"]["tmp_name"], '../public/assets/upload/excel_file/bike_impounding/'.$file_name);
            $file_path_image = 'assets/upload/excel_file/bike_impounding/'.$file_name;
            // $name = rand(100,100000).'.'.time().'.'.$request->select_file->extension();
            // $file_path_image = 'assets/upload/lpo/' . $name;
            // $t = Storage::disk('s3')->put($file_path_image , file_get_contents($request->select_file));

            $bike_upload_path = new  BikeImpoundingUploadFile_Path();
            $bike_upload_path->file_path = $file_path_image;
            $bike_upload_path->save();
            $last_id = $bike_upload_path->id;

            $file_image = public_path($file_path_image);
        }


        $import = new BikeImpounding($last_id);
        Excel::import($import, $file_image);
        // return  $import->getMessage();
        $msg =  $import->getMessage();
        $message = [
            'message' => "$msg Bike Impounding Uploaded Successfully",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);


    }

    public function single_bike_impounding(Request $request) {
        // return $request->all();
        $obj = new BikeImpoundingUpload;
        $obj->plate_number = $request->plate_no;
        $obj->plate_category = $request->plate_category;
        $obj->ticket_number = $request->ticket_number;
        $obj->ticket_date = $request->ticket_date;
        $obj->ticket_time = $request->ticket_time;
        $obj->value_instead_of_booking = $request->value;
        $obj->number_of_days_of_booking = $request->no_days;
        $obj->text_violation = $request->text_violation;
        $obj->save();
        $message = [
            'message' => "Bike Impounding Uploaded Successfully",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
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
    }

    public function bike_impounding_total_amount_ajax(Request $request){

        if($request->ajax()){

            if($request->start_date=="ab"){

                $data = BikeImpoundingUpload::orderby('id','desc')->get();

                $array_to_send = array(
                    'total_amount' => $data->sum('value_instead_of_booking') ? number_format($data->sum('value_instead_of_booking'), 2) : 0,
                    'total_rider' => $data->count() ? number_format($data->count(), 2) : 0,
                );

                echo json_encode($array_to_send);
                exit;

            }else{

                $data = BikeImpoundingUpload::whereBetween('ticket_date', [$request->start_date, $request->end_date])->orderby('ticket_date','desc')->get();
                $array_to_send = array(
                    'total_amount' => $data->sum('value_instead_of_booking') ? number_format($data->sum('value_instead_of_booking'), 2) : 0,
                    'total_rider' => $data->count() ? $data->count() : 0,
                );

                echo json_encode($array_to_send);
                exit;
            }

        }

    }

    public function fine_or_impound(Request $request){


        $validator = Validator::make($request->all(), [
            'fine_date' => 'required',
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

        BikeImpoundingUpload::where('id', $request->id)->update([
            'fine_date' =>  $request->fine_date,
        ]);

        $message = [
            'message' => "Bike Impounding Uploaded Successfully",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function impounded_bike(Request $request){



        if($request->ajax()) {

            if(!empty($request->from_date)){
                $data = BikeImpoundingUpload::where('fine_date', '!=', NULL)->where('number_of_days_of_booking', '>=', 30)->whereBetween('ticket_date', [$request->from_date, $request->end_date])->orderby('id','desc')->get();

            }else{
                $data = BikeImpoundingUpload::where('fine_date', '!=', NULL)->where('number_of_days_of_booking', '>=', 30)->orderby('id','desc')->get();
            }

            return Datatables::of($data)
            ->editColumn('number_days', function (BikeImpoundingUpload $upload) {
                return $upload->number_of_days_of_booking;
            })
            ->editColumn('fine_date', function (BikeImpoundingUpload $upload){
                    return $upload->fine_date;
            })
            ->editColumn('tracking_date', function (BikeImpoundingUpload $upload){
                return $upload->tracking_date;
            })
            ->editColumn('impound_days_left', function (BikeImpoundingUpload $upload){
                if($upload->tracking_date) {
                    $date = date("d-m-Y", strtotime("$upload->tracking_date +$upload->number_of_days_of_booking days"));

                    $now = date('d-m-Y', time());
                    $datediff =  strtotime($date) - strtotime($now);
                    $datediff = $datediff/86400;
                    if($datediff < 0)
                        return 0;
                    return $datediff;
                }
                return '';

            })
            ->editColumn('action', function (BikeImpoundingUpload $upload){
                if($upload->tracking_date) {
                    return 'Completed';
                } else{
                    return '<a class="btn btn-primary impound-btn" data-toggle="modal" data-id="'. $upload->id . '"  data-target="#impoundModal" type="button" href="javascript:void(0)">Impound</a>';
                }

            })
            ->make(true);
        }

        $total_fess = BikeImpoundingUpload::sum('value_instead_of_booking');
        $total_bikes = BikeImpoundingUpload::distinct('plate_number')->count();

        return view('admin-panel.bike_impounding_upload.impounded-bike', compact('total_fess','total_bikes'));
    }

    public function impound_tracking(Request $request){


        $validator = Validator::make($request->all(), [
            'tracking_date' => 'required',
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

        BikeImpoundingUpload::where('id', $request->id)->update([
            'tracking_date' =>  $request->tracking_date,
        ]);

        $message = [
            'message' => "Bike Tracking Updated Successfully",
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($message);
    }
}
