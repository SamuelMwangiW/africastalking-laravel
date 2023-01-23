<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;
use SamuelMwangiW\Africastalking\Tests\Fixtures\TestConnector;
use SamuelMwangiW\Africastalking\Tests\Fixtures\TestRequest;
use SamuelMwangiW\Africastalking\ValueObjects\CapabilityToken;

it('fakes requests',function (){
    Saloon::fake([
        MockResponse::make([
            'clientName' => 'John.Doe',
            'incoming' => true,
            'lifeTimeSec' => '86400',
            'outgoing' => true,
            'token' => 'ATCAPtkn_somerandomtexthere',
        ],200)
    ]);

    $connector = new TestConnector();
    $response = $connector->send(TestRequest::make())->dto();

    expect($response)
        ->toBeInstanceOf(CapabilityToken::class)
        ->clientName->toBe('John.Doe')
        ->incoming->toBeTrue()
        ->outgoing->toBeTrue()
        ->lifeTimeSec->toBe('86400')
        ->token->toBe('ATCAPtkn_somerandomtexthere');
});
