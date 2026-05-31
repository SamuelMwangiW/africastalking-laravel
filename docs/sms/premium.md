# Sending Premium SMS

Premium SMS messages are sent to subscribers of a premium short code. Unlike bulk SMS, recipients are billed for receiving these messages. Use this for subscription services, content delivery, and opt-in campaigns.

## Basic Example

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$response = Africastalking::sms('Your weekly horoscope: The stars are aligned in your favour.')
    ->to(['+254712345678', '+256706123567'])
    ->premium()
    ->send();
```

## Full Method Reference

| Method | Description |
|---|---|
| `to(string\|array $numbers)` | Recipient phone number(s) |
| `as(string $shortCode)` | Override the short code / sender ID |
| `premium()` | **Required** — designates this as a premium message |
| `bulkMode(bool $bulk)` | `true` sends in bulk mode; `false` sends as individual premium messages |
| `retry(int $hours)` | Number of hours to retry delivery if the message is not delivered |
| `keyword(string $keyword)` | Keyword associated with the premium subscription |
| `linkId(string $id)` | Link ID for premium message delivery tracking |
| `send()` | Dispatch the request |

## Full Example

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$response = Africastalking::sms('Your premium content update for this week.')
    ->as('90012')
    ->to(['+254712345678', '+256706123567'])
    ->premium()
    ->bulkMode(false)
    ->retry(2)
    ->keyword('WEEKLY')
    ->linkId('msg-link-id-abc123')
    ->send();
```

## The Response

`send()` returns a `SentMessageResponse` object. Per-recipient results are in the `->recipients` collection, each a `SentMessageRecipient`:

```php
foreach ($response->recipients as $recipient) {
    echo $recipient->number->number; // +254712345678
    echo $recipient->status->value;  // "Success" | "InvalidPhoneNumber" | etc.
    echo $recipient->cost;           // "KES 5.0000"
    echo $recipient->id;             // AT message ID
}
```

::: warning
Premium SMS requires a registered short code and premium service approval from Africa's Talking. This is not available in the sandbox by default — contact support to enable it.
:::
