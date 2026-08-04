<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\ValueObjects\CallTransferResponse;

it('can be constructed')
    ->expect(fn() => new CallTransferResponse(
        status: Status::SUCCESS,
        errorMessage: 'None',
    ))
    ->toBeInstanceOf(CallTransferResponse::class)
    ->status->toBe(Status::SUCCESS)
    ->errorMessage->toBe('None');

it('can be constructed statically from the nested callTransferResponse shape')
    ->expect(fn() => CallTransferResponse::make([
        'callTransferResponse' => [
            'status' => Status::SUCCESS->value,
            'errorMessage' => 'None',
        ],
    ]))
    ->toBeInstanceOf(CallTransferResponse::class)
    ->status->toBe(Status::SUCCESS)
    ->errorMessage->toBe('None');

it('can be constructed statically from an already-unwrapped array')
    ->expect(fn() => CallTransferResponse::make([
        'status' => Status::FAILED->value,
        'errorMessage' => 'InvalidPhoneNumber',
    ]))
    ->toBeInstanceOf(CallTransferResponse::class)
    ->status->toBe(Status::FAILED)
    ->errorMessage->toBe('InvalidPhoneNumber');

it('implements DTO contract')
    ->expect(fn() => new CallTransferResponse(
        status: Status::SUCCESS,
        errorMessage: 'None',
    ))
    ->toBeInstanceOf(DTOContract::class);

it('can be cast to array')
    ->expect(fn() => new CallTransferResponse(
        status: Status::SUCCESS,
        errorMessage: 'None',
    ))
    ->__toArray()->toBeArray()->toMatchArray(['status' => Status::SUCCESS, 'errorMessage' => 'None']);

it('can be cast to string', function (): void {
    $object = new CallTransferResponse(
        status: Status::SUCCESS,
        errorMessage: 'None',
    );

    expect((string) $object)
        ->toBeString()
        ->toBe($object->__toString())
        ->toBe('{"status":"Success","errorMessage":"None"}');
});

it('is successful when the status is Success')
    ->expect(fn() => new CallTransferResponse(status: Status::SUCCESS, errorMessage: 'None'))
    ->isSuccessful()->toBeTrue();

it('is not successful when the status is anything else')
    ->expect(fn() => new CallTransferResponse(status: Status::FAILED, errorMessage: 'InvalidPhoneNumber'))
    ->isSuccessful()->toBeFalse();
