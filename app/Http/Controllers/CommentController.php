<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    ///
    public function __construct()
    {
        $this->user_type = "App\User";
        $this->user_id = 1;
        $this->auditable_type = "App\Comment";
        $this->url = "https://message.heroleads.co.th/laravel_event/public/index.php/api/comment/";
        $this->ip_address = "127.0.0.1";
        $this->user_agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36";
    }

    public function select(request $request)
    {
        $comments = Comment::find($request->id)->get();

        return response(array(
            $comments
        ), '200');
    }

    public function insert(request $request)
    {
        $comment = new Comment;

        $comment->post_id    = $request->post_id;
        $comment->comment    = $request->comment;
        $comment->user_id    = $this->user_id;

        $comment->save();

        $data = array(
            'user_type' => $this->user_type,
            'user_id' => $this->user_id,
            'event' => 'created',
            'auditable_type' => $this->auditable_type,
            'auditable_id' => $comment->id,
            'new_values' => $comment["attributes"],
            'url' => $this->url.'insert',
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'tags' => ''
        );
        
        //dispatch(new LoggingService($data));

        $this->call_logging_server($data);
        
        return response(array(
            'Status' => 'Success'
        ), '200');
    }

    public function update(request $request)
    {
        $comment = Comment::find($request->id);
        
        $old = $comment["attributes"];

        $comment->post_id    = $request->post_id;
        $comment->comment    = $request->comment;
        $comment->user_id    = $this->user_id;
        
        $comment->save();

        $data = array(
            'user_type' => $this->user_type,
            'user_id' => $this->user_id,
            'event' => 'updated',
            'auditable_type' => $this->auditable_type,
            'auditable_id' => $comment->id,
            'old_values' => $old,
            'new_values' => $comment["attributes"],
            'url' => $this->url.'update',
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'tags' => ''
        );

        //dispatch(new LoggingService($data));

        $this->call_logging_server($data);

        return response(array(
            'Status' => 'Success'
        ), '200');
    }

    public function delete(request $request)
    {
        $comment = Comment::find($request->id);
        $comment->delete();
        
        $data = array(
            'user_type' => $this->user_type,
            'user_id' => $this->user_id,
            'event' => 'deleted',
            'auditable_type' => $this->auditable_type,
            'auditable_id' => $comment->id,
            'old_values' => $comment["attributes"],
            'url' => $this->url.'delete',
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'tags' => ''
        );

        //dispatch(new LoggingService($data));
        
        $this->call_logging_server($data);

        return response(array(
            'Status' => 'Success'
        ), '200');
    }

    public function call_logging_server($data)
    {        
        $data = json_encode($data);

        $ch = curl_init("http://logservice.heroleads.co.th/logService/public/index.php/createTaskApprovalService");
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
}
