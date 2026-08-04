# Sending Messages Asynchronously & Concurrently

For high-volume use cases, SMS messages can be dispatched asynchronously or sent concurrently in a pool, instead of blocking on every request in a loop.

## Async: `async()`

Chain `async()` before `send()` to dispatch a single message without blocking. Instead of a `SentMessageResponse`, `send()` returns a Guzzle `PromiseInterface`:

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$promise = Africastalking::sms('Hello there')
    ->to('+254712345678')
    ->async()
    ->send();

// ... do other work while the request is in flight ...

$response = $promise->wait(); // SentMessageResponse
```

If the send fails — either a transport error or an API-level failure such as an invalid sender ID — the promise rejects with an `AfricastalkingException` instead of throwing synchronously, so wrap `wait()` in a `try`/`catch`:

```php
try {
    $response = $promise->wait();
} catch (\SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException $exception) {
    // handle the failure
}
```

`async()` is only relevant to a single in-flight request. To send many messages concurrently, use `pool()` instead.

## Concurrency: `pool()`

Unlike `async()`, calling `pool()` is a blocking call: it dispatches every message concurrently — capped at a maximum number of requests in flight at once — waits for all of them to finish, and only then returns. There's no separate `send()` or `wait()` step; `pool()` does both internally and hands you back the finished results.

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$messages = [
    Africastalking::sms('Hi Alice')->to('+254700000001'),
    Africastalking::sms('Hi Bob')->to('+254700000002'),
    Africastalking::sms('Hi Carol')->to('+254700000003'),
];

$results = Africastalking::sms()->pool($messages, concurrency: 5);
// By the time execution reaches here, every message above has already been sent.
```

Under the hood this uses [Saloon's request pool](https://docs.saloon.dev/digging-deeper/concurrency-and-pools), which is itself built on Guzzle promises — but that's an implementation detail; `pool()` resolves the promise for you before returning.

`pool()` returns an `Illuminate\Support\Collection` keyed the same way as the input — numeric or string keys are both preserved:

```php
$results = Africastalking::sms()->pool([
    'alice' => Africastalking::sms('Hi Alice')->to('+254700000001'),
    'bob' => Africastalking::sms('Hi Bob')->to('+254700000002'),
]);

$results->get('alice'); // SentMessageResponse|Throwable
```

### Per-item failures don't fail the whole pool

Each entry in the returned collection is either a `SentMessageResponse` on success, or the `Throwable` that was raised for that specific message. Inspect each result to know which recipients succeeded:

```php
foreach ($results as $key => $result) {
    if ($result instanceof \Throwable) {
        logger()->warning("Message {$key} failed: {$result->getMessage()}");
        continue;
    }

    // $result is a SentMessageResponse
}
```

### Controlling concurrency

Pass an `int` for a fixed cap, or any callable that receives the number of pending requests and returns the concurrency to use at that point:

```php
Africastalking::sms()->pool($messages, concurrency: fn(int $pendingRequests) => min($pendingRequests, 10));
```

::: warning Bulk and Premium messages cannot be mixed in one pool
A single `pool()` call must contain either all bulk SMS messages or all premium SMS messages — Africa's Talking resolves each mode to a different API endpoint, so mixing them within one concurrent batch is unsupported. Mixing them throws an `AfricastalkingException`. Call `pool()` separately for each mode instead.
:::
