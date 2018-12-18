<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendActivationCode implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        //
        //\Log::info('activation', ['user' => $event->user]);

        //    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/profile/insert");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);

        $data = array(
            'title' => 'Mr.',
            'first_name' => 'AAAAAAAAAAA',
            'last_name' => 'BBBBBBBBBBBBBBB',
            'age' => '30',
            'height' => '199',
            'tall' => '200',
            'address' => 'BKK'
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
    }
}
