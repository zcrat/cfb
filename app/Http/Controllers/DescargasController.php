<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DescargasController extends Controller
{
    public function downloadFile($file){
        $pathtoFile = public_path().'/facturas/'.$file;
        return response()->download($pathtoFile);
      }

      public function downloadFileXML($file){
        $pathtoFile = public_path().'/documentos/facturas_clientes_xml/'.$file;
        return response()->download($pathtoFile);
      }

      public function downloadFilePDF($file){
        $pathtoFile = public_path().'/documentos/facturas_clientes_pdf/'.$file;
        return response()->download($pathtoFile);
      }
}
