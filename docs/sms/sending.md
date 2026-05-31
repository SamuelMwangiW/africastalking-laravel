# Sending Bulk SMS

Bulk SMS is the standard way to send transactional or marketing messages to one or many recipients.

## Basic Example

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$response = Africastalking::sms('Hello from MyApp!')
    ->to('+254712345678')
    ->send();
```

Or with the global helper:

```php
$response = africastalking()->sms('Hello from MyApp!')
    ->to('+254712345678')
    ->send();
```

## Sending to Multiple Recipients

Pass an array of phone numbers to `to()`:

```php
$response = Africastalking::sms('Your OTP is 123456')
    ->to(['+254712345678', '+256706123567', '+255712000000'])
    ->send();
```

## Full Method Reference

| Method | Description |
|---|---|
| `sms(string $text)` | Set the message text (can also be set later with `message()`) |
| `message(string $text)` | Set or overwrite the message text |
| `text(string $text)` | Alias for `message()` |
| `to(string\|array $numbers)` | Set recipient phone number(s) |
| `as(string $senderId)` | Override the sender ID from config |
| `bulk()` | Mark as bulk (default — usually not needed explicitly) |
| `enqueue()` | Optimise throughput by batching with the API before waiting for telco acknowledgement |
| `send()` | Dispatch the request and return the response |

## Advanced Example

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$response = Africastalking::sms()
    ->message('Your order #1234 has been shipped and will arrive in 2–3 days.')
    ->as('MyStore')                              // custom sender ID
    ->to(['+254712345678', '+256706123567'])
    ->enqueue()                                  // for high-volume sends
    ->send();
```

## The Response

`send()` returns a `SentMessageResponse` object. Per-recipient results are in the `->recipients` collection, each a `SentMessageRecipient`:

```php
foreach ($response->recipients as $recipient) {
    echo $recipient->number->number; // +254712345678
    echo $recipient->status->value;  // "Success" | "InvalidPhoneNumber" | etc.
    echo $recipient->cost;           // "KES 0.8000"
    echo $recipient->id;             // AT message ID
}
```

::: tip Sender IDs
In the sandbox environment you may use any alphanumeric sender ID. In production, sender IDs must be registered with Africa's Talking for your account.
:::
