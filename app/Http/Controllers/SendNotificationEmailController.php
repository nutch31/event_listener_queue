<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendNotificationEmailController extends Controller
{
    //
    public function sendnotification(request $request)
    {

        for($x=1;$x<=1;$x++)
        {            
            $data = array(
                "name" => "Mr. Nut Chantathab",
                "email_from" => "admin.th@heroleads.com",
                "email" => array("nut@heroleads.com", "nut_ch31@hotmail.com"),
                "email_cc" => "nutnutnutnutnutnutnutnutnutnut@gmail.com",
                "email_bcc" => "pongchrist@heroleads.com",
                "subject_name" => "FYI : TEST SYSTEM",
                "campaign_name" => array("Rubic Cube : forgot enter new channel cycle", "Ford : forgot enter new channel cycle "),                
                "channel_name" => array("Channel 1", "Channel X"),
                "issue" => array("issue 1", "issue X"),
                "link_campaign"  => array("http://www.google.com", "http://www.google.com"),  
                "link_channel"  => array("http://www.google.com", "http://www.google.com"),      
            );

            $data = json_encode($data);
            
            $ch = curl_init("https://message.heroleads.co.th/sendEmail/public/index.php/api/notificationEmail");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
                
            curl_setopt($ch, CURLOPT_VERBOSE, true);
    
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                'Content-Type: application/json',                                                                                
                'Content-Length: ' . strlen($data))
            );     
            $response = curl_exec($ch);
            $info = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
            curl_close($ch);

        }

        return response(array(
            'Status' => 'Success'
        ), '200');
    }
}
