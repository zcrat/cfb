<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FacturasEmisor;
use DB;
use App\Classes\Certificados;

class ConfigurarFacturaController extends Controller
{


    public function index(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

             $emisor = FacturasEmisor::find($request->id);
           

        return [

            'emisor' => $emisor
        ];
    }
    
    public function indexAll(Request $request)
    {
       
       
    
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        
        
        if ($buscar==''){
            $emisores = FacturasEmisor::orderBy('id', 'desc')->paginate(20);
        }
        else{
            $emisores = FacturasEmisor::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
        }

        

        return [
            'pagination' => [
                'total'        => $emisores->total(),
                'current_page' => $emisores->currentPage(),
                'per_page'     => $emisores->perPage(),
                'last_page'    => $emisores->lastPage(),
                'from'         => $emisores->firstItem(),
                'to'           => $emisores->lastItem(),
            ],
            'emisores' => $emisores
        ];
    }

    public function store(Request $request)
    {
     
       
        if($request->archivo_cerc==null){
            $fileName = $request->archivo_cer;
            $ncer = $request->n_certificado;
        } else {
            $exploded = explode(',', $request->archivo_cerc);
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'cer'))
                $extension = 'cer';
             else 
                $extension = 'key';
    
            $fileName = $request->rfc.'.'.$extension;
            $path = public_path().'/utilerias/certificados/'.$fileName;
            file_put_contents($path, $decoded);

            $archivo_cer =$path;  

            $cerpem = new Certificados();
	        $cerpem->generaCerPem($archivo_cer);
            $salida = shell_exec('openssl x509 -in '.$archivo_cer.".pem".' -noout -serial  2>&1');
	        if (strpos($salida, 'serial=') !== false){
			    	$salida = str_replace('serial=', '', $salida);
			    	$serial = '';
			    	for ($i = 0; $i<strlen($salida); $i++){
				    	if($i%2!=0)
				    	{
					    	$serial .= $salida[$i];
				    	}
			    	}
                    $ncer = $serial;
                
			}else {
				
            }
        }

        if($request->archivo_keyc==null){
            $fileName2 = $request->archivo_key;
        } else {
            $exploded2 = explode(',', $request->archivo_keyc);       
            $decoded2 = base64_decode($exploded2[1]);
            if(str_contains($exploded2[0], 'cer'))
                 $extension2 = 'cer';
             else 
                 $extension2 = 'key';    
            $fileName2 = $request->rfc.'.'.$extension2;
            $path2 = public_path().'/utilerias/certificados/'.$fileName2;
            file_put_contents($path2, $decoded2);
        }

        if (!$request->ajax()) return redirect('/');
        $articulo = new FacturasEmisor();
        $articulo->rfc_emisor = $request->rfc;
        $articulo->nombre_emisor = $request->razonsocial;
        $articulo->regimen_emisor = $request->regimen;
        $articulo->codigo_emisor = $request->codigo;
        $articulo->serie_factura = $request->serie;
        $articulo->folio_factura = $request->folio;
        $articulo->n_certificado = $ncer;
        $articulo->clave_key = $request->clave_key;
        $articulo->archivo_cer = $fileName;
        $articulo->archivo_key = $fileName2;
        $articulo->save();

        $estado = true;
        return ['estado' => $estado];
    }

    public function update(Request $request)
    {
     
       
        if($request->archivo_cerc==null){
            $fileName = $request->archivo_cer;
            $ncer = $request->n_certificado;
        } else {
            $exploded = explode(',', $request->archivo_cerc);
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'cer'))
                $extension = 'cer';
             else 
                $extension = 'key';
    
            $fileName = $request->rfc.'.'.$extension;
            $path = public_path().'/utilerias/certificados/'.$fileName;
            file_put_contents($path, $decoded);

            $archivo_cer =$path;  

            $cerpem = new Certificados();
	        $cerpem->generaCerPem($archivo_cer);
            $salida = shell_exec('openssl x509 -in '.$archivo_cer.".pem".' -noout -serial  2>&1');
	        if (strpos($salida, 'serial=') !== false){
			    	$salida = str_replace('serial=', '', $salida);
			    	$serial = '';
			    	for ($i = 0; $i<strlen($salida); $i++){
				    	if($i%2!=0)
				    	{
					    	$serial .= $salida[$i];
				    	}
			    	}
                    $ncer = $serial;
                
			}else {
				
            }
        }

        if($request->archivo_keyc==null){
            $fileName2 = $request->archivo_key;
        } else {
            $exploded2 = explode(',', $request->archivo_keyc);       
            $decoded2 = base64_decode($exploded2[1]);
            if(str_contains($exploded2[0], 'cer'))
                 $extension2 = 'cer';
             else 
                 $extension2 = 'key';    
            $fileName2 = $request->rfc.'.'.$extension2;
            $path2 = public_path().'/utilerias/certificados/'.$fileName2;
            file_put_contents($path2, $decoded2);
        }

        if (!$request->ajax()) return redirect('/');
        $articulo = FacturasEmisor::findOrFail($request->id);
        $articulo->rfc_emisor = $request->rfc;
        $articulo->nombre_emisor = $request->razonsocial;
        $articulo->regimen_emisor = $request->regimen;
        $articulo->codigo_emisor = $request->codigo;
        $articulo->serie_factura = $request->serie;
        $articulo->folio_factura = $request->folio;
        $articulo->n_certificado = $ncer;
        $articulo->clave_key = $request->clave_key;
        $articulo->archivo_cer = $fileName;
        $articulo->archivo_key = $fileName2;
        $articulo->save();


        return ['articulo' => $articulo];
    }

   

   
}
