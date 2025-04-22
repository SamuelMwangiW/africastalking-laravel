# Voice Responses

This package provides an easy and intuitive voice response builder that allows any combination of the following:

Note that all params marked as optional in
the [documentation](https://developers.africastalking.com/docs/voice/actions/overview) are also optional

```php
<?php

return africastalking()->voice()
    ->say(message: '', playBeep: "false", voice: "en-US-Standard-C")
    ->play(url: 'https://example.com/audio.wav')
    ->getDigits(
        say: 'Please enter your account number followed by the hash sign',
        finishOnKey: '#',
        timeout: '30',
        callbackUrl: 'http://mycallbackURL.com',
    )->dial(
        phoneNumbers: ['+254711XXXYYY', '+25631XYYZZZZ', 'test@ke.sip.africastalking.com'],
        record: true,
        ringBackTone: 'http://mymediafile.com/playme.mp3',
        maxDuration: 5,
        sequential: false,
        callerId: '+254711XXXYYY',
    )->record(
        say: 'Please enter your account number followed by the hash sign',
        finishOnKey: '#',
        timeout: '30',
        maxLength: 10,
        playBeep: true,
        trimSilence: true
    )->redirect(
        url: 'http://www.myotherhandler.com/process.php',
    )->reject();
```

See example in a controller below:

```php
<?php

namespace App\Http\Controllers\CallCenter;

use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;

class HandleCallsController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if ($request->input('isActive')){
            return africastalking()->voice()
                       ->say('Welcome to Unicorn bank.')
                       ->getDigits(
                           say:'Please enter your account Number followed by the # key',
                           finishOnKey: '#'
                       )
        }
        
        return response('OK');
    }
}

```

```php
<?php

namespace App\Http\Controllers\CallCenter;

use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;

class RecordCallsController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if ($request->input('isActive')){
            return africastalking()->voice()
                       ->say('Our working hours are 9AM - 7PM, Monday to to Friday')
                       ->record(
                            say: 'Please leave a message after the tone.',
                            finishOnKey: '#',
                            playBeep: true,
                            maxLength: 10,
                            trimSilence: true,
                       );
        }
        
        return response('OK');
    }
}

```

```php
<?php

namespace App\Http\Controllers\CallCenter;

use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;

class RejectCallsController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if ($request->input('isActive')){
            return africastalking()->voice()
                       ->say('Our working hours are 9AM - 7PM, Monday to to Friday')
                       ->reject();
        }
        
        return response('OK');
    }
}

```


```php
<?php

namespace App\Http\Controllers\CallCenter;

use App\Models\Doctor;
use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;

class ForwardCallsController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if ($request->input('isActive')){
            $doctor = Doctor::query()->onDuty()->first();
            
            return africastalking()->voice()
                       ->dial(
                            phoneNumbers: [$doctor->number],
                            record: true,
                            ringBackTone: "https://example.com/marketing-tone.wave"
                       );
        }
        
        return response('OK');
    }
}

```