<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\CategoryAssign;
use App\Model\Project\invoice;
use App\Model\Project\Project;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|ProjectManage', ['only' => ['index','invoiceview','assign','status','report','store','update','']]);
    }
    public function index()
    {
        $invoice=invoice::all();
        $project=Project::all();
        $name=CategoryAssign::where('main_category','=', '1')->get();
        return view('admin-panel.Project.Invoice',compact('invoice','project','name'));
    }

    public function invoiceview()
    {
        $invoice=invoice::all();
        $project=Project::all();
        return view('admin-panel.Project.invoice_view',compact('invoice','project'));
    }

    public function assign()
    {
        $invoice=invoice::all();
        $project=Project::where('status','!=', '1')->get();
        return view('admin-panel.Project.Assignproject',compact('invoice','project'));
    }

    public function status()
    {
        $invoice=invoice::all();
        $project=Project::all();
        return view('admin-panel.Project.project_status',compact('invoice','project'));
    }

    public function report()
    {
        $invoice=invoice::all();
        $project=Project::all();
        return view('admin-panel.Project.report',compact('invoice','project'));
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
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'unique:invoices,invoice_number',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";
            foreach ($validate->all() as $error){
                $message_error .= $error;
            }
            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }
        $obj = new invoice();

        if (!file_exists('../public/assets/upload/project_invoices/')) {
            mkdir('../public/assets/upload/project_invoices/', 0777, true);
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $file_name = time() . "_" . $request->date . '.' . $ext;

        move_uploaded_file($_FILES["image"]["tmp_name"], '../public/assets/upload/project_invoices/' . $file_name);
        $file_path = 'assets/upload/project_invoices/' . $file_name;

        $pro = IdGenerator::generate(['table' => 'invoices', 'field' => 'inv_no', 'length' => 7, 'prefix' => 'INV1']);
            $obj->invoice_number=$request->input('invoice_number');
            $obj->invoice_image=$file_path;
            $obj->person_name=$request->input('person_name');
            $obj->amount=$request->input('amount');
            $obj->cash_credit=$request->input('cash_credit');
            $obj->inv_no=$pro;
            $obj->save();

            $message = [
                'message' => 'Invoice Added Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('project_invoice')->with($message);
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
        $obj = invoice::find($id);
        $obj->project_id=$request->input('project_name');
        $obj->save();
        $message = [
            'message' => ' Updated Successfully',
            'alert-type' => 'success'
        ];
        return back()->with($message);
        // return redirect()->route('project_invoice')->with($message);
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
