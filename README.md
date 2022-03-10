# africastalking-laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/samuelmwangiw/africastalking-laravel.svg?style=flat-square)](https://packagist.org/packages/samuelmwangiw/africastalking-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/samuelmwangiw/africastalking-laravel/run-tests?label=tests)](https://github.com/samuelmwangiw/africastalking-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/samuelmwangiw/africastalking-laravel/Check%20&%20fix%20styling?label=code%20style)](https://github.com/samuelmwangiw/africastalking-laravel/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/samuelmwangiw/africastalking-laravel.svg?style=flat-square)](https://packagist.org/packages/samuelmwangiw/africastalking-laravel)

This is an unofficial Laravel SDK for interacting with [Africastalking](https://developers.africastalking.com/docs/sms/overview) APIs that takes advantage of native Laravel components such as 
- [HTTP Client](https://laravel.com/docs/9.x/http-client#main-content) in place of Guzzle client
- [Service Container](https://laravel.com/docs/9.x/container#main-content) for a great dev experience
- [Notifications](https://laravel.com/docs/9.x/notifications) to allow you route notifications via Africastalking
- [Config](https://laravel.com/docs/9.x/configuration#main-content)
- [Collections](https://laravel.com/docs/9.x/collections#main-content)
- Among many others

## Installation

You can install the package via composer:

```bash
composer require samuelmwangiw/africastalking-laravel
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="africastalking-config"
```

This is the contents of the published config file:

```php
return [
    'username' => env('AFRICASTALKING_USERNAME','sandbox'),
    'api-key' => env('AFRICASTALKING_API_KEY'),
    'from' => env('AFRICASTALKING_FROM'),
];
```

You should configure the package by setting the `env` variables in your `.env` file.

## Usage
### Application Balance

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

/** @var \SamuelMwangiW\Africastalking\ValueObjects\Account $account */
$account = Africastalking::application()->balance();
```
### Bulk Messages
The most basic example to send out a message is
```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$response = Africastalking::sms('Hello mom!')
        ->to('+254712345678')
        ->send();
```
Other valid examples are
```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$response = Africastalking::sms('It is quality rather than quantity that matters. - Lucius Annaeus Seneca')
        ->as('MyBIZ') // optional: When the senderId is different from `config('africastalking.from')`
        ->to(['+254712345678','+256706123567'])
        ->bulk() // optional: Messages are bulk by default
        ->enqueue() //used for Bulk SMS clients that would like to deliver as many messages to the API before waiting for an acknowledgement from the Telcos
        ->send()
```

The response is Collection of `\SamuelMwangiW\Africastalking\ValueObjects\RecipientsApiResponse` objects
### Premium Messages
```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$response = Africastalking::sms('It is quality rather than quantity that matters. - Lucius Annaeus Seneca')
        ->as('90012') // optional: When the senderId is different from `config('africastalking.from')`
        ->to(['+254712345678','+256706123567'])
        ->premium() // Required to designate messages as bulk
        ->bulkMode(false) // True to send premium messages in bulkMode and false to send as premium
        ->retry(2) //specifies the number of hours your subscription message should be retried in case it’s not delivered to the subscriber.
        ->keyword('keyword') // optional:
        ->linkId('message-link-id') // optional:
        ->send()

```
The response is Collection of `\SamuelMwangiW\Africastalking\ValueObjects\RecipientsApiResponse` objects
### Airtime (Pending)
TBA
### Payments (Pending)
WIP
### Voice (Pending)
WIP
### IOT (Pending)
WIP

## Requests
I intend to ship [Laravel Requests](https://laravel.com/docs/9.x/validation#creating-form-requests) that you can inject into your controller(s) for:
- USSD requests
- Sms Callback requests
- Airtime validation and delivery Callback request
- Voice call Requests

## Notification
I intend to allow for easily routing of notifications via Africastalking SMS
## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Samuel Mwangi](https://github.com/SamuelMwangiW)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
