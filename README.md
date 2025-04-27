# africastalking-laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/samuelmwangiw/africastalking-laravel.svg?style=flat-square)](https://packagist.org/packages/samuelmwangiw/africastalking-laravel)
[![run-tests](https://github.com/SamuelMwangiW/africastalking-laravel/actions/workflows/run-tests.yml/badge.svg)](https://github.com/SamuelMwangiW/africastalking-laravel/actions/workflows/run-tests.yml)
[![PHPStan](https://github.com/SamuelMwangiW/africastalking-laravel/actions/workflows/phpstan.yml/badge.svg)](https://github.com/SamuelMwangiW/africastalking-laravel/actions/workflows/phpstan.yml)
[![Code styling](https://github.com/SamuelMwangiW/africastalking-laravel/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/SamuelMwangiW/africastalking-laravel/actions/workflows/php-cs-fixer.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/samuelmwangiw/africastalking-laravel.svg?style=flat-square)](https://packagist.org/packages/samuelmwangiw/africastalking-laravel)

This is an unofficial Laravel SDK for interacting
with [Africa's Talking](https://developers.africastalking.com/docs/sms/overview) APIs that takes advantage of native
Laravel components such as

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

You should configure the package by setting the `env` variables in your `.env` file.

## Documentations

The full documentation can be found at [Main Documentation](https://at-laravel-docs.pages.dev/) site.

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
