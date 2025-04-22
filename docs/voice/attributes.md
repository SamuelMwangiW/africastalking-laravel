# Synthesized Speech Attributes.

The ```<Say />``` action supports the use of Speech Synthesis Markup Language(SSML).

To respond with *Synthesized Speech*, pass a callback `say()` above as the first parameter that receives an instance of ```SynthesisedSpeech``` object

```php

<?php

namespace App\Http\Controllers\CallCenter;

use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\SynthesisedSpeech;

class HandleCallsController
{
    public function __invoke(VoiceCallRequest $request)
    {
        if ($request->input('isActive')){
            return africastalking()->voice()
                       ->say(
                         fn(SynthesisedSpeech $speech) => $speech
                                 ->say('Welcome to Wasafi. Your airtime balance is')
                                 ->sayAsCurrency('$1000','en-US')
                                 ->say(' and expires on ')
                                 ->sayAsDate('20420420')
                                 ->say(' at ')
                                 ->sayAsTime('04:42PM')
                                 ->pause('69ms')
                                 ->say('For assistance Call our customer service team on ')
                                 ->sayAsTelephone('0800694269')
                                 ->bleep('Thank you for choosing us 😜')
                       )
        }
        
        return response('OK');
    }
}
```

> **Note**
> You can only have a single ```<Say />``` within an XML response