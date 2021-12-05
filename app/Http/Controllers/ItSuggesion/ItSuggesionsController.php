<?php

namespace App\Http\Controllers\ItSuggesion;

use App\Model\It_tickets\It_tickets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItSuggesionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin-panel.it_suggesions.it_suggesions');

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
//        dd('here');
        if (!file_exists('../public/assets/upload/it_tickets/')) {
            mkdir('../public/assets/upload/it_tickets/', 0777, true);
        }

        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $file_name = time() . "_" . $request->date . '.' . $ext;

        move_uploaded_file($_FILES["img"]["tmp_name"], '../public/assets/upload/it_tickets/' . $file_name);
        $file_path = 'assets/upload/it_tickets/' . $file_name;

        //-------
        if (!file_exists('../public/assets/upload/it_tickets/')) {
            mkdir('../public/assets/upload/it_tickets/', 0777, true);
        }

        $ext2 = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
        $file_name2 = time() . "_" . $request->date . '.' . $ext2;

        move_uploaded_file($_FILES["file_name"]["tmp_name"], '../public/assets/upload/it_tickets/' . $file_name2);
        $file_path2 = 'assets/upload/it_tickets/' . $file_name2;




        $obj = new It_tickets();
        $obj->user_id = $request->input('user_id');
        $obj->message = $request->input('message');
        $obj->img = $file_path;
        $obj->file = $file_path2;
        $obj->status = '0';
//        dd($obj);
//        $obj->save();
        $obj->save();
        $message = [
            'message' => 'IT Ticket Generated Successfully',
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
}
