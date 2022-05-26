# africastalking-laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/samuelmwangiw/africastalking-laravel.svg?style=flat-square)](https://packagist.org/packages/samuelmwangiw/africastalking-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/samuelmwangiw/africastalking-laravel/run-tests?label=tests)](https://github.com/samuelmwangiw/africastalking-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![PHPStan](https://github.com/SamuelMwangiW/africastalking-laravel/actions/workflows/phpstan.yml/badge.svg)](https://github.com/SamuelMwangiW/africastalking-laravel/actions/workflows/phpstan.yml)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/samuelmwangiw/africastalking-laravel/Check%20&%20fix%20styling?label=code%20style)](https://github.com/samuelmwangiw/africastalking-laravel/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/samuelmwangiw/africastalking-laravel.svg?style=flat-square)](https://packagist.org/packages/samuelmwangiw/africastalking-laravel)

This is an unofficial Laravel SDK for interacting
with [Africastalking](https://developers.africastalking.com/docs/sms/overview) APIs that takes advantage of native
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
    'username' => env('AFRICASTALKING_USERNAME','sandbox'),
    'api-key' => env('AFRICASTALKING_API_KEY'),
    'from' => env('AFRICASTALKING_FROM'),
    'payment' => [
        'product-name' => env('AFRICASTALKING_PAYMENT_PRODUCT'),
    ]
];
```

You should configure the package by setting the `env` variables in your `.env` file.

## Usage

### Application Balance

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

/** @var \SamuelMwangiW\Africastalking\ValueObjects\Balance $account */
$account = Africastalking::application()->balance();

// Or using the global helper function
$account = africastalking()->application()->balance();
```

### Bulk Messages

The most basic example to send out a message is

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$response = Africastalking::sms('Hello mom!')
        ->to('+254712345678')
        ->send();

// Or using the global helper function
$response = africastalking()->sms("Hello Mom")
        ->to('+254712345678')
        ->send();
```

Other valid examples are

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$response = Africastalking::sms('It is quality rather than quantity that matters. - Lucius Annaeus Seneca')
        ->message("We made it!") //overwrites any text previously set
        ->text("Look, am on the internet") //alias to message()
        ->as('MyBIZ') // optional: When the senderId is different from `config('africastalking.from')`
        ->to(['+254712345678','+256706123567'])
        ->bulk() // optional: Messages are bulk by default
        ->enqueue() //used for Bulk SMS clients that would like to deliver as many messages to the API before waiting for an acknowledgement from the Telcos
        ->send()

// Or using the global helper function
$response = africastalking()->sms()
        ->message("Hello Mom") //overwrites any text previously set
        ->to('+254712345678')
        ->send();
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

### Airtime

The most basic example to disburse airtime is

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$response = Africastalking::airtime()
        ->to('+254712345678','KES',100)
        ->send();

// Or using the global helper function
$response = africastalking()->airtime()
        ->to('+256706345678','UGX',100)
        ->send();
```

You may also pass an instance of `AirtimeTransaction`

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;
use SamuelMwangiW\Africastalking\Enum\Currency;

$transaction = new AirtimeTransaction(PhoneNumber::make('+256769000000'),Currency::UGANDA,1000)

$response = Africastalking::airtime()
        ->to($transaction)
        ->send();
```

The Airtime class provides an `add()` that's basically an alias to the `to()` and since either of these methods can be
fluently chained, it unlocks capabilities such as adding the recipients in a loop and sending once at the end

```php
use App\Models\Clients;

$airtime = africastalking()->airtime();

