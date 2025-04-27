# Installation Guide

You can install the package via composer:

```shell
composer require samuelmwangiw/africastalking-laravel
```

You can publish the config file with:

```shell
php artisan vendor:publish --tag="africastalking-config"
```


```php
return [
    'username' => env('AFRICASTALKING_USERNAME', 'sandbox'),
    'api-key' => env('AFRICASTALKING_API_KEY'),
    'sms' => [
        'from' => env('AFRICASTALKING_FROM'),
    ],
    'payment' => [
        'product-name' => env('AFRICASTALKING_PAYMENT_PRODUCT'),
    ],
    'voice' => [
        'from' => env('AFRICASTALKING_VOICE_PHONE_NUMBER'),
    ]
];
```