<?php

namespace App\Http\Controllers;


use App\Model\Form_upload;
use App\Model\Vehicle_salik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\DeclareDeclare;

class UploadFormsController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|upload-form-upload-form|upload-form-view-forms', ['only' => ['index','store','destroy','edit','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result=Form_upload::all();
        return view('admin-panel.uploading_forms.upload_forms',compact('result'));
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
        $cv=null;
        if (!empty($_FILES['file_name']['name'])) {
            if (!file_exists('../public/assets/upload_forms/')) {
                mkdir('../public/assets/upload_forms/', 0777, true);
            }

            $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;
//            dd($file_name);
            move_uploaded_file($_FILES["file_name"]["tmp_name"], '../public/assets/upload_forms/' . $file_name);
            $cv = file_get_contents(asset('assets/upload_forms/' . $file_name));
//            $cv = file_get_contents($file_name[0]);
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
                    $value = array('transaction_id' => $value['Transaction ID'],
                        'trip_date' => $value['Trip Date'],
                        'trip_time' => $value['Trip Time'],
                        'transaction_post_date' => $value['Transaction Post Date'],
                        'toll_gate' => $value['Toll Gate'],
                        'direction' => $value['Direction'],
                        'tag_number' => $value['Tag Number'],
                        'plate' => $value['Plate'],
                        'amount' => $value['Amount(AED)'],
                        'account_number' => $value['Account Number'],
                    );
                    array_push($data, $value);
                }

            }
            try {
                $arrayLength = count($data);
                $i = 0;
                while ($i < $arrayLength)
                {
                    $transaction_id_inserted=$data[$i]["transaction_id"];
                    $res = DB::table('vehicle_saliks')->where('transaction_id', $transaction_id_inserted)->first();


                    if (isset($res)) {
                        DB::table('vehicle_saliks')->where('transaction_id', $transaction_id_inserted)->update($data[$i]);

                    }
                    else {
                        Vehicle_salik::insert($data[$i]);
                    }
                    $i++;
                }
                $message = [
                    'message' => 'File Added Successfully',
                    'alert-type' => 'success',
                ];

                return redirect()->route('upload_form')->with($message);
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


}
