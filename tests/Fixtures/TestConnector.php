<?php

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Saloon\Http\Connector;

class TestConnector extends Connector
{

    /**
     * @inheritDoc
     */
    public function resolveBaseUrl(): string
    {
        return 'https://webrtc.africastalking.com/';
    }
}
