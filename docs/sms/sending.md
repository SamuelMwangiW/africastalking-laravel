# Sending Bulk Messages

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
        ->as('MyBIZ') // optional: When the senderId is different from `config('africastalking.sms.from')`
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

