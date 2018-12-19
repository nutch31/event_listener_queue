<?php

namespace App\Http\Controllers;

use App\Jobs\LoggingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Profile;
use App\Http\Controllers\Controller;
use App\Events\LoggingServerEvents;

class ProfileController extends Controller
{
    ///
    public function select(request $request)
    {
        $profiles = Profile::find($request->id)->get();

        return response(array(
            $profiles
        ), '200');
    }

    public function insert(request $request)
    {
        $profile = new Profile;

        $profile->title = $request->title;
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->age = $request->age;
        $profile->height = $request->height;
        $profile->tall = $request->tall;
        $profile->address = $request->address;

        $profile->save();

        $data = array(
            'user_type' => 'App\User',
            'user_id' => '1',
            'event' => 'created',
            'auditable_type' => 'App\Profile',
            'auditable_id' => $profile->id,
            'old_values' => '',
            'new_values' => $profile["attributes"],
            'url' => 'http://localhost:8000/laravel_event/insert',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36',
            'tags' => ''
        );

        dispatch(new LoggingService($data));

        return response(array(
            'Status' => 'Success'
        ), '200');
    }

    public function update(request $request)
    {
        $profile = Profile::find($request->id);
        
        $old = $profile["attributes"];

        $profile->title = $request->title;
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->age = $request->age;
        $profile->height = $request->height;
        $profile->tall = $request->tall;
        $profile->address = $request->address;
        
        $profile->save();

        $data = array(
            'user_type' => 'App\User',
            'user_id' => '1',
            'event' => 'updated',
            'auditable_type' => 'App\Profile',
            'auditable_id' => $profile->id,
            'old_values' => $old,
            'new_values' => $profile["attributes"],
            'url' => 'http://localhost:8000/laravel_event/update',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36',
            'tags' => ''
        );

        dispatch(new LoggingService($data));

        return response(array(
            'Status' => 'Success'
        ), '200');
    }

    public function delete(request $request)
    {
        $profile = Profile::find($request->id);
        $profile->delete();
        
        $data = array(
            'user_type' => 'App\User',
            'user_id' => '1',
            'event' => 'deleted',
            'auditable_type' => 'App\Profile',
            'auditable_id' => $profile->id,
            'old_values' => $profile["attributes"],
            'new_values' => '',
            'url' => 'http://localhost:8000/laravel_event/delete',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36',
            'tags' => ''
        );

        dispatch(new LoggingService($data));

        return response(array(
            'Status' => 'Success'
        ), '200');
    }
}
