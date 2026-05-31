# Installation

## Requirements

- PHP **8.3** or higher
- Laravel **12.x** or higher

## Install via Composer

```shell
composer require samuelmwangiw/africastalking-laravel
```

## Publish the Config File

```shell
php artisan vendor:publish --tag="africastalking-config"
```

This creates `config/africastalking.php`:

```php
return [
    'username' => env('AFRICASTALKING_USERNAME', 'sandbox'),
    'api-key'  => env('AFRICASTALKING_API_KEY'),

    'sms' => [
        'from' => env('AFRICASTALKING_FROM'),
    ],

    'payment' => [
        'product-name' => env('AFRICASTALKING_PAYMENT_PRODUCT'),
    ],

    'voice' => [
        'from' => env('AFRICASTALKING_VOICE_PHONE_NUMBER'),
    ],
];
```

## Configure Your Environment

Add the following variables to your `.env` file:

```dotenv
AFRICASTALKING_USERNAME=sandbox
AFRICASTALKING_API_KEY=your-api-key-here

# SMS sender ID (optional — uses shortcode if omitted)
AFRICASTALKING_FROM=MyApp

# Payments product name (required for payment features)
AFRICASTALKING_PAYMENT_PRODUCT=MyPaymentProduct

# Voice caller ID (required for outbound calls)
AFRICASTALKING_VOICE_PHONE_NUMBER=+254700000000
```

::: tip Sandbox Testing
Keep `AFRICASTALKING_USERNAME=sandbox` while developing. The sandbox environment is free and does not send real SMS messages or charge real money. Switch to your live credentials only when going to production.
:::

## Verify the Setup

### Option 1 — `php artisan about`

The package registers itself with Laravel's `about` command. Run it to confirm your credentials are loaded and the API is reachable:

```shell
php artisan about
```

Look for the **Africastalking** section in the output:

```
  Africastalking ...............................................................
  SDK Version ................................................. 1.x.x
  Username ................................................... sandbox
  SenderID ................................................... MyApp
  Voice Phone # .............................................. +254700000000
  Payment Product ............................................ MyPaymentProduct
  App Balance ................................................ KES 1,000
  Payments Product Balance ................................... KES 5,000
```

- If **App Balance** shows a value (even `KES 0`), the API key and username are correct.
- If it shows `FAILED` in red, double-check your `AFRICASTALKING_API_KEY` and `AFRICASTALKING_USERNAME` in `.env`.
- **Payments Product Balance** will show `Not setup` in yellow if `AFRICASTALKING_PAYMENT_PRODUCT` is not configured — that is expected if you are not using the payments API.

### Option 2 — Fetch the balance in code

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$balance = Africastalking::application()->balance();

echo $balance->amount;   // e.g. "100.00"
echo $balance->currency; // e.g. "KES"
```
