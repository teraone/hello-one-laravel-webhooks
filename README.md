# [hello one](https://www.hello-one.de) webhooks for Laravel

Securely receive Webhooks from your [hello one](https://www.hello-one.de) project.

## Installation
 1) You can install this package via composer using the following command:
    ```sh
    composer require hello-one/laravel-webhooks
    ```
    The package will automatically register itself using [package discovery](https://laravel.com/docs/packages#package-discovery).

 2) Add your app as a webhook on our [dashboard](https://dashboard.hello-one.de/). 
    The default route is 
    ```
    https://{{yourdomain.com}}/hello-one/webhook
    ```
    Please note: we only support TLS endpoints ("https only")
    
 3) Copy the secret signing key
 4) Add the secret signing key to your .env file 
    ```dotenv
    HELLO_ONE_WEBHOOK_SIGNING_SECRET={{INSERT_TOKEN_HERE}
    ```
 5) Your app will now receive events from your hello one project. You can test the integration by sending a test-event from our dashboard
 
    
## Usage
This package handles incoming webhook requests from hello one.
It verifies the request signature of hello one webhook requests.
When a request is valid the package emits and emits a  [Laravel Event](https://laravel.com/docs/7.x/events) 

To react on any of the events you can create an event listener. 

Listen to all webhook events with a wildcard:
```php
Event::listen('hello-one.webhook.*', function (string $eventName, array $data) {
    Log::info('hello one event received: '.  $eventName, $data);
});
```

Listen to specific events:
```php
Event::listen('hello-one.webhook.guest.created', function (string $eventName, array $data) {
    Log::info('A new Guest was just created', $data['guest']['id']);
    // use the data from $data['guest'] 
});
```



## Event List
You can query the complete event list from our [API](https://api-stage.hello-one.de/api/documentation)

```shell script
curl -X GET "https://api.hello-one.de/api/webhooks/events" -H  "accept: application/json"
```

Please note: in Laravel all events are prefixed with `hello-one.webhook.`

|  Laravel Event Name | Description   |
|---|---|
|  `hello-one.webhook.webhook_test`            |  This is a test event. You should ignore it. |
|  `hello-one.webhook.guest.created`            |  A Guest registered or was added by an admin |
|  `hello-one.webhook.guest.updated`            | A Guest was updated  |
|  `hello-one.webhook.guest.deleted`            | A Guest was deleted  |
|  `hello-one.webhook.event_booking.created`    | The Guest made a reservation for an event  |
|  `hello-one.webhook.event_booking.updated`    |   |
|  `hello-one.webhook.event_booking.deleted`    |   |
|  `hello-one.webhook.event.created`            | An event was added to your project  |
|  `hello-one.webhook.event.updated`            |   |
|  `hello-one.webhook.event.deleted`            |   |
|  `hello-one.webhook.session.created`          | A session was added to an event  |
|  `hello-one.webhook.session.updated`          |   |
|  `hello-one.webhook.session.deleted`          |   |
|  `hello-one.webhook.session_booking.created`  | A Guest booked a session  |
|  `hello-one.webhook.session_booking.updated`  |   |
|  `hello-one.webhook.session_booking.deleted`  |   |
|  `hello-one.webhook.form_submission.created`  | A form was submitted  |
|  `hello-one.webhook.form_submission.updated`  |   |
|  `hello-one.webhook.form_submission.deleted`  |   |
|  `hello-one.webhook.form.created`             | A form was created  |
|  `hello-one.webhook.form.updated`             |   |
|  `hello-one.webhook.form.deleted`             |   |
|  `hello-one.webhook.audience.created`         | An audience was created  |
|  `hello-one.webhook.audience.updated`         |   |
|  `hello-one.webhook.audience.delete`          |   |


    
## Configuration
Publish the config file and adjust as needed
```sh
 php artisan vendor:publish --tags 'hello-one-webhooks'
 ```


## Documentation
Please notice our [Webhook Documentation](https://docs.hello-one.de/project-settings/webhooks.html)

## Contributing
Feel free to open a ticket, submit a Pull Request or ask our [Support Team](mailto:info@hello-one.de)

