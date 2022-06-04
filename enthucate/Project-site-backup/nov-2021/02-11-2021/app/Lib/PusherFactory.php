<?php
namespace App\Lib;
use Pusher\Pusher;
use Config;
class PusherFactory
{
    public static function make()
    {
        // Config::get('app.PUSHER_APP_CLUSTER')
        return new Pusher(
           Config::get('app.PUSHER_APP_KEY'), // public key
            Config::get('app.PUSHER_APP_SECRET'), // Secret
            Config::get('app.PUSHER_APP_ID'), // App_id
            array(
                'cluster' => Config::get('app.PUSHER_APP_CLUSTER'), // Cluster
                'encrypted' => true,
            )
        );
    }
}