<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    ///
    public function __construct()
    {
        $this->user_type = "App\User";
        $this->user_id = 1;
        $this->auditable_type = "App\Post";
        $this->url = "https://message.heroleads.co.th/laravel_event/public/index.php/api/post/";
        $this->ip_address = "127.0.0.1";
        $this->user_agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36";
    }

    public function select(request $request)
    {
        $posts = Post::find($request->id)->get();

        return response(array(
            $posts
        ), '200');
    }

    public function insert(request $request)
    {
        $post = new Post;

        $post->post_name    = $request->post_name;
        $post->post_detail  = $request->post_detail;
        $post->status       = $request->status;
        $post->user_id      = $this->user_id;

        $post->save();

        $data = array(
            'user_type' => $this->user_type,
            'user_id' => $this->user_id,
            'event' => 'created',
            'auditable_type' => $this->auditable_type,
            'auditable_id' => $post->id,
            'new_values' => $post["attributes"],
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
        $post = Post::find($request->id);
        
        $old = $post["attributes"];

        $post->post_name    = $request->post_name;
        $post->post_detail  = $request->post_detail;
        $post->status       = $request->status;
        $post->user_id      = $this->user_id;
        
        $post->save();

        $data = array(
            'user_type' => $this->user_type,
            'user_id' => $this->user_id,
            'event' => 'updated',
            'auditable_type' => $this->auditable_type,
            'auditable_id' => $post->id,
            'old_values' => $old,
            'new_values' => $post["attributes"],
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
        $post = Post::find($request->id);
        $post->delete();
        
        $data = array(
            'user_type' => $this->user_type,
            'user_id' => $this->user_id,
            'event' => 'deleted',
            'auditable_type' => $this->auditable_type,
            'auditable_id' => $post->id,
            'old_values' => $post["attributes"],
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

        $ch = curl_init("https://message.heroleads.co.th/loggingService/public/index.php/api/insert");
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
