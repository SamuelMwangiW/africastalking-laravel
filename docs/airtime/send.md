# Sending Airtime

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