Clients::query()->chunk(1000, function ($clients) use($airtime) {
    foreach ($clients as $client) {
        $airtime->add($client->phone,'TZS',3000);
    }
});
$results = $airtime->send();
```

### USSD Response

This package allows to easily create `USSD` response by exposing a `\SamuelMwangiW\Africastalking\Response\UssdResponse`
class that implements Laravel's Responsable contract.

To send a ussd response, simply return `africastalking()->ussd()` in your controller.

The `ussd` optionally takes 2 parameters and returns an instance of `UssdResponse`:

- `response` - The response message to be displayed to the client
- `expectsInput` - A boolean whether or not to prompt for user input. The default value is `true`

The `UssdResponse` class has the following methods that can be chained fluently

- `response` - Receives the response message to be displayed to the client as an argument
- `expectsInput` - Receives the expectsInput boolean to be displayed to the client as an argument. The default value is
  true
- `end` - Is an alias `expectsInput()` but sets the boolean value `false` always

See below an example controller that makes of the `UssdResponse` and Ussd's `HttpRequest`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Str;
use SamuelMwangiW\Africastalking\Http\Requests\UssdEventRequest;
use SamuelMwangiW\Africastalking\Http\Requests\UssdSessionRequest;

class UssdController extends Controller
{
    public function session(UssdSessionRequest $request)
    {
        if (!$request->userInput()) {
            return africastalking()->ussd('Kindly enter your account number');
        }

        $account = Client::query()
            ->whereAccountNo(
                Str::of($request->userInput())->afterLast('*')->toString()
            )->first();

        if ($account?->exists()) {
            return africastalking()
                ->ussd("Your account Balance is KES {$account->balance}")->end();
        }

        return africastalking()
            ->ussd("The account you entered does not exists.\n\nKindly enter a valid account number");
    }

    public function event(UssdEventRequest $request)
    {
       //Handle the USSD event here
       
        return response('OK');
    }
}
```

### Payments (wip)

#### Mobile Checkout

```php
africastalking()
    ->payment()
    ->mobileCheckout()
    ->to('+254720123123')
    ->amount(5000)
    ->currency('KES')
    ->send()
```

#### Wallet Balance

```php
/** @var \SamuelMwangiW\Africastalking\ValueObjects\Balance $balance **/
$balance = africastalking()->wallet()->balance();
```

#### Stash top up

```php
africastalking()
    ->stash()
    ->topup('TZS',100000);

//or fluently
africastalking()
    ->stash()
    ->amount(10000)
    ->currency('USD')
    ->product('My Product') //To override the product name in config
    ->topup(); //topup() has an alias named send() if you fancy

```

### Voice Responses

This package provides an easy and intuitive voice response builder that allows any combination of the following:

