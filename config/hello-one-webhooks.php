<?php

return [


   /*
   |--------------------------------------------------------------------------
   | Webhook Route
   |--------------------------------------------------------------------------
   |
   | This is the route to where your webhooks will be sent
   | You can disable the publishing of the route to handle the requests
   | by yourself.
   | You can also define which middleware should be called.
   |
   */

    'routes' => [
        'publish' => env('HELLO_ONE_WEBHOOK_PUBLISH_ROUTES', true),
        'prefix' => env('HELLO_ONE_WEBHOOK_ROUTE_PREFIX', 'hello-one'),
        'middleware' => ['api'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Signing Secret
    |--------------------------------------------------------------------------
    |
    | The secret used to verify the webhook signature
    |
    */
    'signing_secret' => env('HELLO_ONE_WEBHOOK_SIGNING_SECRET', null),

    /*
    |--------------------------------------------------------------------------
    | Log Requests and errors
    |--------------------------------------------------------------------------
    |
    | Log all requests and errors
    |
    */
    'log_requests' => env('HELLO_ONE_WEBHOOK_LOG_REQUESTS', true),
    'log_errors' => env('HELLO_ONE_WEBHOOK_LOG_ERRORS', true),
    'log_channel' => env('HELLO_ONE_LOGGER', config('logging.default')),
];
