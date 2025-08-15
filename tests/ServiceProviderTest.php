<?php

declare(strict_types=1);

use Illuminate\Support\Facades\App;
use Saloon\Http\Senders\GuzzleSender;

it('uses a singleton GuzzleSender', function (): void {
    $bound = App::bound(GuzzleSender::class);

    expect($bound)->toBe(true);
});
