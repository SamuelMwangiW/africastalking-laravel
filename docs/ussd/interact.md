# USSD Response

This package allows to easily create `USSD` response by exposing a `\SamuelMwangiW\Africastalking\Response\UssdResponse`
class that implements Laravel's Responsable contract.

To send a ussd response, simply return `africastalking()->ussd()` in your controller.

The `ussd` optionally takes 2 parameters and returns an instance of `UssdResponse`:

- `response` - The response message to be displayed to the client
- `expectsInput` - A boolean whether or not to prompt for user input. The default value is `true`

The `UssdResponse` class has the following methods that can be chained fluently

- `response` - Receives the response message to be displayed to the client as an argument
- `expectsInput` - Receives the expectsInput boolean to be displayed to the client as an argument. The default value is
  true
- `end` - Is an alias `expectsInput()` but sets the boolean value `false` always

See below an example controller that makes of the `UssdResponse` and Ussd's `HttpRequest`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Str;
use SamuelMwangiW\Africastalking\Http\Requests\UssdEventRequest;
use SamuelMwangiW\Africastalking\Http\Requests\UssdSessionRequest;

class UssdController extends Controller
{
    public function session(UssdSessionRequest $request)
    {
        if (!$request->userInput()) {
            return africastalking()->ussd('Kindly enter your account number');
        }

        $account = Client::query()
            ->whereAccountNo(
                Str::of($request->userInput())->afterLast('*')->toString()
            )->first();

        if ($account?->exists()) {
            return africastalking()
                ->ussd("Your account Balance is KES {$account->balance}")->end();
        }

        return africastalking()
            ->ussd("The account you entered does not exists.\n\nKindly enter a valid account number");
    }

    public function event(UssdEventRequest $request)
    {
       //Handle the USSD event here
       
        return response('OK');
    }
}
```
