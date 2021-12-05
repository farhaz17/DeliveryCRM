<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function download(){
        return view('admin-panel.pages.download_apk');
    }

    public function fileDownload(){
        //Suppose profile.docx file is stored under project/public/download/profile.docx
//        $download = 'http://localhost/zone_repair/ticket_app/voices/'. $filename;
//        return response()->download($download);

        return response()->download(base_path("ticket_app/apk/Zone_Delivery_CSR.apk"));
    }
}
