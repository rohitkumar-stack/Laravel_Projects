<?php

return [

    /*
     |----------------------------------------------------------------------
     | Queue Configuration
     |----------------------------------------------------------------------
     |
     | Set queue connection name to be use for running all the queues.
     |
     */
    'queue' => env('TENANTI_QUEUE_CONNECTION', 'default'),

    /*
    |----------------------------------------------------------------------
    | Driver Configuration
    |----------------------------------------------------------------------
    |
    | Setup your driver configuration to let us match the driver name to
    | a Model and path to migration.
    |
    */

    'drivers' => [
        'organisation' => [
            'model' => 'App\Models\Organisation',
            'paths' => database_path('tenant/organisation'),
            'shared' => true,
        ],
    ],
];
