<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    |
    | These are the oAuth credentials provided by My Utility Genius for
    | accessing the API on registration.
    |
    | https://api-home.myutilitygenius.co.uk/user-guide
    |
    */

    'auth' => [
        'client-id' => env('MUG_CLIENT_ID'),
        'secret-key' => env('MUG_CLIENT_SECRET'),
    ],

];
