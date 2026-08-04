# Transferring an Active Call

`dial()` and `redirect()` are XML instructions your callback returns to control a call as it's being set up. Call transfer is different: it's a direct API call you make to move an **already in-progress, two-legged call** — for example, one you connected earlier with `dial()` — to a different number, without ending the call.

This is useful for scenarios like transferring a customer from a first-line agent to a supervisor, or moving a caller between departments mid-conversation.

## Basic Example

```php
africastalking()->voice()
    ->transferCall($sessionId)
    ->to('+254728900922')
    ->send();
```

::: warning Requires a Two-Legged Call
The call being transferred must already have two active legs — for example, a caller connected to an agent via `dial()`. Attempting to transfer a call that hasn't been connected to a second party will fail.
:::

## Getting the Session ID

The `sessionId` identifies the ongoing call and comes from Africa's Talking's callback payload. If you're inside a voice event handler, read it off the request:

```php
use SamuelMwangiW\Africastalking\Http\Requests\VoiceEventRequest;

class TransferToSupervisorController
{
    public function __invoke(VoiceEventRequest $request)
    {
        africastalking()->voice()
            ->transfer($request->id()) // sessionId
            ->to('+254728900922')
            ->send();

        return response('OK');
    }
}
```

## Method Reference

| Method | Description |
|---|---|
| `transferCall(?string $sessionId)` / `transfer(?string $sessionId)` | Start building a transfer for the given call session |
| `to(string $phoneNumber)` | The phone number to transfer the call to |
| `callLeg(string\|CallLeg $leg)` | Which leg to transfer — `CallLeg::CALLER` or `CallLeg::CALLEE`. Defaults to the callee if not set |
| `holdMusic(?string $url)` | A media file URL to play to the other party while the transfer is in progress |
| `send()` | Dispatch the transfer request |

## Choosing Which Leg to Transfer

By default, Africa's Talking transfers the callee leg. Use `callLeg()` to transfer the caller instead, passing either the `CallLeg` enum or its raw string value:

```php
use SamuelMwangiW\Africastalking\Enum\CallLeg;

africastalking()->voice()
    ->transferCall($sessionId)
    ->to('+254728900922')
    ->callLeg(CallLeg::CALLER)
    ->send();
```

## Playing Hold Music

```php
africastalking()->voice()
    ->transferCall($sessionId)
    ->to('+254728900922')
    ->holdMusic('https://example.com/hold-music.mp3')
    ->send();
```

## The Response

`send()` returns a `CallTransferResponse`:

```php
$response = africastalking()->voice()
    ->transferCall($sessionId)
    ->to('+254728900922')
    ->send();

$response->status;         // Status::SUCCESS
$response->errorMessage;   // "None"
$response->isSuccessful(); // true
```

## Example: Transfer to a Supervisor on Request

```php
<?php

namespace App\Http\Controllers\CallCenter;

use App\Models\Supervisor;
use SamuelMwangiW\Africastalking\Http\Requests\VoiceEventRequest;

class HandleDtmfController
{
    public function __invoke(VoiceEventRequest $request)
    {
        if ('9' !== $request->input('dtmfDigits')) {
            return response('OK');
        }

        $supervisor = Supervisor::query()->onDuty()->first();

        africastalking()->voice()
            ->transferCall($request->id())
            ->to($supervisor->phone)
            ->holdMusic('https://example.com/hold-music.mp3')
            ->send();

        return response('OK');
    }
}
```

::: tip
See the [Africa's Talking Call Transfer documentation](https://developers.africastalking.com/docs/voice/call_transfer) for the underlying API details.
:::