Note that all params marked as optional in
the [documentation](https://developers.africastalking.com/docs/voice/actions/overview) are also optional

```php
<?php

return africastalking()->voice()
    ->say(message: '', playBeep: "false", voice: "en-US-Standard-C")
    ->play(url: 'https://example.com/audio.wav')
    ->getDigits(
        say: 'Please enter your account number followed by the hash sign',
        finishOnKey: '#',
        timeout: '30',
        callbackUrl: 'http://mycallbackURL.com',
    )->dial(
        phoneNumbers: ['+254711XXXYYY', '+25631XYYZZZZ', 'test@ke.sip.africastalking.com'],
        record: true,
        ringBackTone: 'http://mymediafile.com/playme.mp3',
        maxDuration: 5,
        sequential: false,
        callerId: '+254711XXXYYY',
    )->record(
        say: 'Please enter your account number followed by the hash sign',
        finishOnKey: '#',
        timeout: '30',
        maxLength: 10,
        playBeep: true,
        trimSilence: true
    )->redirect(
        url: 'http://www.myotherhandler.com/process.php',
    )->reject();
```

See example in a controller below:

```php
<?php

namespace App\Http\Controllers\CallCenter;

use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;

class HandleCallsController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if ($request->input('isActive')){
            return africastalking()->voice()
                       ->say('Welcome to Unicorn bank.')
                       ->getDigits(
                           say:'Please enter your account Number followed by the # key',
                           finishOnKey: '#'
                       )
        }
        
        return response('OK');
    }
}

```

```php
<?php

namespace App\Http\Controllers\CallCenter;

use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;

class RecordCallsController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if ($request->input('isActive')){
            return africastalking()->voice()
                       ->say('Our working hours are 9AM - 7PM, Monday to to Friday')
                       ->record(
                            say: 'Please leave a message after the tone.',
                            finishOnKey: '#',
                            playBeep: true,
                            maxLength: 10,
                            trimSilence: true,
                       );
        }
        
        return response('OK');
    }
}

```

```php
<?php

namespace App\Http\Controllers\CallCenter;

use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;

class RejectCallsController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if ($request->input('isActive')){
            return africastalking()->voice()
                       ->say('Our working hours are 9AM - 7PM, Monday to to Friday')
                       ->reject();
        }
        
        return response('OK');
    }
}

```


```php
<?php

namespace App\Http\Controllers\CallCenter;

use App\Models\Doctor;
use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;

class ForwardCallsController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if ($request->input('isActive')){
            $doctor = Doctor::query()->onDuty()->first();
            
            return africastalking()->voice()
                       ->dial(
                            phoneNumbers: [$doctor->number],
                            record: true,
                            ringBackTone: "https://example.com/marketing-tone.wave"
                       );
        }
        
        return response('OK');
    }
}

```

### Making Calls

```php
// Most basic call
africastalking()->voice()
    ->call('+254720123123')
    ->done();

// Call a list of users
africastalking()->voice()
    ->call(['+254720123123','+254731234567'])
    ->done();

// override the callerId
africastalking()->voice()
    ->call('+254720123123')
    ->as('+254711082999')
    ->done();

// Set the call Request Id
africastalking()->voice()
    ->call('+254720123123')
    ->requestId('id_12345')
    ->done();

// You can also use send if like that better
africastalking()->voice()
    ->call('+254720123123')
    ->send();
```

## HTTP Requests

The package ships with the following [Laravel Requests](https://laravel.com/docs/9.x/validation#creating-form-requests)
that you can inject into your application controllers:

```php
\SamuelMwangiW\Africastalking\Http\Requests\AirtimeStatusRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\AirtimeValidationRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\BulkSmsOptOutRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\IncomingMessageRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\MessageDeliveryRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\MobileC2BValidationRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\PaymentNotificationRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\SubscriptionRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\UssdEventRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\UssdSessionRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\VoiceEventRequest::class;
```

In addition to exposing the post params in a nice FormRequest object, these classes also include nice helper methods
where applicable e.g.

- `id()` to retrieve the unique ATPid associated with every request
- `phone()` to retrieve the client's phone number
- `userInput()` to retrieve ussd user input
- `status()` to get transaction / request final status
- `deliveryFailed()` returns a boolean `true` if sms or airtime delivery failed and `false` otherwise
- among many others

Example for a Message Delivery callback action Controller

```php
<?php

namespace App\Http\Controllers\Messaging;

use App\Models\Message;
use SamuelMwangiW\Africastalking\Http\Requests\MessageDeliveryRequest;

class MessageDeliveredController{
    public function __invoke(MessageDeliveryRequest $request)
    {
        $message = Message::query()
                            ->where(['transaction_id'=>$request->id()])
                            ->firstOrFail();
                            
        $message->update([
            'delivered_at'=>now(),
            'status'=>$request->status(),
        ]);
        
        return response('OK');
    }
}

```

## Notification

The package ships with a Channel to allow for easily routing of notifications via Africastalking SMS.

To route a notification via Africastalking, return `SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel` in
your notifications `via` method and the text message to be sent in the `toAfricastalking` method

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

class WelcomeNotification extends Notification
{
    public function via($notifiable)
    {
        return [AfricastalkingChannel::class];
    }

    public function toAfricastalking($notifiable)
    {
        return "Hi {$notifiable->name}. Your account at Unicorn Bank has been created. Hope you enjoy the service";
    }
}

```

Also ensure that the notifiable model implements `SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages` and that
the model's `routeNotificationForAfricastalking()` returns the phone number to receive the message

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages;

class User extends Model implements ReceivesSmsMessages
{
    protected $fillable = ['email','name','phone'];

    public function routeNotificationForAfricastalking(Notification $notification): string
    {
        return $this->phone;
    }
}

```

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
