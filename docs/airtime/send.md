# Sending Airtime

Disburse airtime to one or many phone numbers. Amounts are specified in the local currency of each recipient's network.

## Basic Example

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$response = Africastalking::airtime()
    ->to('+254712345678', 'KES', 50)
    ->send();
```

Or with the global helper:

```php
$response = africastalking()->airtime()
    ->to('+256706345678', 'UGX', 1000)
    ->send();
```

## Sending to Multiple Recipients

Chain multiple `to()` calls (or use `add()`, which is an alias):

```php
$response = Africastalking::airtime()
    ->to('+254712345678', 'KES', 50)
    ->to('+256706345678', 'UGX', 2000)
    ->to('+255712000000', 'TZS', 500)
    ->send();
```

## Using the `AirtimeTransaction` Value Object

For more explicit control, pass an `AirtimeTransaction` instance:

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;
use SamuelMwangiW\Africastalking\Enum\Currency;

$transaction = new AirtimeTransaction(
    phoneNumber: PhoneNumber::make('+254712345678'),
    currencyCode: Currency::KENYA,
    amount: 100
);

$response = Africastalking::airtime()
    ->to($transaction)
    ->send();
```

## Batch Sending in a Loop

Use `add()` (alias of `to()`) to build up a list of recipients dynamically, then dispatch once:

```php
use App\Models\Client;

$airtime = africastalking()->airtime();

Client::query()->chunk(1000, function ($clients) use ($airtime) {
    foreach ($clients as $client) {
        $airtime->add($client->phone, 'KES', 30);
    }
});

$results = $airtime->send();
```

::: tip
Chunking avoids loading thousands of records into memory at once. The `send()` call dispatches all recipients in a single API request.
:::

## The Response

`send()` returns an `AirtimeResponse` object. Per-recipient results are in the `->responses` collection, each an `AirtimeRecipientResponse`:

```php
echo $results->numSent;      // 3 (total recipients processed)
echo $results->amount;       // "KES 150.0000" (total amount sent)
echo $results->errorMessage; // "" on success

foreach ($results->responses as $recipient) {
    echo $recipient->phoneNumber->number; // +254712345678
    echo $recipient->amount;              // "KES 50.0000"
    echo $recipient->status->value;       // "Success" | "Failed"
    echo $recipient->errorMessage;        // "" on success
}
```
