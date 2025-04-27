# WebRTC

```php
<?php

namespace App\Http\Controllers\Voice;

class WebRtcTokenController {
    public function __invoke()
    {
        $clientName = auth()->user()?->name ?? 'Browser';
        
        $token = africastalking()
            ->voice()
            ->webrtc()
            ->for($clientName)
            ->token();
        
        return [
            'token' => $token->token,
            'clientName' => $token->clientName,
            'expire' => $token->lifeTimeSec,
        ];
    }
}
```