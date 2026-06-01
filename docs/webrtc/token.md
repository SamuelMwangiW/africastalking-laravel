# WebRTC Token

WebRTC (Web Real-Time Communication) allows your web app to make and receive voice calls directly in the browser without any plugins. To authenticate a browser client with Africa's Talking's WebRTC infrastructure, your backend must generate a short-lived token and send it to the frontend.

## Generate a Token

```php
$token = africastalking()
    ->voice()
    ->webrtc()
    ->for('BrowserClient')
    ->token();

echo $token->token;       // the JWT token string
echo $token->clientName;  // "BrowserClient"
echo $token->lifeTimeSec; // token lifetime in seconds
```

## Example: Token Endpoint Controller

Expose a route that your frontend JavaScript can call to get a fresh token:

```php
<?php

namespace App\Http\Controllers\Voice;

use Illuminate\Http\JsonResponse;

class WebRtcTokenController
{
    public function __invoke(): JsonResponse
    {
        $clientName = auth()->user()?->name ?? 'Guest';

        $token = africastalking()
            ->voice()
            ->webrtc()
            ->for($clientName)
            ->token();

        return response()->json([
            'token'      => $token->token,
            'clientName' => $token->clientName,
            'expiresIn'  => $token->lifeTimeSec,
        ]);
    }
}
```

Register the route (protect it with `auth` middleware so only logged-in users can get a token):

```php
// routes/api.php
Route::middleware('auth:sanctum')->get('/webrtc/token', WebRtcTokenController::class);
```

## Using the Token in the Browser

Fetch the token from your backend and pass it to Africa's Talking's [JavaScript WebRTC SDK](https://developers.africastalking.com/docs/voice/webrtc):

```javascript
fetch('/api/webrtc/token')
  .then(res => res.json())
  .then(({ token, clientName }) => {
    const client = new AfricasTalking.Voice({ token, clientName });
    client.on('ready', () => console.log('WebRTC client ready'));
  });
```

::: tip Token Lifetime
Tokens are short-lived. Request a fresh token each time the user starts a call session rather than caching them long-term.
:::
