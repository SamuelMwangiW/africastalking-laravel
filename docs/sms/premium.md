# Sending Premium Messages

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$response = Africastalking::sms('It is quality rather than quantity that matters. - Lucius Annaeus Seneca')
        ->as('90012') // optional: When the senderId is different from `config('africastalking.sms.from')`
        ->to(['+254712345678','+256706123567'])
        ->premium() // Required to designate messages as bulk
        ->bulkMode(false) // True to send premium messages in bulkMode and false to send as premium
        ->retry(2) //specifies the number of hours your subscription message should be retried in case it’s not delivered to the subscriber.
        ->keyword('keyword') // optional:
        ->linkId('message-link-id') // optional:
        ->send()
```

The response is Collection of `\SamuelMwangiW\Africastalking\ValueObjects\RecipientsApiResponse` objects

