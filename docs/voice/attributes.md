# Synthesized Speech (SSML)

The `say()` action supports [Speech Synthesis Markup Language (SSML)](https://www.w3.org/TR/speech-synthesis/), which gives you precise control over how text is spoken — including currency amounts, dates, times, phone numbers, and pauses.

To use SSML, pass a closure to `say()`. The closure receives a `SynthesisedSpeech` object that you build fluently:

## Basic Example

```php
use SamuelMwangiW\Africastalking\ValueObjects\Voice\SynthesisedSpeech;

return africastalking()->voice()
    ->say(
        fn(SynthesisedSpeech $speech) => $speech
            ->say('Your account balance is')
            ->sayAsCurrency('KES 4200', 'en-KE')
            ->say('and your next payment is due on')
            ->sayAsDate('20241231')
    );
```

## Full SSML Method Reference

| Method | Description | Example |
|---|---|---|
| `say(string $text)` | Speak plain text | `->say('Hello there')` |
| `sayAsCurrency(string $amount, string $locale)` | Speak as a monetary amount | `->sayAsCurrency('$1000', 'en-US')` |
| `sayAsDate(string $date)` | Speak a date (YYYYMMDD) | `->sayAsDate('20241231')` |
| `sayAsTime(string $time)` | Speak a time | `->sayAsTime('04:42PM')` |
| `sayAsTelephone(string $number)` | Speak digits individually as a phone number | `->sayAsTelephone('0800694269')` |
| `pause(string $duration)` | Insert a pause | `->pause('500ms')` |
| `bleep(string $text)` | Speak text with profanity bleeping | `->bleep('some text')` |

## Full Example Controller

```php
<?php

namespace App\Http\Controllers\CallCenter;

use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\SynthesisedSpeech;

class AccountBalanceController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if (! $request->input('isActive')) {
            return response('OK');
        }

        return africastalking()->voice()
            ->say(
                fn(SynthesisedSpeech $speech) => $speech
                    ->say('Welcome to Wasafi. Your airtime balance is')
                    ->sayAsCurrency('$1000', 'en-US')
                    ->say('and expires on')
                    ->sayAsDate('20421231')
                    ->say('at')
                    ->sayAsTime('04:42PM')
                    ->pause('500ms')
                    ->say('For assistance, call our customer care team on')
                    ->sayAsTelephone('0800694269')
                    ->bleep('Thank you for choosing us!')
            );
    }
}
```

::: warning One `<Say>` per Response
Africa's Talking only allows a single `<Say>` action within a single XML response. Use the `SynthesisedSpeech` builder to combine multiple spoken segments — do not chain multiple `->say()` calls when using SSML closures.
:::
