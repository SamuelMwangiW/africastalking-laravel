<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | AfricasTalking Username
    |--------------------------------------------------------------------------
    |
    | This value is the username for your AfricasTalking account. In sandbox
    | mode, this is typically set to 'sandbox'. In production, you should
    | use your actual AfricasTalking username.
    |
    */
    'username' => env('AFRICASTALKING_USERNAME', 'sandbox'),

    /*
    |--------------------------------------------------------------------------
    | AfricasTalking API Key
    |--------------------------------------------------------------------------
    |
    | This is your AfricasTalking API key which is used to authenticate
    | your requests to the AfricasTalking API.
    |
    */
    'api-key' => env('AFRICASTALKING_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | SMS Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can specify the SMS sender ID or short code that will appear
    | as the sender of messages sent through the AfricasTalking SMS API.
    |
    */
    'sms' => [
        'from' => env('AFRICASTALKING_FROM'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the product name for payment services. This is the name that
    | will be used to identify your payment service on AfricasTalking.
    |
    */
    'payment' => [
        'product-name' => env('AFRICASTALKING_PAYMENT_PRODUCT'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Voice Configuration
    |--------------------------------------------------------------------------
    |
    | This section configures the phone number that will be used as the caller
    | ID when making outbound calls through AfricasTalking Voice API.
    |
    */
    'voice' => [
        'from' => env('AFRICASTALKING_VOICE_PHONE_NUMBER'),
    ],
];
