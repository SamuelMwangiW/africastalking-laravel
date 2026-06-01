# Voice Responses (IVR)

When Africa's Talking connects a call to your callback URL, your application responds with XML instructions that control what happens next — play audio, collect keypad input, record the call, dial another number, or hang up. This package provides a fluent builder for those responses.

## All Available Actions

```php
africastalking()->voice()
    ->say(message: 'Welcome to our service.', voice: 'en-US-Standard-C', playBeep: false)
    ->play(url: 'https://example.com/hold-music.wav')
    ->getDigits(
        say: 'Press 1 for sales, 2 for support, or 3 to leave a message.',
        finishOnKey: '#',
        timeout: 10,
        callbackUrl: 'https://myapp.com/api/voice/digits',
    )
    ->dial(
        phoneNumbers: ['+254711000000', 'agent@ke.sip.africastalking.com'],
        record: true,
        ringBackTone: 'https://example.com/ringing.mp3',
        maxDuration: 120,
        sequential: true,
        callerId: '+254711000000',
    )
    ->record(
        say: 'Please leave a message after the tone.',
        finishOnKey: '#',
        timeout: 30,
        maxLength: 60,
        playBeep: true,
        trimSilence: true,
    )
    ->redirect(url: 'https://myapp.com/api/voice/next-step')
    ->reject();
```

All parameters marked as optional in the [Africa's Talking Voice docs](https://developers.africastalking.com/docs/voice/actions/overview) are also optional here.

## Action Reference

| Method | Description |
|---|---|
| `say(string\|Closure $message, ...)` | Play text-to-speech audio. Accepts a string or a `SynthesisedSpeech` closure for SSML. |
| `play(string $url)` | Stream an audio file (WAV, MP3) |
| `getDigits(string $say, ...)` | Play a prompt and collect keypad input |
| `dial(array $phoneNumbers, ...)` | Forward the call to one or more numbers or SIP addresses |
| `record(string $say, ...)` | Record the caller's voice after a prompt |
| `redirect(string $url)` | Hand control to another callback URL |
| `reject()` | Reject / hang up the call immediately |

## Example Controllers

### Welcome Menu

```php
<?php

namespace App\Http\Controllers\CallCenter;

use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;

class HandleCallsController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if (! $request->input('isActive')) {
            return response('OK');
        }

        return africastalking()->voice()
            ->say('Welcome to Unicorn Bank.')
            ->getDigits(
                say: 'Press 1 for your balance, 2 to speak to an agent, or 3 to leave a message.',
                finishOnKey: '#',
                timeout: 10,
            );
    }
}
```

### Call Recording

```php
<?php

namespace App\Http\Controllers\CallCenter;

use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;

class RecordCallsController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if (! $request->input('isActive')) {
            return response('OK');
        }

        return africastalking()->voice()
            ->say('Our working hours are 9 AM to 7 PM, Monday to Friday.')
            ->record(
                say: 'Please leave a message after the tone and press # when done.',
                finishOnKey: '#',
                playBeep: true,
                maxLength: 60,
                trimSilence: true,
            );
    }
}
```

### Forward Calls to an Agent

```php
<?php

namespace App\Http\Controllers\CallCenter;

use App\Models\Agent;
use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;

class ForwardCallsController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if (! $request->input('isActive')) {
            return response('OK');
        }

        $agent = Agent::query()->onDuty()->first();

        return africastalking()->voice()
            ->say('Please hold while we connect you to an agent.')
            ->dial(
                phoneNumbers: [$agent->phone],
                record: true,
                ringBackTone: 'https://example.com/hold-music.mp3',
            );
    }
}
```

### Reject After Hours

```php
<?php

namespace App\Http\Controllers\CallCenter;

use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;

class RejectCallsController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if (! $request->input('isActive')) {
            return response('OK');
        }

        return africastalking()->voice()
            ->say('Sorry, our lines are closed. Working hours are 9 AM to 7 PM, Monday to Friday.')
            ->reject();
    }
}
```

::: tip Synthesized Speech (SSML)
For advanced text-to-speech with currency, date, time, and phone number formatting, see [Synthesized Speech Attributes](./attributes).
:::
