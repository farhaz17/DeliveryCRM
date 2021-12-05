<?php

namespace App\Http\Controllers;


use App\Bike;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\InvParts;
use App\Model\Parts;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\Types\Null_;

class BikemasterController extends Controller
{
    public function index()
    {
        $bike = Bike::all()->toArray();
        return view('admin-panel.pages.bike_master',compact('bike'));
    }

    public function store(Request $request)
    {
        $cv=null;
        if (!empty($_FILES['file_name']['name'])) {
            if (!file_exists('../public/assets/docs/')) {
                mkdir('../public/assets/docs/', 0777, true);
            }
            $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;
            move_uploaded_file($_FILES["file_name"]["tmp_name"], '../public/assets/docs/' . $file_name);
            $cv = file_get_contents(asset('assets/docs/' . $file_name));
            $lines = explode(PHP_EOL, $cv);

            $csvContents = array();
            foreach ($lines as $key => $line) {
                $csvContents[] = str_getcsv($line);
            }
            $keys = $csvContents[0];
            unset($csvContents[0]);
            $keys = collect($keys)->transform(function ($item) {
                return trim($item);
            })->toArray();
            $csvContents = array_values($csvContents);
            foreach ($csvContents as &$row) {
                foreach ($row as $key => $value) {
                    $row[$keys[$key]] = trim($value);
                    unset($row[$key]);
                }
            }
            $kd = 0;
            $data = array();
            foreach ($csvContents as $key => $value) {
                if ($key < count($csvContents) - 1) {
                   $date = new \DateTime($request->date);
                    $value = array('model' => $value['Model'],
                        'chasis_no' => $value['Chasis No'],
                        'plate_no' => $value['Plate No'],
                        'make_year' => $value['Make Year'],
                        'company' => $value['Company'],
                        'registration_valid' => $value['Registration ValidFor Days'],
                        'no_of_fines' => $value['No of fines'],
                        'fines_amount' => $value['Fines Amount'],
                        'issue_date' => $value['Issue Date'],
                        'expiry_date' => $value['Expiry Date'],
                        'insurance_co' => $value['Innsurance co'],
                        'mortaged_by' => $value['Mortagged By'],
                    );
                    array_push($data, $value);
                }
            }
            try {
                $arrayLength = count($data);
                $i = 0;
                while ($i < $arrayLength)
                {
                    $chasis_inserted=$data[$i]["chasis_no"];
                    $res = DB::table('bikes')->where('chasis_no', $chasis_inserted)->first();

                        if (isset($res)) {
                           DB::table('bikes')->where('chasis_no', $chasis_inserted)->update($data[$i]);
                               }
                        else {
                            Bike::insert($data[$i]);
                        }
                    $i++;
                }
                $message = [
                    'message' => 'File Added Successfully',
                    'alert-type' => 'success',
                ];
                return redirect()->route('bike')->with($message);
            }
            catch (\Illuminate\Database\QueryException $e) {
                $result = [
                    'error' => $e->getMessage()
                ];
                return response()->json($result, 500);
            }
        }
        else {
            $result['response'] = false;
            $result['message'] = "file not found";
            return response()->json($result, 200);
        }
    }

    public function edit($id)
    {
        $edit_bike_data=Bike::find($id);
        $bike=Bike::all();
        return view('admin-panel.pages.bike_master',compact('edit_bike_data','bike'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'chasis_no' => 'unique:bikes,chasis_no,'.$id
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => 'Chasis number already exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('bike')->with($message);
            }
            $model = $request->get('model');
            $chasis_no = $request->get('chasis_no');
            $plate_no = $request->get('plate_no');
            $make_year = $request->get('make_year');
            $registration_valid = $request->get('registration_valid');
            $no_of_fines = $request->get('no_of_fines');
            $fines_amount = $request->get('fines_amount');
            $issue_date = $request->get('issue_date');
            $expiry_date = $request->get('expiry_date');
            $insurance_co = $request->get('insurance_co');
            $mortaged_by = $request->get('mortaged_by');
            DB::table('bikes')->where('id', $id)->update([
                'model' => $model,
                'chasis_no'=> $chasis_no,
                'plate_no' => $plate_no,
                'make_year'=> $make_year,
                'registration_valid' => $registration_valid,
                'no_of_fines'=> $no_of_fines,
                'fines_amount' => $fines_amount,
                'issue_date'=> $issue_date,
                'expiry_date'=> $expiry_date,
                'insurance_co'=> $insurance_co,
                 'mortaged_by'=> $mortaged_by
            ]);
            $message = [
                'message' => 'Bike Updated Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('bike')->with($message);
        }
        catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('bike')->with($message);
        }
    }

    public function destroy($id)
    {
        try {
            $obj = Bike::find($id);

            $obj->delete();
            $message = [
                'message' => 'Bike Deleted Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('bike')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('bike')->with($message);
        }
    }
}
