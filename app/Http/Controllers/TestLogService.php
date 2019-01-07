<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestLogService extends Controller
{
    ///
    public function __construct()
    {
    }

    public function select(request $request)
    {        
        $response = $this->call_logging_server_get();

        return response(array(
            'Status' => $response
        ), '200');
    }

    public function insert(request $request)
    {
        $response = $this->call_logging_server_post();
        
        return response(array(
            'Status' => $response
        ), '200');
    }

    public function call_logging_server_get()
    {   
        // create curl resource 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "http://logservice.heroleads.co.th/logService/public/index.php/get"); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'secretKey: 6e6b5e6a-cf0c-462a-8303-8e6bb6403930'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      

        return $output;

    }

    public function call_logging_server_post()
    {        
        $ch = curl_init("http://logservice.heroleads.co.th/logService/public/index.php/post");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
            
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'secretKey: 6e6b5e6a-cf0c-462a-8303-8e6bb6403930'
        ));
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $response = curl_exec($ch);
        $info = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        curl_close($ch);

        return $response;
    }
}