<?php

declare(strict_types=1);

use Saloon\Exceptions\Request\ClientException;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Domain\CallTransfer;
use SamuelMwangiW\Africastalking\Enum\CallLeg;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Saloon\Requests\Voice\CallTransferRequest;
use SamuelMwangiW\Africastalking\ValueObjects\CallTransferResponse;

it('resolves a CallTransfer instance', function (): void {
    expect(Africastalking::voice()->transferCall())->toBeInstanceOf(CallTransfer::class);
});

it('resolves a CallTransfer instance via the transfer() alias', function (): void {
    expect(Africastalking::voice()->transfer())->toBeInstanceOf(CallTransfer::class);
});

it('transfers a call via the transfer() alias, sending the same sessionId', function (): void {
    Saloon::fake([
        CallTransferRequest::class => function (PendingRequest $pendingRequest) {
            expect($pendingRequest->body()?->get('sessionId'))->toBe('ATVId_47ef478e918923e7b2d0921ebd5b66a6');

            return MockResponse::fixture('voice/call-transfer');
        },
    ]);

    $response = Africastalking::voice()
        ->transfer('ATVId_47ef478e918923e7b2d0921ebd5b66a6')
        ->to('+254728900922')
        ->send();

    expect($response)->toBeInstanceOf(CallTransferResponse::class)
        ->status->toBe(Status::SUCCESS);
});

it('transfers a call to another number', function (): void {
    Saloon::fake([
        CallTransferRequest::class => MockResponse::fixture('voice/call-transfer'),
    ]);

    $response = Africastalking::voice()
        ->transferCall('ATVId_47ef478e918923e7b2d0921ebd5b66a6')
        ->to('+254728900922')
        ->send();

    expect($response)->toBeInstanceOf(CallTransferResponse::class)
        ->status->toBe(Status::SUCCESS)
        ->and($response->isSuccessful())->toBeTrue();
});

it('sends the sessionId, phoneNumber, username and a default callLeg of callee in the request body', function (): void {
    Saloon::fake([
        CallTransferRequest::class => function (PendingRequest $pendingRequest) {
            expect($pendingRequest->body()?->get('sessionId'))->toBe('ATVId_47ef478e918923e7b2d0921ebd5b66a6')
                ->and($pendingRequest->body()?->get('phoneNumber'))->toBe('+254728900922')
                ->and($pendingRequest->body()?->get('username'))->not->toBeNull()
                ->and($pendingRequest->body()?->get('callLeg'))->toBe('callee')
                ->and($pendingRequest->body()?->all())->not->toHaveKey('holdMusicUrl');

            return MockResponse::fixture('voice/call-transfer');
        },
    ]);

    Africastalking::voice()
        ->transferCall('ATVId_47ef478e918923e7b2d0921ebd5b66a6')
        ->to('+254728900922')
        ->send();
});

it('sends the callLeg when set via leg(), accepting either a string or the CallLeg enum', function (string|CallLeg $leg): void {
    Saloon::fake([
        CallTransferRequest::class => function (PendingRequest $pendingRequest) {
            expect($pendingRequest->body()?->get('callLeg'))->toBe('caller');

            return MockResponse::fixture('voice/call-transfer');
        },
    ]);

    Africastalking::voice()
        ->transferCall('ATVId_47ef478e918923e7b2d0921ebd5b66a6')
        ->to('+254728900922')
        ->leg($leg)
        ->send();
})->with([
    'string' => 'caller',
    'enum' => CallLeg::CALLER,
]);

it('sends the holdMusicUrl when set', function (): void {
    Saloon::fake([
        CallTransferRequest::class => function (PendingRequest $pendingRequest) {
            expect($pendingRequest->body()?->get('holdMusicUrl'))->toBe('https://example.com/hold-music.mp3');

            return MockResponse::fixture('voice/call-transfer');
        },
    ]);

    Africastalking::voice()
        ->transferCall('ATVId_47ef478e918923e7b2d0921ebd5b66a6')
        ->to('+254728900922')
        ->holdMusic('https://example.com/hold-music.mp3')
        ->send();
});

it('throws when the transfer request fails', function (): void {
    Saloon::fake([
        CallTransferRequest::class => MockResponse::make(
            body: "Request is missing required form field 'sessionId'",
            status: 400,
        ),
    ]);

    Africastalking::voice()
        ->transferCall()
        ->to('+254728900922')
        ->send();
})->throws(ClientException::class);
