<?php

return [
    'username' => env('AFRICASTALKING_USERNAME','sandbox'),
    'api-key' => env('AFRICASTALKING_API_KEY'),
    'from' => env('AFRICASTALKING_FROM'), //to extract this to an sms group
    'payment' => [
        'product-name' => env('AFRICASTALKING_PAYMENT_PRODUCT'),
    ],
    'voice' => [
        'from' => env('AFRICASTALKING_VOICE_PHONE_NUMBER'),
    ]
];
